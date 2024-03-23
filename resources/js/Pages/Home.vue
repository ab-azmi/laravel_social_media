<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GroupList from '@/Components/app/GroupList.vue';
import FollowerList from '@/Components/app/FollowerList.vue';
import PostList from '@/Components/app/PostList.vue';
import CreatePost from '@/Components/app/CreatePost.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import { Post } from '@/types';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    posts?: Object;
}>();
</script>

<template>

    <Head title="Social Media Web" />

    <AuthenticatedLayout>

    <main class="grid lg:grid-cols-12 gap-4 px-5 py-6 relative">
        <!-- Groups -->
        <div class="lg:col-span-3 row-start-1 row-end-2 bg-white p-3 rounded-lg h-fit lg:sticky lg:top-6">
            <GroupList/>
        </div>
        <div class="lg:col-span-6 row-start-3 row-end-4 lg:row-auto">
            <div class="bg-white p-3 rounded-lg mt-3 lg:mt-0 lg:mb-5">
                <CreatePost/>
            </div>
            <div class="">
                <PostList :posts="posts"/>
            </div>
        </div>
        <div class="lg:col-span-3 row-start-2 row-end-3 lg:row-auto bg-white p-3 rounded-lg h-fit lg:sticky lg:top-6">
            <FollowerList/>
        </div>
    </main>
</AuthenticatedLayout>
</template>

<style>

</style>
