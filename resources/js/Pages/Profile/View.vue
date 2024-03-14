<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TabItem from '@/Components/app/TabItem.vue';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import Edit from './Edit.vue';
import { User } from '@/types';
import { computed, ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { CheckCircleIcon, PencilSquareIcon, XCircleIcon } from '@heroicons/vue/24/solid';
import Notification from '@/Components/app/Notification.vue';

const props = defineProps<{
    mustVerifyEmail: boolean;
    status?: string;
    user: User,
    errors: {
        cover: string;
        avatar: string;
    },
}>();

const imagesForm = useForm<{
    cover: File | string | undefined | null;
    avatar: File | string | undefined | null;

}>({
    cover: props.user.cover_path,
    avatar: props.user.avatar_path,
})
const coverImageSrc = ref<string | null>(null);

const isMyProfile = computed(() => {
    return props.user?.id === usePage().props.auth?.user?.id;
});

function onCoverChange(e: Event) {
    imagesForm.cover = (e.target as HTMLInputElement).files?.[0];

    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = (e) => {
            coverImageSrc.value = e.target?.result as string;
        }
        reader.readAsDataURL(imagesForm.cover);
    }
}

function cancleCoverChange() {
    coverImageSrc.value = null;
    imagesForm.cover = null;
}

function submitCoverChange(){
    imagesForm.post(route('profile.update-images', props.user.id));
    cancleCoverChange();
}

console.log(props.status);
</script>

<template>
    <AuthenticatedLayout>
        <main class="container mx-auto my-5">

            <Notification :status="status" :message="errors.cover" />

            <!-- Cover -->
            <section class="relative">
                <div class="w-full h-[280px] overflow-hidden rounded-t-lg ">
                    <img class="w-full object-cover" :src="coverImageSrc || user.cover_path || '/img/forrest.jpg'"
                        alt="" srcset="">
                </div>
                <div
                    class="absolute bottom-7 w-[40%] flex gap-3 items-center left-7 rounded-full p-4 backdrop-brightness-90 backdrop-blur-md">
                    <div class="w-24 rounded-full overflow-hidden border-2 border-x-pink-400">
                        <img src="https://randomuser.me/api/portraits/women/56.jpg" alt="" srcset="">
                    </div>
                    <div class="text-white">
                        <h1 class="text-lg">{{ user.name }}</h1>
                        <p class="text-sm">{{ user.email }}</p>
                    </div>
                </div>
                <div class="absolute top-5 right-5" v-if="isMyProfile">
                    <!-- Cover action button -->
                    <div v-if="coverImageSrc" class="flex gap-2">
                        <button
                            class="px-3 py-2 backdrop-blur-lg backdrop-brightness-50 rounded-md text-white flex items-center gap-3 text-sm hover:scale-110 transition-all overflow-hidden"
                            @click="cancleCoverChange">
                            <XCircleIcon class="w-5 h-5 text-red-500" />
                            Cancle
                        </button>
                        <button
                            class="px-3 py-2 backdrop-blur-lg backdrop-brightness-50 rounded-md text-white flex items-center gap-3 text-sm hover:scale-110 transition-all overflow-hidden"
                            @click="submitCoverChange">
                            <CheckCircleIcon class="w-5 h-5 text-green-500" />
                            Submit
                        </button>
                    </div>
                    <button v-else
                        class="px-3 py-2 backdrop-blur-lg backdrop-brightness-50 rounded-md text-white flex items-center gap-3 text-sm hover:scale-110 transition-all overflow-hidden">
                        <PencilSquareIcon class="w-4 h-4" />
                        Update cover
                        <input type="file" name="" id="" class="absolute opacity-0 cursor-pointer"
                            @change="onCoverChange">
                    </button>
                </div>
            </section>

            <!-- Tabs -->
            <section>
                <TabGroup>
                    <TabList class="flex space-x-1 rounded-b-lg overflow-hidden bg-white">
                        <Tab as="template" key="about" v-if="isMyProfile" v-slot="{ selected }">
                            <TabItem label="About" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="posts" v-slot="{ selected }">
                            <TabItem label="Posts" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="followers" v-slot="{ selected }">
                            <TabItem label="Followers" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="followings" v-slot="{ selected }">
                            <TabItem label="Followings" :selected="selected" />
                        </Tab>
                        <Tab as="template" key="photos" v-slot="{ selected }">
                            <TabItem label="Photos" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel key="about" :class="[
                        'rounded-xl bg-white p-3',
                        ' focus:outline-none ring-0',
                    ]" v-if="isMyProfile">
                            <Edit :must-verify-email="mustVerifyEmail" :status="status" />
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
