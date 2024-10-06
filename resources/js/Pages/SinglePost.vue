<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { onMounted } from 'vue';

const props = defineProps({
    post: Object,
    comments: Array,
    currentUser: Object, 
});
onMounted(() => {
    const refreshValue = localStorage.getItem('refresh');
    if(refreshValue == 1) {
        localStorage.removeItem('refresh');
        window.location.reload();
    }
});
const commentForm = ref({
    comment: '',
});

const addComment = async () => {
    try {
        await axios.post(`/posts/${props.post.id}/comments`, {
            comment: commentForm.value.comment,
        });
        window.location.reload();
    } catch (error) {
        console.log('Error adding comment', error);
    }
};

const deleteComment = async (commentId) => {
    if (confirm('Are you sure you want to delete this comment?')) {
        try {
            localStorage.setItem('refresh', 1);
            await axios.delete(`/comments/${commentId}`);
        } catch (error) {
            console.log('Error deleting comment', error);
        }
    }
};

const canDeleteComment = (comment) => {
    return (
        props.currentUser &&
        (props.currentUser.role === 'admin' ||
            props.currentUser.id === comment.user.id ||
            props.currentUser.id === props.post.user_id)
    );
};
</script>

<template>
    <Head title="Post Details" />

    <component :is="props.currentUser ? AuthenticatedLayout : GuestLayout">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ props.post.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">{{ props.post.title }}</h3>
                        <p class="text-gray-600">By {{ props.post.user.name }} on {{ new Date(props.post.created_at).toLocaleString() }}</p>
                        <p class="mt-4">{{ props.post.content }}</p>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold">Comments</h4>

                        <div v-if="props.currentUser" class="mt-4">
                            <textarea v-model="commentForm.comment" placeholder="Add your comment" class="w-full p-2 border rounded-md"></textarea>
                            <button @click="addComment" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Post Comment</button>
                        </div>

                        <div v-else class="mt-4">
                            <p class="text-gray-500">Please log in to add a comment.</p>
                        </div>

                        <div class="mt-6">
                            <div v-for="comment in props.comments" :key="comment.id" class="border-b border-gray-300 py-4">
                                <p><strong>{{ comment.user.name }}:</strong> {{ comment.comment }}</p>
                                <p class="text-sm text-gray-500">{{ new Date(comment.created_at).toLocaleString() }}</p>

                                <div v-if="canDeleteComment(comment)">
                                    <form >
                                        <button @click.stop="deleteComment(comment.id)" class="text-red-500">Delete comment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>
