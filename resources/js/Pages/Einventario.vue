<template>
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Editar Inventario</h1>
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
                <input
                    type="text"
                    v-model="ubicacion"
                    id="ubicacion"
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Introduce la nueva ubicación"
                >
            </div>
            <div>
                <label for="id_sucursal" class="block text-sm font-medium text-gray-700">Sucursal</label>
                <select
                    v-model="id_sucursal"
                    id="id_sucursal"
                    required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                    <option v-for="sucursal in sucursales" :key="sucursal.id_sucursal" :value="sucursal.id_sucursal">
                        {{ sucursal.nombre }}
                    </option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center">
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-lg transition-all duration-300"
                >
                    Actualizar Inventario
                </button>
                <a
                    href="/inventarios"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow-lg transition-all duration-300"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        inventario: Object,
        sucursales: Array,
    },
    data() {
        return {
            ubicacion: this.inventario.ubicacion,
            id_sucursal: this.inventario.id_sucursal,
        };
    },
    methods: {
        submit() {
            Inertia.put(`/inventarios/${this.inventario.id_inventario}`, {
                ubicacion: this.ubicacion,
                id_sucursal: this.id_sucursal,
            });
        },
    },
};
</script>
