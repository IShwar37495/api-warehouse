<template>
    <div
        class="relative p-6 bg-white border border-gray-200 dark:bg-gray-900 rounded-xl dark:border-gray-700"
    >
        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
            {{ title }}
        </h3>
        <div class="relative">
            <pre
                class="p-6 overflow-x-auto font-mono text-sm text-gray-900 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200"
            ><code>{{ code }}</code></pre>
            <button
                @click="copyCode"
                class="absolute p-2 text-gray-500 transition-colors bg-gray-100 rounded-lg top-3 right-3 hover:text-[#FE4D01] dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white"
                title="Copy to clipboard"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-4m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                    />
                </svg>
            </button>
            <div
                v-if="showCopySuccess"
                class="absolute px-2 py-1 text-sm text-white bg-green-500 rounded-md top-3 right-12"
            >
                Copied!
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref } from "vue";

// Component props
const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    code: {
        type: String,
        required: true,
    },
});

// Local state for copy success message
const showCopySuccess = ref(false);

// Copy code to clipboard
const copyCode = () => {
    navigator.clipboard.writeText(props.code);
    showCopySuccess.value = true;
    setTimeout(() => {
        showCopySuccess.value = false;
    }, 2000);
};
</script>
