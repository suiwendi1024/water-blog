<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import axios from 'axios';
import CommentsSectionForm from '@/Components/CommentsSectionForm.vue';
import CommentsSectionComment from '@/Components/CommentsSectionComment.vue';

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

const addComment = comment => {
    laravelData.value.data.unshift(comment)
    laravelData.value.total++
}

const removeComment = index => {
    laravelData.value.data.splice(index, 1)
    laravelData.value.total--
}
</script>

<template>
    <div class="card bg-white shadow-sm sm:rounded-lg divide-y">
        <!-- 发表评论 -->
        <div class="card-body">
            评论 {{ laravelData.total }}
            <CommentsSectionForm
                :url="url"
                @created="addComment"
            ></CommentsSectionForm>
        </div>
        <!-- 评论列表 -->
        <CommentsSectionComment
            v-for="(comment, index) in laravelData.data"
            :key="comment.id"
            :comment="comment"
            class="card-body"
            @deleted="removeComment(index)"
        ></CommentsSectionComment>
    </div>

    <TailwindPagination
        :data="laravelData"
        @pagination-change-page="getResults"
    ></TailwindPagination>
</template>
