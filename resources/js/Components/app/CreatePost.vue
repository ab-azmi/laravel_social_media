<script setup lang="ts">
import {ref} from 'vue';
import { useForm } from '@inertiajs/vue3';
import PostModal from './PostModal.vue';

const showModal = ref<boolean>(false);

const postForm = useForm<{
    body: string;
}>({
    body: ''
});

function showCreateModal(){
    showModal.value = true;
}
</script>

<template>
    <section class="p-3">
        <div @click="showCreateModal" class="border-gray-300 py-2 px-3 border focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" >
            Click here to cerate new post
        </div>
        <!-- <div v-if="creating" class="w-full flex justify-between">
            <button class="inline-flex justify-center rounded-md border border-transparent bg-green-100 px-4 py-2 text-sm font-medium text-green-900 hover:bg-green-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-2">
                Attach file
                <input type="file" class="absolute top-0 left-0 opacity-0">
            </button>
            <button @click="submitPost" class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">Submit</button>
        </div> -->
        <PostModal v-model="showModal" :post="null"/>
    </section>
</template>