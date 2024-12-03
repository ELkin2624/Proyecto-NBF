<template>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800">Notas de Venta</h1>
                <div class="flex space-x-3">
                    <a 
                        :href="route('notas-venta.create')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Crear Nueva Nota
                    </a>
                    <a 
                        :href="route('pedidos.index')"
                        class="inline-flex items-center px-4 py-2 text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition-colors duration-300 ease-in-out"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                        Ver Pedidos
                    </a>
                </div>
            </div>

        <!-- Filters -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input 
                    v-model="filters.id_venta" 
                    type="text" 
                    placeholder="ID de venta" 
                    class="input-field"
                />
                <input 
                    v-model="filters.fecha" 
                    type="date" 
                    class="input-field"
                />
                <select 
                    v-model="filters.estado" 
                    class="input-field"
                >
                    <option value="">Filtrar por estado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Pagada">Pagada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
                <button 
                    @click="applyFilters" 
                    class="btn-primary flex items-center justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Filtrar
                </button>
            </div>
        </div>

        <!-- Tabla de Notas de Venta -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Venta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr 
                        v-for="nota in notas.data" 
                        :key="nota.id_venta" 
                        class="hover:bg-gray-50 transition-colors duration-200"
                    >
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ nota.id_venta }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ nota.fecha }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            ${{ nota.monto_total }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span 
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                            >
                                {{ nota.estado }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2 justify-center">
                                <button 
                                    @click="verFactura(nota)"
                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                    title="Ver Factura"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                  
                                <button 
                                    v-if="nota.estado === 'Pendiente'"
                                    @click="actualizarEstado(nota.id_venta)"
                                    class="text-green-600 hover:text-green-900 transition-colors"
                                    title="Marcar como Pagada"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                  
                                <button 
                                    v-if="nota.estado !== 'Cancelada'"
                                    @click="cancelarVenta(nota.id_venta)"
                                    class="text-red-600 hover:text-red-900 transition-colors"
                                    title="Cancelar Venta"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div v-if="notas.data.length === 0" class="text-center py-10 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3a1 1 0 102 0V8zm-3 3a1 1 0 100 2h3a1 1 0 100-2H8z" clip-rule="evenodd" />
            </svg>
            No hay notas de venta disponibles
        </div>

        
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';

export default {
    props: {
        notas: Object,
        pagination: Object,
    },

    setup() {
        const filters = ref({
            id_venta: '',
            fecha: '',
            estado: '',
        });

        const applyFilters = () => {
            // Hacer la petición para filtrar las notas de venta
            axios.get(route('notas-venta.index'), { params: filters.value });
        };

        const changePage = (page) => {
            // Cambiar la página de resultados
            axios.get(route('notas-venta.index'), { params: { ...filters.value, page } });
        };

        const verFactura = (nota) => {
            // Lógica para ver la factura
            window.location.href = route('notas-venta.factura', { id: nota.id_venta });
        };

        const actualizarEstado = (id_venta) => {
            // Lógica para marcar la nota de venta como pagada
            axios.post(route('notas-venta.estado', { id_venta }), { estado: 'Pagada' })
                .then(() => {
                    // Actualizar la vista
                    applyFilters();
                });
        };

        const cancelarVenta = (id_venta) => {
            // Lógica para cancelar la venta
            axios.post(route('notas-venta.estado', { id_venta }), { estado: 'Cancelada' })
                .then(() => {
                    // Actualizar la vista
                    applyFilters();
                });
        };

        return {
            filters,
            applyFilters,
            changePage,
            verFactura,
            actualizarEstado,
            cancelarVenta,
        };
    },
};
</script>

<style scoped>
.input {
    padding: 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid #ccc;
}
.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
.btn-primary {
    background-color: #007bff;
    color: white;
}
.btn-secondary {
    background-color: #6c757d;
    color: white;
}
.btn-success {
    background-color: #28a745;
    color: white;
}
.btn-danger {
    background-color: #dc3545;
    color: white;
}
</style>
