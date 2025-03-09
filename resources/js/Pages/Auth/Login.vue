<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const isLoading = ref(false);
const showPassword = ref(false);

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    isLoading.value = true;
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => {
            form.reset("password");
            isLoading.value = false;
        },
    });
};

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
    <Head title="Log in" />

    <div
        class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800"
    >
        <AuthenticationCard
            class="w-full max-w-md overflow-hidden transition-all duration-300 bg-white shadow-2xl rounded-2xl dark:bg-gray-800"
        >
            <template #logo>
                <div class="flex flex-col items-center mb-6">
                    <img
                        src="/images/image.png"
                        alt="API Warehouse Logo"
                        class="object-contain w-40 h-32 transition-transform duration-500 hover:scale-105"
                    />
                    <h1
                        class="mt-4 text-2xl font-bold text-gray-800 dark:text-white"
                    >
                        Welcome Back
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Sign in to access your account
                    </p>
                </div>
            </template>

            <div
                v-if="status"
                class="p-3 mb-6 text-sm font-medium text-green-600 border-l-4 border-green-500 rounded-lg bg-green-50 dark:bg-green-900/30 dark:text-green-400"
            >
                {{ status }}
            </div>

            <div class="mb-6">
                <a
                    href="/auth/google"
                    class="flex items-center justify-center w-full px-6 py-3 transition duration-300 transform bg-white border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:-translate-y-1 hover:shadow-lg group"
                >
                    <svg
                        class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4"
                        />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853"
                        />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05"
                        />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335"
                        />
                    </svg>
                    <span class="font-medium text-gray-800 dark:text-gray-200"
                        >Continue with Google</span
                    >
                </a>

                <div class="relative flex items-center justify-center my-6">
                    <div
                        class="w-full border-t border-gray-300 dark:border-gray-600"
                    ></div>
                    <span
                        class="absolute px-3 text-xs text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800"
                        >or continue with email</span
                    >
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <div class="group">
                    <InputLabel
                        for="email"
                        value="Email"
                        class="block mb-1 font-medium text-gray-700 transition-all duration-200 dark:text-gray-300 group-focus-within:text-orange-500"
                    />
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 flex items-center text-gray-500 left-3 dark:text-gray-400"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M21 5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2Z"
                                />
                                <path d="m3 7 9 6 9-6" />
                            </svg>
                        </span>
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="block w-full py-3 pl-10 pr-3 mt-1 transition-all duration-200 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-orange-500/50 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-orange-500 focus:border-orange-500 dark:text-white"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="your@email.com"
                        />
                    </div>
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="group">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="block mb-1 font-medium text-gray-700 transition-all duration-200 dark:text-gray-300 group-focus-within:text-orange-500"
                    />
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 flex items-center text-gray-500 left-3 dark:text-gray-400"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    width="18"
                                    height="11"
                                    x="3"
                                    y="11"
                                    rx="2"
                                    ry="2"
                                />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <TextInput
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            class="block w-full py-3 pl-10 pr-12 mt-1 transition-all duration-200 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-orange-500/50 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-orange-500 focus:border-orange-500 dark:text-white"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <button
                            type="button"
                            @click="togglePasswordVisibility"
                            class="absolute inset-y-0 flex items-center text-gray-500 right-3 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                        >
                            <svg
                                v-if="!showPassword"
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"
                                />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                                <path
                                    d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"
                                />
                                <path
                                    d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"
                                />
                                <line x1="2" x2="22" y1="2" y2="22" />
                            </svg>
                        </button>
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <Checkbox
                            v-model:checked="form.remember"
                            name="remember"
                            class="text-orange-500 border-gray-300 rounded focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600"
                        />
                        <span
                            class="text-sm text-gray-600 ms-2 dark:text-gray-400"
                            >Remember me</span
                        >
                    </label>

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm font-medium text-orange-500 transition-colors duration-200 hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-300"
                    >
                        Forgot password?
                    </Link>
                </div>

                <PrimaryButton
                    class="relative w-full px-4 py-3 mt-2 overflow-hidden font-medium text-white transition-all duration-300 rounded-lg shadow-md bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 hover:shadow-lg dark:from-orange-500 dark:to-orange-600 dark:hover:from-orange-600 dark:hover:to-orange-700"
                    :class="{ 'opacity-75': form.processing || isLoading }"
                    :disabled="form.processing || isLoading"
                >
                    <span v-if="!isLoading">Log in</span>
                    <span v-else class="flex items-center justify-center">
                        <svg
                            class="w-4 h-4 mr-2 -ml-1 text-white animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        Signing in...
                    </span>
                </PrimaryButton>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <Link
                        :href="route('register')"
                        class="font-medium text-orange-500 transition-colors duration-200 hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-300"
                    >
                        Sign up now
                    </Link>
                </p>
            </div>
        </AuthenticationCard>
    </div>
</template>
