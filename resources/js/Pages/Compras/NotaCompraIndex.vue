<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-2xl font-bold mb-6">Gestión de Notas de Compra</h1>

      <!-- Botón para crear una nueva nota -->
      <div class="mb-4">
        <a
          href="/notas-compra/create"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Nueva Nota de Compra
        </a>
      </div>

      <!-- Botón para recepcion de producto -->
      <div class="mb-4">
        <a
          href="/notas-compra/create"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Nueva Nota de Compra
        </a>
      </div>

      <!-- Tabla de notas de compra -->
      <table class="min-w-full bg-white rounded shadow-md">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Proveedor</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Fecha Orden</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Estado</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="nota in notasCompra"
            :key="nota.id_nota_compra"
            class="border-b hover:bg-gray-50"
          >
            <td class="px-6 py-4 text-sm text-gray-900">{{ nota.id_nota_compra }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">
                {{ nota.proveedor?.nombre || 'Sin proveedor asignado' }}
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ nota.fecha_orden }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">
              <span
                :class="{
                  'px-2 py-1 text-xs rounded-full': true,
                  'bg-yellow-200 text-yellow-800': nota.estado === 'En espera',
                  'bg-blue-200 text-blue-800': nota.estado === 'En proceso',
                  'bg-green-200 text-green-800': nota.estado === 'Completada',
                  'bg-red-200 text-red-800': nota.estado === 'Cancelada',
                }"
              >
                {{ nota?.estado || 'Estado no disponible'}}
              </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ nota?.total || 0 }} Bs</td>
            <td class="px-6 py-4 flex space-x-2">
              <a
                :href="`/notas-compra/${nota.id_nota_compra}/edit`"
                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm"
              >
                Editar
              </a>

              <!-- Botón para ver historial -->
              <button
                @click="verHistorial(nota.id_nota_compra)"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
              >
                    Ver Historial
              </button>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  import { Link } from "@inertiajs/vue3";
  export default {
    props: {
      notasCompra: Array, // Recibimos las notas de compra desde el servidor
      proveedores:Array,
      productos: Array,
    },
    methods: {
        verHistorial(id) {
            this.$inertia.get(`/notas-compra/${id}/historial`);
        },

        irARecepcion(id) {
            this.$inertia.get(`/notas-compra/${id}/recibir`);
        },
    },
  };
  </script>

  <style>
  /* Agrega estilos personalizados si es necesario */
  </style>
