<script setup lang="ts">
import {ref} from 'vue';
import TextInput from '@/Components/TextInput.vue';
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
        <TextInput @click="creating = !creating" v-model="postForm.body" class="px-2 py-3 w-full text-slate-500 border border-gray-300 rounded-lg mb-3" placeholder="Click here to cerate new post">
        </TextInput>
        <div v-if="creating" class="w-full flex justify-between">
            <button class="relative overflow-hidden px-3 py-2 text-sm rounded-lg bg-blue-400 hover:bg-blue-900 hover:text-white transition">
                Attach file
                <input type="file" class="absolute top-0 left-0 opacity-0">
            </button>
            <button @click="submitPost" class="px-3 py-2 text-sm rounded-lg bg-green-400 hover:bg-green-900 hover:text-white transition">Submit</button>
        </div>
    </section>
</template>