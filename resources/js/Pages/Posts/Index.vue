<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BlogEntry from '@/Pages/Posts/Partials/BlogEntry.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';

const props = defineProps({
    list: {
        type: Array,
        required: true,
    },
    posts: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
})

const laravelData = ref(props.posts)

const getResults = (page = 1) => {
    router.visit(route('posts.index', { page }), {
        only: ['posts'],
    })
}

const currentCategory = ref(new URLSearchParams(location.search).get('category'))
</script>

<template>
    <Head title="主页" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-7 col-start-2">
                    <!-- 分类 -->
                    <div class="tabs">
                        <Link v-for="(category, index) in categories" :key="category.id" class="tab" :only="['posts']"
                              :href="!index ? route('posts.index') : route('posts.index', { category: category.id })"
                              :class="{ 'tab-active': !index ? !currentCategory : category.id == currentCategory }">
                        {{ category.title }}
                        </Link>
                    </div>
                </div>

                <div class="col-span-3 flex justify-end">
                    <!-- 发表帖子 -->
                    <Link :href="route('posts.create')" as="button" class="btn btn-warning btn-sm">发表帖子</Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-7 col-start-2">
                        <!-- 帖子列表 -->
                        <article class="card bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y">
                            <BlogEntry v-for="post in laravelData.data" :key="post.id" :post="post"></BlogEntry>
                        </article>

                        <div class="flex justify-end">
                            <TailwindPagination class="mt-4" :data="laravelData" @pagination-change-page="getResults" />
                        </div>
                    </div>

                    <div class="col-span-3">
                        <!-- 帖子排行榜 -->
                        <ul class="menu bg-white overflow-hidden shadow-sm sm:rounded-lg p-0 [&_li>*]:rounded-none">
                            <li class="menu-title text-gray-900 border-b">排行榜</li>
                            <li v-for="(item, index) in list" :key="item.id">
                                <a :href="item.href" target="_blank">
                                    <span class="badge badge-sm" :class="index < 3 ? 'badge-secondary' : 'badge-neutral'">
                                        {{ ++index }}
                                    </span>
                                    {{ item.title }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
