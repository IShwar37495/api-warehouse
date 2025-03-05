<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const primaryColor = '#fe4d01';
const isModalOpen = ref(false);
const photoPreview = ref(null);
const photoInput = ref(null);

const form = useForm({
    photo: null,
});

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    photoPreview.value = null;
    if (photoInput.value) {
        photoInput.value.value = null;
    }
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const file = photoInput.value.files[0];

    if (!file) return;

    // Validate file type and size
    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (!validTypes.includes(file.type)) {
        alert('Please upload a valid image (JPEG, PNG, or GIF)');
        return;
    }

    if (file.size > maxSize) {
        alert('File is too large. Maximum size is 5MB');
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };
    reader.readAsDataURL(file);

    form.photo = file;
};

const uploadPhoto = () => {
    form.post(route('user.addProfilePic'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            closeModal();
        }
    });
};
</script>

<template>
    <div>
        <!-- Add Picture Button -->
        <button
            @click="openModal"
            class="px-4 py-2 rounded-md transition-all duration-300"
            :style="{
                backgroundColor: primaryColor,
                color: 'white',
                hover: `background-color: ${primaryColor}E0`
            }"
        >
            Add Profile Picture
        </button>

        <!-- Modal Overlay -->
        <div
            v-if="isModalOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
            @click.self="closeModal"
        >
            <!-- Modal Content -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-96 p-6 relative"
                @click.stop
            >
                <!-- Close Button -->
                <button
                    @click="closeModal"
                    class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2
                    class="text-xl font-bold mb-4 text-center"
                    :style="{ color: primaryColor }"
                >
                    Upload Profile Picture
                </h2>

                <!-- Hidden File Input -->
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    accept="image/jpeg,image/png,image/gif"
                    @change="updatePhotoPreview"
                >

                <!-- Image Preview Container -->
                <div
                    class="flex items-center justify-center mb-4 relative group cursor-pointer"
                    @click="selectNewPhoto"
                >
                    <div
                        class="w-32 h-32 rounded-full border-4 flex items-center justify-center overflow-hidden transition-all duration-300 hover:scale-105"
                        :style="{
                            borderColor: primaryColor,
                            backgroundColor: `${primaryColor}10`
                        }"
                    >
                        <img
                            v-if="photoPreview"
                            :src="photoPreview"
                            alt="Profile Preview"
                            class="w-full h-full object-cover"
                        >
                        <div
                            v-else
                            class="text-center flex flex-col items-center justify-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-12 w-12 mb-2 text-gray-500"
                                :style="{ color: primaryColor }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            <span
                                class="text-sm"
                                :style="{ color: primaryColor }"
                            >
                                Click to upload
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center space-x-4">
                    <button
                        type="button"
                        class="px-4 py-2 rounded-md transition-all duration-300 flex items-center justify-center"
                        :class="{
                            'opacity-50 cursor-not-allowed': !photoPreview,
                            'hover:scale-105': photoPreview
                        }"
                        :style="{
                            backgroundColor: photoPreview ? primaryColor : `${primaryColor}50`,
                            color: 'white'
                        }"
                        :disabled="!photoPreview"
                        @click="uploadPhoto"
                    >
                        Upload Photo
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Additional custom styles can be added here */
.hover\:scale-105:hover {
    transform: scale(1.05);
}
</style>
