<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import axios from 'axios';
import CommentsSectionForm from '@/Components/CommentsSectionForm.vue';
import CommentsSectionDropdown from '@/Components/CommentsSectionDropdown.vue';

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
    <div class="bg-white shadow-sm sm:rounded-lg divide-y">
        <!-- 发表评论 -->
        <div class="card-body">
            评论 {{ laravelData.total }}
            <CommentsSectionForm
                :url="url"
                @created="addComment"
            ></CommentsSectionForm>
        </div>
        <!-- 评论列表 -->
        <article
            v-for="(comment, index) in laravelData.data"
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
            <div class="flex justify-between">
                <div class="card-actions items-center text-gray-600">
                    <div>{{ comment.created_at }}</div>
                </div>
                <CommentsSectionDropdown
                    :id="comment.id"
                    :can-delete="comment.owner.id == $page.props.auth.user.id"
                    @deleted="removeComment(index)"
                ></CommentsSectionDropdown>
            </div>
        </article>
    </div>

    <TailwindPagination
        :data="laravelData"
        @pagination-change-page="getResults"
    ></TailwindPagination>
</template>
