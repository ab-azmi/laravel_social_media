<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TabItem from '@/Components/app/TabItem.vue';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import Edit from './Edit.vue';
import { User } from '@/types';
import {computed, ref} from 'vue';
import { usePage } from '@inertiajs/vue3';


const props = defineProps<{
    mustVerifyEmail: boolean;
    status?: string;
    user: User
}>();

const isMyProfile = computed(() => {
    return props.user?.id === usePage().props.auth?.user?.id;
});
</script>

<template>
    <AuthenticatedLayout>
        <main class="container mx-auto my-5">
            <section class="relative">
                <div class="w-full h-[280px] overflow-hidden rounded-t-lg ">
                    <img class=" object-cover" src="https://source.unsplash.com/1024x500?river" alt="" srcset="">
                </div>
                <div class="absolute bottom-7 w-[40%] flex gap-3 items-center left-7 rounded-full p-4 backdrop-brightness-90 backdrop-blur-md">
                    <div class="w-24 rounded-full overflow-hidden border-2 border-x-pink-400">
                        <img src="https://randomuser.me/api/portraits/women/56.jpg" alt="" srcset="">
                    </div>
                    <div class="text-white">
                        <h1 class="text-lg">{{user.name}}</h1>
                        <p class="text-sm">{{ user.email }}</p>
                    </div>
                </div>
            </section>
            <section>
                <TabGroup>
                    <TabList class="flex space-x-1 rounded-b-lg overflow-hidden bg-white">
                        <Tab as="template" key="about" v-if="isMyProfile"
                            v-slot="{ selected }">
                            <TabItem label="About" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="posts"
                            v-slot="{ selected }">
                            <TabItem label="Posts" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="followers"
                            v-slot="{ selected }">
                            <TabItem label="Followers" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="followings"
                            v-slot="{ selected }">
                            <TabItem label="Followings" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="photos"
                            v-slot="{ selected }">
                            <TabItem label="Photos" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel key="about" :class="[
                            'rounded-xl bg-white p-3',
                            ' focus:outline-none ring-0',
                        ]"  v-if="isMyProfile">
                           <!-- <Edit :must-verify-email="mustVerifyEmail" :status="status" /> -->
                        </TabPanel>
                        <TabPanel key="posts" :class="[
                            'rounded-xl bg-white p-3',
                            ' focus:outline-none ring-0 border-0',
                        ]">
                           Posts
                        </TabPanel>
                        <TabPanel key="followers" :class="[
                            'rounded-xl bg-white p-3',
                            ' focus:outline-none ring-0 border-0',
                        ]">
                           Followers
                        </TabPanel>
                        <TabPanel key="followings" :class="[
                            'rounded-xl bg-white p-3',
                            ' focus:outline-none ring-0 border-0',
                        ]">
                           Followings
                        </TabPanel>
                        <TabPanel key="photos" :class="[
                            'rounded-xl bg-white p-3',
                            ' focus:outline-none ring-0 border-0',
                        ]">
                           Photos
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </section>
        </main>
    </AuthenticatedLayout>
</template>
