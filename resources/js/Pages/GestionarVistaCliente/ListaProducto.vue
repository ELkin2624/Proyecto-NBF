<template>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold mb-4">Catálogo de Productos</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="product in products" :key="product.id" class="border rounded-lg p-4 shadow">
          <img :src="product.image" alt="Imagen del producto" class="h-40 w-full object-cover mb-4">
          <h2 class="text-lg font-semibold">{{ product.name }}</h2>
          <p class="text-gray-500">{{ product.description }}</p>
          <p class="text-xl font-bold text-blue-600">{{ product.price | currency }}</p>
          <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Ver detalles</button>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        products: [],
      };
    },
    async created() {
      try {
        const response = await fetch('/api/products'); // Ruta para obtener los productos desde Laravel
        this.products = await response.json();
      } catch (error) {
        console.error("Error al obtener los productos:", error);
      }
    },
  };
  </script>

  <style scoped>
  /* Puedes añadir estilos específicos aquí si deseas personalizar */
  </style>
