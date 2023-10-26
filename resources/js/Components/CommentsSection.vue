<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import axios from 'axios';
import CommentForm from '@/Components/CommentForm.vue';

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
});

const laravelData = ref({})

const getResults = (page = 1) => {
    axios.get(props.url, { params: { page } }).then(({ data }) => {
        laravelData.value = data
    })
}

getResults()

const addComment = (comment) => {
    laravelData.value.data.unshift(comment)
}
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y">
        <div class="card-body">
            评论 {{ laravelData.total }}
            <CommentForm
                :url="url"
                @created="addComment"
            ></CommentForm>
        </div>
        <article
            v-for="comment in laravelData.data"
            :key="comment.id"
            class="card-body"
        >
            <h4 class="font-bold">
                <a
                    href="#"
                    target="_blank"
                >{{ comment.owner.name }}</a>
            </h4>
            <div v-html="comment.body"></div>
            <div class="card-actions items-center text-gray-600">
                <div>{{ comment.created_at }}</div>
            </div>
        </article>
    </div>

    <TailwindPagination
        :data="laravelData"
        @pagination-change-page="getResults"
    ></TailwindPagination></template>
