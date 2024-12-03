<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
             :class="{ 'animate-fade-in': true }">
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-2xl transition-shadow duration-300">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Imagen del producto -->
                    <div>
                        <img
                            :src="`/storage/${producto.imagen_url}`"
                            :alt="producto.nombre"
                            class="w-full rounded-lg shadow transition-transform duration-300 transform hover:scale-105 hover:brightness-105"
                            v-if="producto.imagen_url"
                        />
                        <div
                            v-else
                            class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-lg"
                        >
                            <span class="text-gray-400">Imagen no disponible</span>
                        </div>
                    </div>

                    <!-- Detalles del producto -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ producto.nombre }}</h1>
                        <p class="text-lg text-gray-600 mb-4">{{ producto.descripcion }}</p>

                        <div class="flex items-center mb-4">
                            <span class="text-sm font-medium text-gray-700 mr-2">Precio por menor:</span>
                            <span class="bg-indigo-100 text-indigo-600 text-lg px-3 py-1 rounded-lg font-semibold">${{ producto.precioxmenor }}</span>
                        </div>

                        <div class="flex items-center mb-4">
                            <span class="text-lg font-medium text-gray-900">Marca:</span>
                            <span class="ml-2 text-gray-700">{{ producto.marca.nombre }}</span>
                        </div>

                        <div class="flex items-center mb-4">
                            <span class="text-lg font-medium text-gray-900">Categoría:</span>
                            <span class="ml-2 text-gray-700">{{ producto.categoria.nombre }}</span>
                        </div>

                        <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad:</label>
                        <input
                            type="number"
                            id="cantidad"
                            v-model="cantidad"
                            min="1"
                            class="mt-1 block w-20 p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200"
                        />

                        <button
                            @click="addToCart"
                            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:scale-95 transition-all duration-200 flex items-center space-x-2"
                        >
                            <i class='bx bx-cart-add bx-sm'></i>
                            Agregar al carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    producto: Object,
});

const cantidad = ref(1);
const { auth } = usePage().props;

function addToCart() {
    if (!auth.user) {
        alert('Debes iniciar sesión para añadir productos al carrito.');
        return;
    }

    Inertia.post(route('carrito.add'), {
        codigo_producto: props.producto.codigo,
        cantidad: cantidad.value,
    }).then((response) => {
        if (response.props.flash.message) {
            alert(response.props.flash.message);
        }
    });
    // Feedback visual
    const btn = document.querySelector('button[click="addToCart"]');
    btn.innerHTML = '✔ Agregado';
    setTimeout(() => (btn.innerHTML = 'Agregar al carrito'), 2000);
    console.log('Producto agregado al carrito:', props.producto.codigo);
}
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>
