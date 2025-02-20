<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const methods = ["GET", "POST", "PUT", "PATCH", "DELETE"];
const authTypes = ["None", "API Key", "Bearer Token", "OAuth2", "Basic Auth"];

// Initialize empty parameter arrays
const queryParams = ref([
    { name: "", type: "string", required: false, description: "" },
]);
const headers = ref([{ name: "", value: "", required: false }]);
const pathParams = ref([{ name: "", type: "string", description: "" }]);

// Active tab tracking
const activeParamTab = ref("query"); // Default to query parameters tab

// Tab switching function
const switchParamTab = (tab) => {
    activeParamTab.value = tab;
};

// Functions to add/remove parameters
const addQueryParam = () => {
    queryParams.value.push({
        name: "",
        type: "string",
        required: false,
        description: "",
    });
};

const removeQueryParam = (index) => {
    queryParams.value.splice(index, 1);
};

const addHeader = () => {
    headers.value.push({ name: "", value: "", required: false });
};

const removeHeader = (index) => {
    headers.value.splice(index, 1);
};

const addPathParam = () => {
    pathParams.value.push({ name: "", type: "string", description: "" });
};

const removePathParam = (index) => {
    pathParams.value.splice(index, 1);
};

// Parameter types
const paramTypes = ["string", "number", "boolean", "array", "object"];

const form = useForm({
    name: "",
    description: "",
    endpoint: "",
    method: "GET",
    authentication: "None",
    queryParameters: [],
    headers: [],
    pathParameters: [],
    requestBody: "{}",
    response: "",
});

const successMessage = ref("");
const errorMessages = ref({});
const showSuccessMessage = ref(false);

const submit = () => {
    form.queryParameters = JSON.stringify(queryParams.value);
    form.headers = JSON.stringify(headers.value);
    form.pathParameters = JSON.stringify(pathParams.value);

    form.post(route("admin.api.store"), {
        onSuccess: () => {
            form.reset();
            queryParams.value = [
                { name: "", type: "string", required: false, description: "" },
            ];
            headers.value = [{ name: "", value: "", required: false }];
            pathParams.value = [{ name: "", type: "string", description: "" }];

            successMessage.value = "API has been successfully created!";
            showSuccessMessage.value = true;

            // Hide success message after 5 seconds
            setTimeout(() => {
                showSuccessMessage.value = false;
            }, 5000);
        },
        onError: (errors) => {
            errorMessages.value = errors;
        },
    });
};
</script>

