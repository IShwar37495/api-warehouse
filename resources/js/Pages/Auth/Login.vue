<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard
        class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-900"
    >
        <template #logo>
            <img
                src="/images/image.png"
                alt="API Warehouse Logo"
                class="object-contain w-32 h-24"
            />
        </template>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600 dark:text-green-400"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-black dark:text-white"
                />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="block w-full mt-1 border-gray-300 dark:border-gray-700 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 dark:focus:ring-orange-500"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-black dark:text-white"
                />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="block w-full mt-1 border-gray-300 dark:border-gray-700 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 dark:focus:ring-orange-500"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="text-sm text-black ms-2 dark:text-white"
                        >Remember me</span
                    >
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-orange-500 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-600"
                >
                    Forgot your password?
                </Link>
            </div>

            <PrimaryButton
                class="w-full px-4 py-2 text-white transition-all bg-orange-600 rounded-lg hover:bg-orange-500 dark:bg-orange-400 dark:hover:bg-orange-500 dark:text-black"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Log in
            </PrimaryButton>
        </form>
    </AuthenticationCard>
</template>
