<script setup lang="ts">
import FollowerItem from '@/Components/app/FollowerItem.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { _show_follower, toggleShowFollower } from '@/utils/persistentState';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/solid';

const search = ref<string>('');

</script>

<template>
    <Disclosure :default-open="_show_follower">
        <DisclosurePanel>
            <DisclosureButton @click="toggleShowFollower" class="flex justify-between w-full items-center">
                <div>
                    <h2 class="text-xl font-bold">My Followers</h2>
                </div>
                <span>
                    <ChevronDownIcon v-if="!_show_follower" class="w-5 h-5 text-slate-500" />
                    <ChevronUpIcon v-else class="w-5 h-5 text-slate-500" />
                </span>
            </DisclosureButton>

            <div class="py-3">
                <TextInput :model-value="search" placeholder="search" class="w-full" />
            </div>

            <div v-if="false" class="text-gray-400 py-4 h-fit">
                You dont have any follower
            </div>
            <div v-else class="py-4 max-h-[500px] overflow-auto">
                <FollowerItem image="https://source.unsplash.com/random/100x100?girl" title="Anjing M" />
                <FollowerItem image="https://source.unsplash.com/random/100x100?girl" title="Anjing M" />
                <FollowerItem image="https://source.unsplash.com/random/100x100?girl" title="Anjing M" />

            </div>
        </DisclosurePanel>
        <DisclosureButton @click="toggleShowFollower" class="flex justify-between w-full items-center">
            <div>
                <h2 v-if="!_show_follower" class="text-xl font-bold">My Followers</h2>
                <h2 v-else class="text-base font-bold text-slate-500">Hide</h2>
            </div>
            <span>
                <ChevronDownIcon v-if="!_show_follower" class="w-5 h-5 text-slate-500" />
                <ChevronUpIcon v-else class="w-5 h-5 text-slate-500" />
            </span>
        </DisclosureButton>
    </Disclosure>


</template>