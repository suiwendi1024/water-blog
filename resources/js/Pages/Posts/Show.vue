<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CommentsSection from '@/Components/CommentsSection.vue';
import { Head } from '@inertiajs/vue3';
import CommentIcon from '@/Components/CommentIcon.vue';
import LikeIcon from '@/Components/LikeIcon.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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

const toggleFollow = () => {
    let method = props.post.author.is_followed ? 'delete' : 'post'
    let url = route('followees.follows.store', { followee: props.post.author.id })

    axios[method](url).then(() => {
        props.post.author.received_follows_count += props.post.author.is_followed ? -1 : 1
        props.post.author.is_followed = !props.post.author.is_followed
    })
}
</script>

<template>
    <Head title="主页" />

    <AuthenticatedLayout>
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
                                    <!-- 数据 -->
                                    <div class="space-x-8 text-sm">
                                        <span>发表 / {{ post.updated_at }}</span>
                                        <span>点赞 / {{ post.likes_count }}</span>
                                        <span>评论 / {{ post.comments_count }}</span>
                                    </div>
                                    <!-- 作者 -->
                                    <div class="flex justify-between mt-8 items-stretch">
                                        <div>
                                            <div class="font-bold">{{ post.author.name }}</div>
                                            <div class="space-x-8 text-sm">
                                                <span>关注 / {{ post.author.received_follows_count }}</span>
                                                <span>帖子 / {{ post.author.posts_count }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <DangerButton v-if="!post.author.is_followed" @click="toggleFollow">关注
                                            </DangerButton>
                                            <PrimaryButton v-else @click="toggleFollow">取消关注</PrimaryButton>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div v-html="post.body"></div>
                            </article>
                        </div>

                        <!-- 评论区 -->
                        <div class="mt-8 space-y-4" id="comments-section">
                            <CommentsSection :url="route('posts.comments.index', { post: post.id })"></CommentsSection>
                        </div>
                    </div>

                    <!-- 侧边按钮 -->
                    <div class="basis-1/12">
                        <div class="fixed bottom-0 mb-8 space-y-4">
                            <ul class="menu menu-md bg-white overflow-hidden shadow-sm sm:rounded-lg p-0 [&_li>*]:rounded-none">
                                <li>
                                    <a @click="toggleLike">
                                        <LikeIcon :is-liked="post.is_liked"></LikeIcon>
                                    </a>
                                </li>
                                <li>
                                    <a href="#comments-section">
                                        <CommentIcon></CommentIcon>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu menu-md bg-white overflow-hidden shadow-sm sm:rounded-lg p-0 [&_li>*]:rounded-none">
                                <li>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
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
