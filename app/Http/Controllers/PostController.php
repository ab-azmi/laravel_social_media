<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;

class PostController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        
        DB::beginTransaction();
        $allPaths = [];

        try {
            $post = Post::create([
                'user_id' => auth()->id(),
                'body' => $data['body'],
            ]);
    
            $attachments = $data['attachments'] ?? [];
            foreach ($attachments as $attachment) {
                $path = $attachment->storeAs('attachments/'.$post->id, $attachment->hashName(), 'public');
                $path = asset('storage/'.$path); 
                $allPaths[] = $path;
                $post->attachments()->create([
                    'path' => $path,
                    'name' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getClientMimeType(),
                    'size' => $attachment->getSize(),
                    'created_by' => auth()->id(),
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            foreach ($allPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            throw $th;
        }
        DB::commit();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        $validated = $request->validated();
        $post->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            $post->attachments()->delete();
            $post->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        DB::commit();
        
        return back();
    }
}
