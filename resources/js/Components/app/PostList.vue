<script setup lang="ts">
import PostItem from '@/Components/app/PostItem.vue';
import PostEditModal from './PostEditModal.vue';
import { Post, Posts } from '@/types';
import { ref } from 'vue';

defineProps<{
    posts?: Posts
}>();

const showEditModal = ref(false);
const editPost = ref<Post | null>(null);

function showEdit(post: Post){
    editPost.value = post;
    showEditModal.value = true;
}

</script>

<template>
    <div class="">
        <template v-for="post in posts?.data" :key="post.id">
            <PostItem :post="post" @editModal="showEdit"/>
        </template>
        <PostEditModal :post="editPost" v-model="showEditModal"/>
    </div>
</template>