<script setup>
import CommentIcon from '@/Components/CommentIcon.vue';
import LikeIcon from '@/Components/LikeIcon.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
})

const toggleLike = () => {
    let method = props.post.is_liked ? 'delete' : 'post'
    let url = route('posts.likes.store', { post: props.post.id })

    axios[method](url).then(() => {
        props.post.likes_count += props.post.is_liked ? -1 : 1
        props.post.is_liked = !props.post.is_liked
    })
}
</script>

<template>
    <div class="card bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <article class="card-body">
            <h2 class="card-title">
                <a
                    :href="post.href"
                    target="_blank"
                    class="link link-primary link-hover"
                >{{ post.title }}</a>
            </h2>
            <div
                v-html="post.beginning"
                class="line-clamp-2 text-gray-600"
            ></div>
            <div class="card-actions items-center text-gray-600">
                <h4 class="font-bold">{{ post.author.name }}</h4>
                <div class="badge badge-outline">{{ post.category.title }}</div>
                <CommentIcon></CommentIcon> {{ post.comments_count }}
                <a
                    href=""
                    @click.prevent="toggleLike"
                >
                    <LikeIcon :is-liked="post.is_liked"></LikeIcon>
                </a>
                {{ post.likes_count }}
            </div>
        </article>
    </div></template>