<template>
    <AppLayout>
        <div
            class="max-w-5xl p-8 mx-auto bg-white shadow-xl dark:bg-gray-800 rounded-xl"
        >
            <h2
                class="pb-4 mb-8 text-3xl font-bold text-gray-800 border-b border-gray-200 dark:text-white dark:border-gray-700"
            >
                Create New API Endpoint
            </h2>

            <!-- Success message -->
            <div
                v-if="showSuccessMessage"
                class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded"
                role="alert"
            >
                <span class="block sm:inline">{{ successMessage }}</span>
                <button
                    @click="showSuccessMessage = false"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3"
                >
                    <span class="sr-only">Close</span>
                    <svg
                        class="w-6 h-6 text-green-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <!-- Error messages -->
            <div
                v-if="Object.keys(errorMessages).length > 0"
                class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded"
                role="alert"
            >
                <strong class="font-bold">Errors:</strong>
                <ul class="pl-5 mt-2 list-disc">
                    <li v-for="(error, field) in errorMessages" :key="field">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Basic Information Section -->
                <div
                    class="p-6 bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600"
                >
                    <h3
                        class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-200"
                    >
                        Basic Information
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- API Name -->
                        <div class="col-span-1">
                            <label
                                class="block mb-2 font-medium text-gray-700 dark:text-gray-300"
                                >API Name</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full px-4 py-3 placeholder-gray-500 border border-gray-300 rounded-lg shadow-sm dark:border-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white dark:placeholder-gray-300"
                                placeholder="User Authentication API"
                                required
                            />
                        </div>

                        <!-- Method -->
                        <div class="col-span-1">
                            <label
                                class="block mb-2 font-medium text-gray-700 dark:text-gray-300"
                                >HTTP Method</label
                            >
                            <select
                                v-model="form.method"
                                class="w-full px-4 py-3 bg-no-repeat border border-gray-300 rounded-lg shadow-sm appearance-none dark:border-gray-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white bg-right-8 bg-chevron-down"
                            >
                                <option
                                    value=""
                                    disabled
                                    class="text-gray-500 dark:text-gray-300"
                                >
                                    Select Method
                                </option>
                                <option
                                    v-for="method in methods"
                                    :key="method"
                                    :value="method"
                                >
                                    {{ method }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Endpoint -->
                    <div class="mt-4">
                        <label
                            class="block mb-2 font-medium text-gray-700 dark:text-gray-300"
                            >Endpoint</label
                        >
                        <div class="flex items-center">
                            <span
                                class="px-3 py-3 text-gray-600 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                            >
                                /api/v1/
                            </span>

                            <input
                                v-model="form.endpoint"
                                type="text"
                                class="flex-1 px-4 py-3 placeholder-gray-500 border border-gray-300 rounded-r-lg dark:border-gray-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white dark:placeholder-gray-300"
                                placeholder="users/authenticate"
                                required
                            />
                        </div>
                    </div>

                    <!-- Authentication -->
                    <div class="mt-4">
                        <label
                            class="block mb-2 font-medium text-gray-700 dark:text-gray-300"
                            >Authentication Type</label
                        >
                        <select
                            v-model="form.authentication"
                            class="w-full px-4 py-3 bg-no-repeat border border-gray-300 rounded-lg shadow-sm appearance-none dark:border-gray-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white bg-right-8 bg-chevron-down"
                        >
                            <option
                                v-for="auth in authTypes"
                                :key="auth"
                                :value="auth"
                            >
                                {{ auth }}
                            </option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label
                            class="block mb-2 font-medium text-gray-700 dark:text-gray-300"
                            >Description</label
                        >
                        <textarea
                            v-model="form.description"
                            class="w-full px-4 py-3 placeholder-gray-500 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white dark:placeholder-gray-300"
                            rows="3"
                            placeholder="This API endpoint authenticates users and returns a JWT token."
                            required
                        ></textarea>
                    </div>
                </div>

                <!-- Parameters Section -->
                <div
                    class="p-6 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700"
                >
                    <h3
                        class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300"
                    >
                        Request Parameters
                    </h3>

                    <!-- Tabs for Different Parameter Types -->
                    <div
                        class="mb-6 border-b border-gray-200 dark:border-gray-700"
                    >
                        <ul class="flex flex-wrap -mb-px">
                            <li class="mr-2">
                                <button
                                    type="button"
                                    @click="switchParamTab('query')"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="[
                                        activeParamTab === 'query'
                                            ? 'border-orange-500 text-orange-600 dark:text-orange-400'
                                            : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-white dark:text-white',
                                    ]"
                                >
                                    Query Parameters
                                </button>
                            </li>
                            <li class="mr-2">
                                <button
                                    type="button"
                                    @click="switchParamTab('headers')"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="[
                                        activeParamTab === 'headers'
                                            ? 'border-orange-500 text-orange-600 dark:text-orange-400'
                                            : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-white dark:text-white',
                                    ]"
                                >
                                    Headers
                                </button>
                            </li>
                            <li class="mr-2">
                                <button
                                    type="button"
                                    @click="switchParamTab('path')"
                                    class="inline-block p-4 border-b-2 rounded-t-lg"
                                    :class="[
                                        activeParamTab === 'path'
                                            ? 'border-orange-500 text-orange-600 dark:text-orange-400'
                                            : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-white dark:text-white',
                                    ]"
                                >
                                    Path Parameters
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Query Parameters Tab -->
                    <div v-if="activeParamTab === 'query'">
                        <div
                            v-for="(param, index) in queryParams"
                            :key="`query-${index}`"
                            class="grid items-center grid-cols-12 gap-4 mb-4"
                        >
                            <div class="col-span-3">
                                <input
                                    v-model="param.name"
                                    placeholder="Parameter name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:placeholder-gray-400 dark:text-white"
                                />
                            </div>
                            <div class="col-span-2">
                                <select
                                    v-model="param.type"
                                    class="w-full px-3 py-2 bg-no-repeat border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white bg-right-4 bg-chevron-down"
                                >
                                    <option
                                        v-for="type in paramTypes"
                                        :key="type"
                                        :value="type"
                                    >
                                        {{ type }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-1 text-center">
                                <input
                                    v-model="param.required"
                                    type="checkbox"
                                    class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-900"
                                />
                                <span
                                    class="ml-1 text-sm text-gray-500 dark:text-gray-200"
                                    >Required</span
                                >
                            </div>
                            <div class="col-span-5">
                                <input
                                    v-model="param.description"
                                    placeholder="Description"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:placeholder-bg-gray-400 dark:text-white"
                                />
                            </div>
                            <div class="flex justify-end col-span-1">
                                <button
                                    @click="removeQueryParam(index)"
                                    type="button"
                                    class="text-red-500 hover:text-red-700 dark:hover:text-red-400"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button
                            @click="addQueryParam"
                            type="button"
                            class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Add Query Parameter
                        </button>
                    </div>

                    <!-- Headers Tab -->
                    <div v-if="activeParamTab === 'headers'">
                        <div
                            v-for="(header, index) in headers"
                            :key="`header-${index}`"
                            class="grid items-center grid-cols-12 gap-4 mb-4"
                        >
                            <div class="col-span-4">
                                <input
                                    v-model="header.name"
                                    placeholder="Header name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white"
                                />
                            </div>
                            <div class="col-span-6">
                                <input
                                    v-model="header.value"
                                    placeholder="Header value"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white"
                                />
                            </div>
                            <div class="col-span-1 text-center">
                                <input
                                    v-model="header.required"
                                    type="checkbox"
                                    class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-900"
                                />
                                <span
                                    class="ml-1 text-sm text-gray-500 dark:text-gray-400"
                                    >Required</span
                                >
                            </div>
                            <div class="flex justify-end col-span-1">
                                <button
                                    @click="removeHeader(index)"
                                    type="button"
                                    class="text-red-500 hover:text-red-700 dark:hover:text-red-400"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button
                            @click="addHeader"
                            type="button"
                            class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Add Header
                        </button>
                    </div>

                    <!-- Path Parameters Tab -->
                    <div v-if="activeParamTab === 'path'">
                        <div
                            v-for="(param, index) in pathParams"
                            :key="`path-${index}`"
                            class="grid items-center grid-cols-12 gap-4 mb-4"
                        >
                            <div class="col-span-3">
                                <input
                                    v-model="param.name"
                                    placeholder="Parameter name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white"
                                />
                            </div>
                            <div class="col-span-3">
                                <select
                                    v-model="param.type"
                                    class="w-full px-3 py-2 bg-no-repeat border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white bg-right-4 bg-chevron-down"
                                >
                                    <option
                                        v-for="type in paramTypes"
                                        :key="type"
                                        :value="type"
                                    >
                                        {{ type }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-5">
                                <input
                                    v-model="param.description"
                                    placeholder="Description (e.g. 'User ID to fetch')"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:placeholder-bg-gray-200 dark:text-white"
                                />
                            </div>
                            <div class="flex justify-end col-span-1">
                                <button
                                    @click="removePathParam(index)"
                                    type="button"
                                    class="text-red-500 hover:text-red-700 dark:hover:text-red-400"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div
                            class="p-3 mt-2 mb-4 text-sm text-gray-600 border-l-4 border-orange-500 rounded-md dark:text-gray-400 bg-orange-50 dark:bg-gray-700"
                        >
                            <p>
                                <strong>Note:</strong> Path parameters are
                                specified in your endpoint URL like
                                <code>/users/{userId}</code>. The parameter
                                names here should match those in your endpoint.
                            </p>
                        </div>

                        <button
                            @click="addPathParam"
                            type="button"
                            class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Add Path Parameter
                        </button>
                    </div>
                </div>

                <!-- Request Body (for POST, PUT, PATCH) -->
                <div
                    v-if="['POST', 'PUT', 'PATCH'].includes(form.method)"
                    class="p-6 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-700"
                >
                    <h3
                        class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300"
                    >
                        Request Body
                    </h3>
                    <textarea
                        v-model="form.requestBody"
                        class="w-full px-4 py-3 font-mono text-sm border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:text-white"
                        rows="8"
                        placeholder='{"username": "string","password": "string"}'
                    ></textarea>
                </div>

                <!-- Response Section -->
                <div
                    class="p-6 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-700"
                >
                    <h3
                        class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300"
                    >
                        Response
                    </h3>

                    <div
                        class="overflow-hidden border border-gray-300 rounded-lg h-96 dark:border-gray-600"
                    >
                        <textarea
                            v-model="form.response"
                            class="w-full p-3 font-mono text-gray-900 bg-white border border-gray-300 rounded-lg h-96 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100"
                            placeholder="Enter API response here..."
                        ></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-[#FE4D01] hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:-translate-y-1"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 mr-2"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Create API
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>
.bg-right-8 {
    background-position: right 0.8rem center;
}

.bg-right-4 {
    background-position: right 0.4rem center;
}

.bg-chevron-down {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-size: 1.25em;
}

/* Enhanced Dark Mode Styles */
.dark .ql-toolbar {
    border-color: rgb(75 85 99) !important;
    background-color: rgb(31 41 55) !important;
}

.dark .ql-toolbar .ql-stroke {
    stroke: rgb(209 213 219) !important;
}

.dark .ql-toolbar .ql-fill {
    fill: rgb(209 213 219) !important;
}

.dark .ql-toolbar .ql-picker-label {
    color: rgb(209 213 219) !important;
}

.dark .ql-container {
    border-color: rgb(75 85 99) !important;
    background-color: rgb(17 24 39) !important;
}

.dark .ql-editor {
    color: rgb(243 244 246) !important;
}

.dark .ql-snow .ql-picker-options {
    background-color: rgb(31 41 55) !important;
    border-color: rgb(75 85 99) !important;
}

.dark .ql-snow .ql-picker-item {
    color: rgb(209 213 219) !important;
}
</style>
