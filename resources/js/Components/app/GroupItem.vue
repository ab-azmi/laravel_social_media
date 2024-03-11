<script setup lang="ts">
defineProps<{
    image?: string;
    title: string;
    description: string;
}>();
</script>

<template>
    <div class="flex group gap-3 items-center hover:bg-slate-200 transition-all rounded-lg cursor-pointer p-2">
        <div class="rounded-lg w-14 overflow-hidden">
            <img class="group-hover:scale-125 transition-all" :src="image" alt="" srcset="">
        </div>
        <div class="w-full ">
            <h3 class="font-bold text-base text-slate-700">{{ title }}</h3>
            <p class="text-xs text-slate-500">
                {{ description }}
            </p>
        </div>
    </div>
</template>