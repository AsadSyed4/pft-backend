<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { deleteModal, dataForDelete } from "@/Stores/deleteModal";
import { Head, Link } from '@inertiajs/vue3';
import DeleteClient from "./Partials/DeleteClient.vue"
import { onBeforeMount, ref } from 'vue';
import axios from 'axios';
type Client = {
    id: number;
    name: string;
    username: string;
    email: string;
    email_verified_at: null | string;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    clients: any,
}>();

const clients = ref<Client[]>([])

onBeforeMount(() => {
    clients.value = props.clients.data
})

const handleDelete = (data: Client) => {
    deleteModal.value = true
    dataForDelete.value = data
}

const removeData=(id: number | undefined)=>{
    if (id) {
        clients.value = clients.value.filter((c: Client) => c.id !== id);
  }
}

</script>

<template>
    <Head title="Clients" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Clients</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="relative overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Joined at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="client in clients" :key="client.id"
                                class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ client.name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ client.username }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ client.email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ client.created_at }}
                                </td>
                                <td class="px-6 py-4">
                                    <a @click="handleDelete(client)"
                                        class="font-medium cursor-pointer text-red-600 dark:text-red-500 hover:underline">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="clients.length === 0" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
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
                    <Link v-if="$page.props.clients.prev_page_url" :href="$page.props.clients.prev_page_url"
                        class="flex items-center justify-center px-4 h-10 mr-3 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5H1m0 0 4 4M1 5l4-4" />
                    </svg>
                    Previous
                    </Link>
                    <Link v-if="$page.props.clients.next_page_url" :href="$page.props.clients.next_page_url"
                        class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Next
                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>

                    </Link>
                </div>
                <DeleteClient @custom-deleted="removeData"/>
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
