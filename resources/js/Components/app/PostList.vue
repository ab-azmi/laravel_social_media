<script setup lang="ts">
import PostItem from '@/Components/app/PostItem.vue';

type Post = {
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

const posts: Array<Post> = [
    {
        id: 1,
        user: {
            name: 'John Doe',
            username: 'johndoe',
            avatar: 'https://randomuser.me/api/portraits/men/3.jpg'
        },
        body: `<p><strong>John Doe</strong> is a web developer and designer. He is working on a project called <strong>social media web</strong> and he is using <strong>Laravel 8</strong> and <strong>Tailwind CSS</strong> to build it.</p>`,
        created_at: '2021-10-10 10:00',
        group: null,
        attachments: [
            {
                id: 1,
                name: 'laravel.png',
                url: 'https://source.unsplash.com/random/500x500?car',
                mime: 'image/png'
            },
            {
                id: 2,
                name: 'tailwind.png',
                url: 'https://source.unsplash.com/random/700x700?cat',
                mime: 'image/png'
            },
            {
                id: 3,
                name: 'docum.docx',
                url: '#',
                mime: 'application/msword'
            }
        ]
    },
    {
        id: 2,
        user: {
            name: 'Janneth Upton',
            username: 'janedoe',
            avatar: 'https://randomuser.me/api/portraits/women/45.jpg',
        },
        body: `<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa rem possimus incidunt repellendus perferendis animi necessitatibus quo consequuntur vero, doloremque accusantium esse optio eos alias libero quidem quis voluptas nihil. Blanditiis officia vitae id aperiam dolorum corrupti repellat eaque consequatur dolores, amet ipsam placeat quas accusantium sequi totam, consequuntur architecto.</p>`,
        created_at: '2021-10-10 10:00',
        group: {
            id: 1,
            name: 'Laravel'
        },
    }
]

</script>

<template>
    <div class="">

        <template v-for="post in posts" :key="post.id">
            <PostItem :post="post"/>
            
        </template>
    </div>
</template>