<script setup lang="ts">
import GroupItem from '@/Components/app/GroupItem.vue';
import TextInput from '@/Components/TextInput.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';
import { _show_group, toggleShowGroup } from '@/utils/persistentState';

const search = ref<string>('');


</script>

<template>

    <Disclosure :default-open="_show_group">
        <DisclosurePanel>
            <DisclosureButton @click="toggleShowGroup" class="flex justify-between w-full items-center">
                <div>
                    <h2 class="text-xl font-bold">My Groups</h2>
                </div>
                <span>
                    <ChevronDownIcon v-if="!_show_group" class="w-5 h-5 text-slate-500" />
                    <ChevronUpIcon v-else class="w-5 h-5 text-slate-500" />
                </span>
            </DisclosureButton>

            <div class="py-3">
                <TextInput :model-value="search" placeholder="search" class="w-full" />
            </div>

            <div v-if="false" class="text-gray-400 py-4 h-fit">
                You are not joined any group
            </div>
            <div v-else class="py-4 max-h-[500px] overflow-auto">
                <GroupItem image="https://source.unsplash.com/random/100x100" title="Laravel Developer"
                    description="lorem ipsum dolor sit ames nit usum ni mundo" />
                <GroupItem image="https://source.unsplash.com/random/100x100" title="Laravel Developer"
                    description="lorem ipsum dolor sit ames nit usum ni mundo" />
                <GroupItem image="https://source.unsplash.com/random/100x100" title="Laravel Developer"
                    description="lorem ipsum dolor sit ames nit usum ni mundo" />


            </div>
        </DisclosurePanel>
        <DisclosureButton @click="toggleShowGroup" class="flex justify-between w-full items-center">
            <div>
                <h2 v-if="!_show_group" class="text-xl font-bold">My Groups</h2>
                <h2 v-else class="text-base font-bold text-slate-500">Hide</h2>
            </div>
            <span>
                <ChevronDownIcon v-if="!_show_group" class="w-5 h-5 text-slate-500" />
                <ChevronUpIcon v-else class="w-5 h-5 text-slate-500" />
            </span>
        </DisclosureButton>
    </Disclosure>


</template>