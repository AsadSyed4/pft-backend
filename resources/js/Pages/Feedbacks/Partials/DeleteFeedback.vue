<script setup lang="ts">
import DangerButton from '@/Components/DangerButton.vue';
import { deleteModal, dataForDelete } from "@/Stores/deleteModal";
import { success, error } from "@/Stores/toast";
import Modal from '@/Components/Modal.vue';
import axios from 'axios';

const emits = defineEmits(['custom-deleted'])

const closeModal = () => {
    deleteModal.value = false
    dataForDelete.value = null
}
const destroyData = async () => {
    axios
        .delete(route('feedbacks.destroy', dataForDelete.value?.id))
        .then(response => {
            if (response.status === 200) {
                emits('custom-deleted', dataForDelete.value?.id);
                success.value = 'Deleted successfully';
            } else {
                error.value = response.data.message;
            }
        })
        .catch(error => {
            error.value = error.message;
        })
        .finally(() => {
            closeModal()
        });
};
</script>
<template>
    <Modal :show="deleteModal" @close="closeModal">
        <button type="button" @click="closeModal"
            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="popup-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <div class="p-6 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want
                to delete {{ dataForDelete?.title }} ?</h3>
            <DangerButton @click="destroyData"> Yes, I'm sure</DangerButton>
            <button data-modal-hide="popup-modal" type="button" @click="closeModal"
                class="inline-flex items-center ml-2 px-4 py-2 bg-white-600 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 text-gray-500 bg-gray-200 hover:bg-gray-100 focus:ring-gray-200 border-gray-200 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                cancel</button>
        </div>
    </Modal>
</template>
