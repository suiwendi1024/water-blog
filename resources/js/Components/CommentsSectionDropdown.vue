<script setup>
import axios from 'axios';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
    canDelete: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['deleted'])

const deleteComment = () => {
    if (confirm('您确认要删除吗？')) {
        axios.delete(route('comments.destroy', { comment: props.id })).then(() => {
            emit('deleted')
        })
    }
    return false
}
</script>

<template>
    <Dropdown
        align="right"
        width="48"
    >
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                        />
                    </svg>
                </button>
            </span>
        </template>

        <template #content>
            <DropdownLink
                v-if="canDelete"
                href=""
                as="button"
                @before="deleteComment"
            >
                删除
            </DropdownLink>
            <DropdownLink
                href=""
                @before="false"
            >
                其他
            </DropdownLink>
        </template>
    </Dropdown>
</template>
