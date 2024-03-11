<script setup lang="ts">
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { DocumentIcon, ArrowDownTrayIcon, HeartIcon, ChatBubbleOvalLeftEllipsisIcon, ChevronRightIcon } from '@heroicons/vue/24/solid';

defineProps<{
    post: {
        id: number;
        user: {
            name: string;
            username: string;
            avatar: string;
        };
        body: string;
        created_at: string;
        attachments?: null | Array<{
            id: number;
            name: string;
            url: string;
            mime: string;
        }>;
        group?: null | {
            id: number;
            name: string;
        };
    }
}>();

function isImage(attachment: { mime: string }) {
    const mime = attachment.mime.split('/')[0];
    return mime.toLowerCase() === 'image';
}

</script>

<template>
    <div class="my-3 p-3 bg-white rounded-lg">
        <!-- Post Head -->
        <section class="flex gap-3 items-start group">
            <a href="#" class="w-10 rounded-full overflow-hidden">
                <img :src="post.user.avatar" alt="" class="group-hover:scale-125 transition-all">
            </a>
            <div class="flex flex-col gap-1">
                <div class="flex gap-2 items-center">
                    <a href="#" class="font-bold hover:underline">{{ post.user.name }}</a>
                    <span v-if="post.group">
                        <ChevronRightIcon class="w-3 h-3 text-slate-800" />
                    </span>
                    <a v-if="post.group" href="#" class="font-bold hover:underline">{{ post.group?.name }}</a>
                </div>
                <p class="text-xs text-slate-500">{{ post.created_at }}</p>
            </div>
        </section>
        <!-- Post Body -->
        <section class="my-2">
            <Disclosure v-slot="{ open }">
                <div v-if="!open" v-html="post.body.substring(0, 150)"></div>
                <DisclosurePanel>
                    <div v-html="post.body"></div>
                </DisclosurePanel>
                <DisclosureButton class="flex justify-end w-full">
                    <span class="text-gray-500 hover:underline">
                        {{ open ? 'Read less' : 'Read more' }}
                    </span>
                </DisclosureButton>
            </Disclosure>
        </section>
        <!-- Post Attachments -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 my-2">
            <div v-for="att of post.attachments">
                <div v-if="isImage(att)" class="relative w-fit">
                    <img :src="att.url" alt="" class="object-cover rounded-lg">
                    <span class="cursor-pointer absolute top-3 right-3 text-white backdrop-brightness-90 p-3 rounded-lg backdrop-blur-lg">
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
        </section>
        <!-- Post Actions -->
        <section class="mt-4 w-full flex gap-10">
            <button class="flex gap-1 hover:gap-2 transition-all text-slate-500 group">
                <HeartIcon class="w-5 h-5 text-pink-400 group-hover:scale-150 transition-all group-hover:text-red-500 animate-pulse"/>
                Like
            </button>
            <button class="flex gap-1 hover:gap-2 transition-all text-slate-500 group">
                <ChatBubbleOvalLeftEllipsisIcon class="w-5 h-5 text-sky-400 group-hover:scale-150 transition-all group-hover:text-blue-500" />
                Comment
            </button>
        </section>
    </div>
</template>