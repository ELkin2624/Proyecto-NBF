<template>
    <div class="container mx-auto py-8">
      <h1 class="text-2xl font-bold mb-4">Historial de Compras</h1>
      <div v-if="pedidos.length" class="space-y-4">
        <div v-for="pedido in pedidos" :key="pedido.id" class="border rounded-lg p-4 shadow">
          <h2 class="text-lg font-semibold">Pedido #{{ pedido.id }}</h2>
          <p class="text-gray-500">Fecha: {{ pedido.fecha }}</p>
          <p class="text-gray-500">Estado: {{ pedido.estado }}</p>
          <p class="font-bold">Total: {{ pedido.total }}</p>
        </div>
      </div>
      <p v-else class="text-gray-500">No tienes pedidos aún.</p>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  // Datos simulados
  const pedidos = ref([
    { id: 1, fecha: '2024-11-20', estado: 'Entregado', total: 50.0 },
    { id: 2, fecha: '2024-11-15', estado: 'En camino', total: 30.0 },
  ]);
  </script>
