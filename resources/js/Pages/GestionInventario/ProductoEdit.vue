<template>
    <div class="container mx-auto p-8 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Producto</h1>

        <form @submit.prevent="submitForm" class="bg-white p-8 rounded-lg shadow-md">
            <div class="grid grid-cols-2 gap-6">
                <!-- Código de Producto -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="codigo">
                        Código de Producto
                    </label>
                    <input
                        v-model="form.codigo"
                        type="text"
                        id="codigo"
                        required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                </div>

                <!-- Nombre de Producto -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">
                        Nombre del Producto
                    </label>
                    <input
                        v-model="form.nombre"
                        type="text"
                        id="nombre"
                        required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                </div>

                <!-- Descripción -->
                <div class="mb-4 col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="descripcion">
                        Descripción
                    </label>
                    <textarea
                        v-model="form.descripcion"
                        id="descripcion"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    ></textarea>
                </div>

                <!-- Precio por Mayor -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="precioxmayor">
                        Precio por Mayor
                    </label>
                    <input
                        v-model="form.precioxmayor"
                        type="number"
                        step="0.01"
                        id="precioxmayor"
                        required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                </div>

                <!-- Precio por Menor -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="precioxmenor">
                        Precio por Menor
                    </label>
                    <input
                        v-model="form.precioxmenor"
                        type="number"
                        step="0.01"
                        id="precioxmenor"
                        required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                </div>

                <!-- Marca -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id_marca">
                        Marca
                    </label>
                    <select
                        v-model="form.id_marca"
                        id="id_marca"
                        required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option v-for="marca in marcas" :key="marca.id_marca" :value="marca.id_marca">
                            {{ marca.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Categoría -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id_categoria">
                        Categoría
                    </label>
                    <select
                        v-model="form.id_categoria"
                        id="id_categoria"
                        required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option v-for="categoria in categorias" :key="categoria.id_categoria" :value="categoria.id_categoria">
                            {{ categoria.nombre }}
                        </option>
                    </select>
                </div>

                <!-- Imagen -->
                <div class="col-span-2 mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="imagen">
                        Imagen del Producto
                    </label>
                    <input
                        @change="handleFileUpload"
                        type="file"
                        id="imagen"
                        accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />

                    <!-- Vista previa de imagen actual -->
                    <div v-if="producto.imagen_url" class="mt-4">
                        <p class="mb-2">Imagen actual:</p>
                        <img
                            :src="`/storage/${producto.imagen_url}`"
                            alt="Imagen del producto"
                            class="w-48 h-48 object-cover rounded"
                        />
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between mt-6">
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Actualizar Producto
                </button>
                <Link
                    :href="route('productos.index')"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                >
                    Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        producto: Object,
        marcas: Array,
        categorias: Array
    },

    data() {
        return {
            form: {
                codigo: this.producto.codigo,
                nombre: this.producto.nombre,
                descripcion: this.producto.descripcion || '',
                precioxmayor: this.producto.precioxmayor,
                precioxmenor: this.producto.precioxmenor,
                id_marca: this.producto.id_marca,
                id_categoria: this.producto.id_categoria,
                imagen: null
            }
        }
    },

    methods: {
        handleFileUpload(event) {
            this.form.imagen = event.target.files[0];
        },

        submitForm() {
            const formData = new FormData();

            // Añadir todos los campos del formulario
            for (const key in this.form) {
                if (this.form[key] !== null) {
                    formData.append(key, this.form[key]);
                }
            }

            // Usar método POST con método de Laravel _method para simular PUT
            Inertia.post(`/productos/${this.producto.codigo}`, formData, {
                forceFormData: true,
                onSuccess: () => {
                    // Opcional: mostrar mensaje de éxito
                },
                onError: (errors) => {
                    // Manejar errores si los hay
                    console.error(errors);
                }
            });
        }
    },

    components: {
        Link
    }
}
</script>
