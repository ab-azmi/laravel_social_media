<script setup lang="ts">
import {ref} from 'vue';

const creating = ref<boolean>(false);
</script>

<template>
    <section class="p-3">
        <div @click="creating = !creating" class="px-2 py-3 text-slate-500 border border-gray-300 rounded-lg mb-3">
            Click here to cerate new post
        </div>
        <div v-if="creating" class="w-full flex justify-between">
            <button class="relative overflow-hidden px-3 py-2 text-sm rounded-lg bg-blue-400 hover:bg-blue-900 hover:text-white transition">
                Attach file
                <input type="file" class="absolute top-0 left-0 opacity-0">
            </button>
            <button class="px-3 py-2 text-sm rounded-lg bg-green-400 hover:bg-green-900 hover:text-white transition">Submit</button>
        </div>
    </section>
</template>