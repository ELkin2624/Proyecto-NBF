<template>
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
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
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
    }
}
</script>
