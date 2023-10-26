<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CommentsSection from '@/Components/CommentsSection.vue';
import { Head, Link } from '@inertiajs/vue3';
import CommentIcon from '@/Components/CommentIcon.vue';
import HeartIcon from '@/Components/HeartIcon.vue';

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
    <Head title="主页" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">主页 / 帖子</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex flex-row gap-4">
                    <div class="basis-2/12"></div>

                    <div class="basis-8/12">
                        <!-- 帖子正文 -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-24 py-20">
                            <article class="prose lg:prose-xl max-w-none">
                                <h2>{{ post.title }}</h2>
                                <div class="not-prose">
                                    <div class="space-x-8 text-sm">
                                        <span>发表 / {{ post.updated_at }}</span>
                                        <span>评论 / {{ post.comments_count }}</span>
                                        <span>点赞 / {{ post.likes_count }}</span>
                                    </div>
                                    <div class="font-bold mt-8">{{ post.author.name }}</div>
                                    <div class="space-x-8 text-sm">
                                        <span>帖子 / {{ post.author.posts_count }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div v-html="post.body"></div>
                            </article>
                        </div>

                        <!-- 评论区 -->
                        <div
                            class="mt-8 space-y-4"
                            id="comments-section"
                        >
                            <CommentsSection :url="route('posts.comments.index', { post: post.id })"></CommentsSection>
                        </div>
                    </div>

                    <!-- 侧边按钮 -->
                    <div class="basis-1/12">
                        <div class="fixed bottom-0 mb-8 space-y-4">
                            <ul class="menu menu-md bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <li>
                                    <a @click="toggleLike">
                                        <HeartIcon :class="{ 'fill-pink-600 stroke-pink-600': post.is_liked }"></HeartIcon>
                                    </a>
                                </li>
                                <li>
                                    <a href="#comments-section">
                                        <CommentIcon></CommentIcon>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu menu-md bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <li>
                                    <a href="#">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-6 h-6"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18"
                                            />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
