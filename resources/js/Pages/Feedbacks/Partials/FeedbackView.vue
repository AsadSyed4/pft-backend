<script setup lang="ts">
import { viewModal, viewLoader, feedback } from "@/Stores/viewFeedback";
import { success, error } from "@/Stores/toast";
import Modal from '@/Components/Modal.vue';
import axios from 'axios';

const closeModal = () => {
    viewModal.value = false
    feedback.value = null
}

const changeVisibility = async (commentId: number, visible: boolean) => {
    let params = { id: commentId, visible: visible }
    axios
        .post(route('comments.change.visibility'), params)
        .then(response => {
            if (response.status === 200) {
                let index: any = feedback.value?.comments.findIndex((comment: any) => comment.id === commentId);
                if (index !== -1) {
                    const commentToUpdate = feedback.value.comments[index];
                    commentToUpdate.visible = visible;
                    feedback.value.comments[index] = commentToUpdate;
                }
                success.value = 'Visibility updated successfully';
            } else {
                error.value = response.data.message;
            }
        })
        .catch(error => {
            error.value = error.message;
        });
};
</script>

<template>
    <Modal :show="viewModal" @close="closeModal">
        <button type="button" @click="closeModal"
            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="popup-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <div v-if="!viewLoader" class="p-6 text-center">
            <div v-if="feedback" class="mt-4">
                <h2 class="text-2xl font-semibold mb-2">{{ feedback.title }}</h2>
                <p class="text-gray-600 mb-4">{{ feedback.description }}</p>

                <div class="flex justify-between items-center text-gray-600 flex-wrap">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="font-semibold">Posted by:</span>
                        <span class="truncate w-24 sm:w-auto">{{ feedback.client.username }}</span>
                    </div>
                    <div class="flex items-center space-x-2 mb-2 sm:mb-0">
                        <span class="font-semibold">Votes:</span>
                        <span>{{ feedback.vote_count }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="font-semibold">Posted at:</span>
                        <span>{{ feedback.created_at }}</span>
                    </div>
                </div>
                <div class="mt-4 bg-gray-100 rounded">
                    <div v-for="comment in feedback.comments" :key="comment.id" class="bg-gray-300 p-3 my-2 rounded">
                        <p class="text-gray-600">{{ comment.content }}</p>
                        <div class="flex justify-between items-center mt-2">
                            <div>
                                <p class="text-xs text-gray-600">
                                    <span class="font-semibold">{{ comment.client.username }}</span> @
                                    {{ comment.created_at }}
                                </p>
                            </div>
                            <div>
                                <i @click="changeVisibility(comment.id, !comment.visible)"
                                    class="fas cursor-pointer text-gray-600 ml-2"
                                    :class="{ 'fa-eye': comment.visible, 'fa-eye-slash': !comment.visible }"></i>
                            </div>
                        </div>
                    </div>

                    <div v-if="feedback.comments.length === 0" class="p-3 my-2">
                        <p class="text-gray-600">No comments.</p>
                    </div>
                </div>
            </div>
            <h3 v-else class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Data Not Found.
            </h3>
        </div>
        <div v-if="viewLoader" class="flex items-center justify-center p-5">
            <div class="loader border-t-4 border-blue-500 border-solid rounded-full w-16 h-16 animate-spin">
            </div>
        </div>
    </Modal>
</template>
