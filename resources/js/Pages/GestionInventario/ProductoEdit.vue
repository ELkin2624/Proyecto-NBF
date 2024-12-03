<template>
<<<<<<< HEAD
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
=======
    <div>
        <h1 class="text-2xl font-semibold mb-4">Editar Producto</h1>

        <form @submit.prevent="updateProducto">
            <!-- Código -->
            <div class="mb-4">
                <label for="codigo" class="block text-gray-700">Código</label>
                <input type="text" v-model="form.codigo" id="codigo" disabled class="mt-1 block w-full border border-gray-300 rounded p-2" />
            </div>

            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700">Nombre</label>
                <input type="text" v-model="form.nombre" id="nombre" class="mt-1 block w-full border border-gray-300 rounded p-2" required />
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-gray-700">Descripción</label>
                <textarea v-model="form.descripcion" id="descripcion" class="mt-1 block w-full border border-gray-300 rounded p-2"></textarea>
            </div>

            <!-- Precio por Mayor -->
            <div class="mb-4">
                <label for="precioxmayor" class="block text-gray-700">Precio x Mayor</label>
                <input type="number" v-model="form.precioxmayor" id="precioxmayor" class="mt-1 block w-full border border-gray-300 rounded p-2" required />
            </div>

            <!-- Precio por Menor -->
            <div class="mb-4">
                <label for="precioxmenor" class="block text-gray-700">Precio x Menor</label>
                <input type="number" v-model="form.precioxmenor" id="precioxmenor" class="mt-1 block w-full border border-gray-300 rounded p-2" required />
            </div>

            <!-- Imagen Actual -->
            <div class="mb-4">
                <label class="block text-gray-700">Imagen Actual</label>
                <img v-if="form.imagen_url" :src="`/storage/${form.imagen_url}`" alt="Imagen del producto" width="100" class="mb-2" />
            </div>

            <!-- Subir Nueva Imagen -->
            <div class="mb-4">
                <label for="imagen_url" class="block text-gray-700">Nueva Imagen</label>
                <input type="file" @change="onFileChange" id="imagen_url" class="mt-1 block w-full border border-gray-300 rounded p-2" />
            </div>

            <!-- Marca -->
            <div class="mb-4">
                <label for="id_marca" class="block text-gray-700">Marca</label>
                <input type="text" v-model="form.id_marca" id="id_marca" class="mt-1 block w-full border border-gray-300 rounded p-2" required />
            </div>

            <!-- Categoría -->
            <div class="mb-4">
                <label for="id_categoria" class="block text-gray-700">Categoría</label>
                <input type="text" v-model="form.id_categoria" id="id_categoria" class="mt-1 block w-full border border-gray-300 rounded p-2" required />
            </div>

            <!-- Botón de Guardar -->
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                Actualizar Producto
            </button>
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        </form>
    </div>
</template>

<script>
<<<<<<< HEAD
import { Link } from '@inertiajs/inertia-vue3';
=======
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
<<<<<<< HEAD
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
=======
        producto: Object
    },
    data() {
        return {
            form: {
                ...this.producto, // Carga los datos del producto en el formulario
                imagen: null // Añade un campo para la nueva imagen
            }
        };
    },
    methods: {
        // Función para manejar la carga de una nueva imagen
        onFileChange(event) {
            this.form.imagen = event.target.files[0];
        },
        // Función para enviar los datos al servidor para actualizar el producto
        updateProducto() {
            const formData = new FormData();
            formData.append('codigo', this.form.codigo);
            formData.append('nombre', this.form.nombre);
            formData.append('descripcion', this.form.descripcion);
            formData.append('precioxmayor', this.form.precioxmayor);
            formData.append('precioxmenor', this.form.precioxmenor);
            formData.append('id_marca', this.form.id_marca);
            formData.append('id_categoria', this.form.id_categoria);

            // Añade la imagen solo si se ha seleccionado una nueva
            if (this.form.imagen) {
                formData.append('imagen_url', this.form.imagen);
            }

            Inertia.put('/productos/${this.producto.codigo}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
        }
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
    }
}
</script>
