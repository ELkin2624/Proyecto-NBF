<template>
    <div class="p-6 bg-gray-800 text-white rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4">Recepción de Productos</h1>

      <div class="mb-6">
        <h2 class="text-xl font-semibold">Detalles de la Nota</h2>
        <p><strong>ID Nota:</strong> {{ notaCompra.id_nota_compra }}</p>
        <p><strong>Proveedor:</strong> {{ notaCompra.proveedor.nombre }}</p>
        <p><strong>Estado Actual:</strong> {{ notaCompra.estado }}</p>
        <p><strong>Total:</strong> ${{ notaCompra.total }}</p>
      </div>

      <form @submit.prevent="registrarRecepcion">
        <h2 class="text-xl font-semibold mb-2">Productos</h2>
        <table class="min-w-full table-auto border-collapse border border-gray-700 text-sm mb-4">
          <thead>
            <tr class="bg-gray-900">
              <th class="border border-gray-700 px-4 py-2">Producto</th>
              <th class="border border-gray-700 px-4 py-2">Cantidad Pedida</th>
              <th class="border border-gray-700 px-4 py-2">Cantidad Recibida</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="producto in productos" :key="producto.codigo_producto" class="hover:bg-gray-700">
              <td class="border border-gray-700 px-4 py-2">{{ producto.nombre }}</td>
              <td class="border border-gray-700 px-4 py-2">{{ producto.cantidad }}</td>
              <td class="border border-gray-700 px-4 py-2">
                <input
                  type="number"
                  v-model="producto.cantidad_recibida"
                  min="0"
                  :max="producto.cantidad"
                  class="bg-gray-700 text-white px-2 py-1 rounded w-full"
                />
              </td>
            </tr>
          </tbody>
        </table>

        <button
          type="submit"
          class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500"
        >
          Registrar Recepción
        </button>
      </form>
    </div>
  </template>

  <script>
  export default {
    props: {
      notaCompra: Object,
      productos: Array,
    },
    methods: {
      async registrarRecepcion() {
        try {
          await this.$inertia.post(`/nota-compra/${this.notaCompra.id_nota_compra}/recibir`, {
            productos: this.productos,
          });
          alert("Recepción registrada exitosamente.");
        } catch (error) {
          console.error(error);
          alert("Ocurrió un error al registrar la recepción.");
        }
      },
    },
  };
  </script>
