<template>
    <div class="container mx-auto mt-10">
      <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Lista de Proveedores</h2>

      <!-- Formulario para agregar nuevo proveedor -->
      <div class="mb-6 p-6 bg-gray-100 rounded-xl shadow-md">
        <h3 class="text-xl font-semibold mb-4">Agregar Proveedor</h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <input type="text" v-model="nuevoProveedor.nombre" placeholder="Nombre" class="input-field" />
          <input type="text" v-model="nuevoProveedor.telefono" placeholder="Teléfono" class="input-field" />
          <input type="number" v-model="nuevoProveedor.tiempo_entrega" placeholder="Tiempo de Entrega (días)" class="input-field" />
        </div>
        <button @click="crearProveedor" class="btn mt-4">Crear Proveedor</button>
      </div>

      <!-- Listado de proveedores -->
      <div v-if="proveedores.length > 0" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="proveedor in proveedores"
          :key="proveedor.id_proveedor"
          class="p-6 bg-white shadow-lg rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105"
        >
          <h3 class="text-lg font-semibold text-gray-800">{{ proveedor.nombre }}</h3>
          <p><strong>Teléfono:</strong> {{ proveedor.telefono }}</p>
          <p><strong>Tiempo de Entrega:</strong> {{ proveedor.tiempo_entrega }} días</p>
          <div class="flex justify-between mt-4">
            <button @click="editarProveedor(proveedor)" class="btn bg-yellow-500 hover:bg-yellow-600">Editar</button>
            <button @click="eliminarProveedor(proveedor.id_proveedor)" class="btn bg-red-500 hover:bg-red-600">Eliminar</button>
          </div>
        </div>
      </div>

      <div v-else>
        <p class="text-gray-500">No se encontraron proveedores.</p>
      </div>

      <!-- Modal para editar proveedor -->
      <div v-if="isEditModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-500">
        <div class="bg-white p-6 rounded-lg transform scale-95 transition-transform duration-300" :class="isEditModalOpen ? 'scale-100' : ''">
          <h3 class="text-xl mb-4">Editar Proveedor</h3>
          <input type="text" v-model="proveedorEditado.nombre" placeholder="Nombre" class="input-field mb-4" />
          <input type="text" v-model="proveedorEditado.telefono" placeholder="Teléfono" class="input-field mb-4" />
          <input type="number" v-model="proveedorEditado.tiempo_entrega" placeholder="Tiempo de Entrega" class="input-field mb-4" />
          <div class="flex justify-between mt-4">
            <button @click="actualizarProveedor" class="btn bg-green-500 hover:bg-green-600">Actualizar</button>
            <button @click="closeEditModal" class="btn bg-gray-400 hover:bg-gray-500">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { ref } from "vue";
  import { Inertia } from "@inertiajs/inertia";

  export default {
    props: {
      proveedores: Array,
    },
    setup(props) {
      const nuevoProveedor = ref({
        nombre: "",
        telefono: "",
        tiempo_entrega: null,
      });

      const proveedorEditado = ref({
        id_proveedor: null,
        nombre: "",
        telefono: "",
        tiempo_entrega: null,
      });

      const isEditModalOpen = ref(false);

      const crearProveedor = () => {
        Inertia.post("/proveedores", nuevoProveedor.value);
      };

      const editarProveedor = (proveedor) => {
        proveedorEditado.value = { ...proveedor };
        isEditModalOpen.value = true;
      };

      const actualizarProveedor = () => {
        Inertia.put(`/proveedores/${proveedorEditado.value.id_proveedor}`, proveedorEditado.value);
        closeEditModal();
      };

      const closeEditModal = () => {
        isEditModalOpen.value = false;
      };

      const eliminarProveedor = (id) => {
        if (confirm("¿Estás seguro de que quieres eliminar este proveedor?")) {
          Inertia.delete(`/proveedores/${id}`);
        }
      };

      return {
        proveedores: props.proveedores,
        nuevoProveedor,
        crearProveedor,
        editarProveedor,
        actualizarProveedor,
        isEditModalOpen,
        proveedorEditado,
        closeEditModal,
        eliminarProveedor,
      };
    },
  };
  </script>

  <style scoped>
  .container {
    max-width: 1200px;
  }
  .input-field {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 0.375rem;
    width: 100%;
    box-sizing: border-box;
    transition: border-color 0.3s;
  }
  .input-field:focus {
    border-color: #4a90e2;
  }

  .btn {
    padding: 0.75rem 1.5rem;
    background-color: #4a90e2;
    color: white;
    border-radius: 0.375rem;
    transition: background-color 0.3s, transform 0.3s;
  }
  .btn:hover {
    background-color: #357ab8;
    transform: translateY(-2px);
  }

  .bg-red-500:hover {
    background-color: #e53e3e;
  }

  .bg-yellow-500:hover {
    background-color: #d69e2e;
  }

  .bg-green-500:hover {
    background-color: #38a169;
  }

  .bg-gray-400:hover {
    background-color: #b8b8b8;
  }

  div[class*="transition-"] {
    transition: all 0.3s ease;
  }
  </style>
