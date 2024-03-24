<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';

const model = defineModel<string | undefined>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }

    input.value?.style.setProperty('height', 'auto');
    input.value?.style.setProperty('height', `${input.value.scrollHeight}px`);
});

defineExpose({ focus: () => input.value?.focus() });

watch(model, () => {
    if(input.value){
        input.value.style.height = 'auto';
        input.value.style.height = input.value.scrollHeight + 'px';
    }
})
</script>

<template>
    <textarea
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        v-model="model"
        ref="input"
        rows="1"
    ></textarea>
</template>
