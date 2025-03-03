<template>
    <AppLayout title="API Documentation">
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <HeroSection />
            <div class="max-w-6xl px-4 py-12 mx-auto">
                <ProcessSteps />
                <AuthenticationSection />
                <FrameworkTabs />
                <ErrorHandling />
                <AdditionalResources />
            </div>
        </div>
        <Footer />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Footer from "@/Layouts/Footer.vue";
import HeroSection from "@/Components/ApiDemo/HeroSection.vue";
import ProcessSteps from "@/Components/ApiDemo/ProcessSteps.vue";
import AuthenticationSection from "@/Components/ApiDemo/AuthenticationSection.vue";
import FrameworkTabs from "@/Components/ApiDemo/FrameworkTabs.vue";
import ErrorHandling from "@/Components/ApiDemo/ErrorHandling.vue";
import AdditionalResources from "@/Components/ApiDemo/AdditionalResources.vue";
</script>

<style scoped>
/* Add any page-specific styles here */
</style>
