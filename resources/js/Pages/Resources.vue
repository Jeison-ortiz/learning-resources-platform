<script setup>
import { Head, Link } from '@inertiajs/vue3';
import axios  from "axios";
import { onMounted, defineProps, ref,watch } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    resources: {
        type: Array,
    },
    categories: {
        type: Array,
    },
    voterId: {
        type:String,
    },
});

let filteredCategory = ref(null);
let search = ref("");
let filteredResources = ref([]);

watch(search, (value) => {
    axios.get("/api/resources?search=" + value + "&category="+ filteredCategory.value).then((response)=>{
        filteredResources.value = response.data;

    });
})

watch(filteredCategory, (value) => {
    axios.get("/api/resources?category=" + value + "&search=" + search.value).then((response)=>{
        filteredResources.value = response.data;

    });
})

onMounted(()=>{
    console.log("Recursos cargados!", props.resources);
    filteredResources.value = props.resources;
})

function vote(resourceId){
    axios.get("/api/vote/" + resourceId).then((response)=>{

        filteredResources.value = filteredResources.value.map((resource)=>{
            if(resource.id===resourceId){
                return response.data
            }
            return resource
        });

    });
}

function youHaveVoted(resource){
    return resource.votes.find((vote)=>vote.code === props.voterId);
}
</script>

<template>
    <Head title="Recursos interesantes para aprender" />

    <div
    class="min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center items-center mb-8">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 26 26"
                    stroke-width="1.5" stroke="currentColor"
                    data-slot="icon"
                    class="w-12 h-12 text-indigo-500">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                </svg>

            </div>
            <div class="relative overflow-x-auto">
                <div>
                    <select v-model="filteredCategory" class="border rounded">
                        <option value="" >Todas las categorias</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <input type="text" placeholder="Buscar..." v-model="search" class=" border rounded" />
                </div>

                <table class="w-full text-sm text-gray-500">
                    <thead class="text-lg text-gray-700 uppercase bg-indigo-500">
                        <tr>
                            <th scope="col" class="p-4">Votos</th>
                            <th scope="col" class="p-4">Recursos</th>
                            <th scope="col">Link</th>
                            <th scope="col">Categoria</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr v-for="resource in filteredResources" :key="resources.id">
                            <th scope="row" class="p-4" text="left">
                                <div class="items-center">
                                    <span class="text-blue-700">
                                        {{ resource.votes.length }}
                                    </span>
                                    <button @click="vote(resource.id)">
                                        <svg
                                            v-if="youHaveVoted(resource)"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-6 h-6 text-red-500">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                        <svg
                                            v-else
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-6 h-6">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    </button>
                                </div>

                            </th>
                            <th scope="row" class="p-4" text="left">{{ resource.title }}</th>
                            <th scope="row" class="p-4">
                                <a target="_blank" :href="resource.link">Ver recurso</a>
                            </th>
                            <th scope="row" class="p-4">{{ resource.category.name }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
