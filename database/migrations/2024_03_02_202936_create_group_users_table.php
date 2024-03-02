<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('created_by')->constrained('users'); //invited by
            $table->string('role', 25);
            $table->string('token', 1024)->nullable();
            $table->timestamp('token_expires_date')->nullable();
            $table->timestamp('token_used')->nullable();
            $table->enum('status', ['pending', 'approved', 'blocked'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_users');
    }
};
