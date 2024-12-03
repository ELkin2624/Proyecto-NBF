<template>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-6">Gestión de Inventario</h1>

        <!-- Botón para añadir inventario -->
        <div class="flex justify-end mb-4">
            <a href="/inventarios/create" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-lg transition-all duration-300">
                Añadir Inventario
            </a>
        </div>

        <!-- Mensaje de éxito -->
        <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ $page.props.flash.success }}
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Cerrar</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 101.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
            </span>
        </div>

        <!-- Tabla de inventarios -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Ubicación</th>
                        <th class="py-2 px-4 text-left">Sucursal</th>
                        <th class="py-2 px-4 text-left">Productos</th>
                        <th class="py-2 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="inventario in inventarios" :key="inventario.id_inventario" class="border-b hover:bg-gray-100 transition-all duration-200">
                        <td class="py-2 px-4">{{ inventario.ubicacion }}</td>
                        <td class="py-2 px-4">{{ inventario.sucursal.nombre }}</td>
                        <td class="py-2 px-4">
                            <ul class="list-disc pl-5">
                                <li v-for="producto in inventario.productos" :key="producto.codigo">
                                    {{ producto.nombre }}: <strong>{{ producto.pivot.cantidad }}</strong>
                                </li>
                            </ul>
                        </td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a :href="`/inventarios/${inventario.id_inventario}/edit`" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded shadow transition-all duration-300">Editar</a>
                            <button @click="deleteInventario(inventario.id_inventario)" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded shadow transition-all duration-300">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        inventarios: Array,
    },
    methods: {
        deleteInventario(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este inventario?')) {
                Inertia.delete(`/inventarios/${id}`);
            }
        },
    },
};
</script>
