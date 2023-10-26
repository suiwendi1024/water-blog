<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { router } from '@inertiajs/vue3'

const props = defineProps({
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

                <div class="flex flex-row gap-4 text-gray-900">
                    <div class="basis-3/12">
                    </div>

                    <div class="basis-7/12 space-y-4">
                        <div
                            v-for="post in laravelData.data"
                            :key="post.id"
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                        >
                            <article class="card-body">
                                <h2 class="card-title">{{ post.title }}</h2>
                                <div
                                    v-html="post.beginning"
                                    class="line-clamp-2"
                                ></div>
                                <h4 class="font-bold">{{ post.author.name }}</h4>
                            </article>
                        </div>

                        <TailwindPagination
                            :data="laravelData"
                            @pagination-change-page="getResults"
                        ></TailwindPagination>
                    </div>

                    <div class="basis-2/12">
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