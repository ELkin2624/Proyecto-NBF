<template>
    <div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
      <!-- Header -->
      <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
          </svg>
          Crear Nota de Venta Manual
        </h1>
      </div>

      <!-- Form -->
      <form @submit.prevent="submit" class="p-6 space-y-6">
        <!-- Basic Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
            <input 
              type="date" 
              v-model="form.fecha" 
              class="input-field w-full" 
              required
            />
          </div>
          <div>
            <label for="id_metodo" class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
            <select 
              v-model="form.id_metodo" 
              class="input-field w-full" 
              required
            >
              <option value="">Seleccionar método de pago</option>
              <option 
                v-for="metodo in metodos" 
                :key="metodo.id" 
                :value="metodo.id"
              >
                {{ metodo.nombre }}
              </option>
            </select>
          </div>
        </div>

        <!-- Product Details Section -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Detalles de Productos</h2>
            <button 
              type="button" 
              @click="addDetalle" 
              class="btn-secondary flex items-center"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              Agregar Producto
            </button>
          </div>

          <div 
            v-for="(detalle, index) in form.detalles" 
            :key="index" 
            class="grid grid-cols-3 gap-4 mb-4 p-4 bg-white rounded-lg shadow-sm"
          >
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Código Producto</label>
              <input 
                type="text" 
                v-model="detalle.codigo_producto" 
                class="input-field w-full" 
                placeholder="Ej. PRD-001"
                required 
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Cantidad</label>
              <input 
                type="number" 
                v-model.number="detalle.cantidad" 
                min="1" 
                class="input-field w-full" 
                required
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Precio Unitario</label>
              <input 
                type="number" 
                v-model.number="detalle.precio_unitario" 
                min="0" 
                step="0.01" 
                class="input-field w-full" 
                required
              />
            </div>
            <div v-if="form.detalles.length > 1" class="col-span-3 text-right">
              <button 
                type="button" 
                @click="removeDetalle(index)" 
                class="text-red-500 hover:text-red-700 transition-colors"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Total Calculation -->
        <div class="text-right">
          <p class="text-xl font-semibold text-gray-800">
            Monto Total: ${{ calculateTotal().toFixed(2) }}
          </p>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button 
            type="submit" 
            
            class="btn-primary flex items-center justify-center"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
            </svg>
            Guardar Nota de Venta
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        metodos: Array,
    },

    setup(props) {
        const form = useForm({
            fecha: new Date().toISOString().split('T')[0],
            monto_total: 0,
            id_metodo: '',
            detalles: [{ codigo_producto: '', cantidad: 1, precio_unitario: 0 }],
        });

        const addDetalle = () => {
            form.detalles.push({ codigo_producto: '', cantidad: 1, precio_unitario: 0 });
        };

        const removeDetalle = (index) => {
            if (form.detalles.length > 1) {
                form.detalles.splice(index, 1);
            }
        };

        const calculateTotal = () => {
            return form.detalles.reduce((total, detalle) => 
                total + (detalle.cantidad * detalle.precio_unitario), 0
            );
        };

        const isFormValid = computed(() => {
            return form.fecha && 
                form.id_metodo && 
                form.detalles.every(detalle => 
                    detalle.codigo_producto && 
                    detalle.cantidad > 0 && 
                    detalle.precio_unitario >= 0
                );
        });

        const submit = () => {
            form.monto_total = calculateTotal();
            form.post(route('notas-venta.storeManual'));
        };

        return {
            form,
            addDetalle,
            removeDetalle,
            calculateTotal,
            submit,
            isFormValid,
        };
    },
};
</script>

<style scoped>
.input-field {
  @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
}

.btn-primary {
  @apply bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed;
}

.btn-secondary {
  @apply bg-gray-100 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-200 transition-colors;
}
</style>
