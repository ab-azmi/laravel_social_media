<script setup lang="ts">
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { ref, defineProps, watch } from 'vue';

const props = defineProps<{
    status: string|undefined;
    message?: string;
}>();

const show = ref(props.status ? true : false);

watch(() => props.status, (newVal) => {
    show.value = true;
    setTimeout(() => {
        show.value = false;
    }, 5000);
});
</script>

<template>
    <div v-show="show" class="animate-bounce fixed z-[9000] px-6 py-3  top-5 right-5 flex rounded-lg gap-4 items-center" :class="{'bg-red-500': props.message, 'bg-purple-500': !props.message}">
        <div>
            <h1 v-if="message">
                {{ message }}
            </h1>
            <h1 v-else>
                {{ status }}
            </h1>
        </div>
        <button @click="show = false">
            <XMarkIcon class="h-5 w-5 text-purple-900" />
        </button>
    </div>
</template>