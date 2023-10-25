import { ref } from "vue";

export const success = ref('')
export const error = ref('')
export const warning = ref('')

export const hideToast = (whichToastToHide: string) => {
    if (whichToastToHide === 'success') {
        success.value = ''
    } else if (whichToastToHide === 'error') {
        error.value = ''
    } else if (whichToastToHide === 'warning') {
        warning.value = ''
    }
}
