<template>
<<<<<<< HEAD
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
=======
    <div class="p-8 bg-gray-100 min-h-screen">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Notas de Compra</h1>

        <!-- Botón para crear una nueva nota de compra -->
        <button
            @click="mostrarFormulario = true"
            class="px-4 py-2 mb-4 text-white bg-blue-600 hover:bg-blue-700 rounded-md"
        >
            Agregar Nota de Compra
        </button>

        <!-- Modal/Formulario para agregar nueva nota -->
        <div v-if="mostrarFormulario"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
        >
            <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Crear Nota de Compra</h2>
                <form @submit.prevent="crearNotaCompra">
                    <div class="mb-4">
                        <label for="proveedor" class="block text-gray-600 mb-1">Proveedor:</label>
                        <select
                            v-model="nuevaNota.id_proveedor"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <option v-for="proveedor in proveedores" :key="proveedor.id_proveedor" :value="proveedor.id_proveedor">
                                {{ proveedor.nombre }}
                            </option>
                        </select>
                    </div>

                    <!-- Productos seleccionados con cantidad y precio -->
                    <label class="block text-gray-600 mb-2">Productos:</label>
                    <table class="w-full text-left mb-4">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2">Producto</th>
                                <th class="px-4 py-2">Cantidad</th>
                                <th class="px-4 py-2">Precio Unitario</th>
                                <th class="px-4 py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="producto in productos" :key="producto.codigo" class="border-b">
                                <td class="px-4 py-2">{{ producto.nombre }}</td>
                                <td class="px-4 py-2">
                                    <input
                                        type="number"
                                        v-model.number="producto.cantidad"
                                        class="w-16 px-2 py-1 border rounded-md focus:ring-2 focus:ring-blue-400"
                                    />
                                </td>
                                <td class="px-4 py-2">
                                    <input
                                        type="number"
                                        v-model.number="producto.precio_unitario"
                                        class="w-20 px-2 py-1 border rounded-md focus:ring-2 focus:ring-blue-400"
                                    />
                                </td>
                                <td class="px-4 py-2">{{ producto.cantidad * producto.precio_unitario }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-end mt-6">
                        <button
                            type="button"
                            @click="mostrarFormulario = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2 hover:bg-gray-400"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de notas de compra -->
        <table class="w-full mt-6 bg-white rounded-lg overflow-hidden shadow">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2">Proveedor</th>
                    <th class="px-4 py-2">Fecha Orden</th>
                    <th class="px-4 py-2">Fecha Entrega</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="nota in notasCompra" :key="nota.id" class="border-b hover:bg-gray-100">
                    <td class="px-4 py-2">{{ nota.proveedor.nombre }}</td>
                    <td class="px-4 py-2">{{ nota.fecha_orden }}</td>
                    <td class="px-4 py-2">{{ nota.fecha_entrega }}</td>
                    <td class="px-4 py-2">{{ nota.total }}</td>
                    <td class="px-4 py-2">{{ nota.estado }}</td>
                    <td class="px-4 py-2">
                        <button
                            @click="actualizarEstado(nota.id)"
                            class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600"
                        >
                            Cambiar Estado
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

  <script>
    import { createApp, h } from 'vue';
    import { createInertiaApp } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';


  export default {
    props: {
        notasCompra: Array,
        proveedores: Array,
        productos: Array,
    },

    data() {
        return {
            mostrarFormulario: false,
            nuevaNota: {
                id_proveedor: null,
                productos: [],
                fecha_orden: new Date().toISOString().slice(0, 10),
                total: 0,
            },
        };
    },

    methods: {
        crearNotaCompra() {
            // Preparamos los productos asegurando que cantidad y precio_unitario tengan valores predeterminados
            this.nuevaNota.productos = this.productos.map(producto => {
                const cantidad = producto.cantidad || 0;
                const precio_unitario = producto.precio_unitario || 0;
                const subtotal = cantidad * precio_unitario;

                return {
                    'codigo_producto': producto.codigo,
                    'cantidad': cantidad,
                    'precio_unitario': precio_unitario,
                    'subtotal': subtotal
                };
            });

            // Calculamos el total de la nota de compra
            this.nuevaNota.total = this.nuevaNota.productos.reduce((acc, producto) => {
                return acc + producto.subtotal;
            }, 0);

            Inertia.post(route('nota-compra.store'), this.nuevaNota)
            .then(() => {
                console.log("Es una promesa y la solicitud fue exitosa.");
                this.mostrarFormulario = false;
                this.$emit('notaAgregada');
            })
            .catch((error) => {
                console.error("Ocurrió un error:", error);
            });

        },
        
        actualizarEstado(id) {
            // Aquí puedes navegar a una nueva vista o mostrar un modal para cambiar el estado
            this.$inertia.post(route('notas-compra.actualizarEstado', id), { estado: 'completada' });
        }
    },
  }
  </script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.6);
        padding: 20px;
    }
</style>

>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
