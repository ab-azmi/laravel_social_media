<script setup lang="ts">
defineProps<{
    selected?: boolean;
    label: string;
}>();
</script>

<template>
    <button :class="[
        'w-full h-14 px-5 font-medium flex gap-2 items-center justify-center',
        'focus:outline-none focus:ring-none',
        selected
            ? 'bg-white text-pink-500 text-xl'
            : 'text-slate-300 hover:text-slate-500 hover:text-xl transition-all ease-out',
    ]">
        <div v-if="selected" class="w-2 h-2 animate-bounce rounded-full bg-pink-500"></div>
        {{ label }}
    </button>
</template>