<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3'; 

const posts = ref([]);
const loading = ref(true);
const error = ref(null);
const { props } = usePage(); 

onMounted(async () => {
    try {
        const response = await axios.get('/posts');
        posts.value = response.data;
    } catch (err) {
        error.value = 'Failed to load posts.';
    } finally {
        loading.value = false;
    }
});

const deletePost = async (postId) => {
    if (confirm('Are you sure you want to delete this post?')) {
        try {
            await axios.delete(`/posts/${postId}`);
            posts.value = posts.value.filter(post => post.id !== postId);
        } catch (error) {
            alert('Failed to delete the post.');
        }
    }
};
</script>

<template>
    <Head title="Posts" />
    <template v-if="props.auth.user">
        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Posts
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div v-if="loading">Loading posts...</div>
                            <div v-if="error" class="text-red-500">{{ error }}</div>
                            <button
                                @click="$inertia.get(`/posts/create`)"
                                class="text-blue-600 hover:text-blue-800"
                                style="margin-bottom:10px"
                            >
                                Add new post
                            </button>
                            <table v-if="!loading && posts.length > 0" class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Post Title</th>
                                        <th class="px-4 py-2 text-left">Post Content</th>
                                        <th class="px-4 py-2 text-left">Author</th>
                                        <th class="px-4 py-2 text-left">Date of creation</th>
                                        <th class="px-4 py-2 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="post in posts" :key="post.id" class="border-t">
                                        <a :href="`/posts/${post.id}`">
    <td class="px-4 py-2" style="color:blue">{{ post.title }}</td>
</a>
                                        <td class="px-4 py-2">{{ post.content }}</td>
                                        <td class="px-4 py-2">{{ post.user.name }}</td>
                                        <td class="px-4 py-2">{{ new Date(post.created_at).toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' }) }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <button
                                                v-if="post.user_id === props.auth.user.id"
                                                @click="$inertia.get(`/posts/${post.id}/edit`)"
                                                class="text-blue-600 hover:text-blue-800"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                v-if="post.user_id === props.auth.user.id || props.auth.user.role === 'admin'"
                                                @click="deletePost(post.id)"
                                                class="ml-4 text-red-600 hover:text-red-800"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-if="!loading && posts.length === 0">
                                No posts available.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
    <template v-else>
        <GuestLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Posts
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div v-if="loading">Loading posts...</div>
                            <div v-if="error" class="text-red-500">{{ error }}</div>

                            <table v-if="!loading && posts.length > 0" class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Post Title</th>
                                        <th class="px-4 py-2 text-left">Post Content</th>
                                        <th class="px-4 py-2 text-left">Author</th>
                                        <th class="px-4 py-2 text-left">Date of creation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="post in posts" :key="post.id" class="border-t">
                                        <a :href="`/posts/${post.id}`">
    <td class="px-4 py-2" style="color:blue">{{ post.title }}</td>
</a>
                                        <td class="px-4 py-2">{{ post.content }}</td>
                                        <td class="px-4 py-2">{{ post.user.name }}</td>
                                        <td class="px-4 py-2">{{ new Date(post.created_at).toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' }) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-if="!loading && posts.length === 0">
                                No posts available.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </GuestLayout>
    </template>
</template>
