<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-2xl font-bold mb-6">Generar Reportes de Notas de Compra</h1>

      <div class="bg-white p-6 rounded shadow-md mb-6">
        <!-- Filtros -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
            <input v-model="filters.fecha_inicio" type="date" class="block w-full border border-gray-300 rounded-md shadow-sm" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
            <input v-model="filters.fecha_fin" type="date" class="block w-full border border-gray-300 rounded-md shadow-sm" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
            <select v-model="filters.proveedor" class="block w-full border border-gray-300 rounded-md shadow-sm">
              <option value="">Seleccionar Proveedor</option>
              <option v-for="proveedor in proveedores" :key="proveedor.id_proveedor" :value="proveedor.id_proveedor">
                {{ proveedor.nombre }}
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select v-model="filters.estado" class="block w-full border border-gray-300 rounded-md shadow-sm">
              <option value="">Seleccionar Estado</option>
              <option value="En espera">En espera</option>
              <option value="En proceso">En proceso</option>
              <option value="Completada">Completada</option>
              <option value="Cancelada">Cancelada</option>
            </select>
          </div>

          <div>
            <button @click="generarReporte" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              Generar Reporte
            </button>
          </div>
        </div>
      </div>

      <!-- Tabla de Reportes -->
      <div v-if="reportes.length" class="overflow-x-auto bg-white p-6 rounded shadow-md">
        <table class="min-w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
              <th class="px-6 py-3">Fecha de Compra</th>
              <th class="px-6 py-3">Proveedor</th>
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3">Total</th>
              <th class="px-6 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="reporte in reportes" :key="reporte.id_nota_compra">
              <td class="px-6 py-4">{{ reporte.fecha_orden }}</td>
              <td class="px-6 py-4">{{ reporte.proveedor_nombre }}</td>
              <td class="px-6 py-4">{{ reporte.estado }}</td>
              <td class="px-6 py-4">{{ reporte.total }}</td>
              <td class="px-6 py-4">
                <button @click="descargarReporte(reporte.id_nota_compra)" class="text-blue-600 hover:text-blue-700">
                  Descargar PDF
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script>
  import { ref } from "vue";
  import { useForm } from "@inertiajs/vue3";

  export default {
    props: {
      proveedores: Array,
      reportes: Array,
    },
    setup(props) {
      const filters = ref({
        fecha_inicio: "",
        fecha_fin: "",
        proveedor: "",
        estado: "",
      });

      const generarReporte = () => {
        // Hacemos una petición al backend para filtrar los reportes según los filtros
        Inertia.get("/notas_compra/reportes", filters.value);
      };

      const descargarReporte = (id) => {
        // Descargar reporte en PDF
        window.location.href = `/notas_compra/${id}/pdf`;
      };

      return {
        filters,
        generarReporte,
        descargarReporte,
      };
    },
  };
  </script>

  <style scoped>
  /* Estilo adicional si es necesario */
  </style>
