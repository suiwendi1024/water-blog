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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">主页</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex flex-row gap-4">
                    <div class="basis-3/12">
                        <!-- 帖子排行榜 -->
                        <ul class="menu bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <li
                                v-for="(item, index) in list"
                                :key="item.id"
                            >
                                <a
                                    :href="item.href"
                                    target="_blank"
                                >
                                    <span
                                        class="badge badge-sm"
                                        :class="index < 3 ? 'badge-secondary' : 'badge-neutral'"
                                    >
                                        {{ ++index }}
                                    </span>
                                    {{ item.title }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="basis-7/12 space-y-4">
                        <!-- 帖子列表 -->
                        <BlogEntry
                            v-for="post in laravelData.data"
                            :key="post.id"
                            :post="post"
                        ></BlogEntry>

                        <TailwindPagination
                            :data="laravelData"
                            @pagination-change-page="getResults"
                        ></TailwindPagination>
                    </div>

                    <div class="basis-2/12">
                        <!-- 分类菜单 -->
                        <div class="sticky top-0">
                            <ul class="menu menu-lg bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <li
                                    v-for="(category, index) in categories"
                                    :key="category.id"
                                >
                                    <Link
                                        v-if="!index"
                                        :href="route('posts.index')"
                                        :class="{ active: !currentCategory }"
                                        :only="['posts']"
                                    >
                                    {{ category.title }}
                                    </Link>
                                    <Link
                                        v-else
                                        :href="route('posts.index', { category: category.id })"
                                        :class="{ active: category.id == currentCategory }"
                                        :only="['posts']"
                                    >
                                    {{ category.title }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
