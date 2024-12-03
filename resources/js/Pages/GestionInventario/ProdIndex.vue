<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Productos</h1>

        <!-- Búsqueda y botón para agregar -->
        <div class="flex justify-between mb-4">
            <div class="relative w-1/3">
                <input
                    v-model="filters.search"
                    placeholder="Buscar producto..."
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300 focus:outline-none transition"
                />
                <span v-if="filters.search"
                      @click="filters.search = ''"
                      class="absolute right-2 top-2 cursor-pointer text-gray-500 hover:text-gray-700">
                    ✕
                </span>
            </div>
            <Link
                href="/productos/create"
                class="bg-blue-600 text-white py-2 px-6 rounded-lg shadow hover:bg-blue-700 transition duration-200 flex items-center space-x-2"
            >
                <span>+</span>
                <span>Agregar Producto</span>
            </Link>
        </div>

        <!-- Filtros -->
        <div class="mb-4">
            <form @submit.prevent="applyFilters">
                <select v-model="filters.categoria" class="border p-2 rounded mr-2">
                    <option value="">Todas las Categorías</option>
                    <option v-for="categoria in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">
                        {{ categoria.nombre }}
                    </option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrar</button>
                <button type="button" @click="clearFilters" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">
                    Limpiar
                </button>
            </form>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="text-center py-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
        </div>

        <!-- Tabla de productos -->
        <div class="overflow-x-auto">
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
                        <th class="px-4 py-2 text-left">Imagen</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="producto in productos.data"
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
                        <td class="border px-4 py-2">
                            <img v-if="producto.imagen_url" :src="`/storage/${producto.imagen_url}`" alt="Imagen del producto" class="w-16 h-16 object-cover" />
                            <span v-else>No disponible</span>
                        </td>
                        <td class="border px-4 py-2 flex space-x-2">
                            <Link
                                :href="route('productos.edit', producto.codigo)"
                                class="bg-green-600 text-white py-2 px-6 rounded-lg shadow hover:bg-green-700 transition duration-200 flex items-center space-x-2"
                            >
                                <span>Editar</span>
                            </Link>
                            <button @click="deleteProducto(producto.codigo)" class="text-red-500">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        productos: Object,
        marcas: Array,
        categorias: Array,
        filters: Object,
    },

    data() {
        return {
            filters: {
                search: this.filters.search || '',
                categoria: this.filters.categoria || '',
                precio_min: this.filters.precio_min || '',
                precio_max: this.filters.precio_max || '',
                bajo_stock: this.filters.bajo_stock || false,
            },
            loading: false,
        };
    },

    methods: {
        deleteProducto(codigo) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                Inertia.delete(`/productos/${codigo}`);
            }
        },

        applyFilters() {
            this.loading = true;
            Inertia.get('/productos', this.filters, {
                preserveState: true,
                preserveScroll: true,
                onFinish: () => {
                    this.loading = false;
                }
            });
        },

        clearFilters() {
            this.filters = {
                search: '',
                categoria: '',
                precio_min: '',
                precio_max: '',
                bajo_stock: false,
            };
            this.applyFilters();
        },
    },

    watch: {
        // Agregar un watcher para aplicar los filtros automáticamente cuando cambie la búsqueda
        'filters.search'(newValue) {
            this.applyFilters();
        },
        'filters.categoria'(newValue) {
            this.applyFilters();
        }
    },

    components: {
        Link,
    },
};
</script>

<style scoped>
</style>
