import { ref } from "vue"

export const success = ref('')
export const error = ref('')
export const warning = ref('')

export const hideToast = (whichToHide: string) => {
    if (whichToHide === 'success') {
        success.value = ''
    }else if (whichToHide === 'error') {
        error.value = ''
    }else if (whichToHide === 'warning') {
        warning.value = ''
    }
}
