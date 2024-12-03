<template>
    <div>
      <h1 class="text-2xl font-semibold mb-4">Crear Pedido</h1>

      <form @submit.prevent="submit">
        <div>
          <label for="fecha_recepcion">Fecha de Recepción:</label>
          <input v-model="form.fecha_recepcion" type="date" id="fecha_recepcion" required />
        </div>

        <div>
          <label for="estado">Estado:</label>
          <input v-model="form.estado" type="text" id="estado" required />
        </div>

        <div>
          <label for="direccion">Dirección:</label>
          <input v-model="form.direccion" type="text" id="direccion" required />
        </div>

        <div>
          <label for="id_cliente">Cliente:</label>
          <select v-model="form.id_cliente" id="id_cliente" required>
            <option v-for="cliente in clientes" :value="cliente.id_cliente" :key="cliente.id_cliente">
              {{ cliente.nombre }}
            </option>
          </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Crear Pedido</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    props: {
      productos: Array,
    },
    data() {
      return {
        form: {
          fecha_recepcion: '',
          estado: '',
          direccion: '',
          id_cliente: '',
        },
      };
    },
    methods: {
      submit() {
        this.$inertia.post(this.route('pedidos.store'), this.form);
      },
    },
  };
  </script>
