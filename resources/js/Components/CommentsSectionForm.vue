<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['created'])

const form = useForm({
    body: '',
})

const submit = () => {
    axios.post(props.url, form.data()).then(({ data }) => {
        emit('created', data)
        form.reset()
    }).catch(error => {
        form.setError(error.response.data.errors)
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <div>
            <textarea
                id="body"
                ref="body"
                v-model="form.body"
                class="textarea textarea-bordered mt-1 block w-full"
                placeholder="评论一下吧"
            ></textarea>

            <InputError
                v-for="message in form.errors.body"
                :message="message"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                发表评论
            </PrimaryButton>
        </div>
    </form>
</template>
