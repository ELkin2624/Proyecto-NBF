<template>
  <div class="p-6 bg-lilac-50 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-semibold text-gray-800">Inventario</h1>
      <button
        @click="goToCreate"
        class="px-6 py-3 bg-yellow-300 text-black rounded-md shadow-sm hover:bg-lilac-300 transition duration-300"
      >
        AGREGAR NUEVA EXISTENCIA
      </button>
    </div>

    <table class="min-w-full bg-white rounded-lg shadow-sm overflow-hidden">
      <thead>
        <tr class="bg-lilac-200 text-gray-800">
          <th class="py-3 px-6 border-b text-center">CODIGO</th>
          <th class="py-3 px-6 border-b text-center">NOMBRE</th>
          <th class="py-3 px-6 border-b text-center">CANTIDAD</th>
          <th class="py-3 px-6 border-b text-center">UBICACION</th>
          <th class="py-3 px-6 border-b text-center">ESTADO</th>
          <th class="py-3 px-6 border-b text-center">ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in inventarios"
          :key="item.id_inventario"
          class="hover:bg-lilac-100 transition duration-300"
        >
          <td class="py-3 px-6 border-b text-center">{{ item.producto.codigo }}</td>
          <td class="py-3 px-6 border-b text-center">{{ item.producto.nombre }}</td>
          <td class="py-3 px-6 border-b text-center">{{ item.cantidad }}</td>
          <td class="py-3 px-6 border-b text-center">{{ item.inventario.ubicacion || 'No asignada' }}</td>
          <td class="py-3 px-6 border-b text-center">
            <span :class="item.cantidad > 80 ? 'text-blue-600' : 'text-purple-600'">
              {{ item.cantidad > 80 ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="py-3 px-6 border-b text-center">
            <button
              @click="updateInventario(inventario)"
              class="bg-green-500 text-white px-2 py-1 rounded"
            >
              Editar
            </button>
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
    },

    updateInventario(inventario) {
      this.$inertia.visit(`/inventarios/${inventario.id}/editar`, {
        cantidad: inventario.cantidad,
      });
    },
  }
}
</script>

<style scoped>
/* Estilos generales */
body {
  font-family: 'Arial', sans-serif;
}

/* Contenedor principal */
.bg-lilac-50 {
  background-color: #f3e8ff; /* Lila claro */
}

/* Botón de acción */
button:hover {
  cursor: pointer;
}

/* Tabla */
table {
  width: 100%;
  border-collapse: collapse;
}

/* Estilos de las celdas */
th, td {
  text-align: center;
  padding: 12px;
  font-size: 16px;
}

/* Fondo y color para las cabeceras */
th {
  background-color: #cbb5e3; /* Lila suave */
  color: #4a5568;
  font-weight: bold;
}

/* Fila de la tabla con color alterno */
tbody tr:nth-child(odd) {
  background-color: #f9f7fe; /* Lila muy claro */
}

/* Efecto hover */
tbody tr:hover {
  background-color: #f3e8ff; /* Lila más notorio */
  transform: translateY(-2px);
  transition: transform 0.2s ease-in-out;
}

/* Estado activo/inactivo */
.text-blue-600 {
  color: #89ee1e; /* Azul moderado */
}

.text-purple-600 {
  color: #6b46c1; /* Lila más fuerte */
}
</style>
