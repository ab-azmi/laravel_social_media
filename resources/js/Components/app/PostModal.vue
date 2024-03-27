<script setup lang="ts">
import { watch, computed, ref } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { Post, Attachment } from '@/types';
import { useForm } from '@inertiajs/vue3';
import PostUserHeader from './PostUserHeader.vue';
import { BookmarkIcon, PaperClipIcon, XMarkIcon, DocumentIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/outline';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps<{
    post?: Post | null,
    modelValue: boolean
}>()

const emit = defineEmits(['update:modelValue'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const postForm = useForm({
    body: props.post?.body,
    attachments: Array<File>()
})

const attachments = ref<Array<Attachment>>([])

const editor = ClassicEditor
const editorConfig = {
    toolbar: {
        items: [
            'undo',
            'redo',
            'heading',
            '|',
            'bold',
            'italic',
            'link',
            '|',
            'blockQuote',
            'bulletedList',
            'numberedList',
            '|',
            'outdent',
            'indent',
        ]
    },
}

//update postForm.body when post changes
watch(() => props.post, (post: Post | null | undefined) => {
    postForm.body = post?.body
})

function closeModal() {
    show.value = false
    postForm.body = ''
    attachments.value = []
}

function submitForm() {
    postForm.attachments = attachments.value.map(att => att.file as File);

    if (props.post) {
        postForm.put(route('posts.update', props.post?.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            }
        })
    } else {
        postForm.post(route('posts.store'), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            }
        })
    }

}

async function onAttachmentChoose($event: Event) {
    for (const file of ($event.target as HTMLInputElement | null)?.files ?? []) {
        var att = {
            name: file.name,
            file: file,
            path: await readFile(file),
            mime: file.type
        }

        attachments.value.push(att)
    }
}

async function readFile(file: File) {
    return new Promise<string>((resolve, reject) => {
        if (isImage({ mime: file.type })) {
            const reader = new FileReader()
            reader.onload = () => {
                resolve(reader.result as string)
            }
            reader.onerror = reject
            reader.readAsDataURL(file)
        } else {
            resolve('')
        }
    })

}

function isImage(attachment: { mime: string }) {
    const mime = attachment.mime.split('/')[0];
    return mime.toLowerCase() === 'image';
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
                                <DialogTitle as="div"
                                    class="text-lg font-medium leading-6 text-gray-900 flex justify-between items-center">
                                    <h1 v-if="post">Update Post</h1>
                                    <h1 v-else>Create Post</h1>
                                    <button>
                                        <XMarkIcon
                                            class="w-5 h-5 text-gray-500 hover:scale-110 transition-all hover:text-blue-500"
                                            @click="closeModal" />
                                    </button>
                                </DialogTitle>

                                <div class="my-4" v-if="post">
                                    <PostUserHeader :post="post" />
                                </div>

                                <div class="mt-2">
                                    <ckeditor :editor="editor" v-model="postForm.body" :config="editorConfig">
                                    </ckeditor>

                                </div>

                                <section v-if="attachments" class="grid grid-cols-1 lg:grid-cols-2 gap-3 my-2">
                                    <div v-for="(att, i) of attachments.slice(0, 4)">
                                        <div v-if="i === 3" class="bg-slate-100 rounded-lg overflow-hidden w-full h-full text-slate-600">
                                            <div v-if="isImage(att)" class="relative w-fit">
                                                <img :src="att.path" alt="" class="object-cover rounded-lg blur-lg brightness-75">
                                                <span class="absolute top-1/2 left-[30%] text-white"> +{{ attachments.length - 3 }} more</span>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div v-if="isImage(att)" class="relative w-fit">
                                                <img :src="att.path" alt="" class="object-cover rounded-lg">
                                                <span @click="attachments.splice(attachments.indexOf(att), 1)"
                                                    class="cursor-pointer absolute top-3 right-3 text-white backdrop-brightness-90 p-3 rounded-lg backdrop-blur-lg">
                                                    <TrashIcon class="w-5 h-5" />
                                                </span>
                                            </div>
                                            <div v-else
                                                class="group flex items-center bg-slate-100 rounded-lg py-6 px-3 justify-between text-slate-600 cursor-pointer">
                                                <div class="flex gap-3">
                                                    <DocumentIcon class="w-6 h-6 text-slate-500" />
                                                    {{ att.name?.substring(0, 10) }}...
                                                </div>
    
                                                <span @click="attachments.splice(attachments.indexOf(att), 1)"
                                                    class="hidden group-hover:block">
                                                    <TrashIcon class="w-6 h-6 text-slate-500" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <div class="mt-4 flex gap-4 justify-end">
                                    <button type="button"
                                        class="relative overflow-hidden inline-flex gap-2 items-center justify-center rounded-md border border-transparent bg-purple-100 px-4 py-2 text-sm font-medium text-purple-900 hover:bg-purple-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2">
                                        <PaperClipIcon class="w-4 h-4" />
                                        Attachments
                                        <input multiple @change="onAttachmentChoose" type="file"
                                            class="absolute top-0 left-0 opacity-0">
                                    </button>
                                    <button type="button"
                                        class="inline-flex gap-2 items-center justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="submitForm">
                                        <BookmarkIcon class="w-4 h-4" />
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