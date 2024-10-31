<template>
    <div class="p-6 bg-white rounded-lg shadow-md">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Inventario</h1>
        <button
          @click="goToCreate"
          class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-500"
        >
          Agregar Nueva Existencia
        </button>
      </div>

      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b">Código</th>
            <th class="py-2 px-4 border-b">Nombre</th>
            <th class="py-2 px-4 border-b">Cantidad</th>
            <th class="py-2 px-4 border-b">Ubicación</th>
            <th class="py-2 px-4 border-b">Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in inventarios" :key="item.id_inventario">
            <td class="py-2 px-4 border-b">{{ item.producto.codigo }}</td>
            <td class="py-2 px-4 border-b">{{ item.producto.nombre }}</td>
            <td class="py-2 px-4 border-b">{{ item.cantidad }}</td>
            <td class="py-2 px-4 border-b">{{ item.inventario.ubicacion || 'No asignada' }}</td>
            <td class="py-2 px-4 border-b">
              <span :class="item.cantidad > 0 ? 'text-green-600' : 'text-red-600'">
                {{ item.cantidad > 0 ? 'Activo' : 'Inactivo' }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  import { Inertia } from '@inertiajs/inertia'

  export default {
    props: {
      inventarios: Array
    },
    methods: {
        goToCreate() {
            Inertia.get('/inventario/create')
        }
    }
  }
  </script>

  <style scoped>
  /* Aquí puedes agregar estilos personalizados si los necesitas */
  </style>
