<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
     <button
        class="px-4 py-2 bg-[#FE4D01] hover:bg-[#D94300] text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-[#FE4D01]"
        v-bind="$attrs"
    >
        <slot />
    </button>
</template>
