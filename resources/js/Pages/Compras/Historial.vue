<template>
    <div class="p-6 bg-gray-800 text-white rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4">Historial de Nota de Compra</h1>

      <div class="mb-6">
        <h2 class="text-xl font-semibold">Detalles de la Nota</h2>
        <p><strong>ID Nota:</strong> {{ notaCompra.id_nota_compra }}</p>
        <p><strong>Proveedor:</strong> {{ notaCompra.proveedor.nombre }}</p>
        <p><strong>Estado Actual:</strong> {{ notaCompra.estado }}</p>
        <p><strong>Total:</strong> ${{ notaCompra.total }}</p>
      </div>

      <h2 class="text-xl font-semibold mb-2">Cambios de Estado</h2>
      <table class="min-w-full table-auto border-collapse border border-gray-700 text-sm">
        <thead>
          <tr class="bg-gray-900">
            <th class="border border-gray-700 px-4 py-2">Fecha</th>
            <th class="border border-gray-700 px-4 py-2">Estado Anterior</th>
            <th class="border border-gray-700 px-4 py-2">Estado Nuevo</th>
            <th class="border border-gray-700 px-4 py-2">Detalles</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in historial" :key="item.id_historial" class="hover:bg-gray-700">
            <td class="border border-gray-700 px-4 py-2">{{ formatFecha(item.fecha) }}</td>
            <td class="border border-gray-700 px-4 py-2">{{ item.estado_anterior }}</td>
            <td class="border border-gray-700 px-4 py-2">{{ item.estado_nuevo }}</td>
            <td class="border border-gray-700 px-4 py-2">{{ item.detalles }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  export default {
    props: {
      notaCompra: Object,
      historial: Array,
    },
    methods: {
      formatFecha(fecha) {
        const options = { year: "numeric", month: "long", day: "numeric", hour: "2-digit", minute: "2-digit" };
        return new Date(fecha).toLocaleDateString("es-ES", options);
      },
    },
  };
  </script>

  <style scoped>
  /* Opcional: Personalización adicional */
  </style>
