<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-2xl font-bold mb-6">Crear Nota de Compra</h1>

      <form @submit.prevent="submitForm" class="space-y-6 bg-white p-6 rounded shadow-md">
        <!-- Selección del proveedor -->
        <div>
          <label for="proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
          <select
            v-model="form.id_proveedor"
            id="proveedor"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
          >
            <option value="" disabled>Seleccione un proveedor</option>
            <option v-for="proveedor in proveedores" :key="proveedor.id_proveedor" :value="proveedor.id_proveedor">
              {{ proveedor.nombre }}
            </option>
          </select>
          <span v-if="errors.id_proveedor" class="text-red-500 text-sm">{{ errors.id_proveedor }}</span>
        </div>

        <!-- Fecha de la orden -->
        <div>
          <label for="fecha_orden" class="block text-sm font-medium text-gray-700">Fecha de la Orden</label>
          <input
            type="date"
            id="fecha_orden"
            v-model="form.fecha_orden"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
          />
          <span v-if="errors.fecha_orden" class="text-red-500 text-sm">{{ errors.fecha_orden }}</span>
        </div>

        <!-- Fecha de entrega -->
        <div>
          <label for="fecha_entrega" class="block text-sm font-medium text-gray-700">Fecha de Entrega</label>
          <input
            type="date"
            id="fecha_entrega"
            v-model="form.fecha_entrega"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
          />
          <span v-if="errors.fecha_entrega" class="text-red-500 text-sm">{{ errors.fecha_entrega }}</span>
        </div>

        <!-- Productos -->
        <div>
          <h2 class="text-lg font-bold mb-4">Productos</h2>
          <div v-for="(producto, index) in form.detalles" :key="index" class="space-y-2">
            <div class="flex items-center space-x-4">
              <!-- Selección de producto -->
              <select
                v-model="producto.codigo_producto"
                class="flex-1 border border-gray-300 rounded-md shadow-sm"
              >
                <option value="" disabled>Seleccione un producto</option>
                <option v-for="prod in productos" :key="prod.codigo" :value="prod.codigo">
                  {{ prod.nombre }}
                </option>
              </select>

              <!-- Cantidad -->
              <input
                type="number"
                v-model="producto.cantidad"
                placeholder="Cantidad"
                class="w-24 border border-gray-300 rounded-md shadow-sm"
              />

              <!-- Precio -->
              <input
                type="number"
                v-model="producto.precio_unitario"
                placeholder="Precio Unitario"
                class="w-28 border border-gray-300 rounded-md shadow-sm"
              />

              <!-- Subtotal -->
              <span class="w-28 text-center">{{ calcularSubtotal(producto) }} Bs</span>

              <!-- Eliminar producto -->
              <button type="button" @click="eliminarProducto(index)" class="text-red-500 hover:underline">
                Eliminar
              </button>
            </div>
          </div>

          <button
            type="button"
            @click="agregarProducto"
            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Agregar Producto
          </button>
        </div>

        <!-- Botón de envío -->
        <div>
          <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Guardar Nota de Compra
          </button>
        </div>
      </form>
    </div>
  </template>

  <script>
  import { useForm } from "@inertiajs/vue3";

  export default {
    props: {
      proveedores: Array, // Proveedores cargados desde el backend
      productos: Array,   // Productos cargados desde el backend
    },
    setup() {
      const form = useForm({
        id_proveedor: "",
        fecha_orden: "",
        fecha_entrega: "",
        detalles: [
          {
            codigo_producto: "",
            cantidad: 1,
            precio_unitario: 0,
          },
        ],
      });

      const errors = form.errors;

      const agregarProducto = () => {
        form.detalles.push({
          codigo_producto: "",
          cantidad: 1,
          precio_unitario: 0,
        });
      };

      const eliminarProducto = (index) => {
        form.detalles.splice(index, 1);
      };

      const calcularSubtotal = (detalle) => {
        return (detalle.cantidad * detalle.precio_unitario).toFixed(2);
      };

      const submitForm = () => {
        form.post("/notas-compra", {
          onSuccess: () => {
            alert("Nota de compra creada con éxito.");
          },
        });
      };

      return { form, errors, agregarProducto, eliminarProducto, calcularSubtotal, submitForm };
    },
  };
  </script>

  <style>
  /* Estilo personalizado si es necesario */
  </style>
