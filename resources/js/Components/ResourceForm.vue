<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

let categories = ref([]);
let title = ref("");
let description = ref("");
let link = ref("");
let category_id = ref(null);

onMounted(()=>{
    axios.get("/api/categories").then((response)=>{
        categories.value = response.data;
    })
})

function createResource(){
    axios
      .post("api/resources",{
            title: title.value,
            description: description.value,
            link: link.value,
            category_id: category_id.value,
    })
    .then((response)=>{
        window.location.href="/";
    })
    .catch((error)=>{
        alert(error.message);
    })
}
</script>

<template>
    <form class="py-2 px-6 bg-white rounded-xl max-w-sm mx-auto text-center">
        <div class="m-8 text-gray-800 grid">
            <label class="mb-2">Titulo del recurso</label>
            <input
                class="border border-gray-300 py-3 px-4 rounded-lg focus:border-indigo-500 outline-none
                focus:ring-1 focus:ring-indigo-500"
                type="text" v-model="title"/>

            <label class="mb-2">Descripción del recurso</label>
            <input
                class="border border-gray-300 py-3 px-4 rounded-lg focus:border-indigo-500 outline-none
                focus:ring-1 focus:ring-indigo-500"
                type="text" v-model="description"/>

            <label class="mb-2">Link del recurso</label>
            <input
                class="border border-gray-300 py-3 px-4 rounded-lg focus:border-indigo-500 outline-none
                focus:ring-1 focus:ring-indigo-500"
                type="text" v-model="link"/>

            <label class="mb-2">¿De que categoria es?</label>
            <select
                class="border border-gray-300 py-3 px-4 rounded-lg focus:border-indigo-500 outline-none
                focus:ring-1 focus:ring-indigo-500"
                 v-model="category_id">
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 my-2 rounded focus:outline-none focus:shadow-outline"
                type = "submit" @click="createResource">Crear recurso</button>
        </div>
    </form>
</template>
