<script setup>
import axios from 'axios';
import CommentsSectionDropdown from '@/Components/CommentsSectionDropdown.vue';
import LikeIcon from '@/Components/LikeIcon.vue';

const props = defineProps({
    comment: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['deleted'])

const toggleLike = () => {
    let method = props.comment.is_liked ? 'delete' : 'post'
    let url = route('comments.likes.store', { comment: props.comment.id })

    axios[method](url).then(() => {
        props.comment.likes_count += props.comment.is_liked ? -1 : 1
        props.comment.is_liked = !props.comment.is_liked
    })
}
</script>

<template>
    <article>
        <h4 class="font-bold">
            <a
                href="#"
                target="_blank"
            >{{ comment.owner.name }}</a>
        </h4>
        <div v-html="comment.body"></div>
        <div class="flex justify-between -mb-2">
            <div class="card-actions items-center text-gray-600 text-sm">
                <div>{{ comment.created_at }}</div>
                <a
                    href=""
                    @click.prevent="toggleLike"
                >
                    <LikeIcon :is-liked="comment.is_liked"></LikeIcon>
                </a>
                {{ comment.likes_count }}
            </div>
            <CommentsSectionDropdown
                :id="comment.id"
                :can-delete="comment.owner.id == $page.props.auth.user.id"
                @deleted="$emit('deleted')"
            ></CommentsSectionDropdown>
        </div>
    </article>
</template>
