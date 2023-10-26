<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import axios from 'axios';

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
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y">
        <article
            v-for="comment in laravelData.data"
            :key="comment.id"
            class="card-body"
        >
            <h4 class="font-bold">
                <a
                    :href="comment.owner.href"
                    target="_blank"
                >{{ comment.owner.name }}</a>
            </h4>
            <div v-html="comment.body"></div>
        </article>
    </div>

    <TailwindPagination
        :data="laravelData"
        @pagination-change-page="getResults"
    ></TailwindPagination>
</template>
