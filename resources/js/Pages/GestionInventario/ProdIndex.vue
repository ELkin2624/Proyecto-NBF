<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Productos</h1>

        <!-- Búsqueda y botón para agregar -->
        <div class="flex justify-between mb-4">
            <div class="relative w-1/3">
                <input
<<<<<<< HEAD
                    v-model="filters.search"
                    placeholder="Buscar producto..."
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300 focus:outline-none transition"
                />
                <span v-if="filters.search"
                      @click="filters.search = ''"
=======
                    v-model="search"
                    placeholder="Buscar producto..."
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300 focus:outline-none transition"
                />
                <span v-if="search"
                      @click="search = ''"
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
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

<<<<<<< HEAD
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
=======
        <!-- Loading state -->
        <div v-if="loading" class="text-center py-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
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
                    <th class="px-4 py-2 text-left">Imagen</th>
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
                    <td class="border px-4 py-2">
                        <img v-if="producto.imagen_url" :src="`/storage/${producto.imagen_url}`" alt="Imagen del producto" class="w-16 h-16 object-cover" />
                        <span v-else>No disponible</span>
                    </td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <button
                            @click="openEditModal(producto)"
                            class="bg-yellow-500 text-white py-1 px-3 rounded-lg hover:bg-yellow-600 transition duration-200"
                        >
                            Editar
                        </button>
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
        <div v-if="editingProduct" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                <h2 class="text-2xl mb-4">Editar Producto</h2>
                <form @submit.prevent="updateProducto" class="space-y-4">
                    <div>
                        <label for="edit-codigo" class="block text-sm font-medium text-gray-700">Codigo</label>
                        <input type="text" v-model="editingProduct.codigo" id="edit-codigo" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition" required />
                    </div>
                    <div>
                        <label for="edit-nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" v-model="editingProduct.nombre" id="edit-nombre" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition" required />
                    </div>
                    <div>
                        <label for="edit-descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea v-model="editingProduct.descripcion" id="edit-descripcion" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition"></textarea>
                    </div>
                    <div>
                        <label for="edit-precioxmayor" class="block text-sm font-medium text-gray-700">Precio x Mayor</label>
                        <input type="number" v-model="editingProduct.precioxmayor" id="edit-precioxmayor" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition" required />
                    </div>
                    <div>
                        <label for="edit-precioxmenor" class="block text-sm font-medium text-gray-700">Precio x Menor</label>
                        <input type="number" v-model="editingProduct.precioxmenor" id="edit-precioxmenor" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition" required />
                    </div>
                    <div>
                        <label for="edit-marca" class="block text-sm font-medium text-gray-700">Marca</label>
                        <select v-model="editingProduct.id_marca" id="edit-marca" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition">
                            <option v-for="marca in marcas" :key="marca.id_marca" :value="marca.id_marca">{{ marca.nombre }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select v-model="editingProduct.id_categoria" id="edit-categoria" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition">
                            <option v-for="categoria in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">{{ categoria.nombre }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-imagen" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
                        <input type="file" @change="handleImageChange" id="edit-imagen" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300 focus:outline-none transition" />
                        <td class="border px-4 py-2">
                            <img v-if="editingProduct.imagen_url" :src="`/storage/${editingProduct.imagen_url}`" alt="Imagen del producto" class="w-16 h-16 object-cover" />
                            <span v-else>No disponible</span>
                        </td>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2 transition duration-200">Guardar Cambios</button>
                        <button @click="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white rounded-lg px-6 py-2 transition duration-200">Cancelar</button>
                    </div>
                </form>
            </div>
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
<<<<<<< HEAD
        productos: Object,
        marcas: Array,
        categorias: Array,
        filters: Object,
=======
        productos: Array,
        marcas: Array,
        categorias: Array,
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
    },

    data() {
        return {
<<<<<<< HEAD
            filters: {
                search: this.filters.search || '',
                categoria: this.filters.categoria || '',
                precio_min: this.filters.precio_min || '',
                precio_max: this.filters.precio_max || '',
                bajo_stock: this.filters.bajo_stock || false,
            },
            loading: false,
=======
            editingProduct: null,
            search: '',
            imagen: null,
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        };
    },

    methods: {
<<<<<<< HEAD
=======
        openEditModal(producto) {
            this.editingProduct = { ...producto };
            this.imagen = null;
        },

        handleImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagen = file;
            }
        },

        updateProducto() {
            const formData = new FormData();
            formData.append('codigo', this.editingProduct.codigo);
            formData.append('nombre', this.editingProduct.nombre);
            formData.append('descripcion', this.editingProduct.descripcion);
            formData.append('precioxmayor', this.editingProduct.precioxmayor);
            formData.append('precioxmenor', this.editingProduct.precioxmenor);
            formData.append('id_marca', this.editingProduct.id_marca);
            formData.append('id_categoria', this.editingProduct.id_categoria);
            if (this.imagen) {
                formData.append('imagen', this.imagen);
            }

            Inertia.put(`/productos/${this.editingProduct.codigo}`, formData, {
                onSuccess: () => {
                    this.cancelEdit();
                },
                onError: (errors) => {
                    console.error(errors);
                }
            });
        },

>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        deleteProducto(codigo) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                Inertia.delete(`/productos/${codigo}`);
            }
        },

<<<<<<< HEAD
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

=======
        cancelEdit() {
            this.editingProduct = null;
            this.imagen = null;
        },
    },

>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
    components: {
        Link,
    },
};
</script>

<style scoped>
</style>
