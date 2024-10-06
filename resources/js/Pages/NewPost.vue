<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

// Stanje za formu
const title = ref('');
const content = ref('');
const errors = ref({});

const submit = async () => {
    try {
        const response = await axios.post('/posts', {
            title: title.value,
            content: content.value,
        });

        window.location.href = '/posts-view';
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors; 
        } else {
            console.error('Unexpected error:', error); 
        }
    }
};
</script>

<template>
    <Head title="Create New Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create New Post
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    Title
                                </label>
                                <input
                                    v-model="title"
                                    type="text"
                                    id="title"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                />
                                <span v-if="errors.title" class="text-red-600 text-sm">{{ errors.title[0] }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">
                                    Content
                                </label>
                                <textarea
                                    v-model="content"
                                    id="content"
                                    rows="5"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                ></textarea>
                                <span v-if="errors.content" class="text-red-600 text-sm">{{ errors.content[0] }}</span>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="px-4 py-2 font-semibold text-white bg-green-500 rounded-lg shadow hover:bg-green-600"
                                >
                                    Create Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
