<script setup lang="ts">
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { DocumentIcon, ArrowDownTrayIcon, HeartIcon, ChatBubbleOvalLeftEllipsisIcon, EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { Post } from '@/types';
import PostUserHeader from './PostUserHeader.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

const props = defineProps<{
    post: Post
}>();

const emit = defineEmits(['editModal'])

const isDeleteModal = ref(false)

function closeDeleteModal() {
    isDeleteModal.value = false
}
function openDeleteModal() {
    isDeleteModal.value = true
}

function isImage(attachment: { mime: string }) {
    const mime = attachment.mime.split('/')[0];
    return mime.toLowerCase() === 'image';
}

function showEditModal() {
    emit('editModal', props.post)
}

function deletePost() {
    // delete request
    useForm({}).delete(route('posts.destroy', props.post.id), {
        preserveScroll: true
    })

}

function downloadAttachment(attachment: { path: string }) {
    window.open(attachment.path, '_blank');
}
</script>

<template>
    <div class="my-3 p-3 bg-white rounded-lg">
        <!-- Post Head -->
        <section class="flex gap-3 items-center">
            <PostUserHeader :post="post" />
            <div class="flex-1 text-right">
                <Menu as="div" class="relative inline-block text-left z-[99]">
                    <MenuButton>
                        <EllipsisVerticalIcon class="w-5 h-5 text-slate-500" />
                    </MenuButton>
                    <Transition enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0">
                        <MenuItems
                            class="absolute right-0 mt-2 w-fit origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                            <div class="px-1 py-1">
                                <MenuItem v-slot="{ active }">
                                <button @click="showEditModal" :class="[
                active ? 'bg-blue-500 text-white' : 'text-gray-900',
                'group flex gap-3 w-full items-center rounded-md px-2 py-2 text-sm',
            ]">
                                    <PencilIcon class="w-5 h-5" />
                                    Edit
                                </button>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <button @click="openDeleteModal" :class="[
                active ? 'bg-blue-500 text-white' : 'text-gray-900',
                'group flex gap-3 w-full items-center rounded-md px-2 py-2 text-sm',
            ]">
                                    <TrashIcon class="w-5 h-5" />
                                    Delete
                                </button>
                                </MenuItem>

                            </div>
                        </MenuItems>
                    </Transition>
                </Menu>
            </div>
        </section>
        <!-- Post Body -->
        <section class="mt-3">
            <Disclosure v-slot="{ open }">
                <div class="ck-content-output" v-if="!open" v-html="post.body.substring(0, 150)"></div>

                <template v-if="post.body.length > 150">
                    <DisclosurePanel>
                        <div class="ck-content-output" v-html="post.body"></div>
                    </DisclosurePanel>
                    <DisclosureButton class="flex justify-end w-full">
                        <span class="text-gray-500 hover:underline mt-2">
                            {{ open ? 'Read less' : 'Read more' }}
                        </span>
                    </DisclosureButton>
                </template>

            </Disclosure>
        </section>
        <!-- Post Attachments -->
        <section v-if="post.attachments" class="grid gap-3 my-2" :class="[post.attachments?.length > 1 ? 'grid-cols-2': 'grid-cols-1']">
            <div v-for="(att, i) of post.attachments?.slice(0, 4)">
                <div v-if="i === 3" class="bg-slate-100 rounded-lg overflow-hidden w-full h-full text-slate-600">
                    <div v-if="isImage(att)" class="relative w-full h-full">
                        <img :src="att.path" alt="" class="object-cover rounded-lg blur-lg brightness-75">
                        <span class="absolute text-2xl top-1/2 left-[40%] text-white" > +{{ post.attachments.length - 3 }} more</span>
                    </div>
                </div>
                <div v-else class="w-full h-full">
                    <div v-if="isImage({ mime: att.mime })" class="relative rounded-lg w-full h-full group overflow-hidden">
                        <img :src="att.path" alt="" class="object-cover w-full h-full group-hover:scale-125 transition-all">
                        <span @click="downloadAttachment(att)"
                            class="cursor-pointer absolute top-3 right-3 text-white backdrop-brightness-90 p-3 rounded-lg backdrop-blur-lg">
                            <ArrowDownTrayIcon class="w-5 h-5" />
                        </span>
                    </div>
                    <div v-else
                        class="group flex items-center bg-slate-100 rounded-lg py-6 px-3 justify-between text-slate-600 cursor-pointer">
                        <div class="flex gap-3">
                            <DocumentIcon class="w-6 h-6 text-slate-500" />
                            {{ att.name }}
                        </div>
    
                        <span class="hidden group-hover:block">
                            <ArrowDownTrayIcon class="w-6 h-6 text-slate-500" />
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Post Actions -->
        <section class="mt-4 w-full flex gap-10">
            <button class="flex gap-1 hover:gap-2 transition-all text-slate-500 group">
                <HeartIcon
                    class="w-5 h-5 text-pink-400 group-hover:scale-150 transition-all group-hover:text-red-500 animate-pulse" />
                Like
            </button>
            <button class="flex gap-1 hover:gap-2 transition-all text-slate-500 group">
                <ChatBubbleOvalLeftEllipsisIcon
                    class="w-5 h-5 text-sky-400 group-hover:scale-150 transition-all group-hover:text-blue-500" />
                Comment
            </button>
        </section>

        <!-- Delete Modal -->
        <TransitionRoot appear :show="isDeleteModal" as="template">
            <Dialog as="div" @close="closeDeleteModal" class="relative z-10">
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
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                    Delete Confirmation
                                </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Your action cannot be undone. Are you sure want to delete the post?
                                    </p>
                                </div>

                                <div class="mt-4 flex gap-3">
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-red-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                        @click="deletePost">
                                        Delete
                                    </button>
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeDeleteModal">
                                        Cancle
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>

</template>
