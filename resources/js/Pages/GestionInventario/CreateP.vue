<template>
    <div class="p-8 bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-2xl">
            <h1 class="text-3xl lg:text-3xl font-bold text-gray-800 mb-6 text-center">Agregar Nuevo Producto</h1>

            <form @submit.prevent="submitForm" class="space-y-4 bg-white p-6 rounded-lg shadow-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                        <input
                            type="text"
                            v-model="producto.codigo"
                            id="codigo"
                            class="w-full border border-gray-300 rounded-lg p-2"
                            required
                        />
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input
                            type="text"
                            v-model="producto.nombre"
                            id="nombre"
                            class="w-full border border-gray-300 rounded-lg p-2"
                            required
                        />
                    </div>
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea
                        v-model="producto.descripcion"
                        id="descripcion"
                        class="w-full border border-gray-300 rounded-lg p-3"
                        rows="3"

                    ></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="precioxmayor" class="block text-sm font-medium text-gray-700">Precio x Mayor</label>
                        <input
                            type="number"
                            v-model="producto.precioxmayor"
                            id="precioxmayor"
                            class="w-full border border-gray-300 rounded-lg p-3"
                            required
                        />
                    </div>

                    <div>
                        <label for="precioxmenor" class="block text-sm font-medium text-gray-700">Precio x Menor</label>
                        <input
                            type="number"
                            v-model="producto.precioxmenor"
                            id="precioxmenor"
                            class="w-full border border-gray-300 rounded-lg p-3"
                            required
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>
                        <select
                            v-model="producto.id_marca"
                            id="marca"
                            class="w-full border border-gray-300 rounded-lg p-3"
                            required
                        >
                            <option value="" disabled>Selecciona una marca</option>
                            <option v-for="marca in marcas" :key="marca.id_marca" :value="marca.id_marca">
                                {{ marca.nombre }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select
                            v-model="producto.id_categoria"
                            id="categoria"
                            class="w-full border border-gray-300 rounded-lg p-3"
                            required
                        >
                            <option value="" disabled>Selecciona una categoría</option>
                            <option v-for="categoria in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">
                                {{ categoria.nombre }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Campo para imagen -->
                <div>
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
                    <input
                        type="file"
                        @change="handleFileUpload"
                        id="imagen"
                        class="w-full border border-gray-300 rounded-lg p-3"
                    />
                </div>

                <div class="flex justify-end items-center space-x-4 sm:space-y-0 sm:space-x-4">
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-600 text-white rounded-lg px-6 py-2 transition duration-200 shadow-lg">
                        Guardar Producto
                    </button>
                    <Link href="/productos" class="w-full sm:w-auto bg-gray-600 hover:bg-gray-600 text-white rounded-lg px-6 py-2 transition duration-200 shadow-lg">
                        Cancelar
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        marcas: Array,
        categorias: Array,
    },
    data() {
        return {
            producto: {
                codigo: '',
                nombre: '',
                descripcion: '',
                precioxmayor: '',
                precioxmenor: '',
                id_marca: '',
                id_categoria: '',
                imagen: null,
            }
        };
    },
    methods: {
        // Método para manejar el archivo de la imagen
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.producto.imagen = file;
            }
        },

        submitForm() {
            const formData = new FormData();
            formData.append('codigo', this.producto.codigo);
            formData.append('nombre', this.producto.nombre);
            formData.append('descripcion', this.producto.descripcion);
            formData.append('precioxmayor', this.producto.precioxmayor);
            formData.append('precioxmenor', this.producto.precioxmenor);
            formData.append('id_marca', this.producto.id_marca);
            formData.append('id_categoria', this.producto.id_categoria);
            if (this.producto.imagen) {
                formData.append('imagen', this.producto.imagen);  // Agregar la imagen
            }

            Inertia.post('/productos', formData, {
                onSuccess: () => {
                    this.$inertia.visit('/productos'); // Redireccionar al listado de productos
                }
            });
        }
    },
    components: {
        Link,
    }
};
</script>
