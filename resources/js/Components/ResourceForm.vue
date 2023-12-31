<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";

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
const isFormIncomplete = computed(() => {
  return !title.value || !description.value || !link.value || !category_id.value;
});
</script>

<template>
    <form class="py-2 px-6 bg-white rounded-xl max-w-sm mx-auto text-center">
      <div class="m-8 text-gray-800 grid grid-cols-1 gap-4">
        <!-- Título del recurso -->
        <div>
          <label class="mb-2 block">Titulo del recurso</label>
          <input
            class="border border-gray-300 py-3 px-4 rounded-lg w-full focus:border-indigo-500 outline-none
            focus:ring-1 focus:ring-indigo-500"
            type="text"
            v-model="title"
          />
        </div>

        <!-- Link del recurso -->
        <div>
          <label class="mb-2 block">Link del recurso</label>
          <input
            class="border border-gray-300 py-3 px-4 rounded-lg w-full focus:border-indigo-500 outline-none
            focus:ring-1 focus:ring-indigo-500"
            type="text"
            v-model="link"
          />
        </div>

        <!-- Categoría del recurso -->
        <div>
          <label class="mb-2 block">¿De qué categoria es?</label>
          <select
            class="border border-gray-300 py-3 px-4 rounded-lg w-full focus:border-indigo-500 outline-none
            focus:ring-1 focus:ring-indigo-500"
            v-model="category_id"
          >
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <!-- Descripción del recurso -->
        <div>
          <label class="mb-2 block">Descripción del recurso</label>
          <textarea
            class="border border-gray-300 py-3 px-4 rounded-lg w-full focus:border-indigo-500 outline-none
            focus:ring-1 focus:ring-indigo-500"
            v-model="description"
          ></textarea>
        </div>

        <!-- Botón de creación de recurso -->
        <button
          :class="{ 'bg-gray-400': isFormIncomplete, 'bg-blue-500 hover:bg-blue-700': !isFormIncomplete }"
          :disabled="isFormIncomplete"
          class="text-white font-bold py-3 px-4 my-2 rounded focus:outline-none focus:shadow-outline"
          type="button"
          @click="createResource"
        >
          Crear recurso
        </button>
      </div>
    </form>
  </template>
