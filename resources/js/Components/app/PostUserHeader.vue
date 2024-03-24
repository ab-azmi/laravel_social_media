<script setup lang="ts">
import { Post } from '../../types';
import {ChevronRightIcon} from '@heroicons/vue/24/solid';

defineProps<{
    post: Post | null
}>();

function formatDate(dateString: string) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options as Intl.DateTimeFormatOptions);
}
</script>

<template>
    <div class="flex gap-3 items-center">
        <a href="#" class="w-10 h-10 rounded-full overflow-hidden block">
        <img :src="post?.user.avatar_path" alt="" class="h-full object-cover hover:scale-125 transition-all">
    </a>
    <div class="flex flex-col gap-1">
        <div class="flex gap-2 items-center">
            <a href="#" class="font-bold hover:underline">{{ post?.user.name }}</a>
            <span v-if="post?.group">
                <ChevronRightIcon class="w-3 h-3 text-slate-800" />
            </span>
            <a v-if="post?.group" href="#" class="font-bold hover:underline">{{ post?.group?.name }}</a>
        </div>
        <p class="text-xs text-slate-500">{{ formatDate(post?.updated_at ?? '') }}</p>
    </div>
    </div>
</template>