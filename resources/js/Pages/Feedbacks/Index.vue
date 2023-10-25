<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { error } from "@/Stores/toast";
import { viewModal, viewLoader,feedback } from "@/Stores/viewFeedback";
import { deleteModal, dataForDelete } from "@/Stores/deleteModal";
import FeedbackView from "./Partials/FeedbackView.vue"
import DeleteFeedback from "./Partials/DeleteFeedback.vue"
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

type Client = {
    id: number;
    username: string;
}

const emit = defineEmits(['deleted']);

type Feedback = {
    id: number;
    title: string;
    description: string;
    category: string;
    client_id: number;
    client: Client;
    vote_count: number;
    created_at: string;
    updated_at: string;
}

const props=defineProps<{
    feedbacks: any,
}>();

const feedbacks = ref<Feedback[]>([])

feedbacks.value = props.feedbacks.data

const handleDelete = (data: Feedback) => {
    deleteModal.value = true
    dataForDelete.value = data
}

const handleView = (data: Feedback) => {
    viewModal.value = true
    viewLoader.value = true
    axios
        .get(route('feedbacks.id',data.id))
        .then(response => {
            if (response.status === 200) {
                feedback.value = response.data.data
            } else {
                error.value = response.data.message;
                viewModal.value = false
            }
        })
        .catch(error => {
            error.value = error.message;
            viewModal.value = false
        }).finally(() => {
            viewLoader.value = false
        })
    dataForDelete.value = data
}

const removeData=(id: number | undefined)=>{
    if (id) {
    feedbacks.value = feedbacks.value.filter((f: Feedback) => f.id !== id);
  }
}

</script>

<template>
    <Head title="Feedbacks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Feedbacks</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="relative overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Posted By
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Votes
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Posted at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="feedback in feedbacks" :key="feedback.id"
                                class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ feedback.client.username }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ feedback.title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ feedback.category }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ feedback.vote_count }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ feedback.created_at }}
                                </td>
                                <td class="px-6 py-4">
                                    <a @click="handleView(feedback)"
                                        class="font-medium cursor-pointer text-blue-600 dark:text-blue-500 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a @click="handleDelete(feedback)"
                                        class="ml-2 font-medium cursor-pointer text-red-600 dark:text-red-500 hover:underline">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="feedbacks.length === 0"
                                class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="px-6 py-4">
                                </td>
                                <td class="px-6 py-4">
                                </td>
                                <th class="px-6 py-4">
                                    No Record Found.
                                </th>
                                <td class="px-6 py-4">
                                </td>
                                <td class="px-6 py-4">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex">
                    <Link v-if="$page.props.feedbacks.prev_page_url" :href="$page.props.feedbacks.prev_page_url"
                        class="flex items-center justify-center px-4 h-10 mr-3 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5H1m0 0 4 4M1 5l4-4" />
                    </svg>
                    Previous
                    </Link>
                    <Link v-if="$page.props.feedbacks.next_page_url" :href="$page.props.feedbacks.next_page_url"
                        class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Next
                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                    </Link>
                </div>
                <DeleteFeedback @custom-deleted="removeData"/>
                <FeedbackView/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.top-custom {
    top: -25px;
}

.rounded-10 {
    border-radius: 10px;
}
</style>
