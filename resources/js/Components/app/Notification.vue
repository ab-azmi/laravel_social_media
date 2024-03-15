<script setup lang="ts">
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { ref, defineProps, watch } from 'vue';

const props = defineProps<{
    status: string|undefined;
    message?: string;
    errors: Object;
}>();

const show = ref(false);

watch([() => props.status, () => props.message, () => props.errors], () => {
    show.value = true;
    setTimeout(() => {
        show.value = false;
    }, 5000);
});
</script>

<template>
    <div v-show="show" class="animate-bounce fixed z-[9000] px-6 py-3  top-5 right-5 flex rounded-lg gap-4 items-center" :class="{'bg-red-500': props.errors, 'bg-purple-500': !props.errors}">
        <div>
            <h1 v-if="message">
                {{ message }}
            </h1>
            <h1 v-else-if="status">
                {{ status }}
            </h1>
            <ul v-if="Object.keys(errors).length">
                <li v-for="(error, key) in errors" :key="key">
                    {{ error }}
                </li>
            </ul>
        </div>
        <button @click="show = false">
            <XMarkIcon class="h-5 w-5 text-black" />
        </button>
    </div>
</template>