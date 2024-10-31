<template>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-semibold mb-4">Registrar Nueva Existencia en Inventario</h1>

      <form @submit.prevent="submitForm">
            <!-- Selector de Producto -->
            <div class="mb-4">
                <label for="producto" class="block text-gray-700">Producto</label>
                <select v-model="form.producto" id="producto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" disabled>Selecciona un producto</option>
                    <option v-for="producto in productos" :key="producto.id" :value="producto.nombre">
                        {{ producto.nombre }}
                    </option>
                </select>
            </div>

            <!-- Selector de Almacén/Ubicación -->
            <div class="mb-4">
                <label for="ubicacion" class="block text-gray-700">Ubicación (Almacén)</label>
                <select v-model="form.ubicacion" id="ubicacion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" disabled>Selecciona una ubicación</option>
                    <option v-for="almacen in almacenes" :key="almacen.id" :value="almacen.ubicacion">
                        {{ almacen.ubicacion }}
                    </option>
                </select>
            </div>

            <!-- Campo de Cantidad -->
            <div class="mb-4">
                <label for="cantidad" class="block text-gray-700">Cantidad</label>
                <input v-model="form.cantidad" type="number" id="cantidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
            </div>

            <!-- Campo de Precio Total -->
            <div class="mb-4">
                <label for="precio_total" class="block text-gray-700">Precio Total</label>
                <input v-model="form.precio_total" type="number" id="precio_total" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0" required>
            </div>

            <!-- Selector de Proveedor -->
            <div class="mb-4">
                <label for="proveedor" class="block text-gray-700">Proveedor</label>
                <select v-model="form.proveedor" id="proveedor" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" disabled>Selecciona un proveedor</option>
                    <option v-for="proveedor in proveedores" :key="proveedor.id" :value="proveedor.nombre">
                        {{ proveedor.nombre }}
                    </option>
                </select>
            </div>

            <!-- Campo de Fecha de Ingreso -->
            <div class="mb-4">
                <label for="fecha" class="block text-gray-700">Fecha de Ingreso</label>
                <input v-model="form.fecha" type="date" id="fecha" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-500">Guardar</button>
      </form>
    </div>
  </template>

  <script>
  import { ref } from 'vue'
  import { Inertia } from '@inertiajs/inertia'

  export default {
    props: {
      productos: Array,
      almacenes: Array,
      proveedores: Array,
    },
    data() {
      return {
        form : {
        producto: '',
        ubicacion: '',
        cantidad: '',
        precio_total: '',
        proveedor: '',
        fecha: ''
        }
      };
    },
    methods: {
        submitForm() {
        Inertia.post('/inventario/store', this.form)
      }
    }
  }
  </script>

  <style scoped>

  </style>

