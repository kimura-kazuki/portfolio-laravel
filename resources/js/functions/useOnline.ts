import { ref } from 'vue';

export default function useOnline() {
    const isOnline: any = ref(navigator.onLine);

    window.addEventListener('online', () => {
        isOnline.value = true;
    });
    window.addEventListener('offline', () => {
        isOnline.value = false;
    });

    return { isOnline };
}
