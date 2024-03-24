<script setup lang="ts">
import { watch, computed } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { Post } from '@/types';
import { useForm } from '@inertiajs/vue3';
import TextAreaInput from '../TextAreaInput.vue';
import PostUserHeader from './PostUserHeader.vue';
import { XMarkIcon } from '@heroicons/vue/24/solid';

const props = defineProps<{
    post: Post | null,
    modelValue: boolean
}>()

const emit = defineEmits(['update:modelValue'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const postForm = useForm({
    body: props.post?.body
})

//update postForm.body when post changes
watch(() => props.post, (post: Post|null) => {
    postForm.body = post?.body
})

function closeModal() {
    show.value = false
}

function submitForm(){
    postForm.put(route('posts.update', props.post?.id), {
        preserveScroll: true,
        onSuccess: () => {
            show.value = false
        }
    })
}

</script>


<template>
    <Teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" class="relative z-10">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                    enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-4 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="div" class="text-lg font-medium leading-6 text-gray-900 flex justify-between items-center">
                                    Update Post
                                    <button>
                                        <XMarkIcon class="w-5 h-5 text-gray-500 hover:scale-110 transition-all hover:text-blue-500" @click="closeModal" />
                                    </button>
                                </DialogTitle>
                                <div class="my-4">
                                    <PostUserHeader :post="post" />
                                </div>

                                <div class="mt-2">
                                    <TextAreaInput v-model="postForm.body" class="w-full text-slate-500 border border-gray-300 rounded-lg mb-3"
                                        placeholder="Click here to update post"/>
                                    
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="submitForm">
                                        Submit
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </Teleport>
</template>