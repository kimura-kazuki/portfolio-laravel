<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const textarea = ref(null);

onMounted(() => {
    // if (textarea.value.hasAttribute('autofocus')) {
    //     textarea.value.focus();
    // }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>

<template>
    <textarea
        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
</template>
