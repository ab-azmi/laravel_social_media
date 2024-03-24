<script setup lang="ts">
import {ref} from 'vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import { useForm } from '@inertiajs/vue3';

const creating = ref<boolean>(false);
const postForm = useForm<{
    body: string;
}>({
    body: ''
});

function submitPost(){
    postForm.post(route('posts.store'), {
        onSuccess: () => {
            creating.value = false;
            postForm.reset();
        }
    })
}
</script>

<template>
    <section class="p-3">
        <TextAreaInput @click="creating = !creating" v-model="postForm.body" class=" w-full text-slate-500 border border-gray-300 rounded-lg mb-3" placeholder="Click here to cerate new post">
        </TextAreaInput>
        <div v-if="creating" class="w-full flex justify-between">
            <button class="inline-flex justify-center rounded-md border border-transparent bg-green-100 px-4 py-2 text-sm font-medium text-green-900 hover:bg-green-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-2">
                Attach file
                <input type="file" class="absolute top-0 left-0 opacity-0">
            </button>
            <button @click="submitPost" class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">Submit</button>
        </div>
    </section>
</template>