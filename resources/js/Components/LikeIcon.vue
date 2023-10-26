<script setup>
import HeartIcon from '@/Components/HeartIcon.vue';

const props = defineProps({
    isLiked: {
        type: Boolean,
        required: true,
    },
});

</script>

<template>
    <HeartIcon :class="{ 'fill-red-500 stroke-red-500': isLiked }"></HeartIcon>
</template>
