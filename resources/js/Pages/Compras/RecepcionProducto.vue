<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-2xl font-bold mb-6">Recepción de Productos - Nota de Compra</h1>

      <form @submit.prevent="submitForm" class="bg-white p-6 rounded shadow-md space-y-6">
        <!-- Producto y cantidad recibida -->
        <div v-for="(detalle, index) in detalles" :key="detalle.id_detalle_nota_compra" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Producto: {{ detalle.codigo_producto }}</label>
            <p class="text-gray-600">{{ detalle.nombre_producto }}</p>
          </div>

          <div>
            <label for="cantidad_recibida" class="block text-sm font-medium text-gray-700">Cantidad Recibida</label>
            <input
              type="number"
              v-model="detalle.cantidad_recibida"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
              :min="1"
            />
            <span v-if="detalle.cantidad_recibida < detalle.cantidad" class="text-red-500 text-sm">
              La cantidad recibida es menor que la solicitada.
            </span>
          </div>

          <div>
            <label for="detalles_danados" class="block text-sm font-medium text-gray-700">Detalles sobre productos dañados</label>
            <textarea
              v-model="detalle.detalles_danados"
              placeholder="Escriba detalles si hay productos dañados"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
            ></textarea>
          </div>
        </div>

        <!-- Botón de guardar -->
        <div>
          <button
            type="submit"
            class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          >
            Registrar Recepción
          </button>
        </div>
      </form>
    </div>
  </template>

  <script>
  import { useForm } from "@inertiajs/vue3";

  export default {
    props: {
      notaCompra: Object, // Nota de compra cargada desde el backend
      detalles: Array, // Detalles de la nota de compra cargados desde el backend
    },
    setup(props) {
      const form = useForm({
        detalles: props.detalles,
      });

      const submitForm = () => {
        form.put(`/notas_compra/${props.notaCompra.id_nota_compra}/recepcion`, {
          onSuccess: () => {
            alert("Recepción registrada con éxito.");
          },
        });
      };

      return { form, submitForm };
    },
  };
  </script>

  <style>
  /* Estilo adicional si es necesario */
  </style>
