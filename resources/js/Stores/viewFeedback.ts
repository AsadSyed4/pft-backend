import { ref } from "vue"

type Client = {
    id: number;
    username: string;
}

type SingleFeedback = {
    id: number;
    title: string;
    description: string;
    category: string;
    client_id: number;
    client: Client;
    comments: Comment[];
    vote_count: number;
    created_at: string;
    updated_at: string;
}
type Comment = {
    id: number;
    client_id: number;
    client: Client;
    feedback_id: number;
    content: string;
    visible: boolean;
    created_at: string;
    updated_at: string;
}

export const viewModal = ref(false)
export const viewLoader = ref(false)
export const feedback = ref<SingleFeedback|null>()
