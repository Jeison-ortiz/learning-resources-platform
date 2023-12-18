<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ResourceForm from "@/Components/ResourceForm.vue"
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-4 px-6 mx-auto text-center">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight" >Sugiere un nuevo recurso</h3>
                        <ResourceForm></ResourceForm>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
