<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CommentsSection from '@/Components/CommentsSection.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
})
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
                    <div class="basis-8/12 mx-auto">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <article class="prose lg:prose-xl max-w-none px-24 py-20">
                                <h2>{{ post.title }}</h2>
                                <h4 class="font-bold">{{ post.author.name }}</h4>
                                <div v-html="post.body"></div>
                            </article>
                        </div>

                        <div class="mt-8 space-y-4">
                            <CommentsSection :url="route('posts.comments.index', { post: post.id })"></CommentsSection>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
