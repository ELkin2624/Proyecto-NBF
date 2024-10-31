<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Productos</h1>

        <!-- Búsqueda y botón para agregar un nuevo producto -->
        <div class="flex justify-between mb-4">
            <input
                v-model="search"
                placeholder="Buscar producto..."
                class="border border-gray-300 rounded-lg p-2 w-1/3 focus:ring focus:ring-blue-300 focus:outline-none transition"
            />
            <Link
                href="/productos/create"
                class="bg-blue-600 text-white py-2 px-6 rounded-lg shadow hover:bg-blue-700 transition duration-200"
            >
                Agregar Producto
            </Link>
        </div>

        <!-- Tabla de productos -->
        <table class="min-w-full table-auto mb-6 bg-white border border-gray-200 shadow-lg rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Código</th>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2 text-left">Descripción</th>
                    <th class="px-4 py-2 text-left">Precio x Mayor</th>
                    <th class="px-4 py-2 text-left">Precio x Menor</th>
                    <th class="px-4 py-2 text-left">Marca</th>
                    <th class="px-4 py-2 text-left">Categoría</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="producto in filteredProducts"
                    :key="producto.codigo"
                    class="hover:bg-gray-100 transition duration-200"
                >
                    <td class="border px-4 py-2">{{ producto.codigo }}</td>
                    <td class="border px-4 py-2">{{ producto.nombre }}</td>
                    <td class="border px-4 py-2">{{ producto.descripcion }}</td>
                    <td class="border px-4 py-2">{{ producto.precioxmayor }}</td>
                    <td class="border px-4 py-2">{{ producto.precioxmenor }}</td>
                    <td class="border px-4 py-2">{{ producto.marca.nombre || 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ producto.categoria.nombre || 'N/A' }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <!-- Botón Editar para abrir el modal -->
                        <button
                            @click="openEditModal(producto)"
                            class="bg-yellow-500 text-white py-1 px-3 rounded-lg hover:bg-yellow-600 transition duration-200"
                        >
                            Editar
                        </button>
                        <!-- Botón Eliminar -->
                        <button
                            @click="deleteProducto(producto.codigo)"
                            class="bg-red-500 text-white py-1 px-3 rounded-lg hover:bg-red-600 transition duration-200"
                        >
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal para editar producto -->
        <div
            v-if="editingProduct"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center"
        >
            <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                <h2 class="text-2xl mb-4">Editar Producto</h2>
                <form @submit.prevent="updateProducto" class="space-y-4">
                    <div>
                        <label for="edit-nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input
                            type="text"
                            v-model="editingProduct.nombre"
                            id="edit-nombre"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"
                            required
                        />
                    </div>
                    <div>
                        <label for="edit-descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea
                            v-model="editingProduct.descripcion"
                            id="edit-descripcion"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"
                            required
                        ></textarea>
                    </div>
                    <div>
                        <label for="edit-precioxmayor" class="block text-sm font-medium text-gray-700">Precio x Mayor</label>
                        <input
                            type="number"
                            v-model="editingProduct.precioxmayor"
                            id="edit-precioxMayor"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"
                            required
                        />
                    </div>
                    <div>
                        <label for="edit-precioxmenor" class="block text-sm font-medium text-gray-700">Precio x Menor</label>
                        <input
                            type="number"
                            v-model="editingProduct.precioxmenor"
                            id="edit-precioxMenor"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"
                            required
                        />
                    </div>
                    <div>
                        <label for="edit-marca" class="block text-sm font-medium text-gray-700">Marca</label>
                        <select
                            v-model="editingProduct.id_marca"
                            id="edit-marca"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"
                        >
                            <option v-for="marca in marcas" :key="marca.id_marca" :value="marca.id_marca">{{ marca.nombre }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select
                            v-model="editingProduct.id_categoria"
                            id="edit-categoria"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"
                        >
                            <option v-for="categoria in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">{{ categoria.nombre }}</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2 transition duration-200">Guardar Cambios</button>
                        <button @click="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white rounded-lg px-6 py-2 transition duration-200">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        productos: {
            type: Array,
            default: () => []
        },
        marcas: {
            type: Array,
            default: () => []
        },
        categorias: {
            type: Array,
            default: () => []
        },
    },
    mounted() {
        console.log(this.productos);
    },
    data() {
        return {
            editingProduct: null,
            search: '',
        };
    },
    computed: {
        filteredProducts() {
            return this.productos.filter(producto =>
                producto.nombre.toLowerCase().includes(this.search.toLowerCase()) ||
                producto.descripcion.toLowerCase().includes(this.search.toLowerCase())
            );
        },
    },
    methods: {
        openEditModal(producto) {
            this.editingProduct = { ...producto }; // Copiar datos del producto para edición
        },
        updateProducto() {
            Inertia.put(`/productos/${this.editingProduct.codigo}`, this.editingProduct, {
                onSuccess: () => {
                    this.editingProduct = null; // Cerrar modal
                },
            });
        },
        deleteProducto(codigo) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                Inertia.delete(`/productos/${codigo}`);
            }
        },
        cancelEdit() {
            this.editingProduct = null; // Cancelar la edición
        },
    },
    components: {
        Link,
    },
};
</script>
