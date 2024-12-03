<template>
    <form @submit.prevent="submitForm">
      <!-- Proveedor -->
      <label for="proveedor">Proveedor:</label>
      <select v-model="form.id_proveedor">
        <option v-for="proveedor in proveedores" :key="proveedor.id_proveedor" :value="proveedor.id_proveedor">
          {{ proveedor.nombre }}
        </option>
      </select>

      <!-- Productos -->
      <label for="productos">Productos:</label>
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="producto in productos" :key="producto.codigo">
            <td>{{ producto.nombre }}</td>
            <td>
              <input
                type="number"
                v-model="form.productos[producto.codigo].cantidad"
                @input="updateSubtotal(producto.codigo)"
                required
              />
            </td>
            <td>
              <input
                type="number"
                v-model="form.productos[producto.codigo].precio_unitario"
                @input="updateSubtotal(producto.codigo)"
                required
              />
            </td>
            <td>
              <input
                type="number"
                v-model="form.productos[producto.codigo].subtotal"
                required
                readonly
              />
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Botón de Envío -->
      <button type="submit">Crear Nota de Compra</button>
    </form>
  </template>

  <script>
  import { ref } from "vue";
  import { Inertia } from "@inertiajs/inertia";

  export default {
    props: {
      proveedores: Array,
      productos: Array,
    },

    setup(props) {
      const form = ref({
        id_proveedor: "",
        productos: props.productos.reduce((acc, producto) => {
          acc[producto.codigo] = {
            cantidad: "",
            precio_unitario: "",
            subtotal: 0,
          };
          return acc;
        }, {}),
      });

      // Calcular el subtotal de un producto
      const updateSubtotal = (codigo) => {
        const producto = form.value.productos[codigo];
        if (producto.cantidad && producto.precio_unitario) {
          producto.subtotal = producto.cantidad * producto.precio_unitario;
        } else {
          producto.subtotal = 0;
        }
      };

      // Enviar el formulario
      const submitForm = () => {
        Inertia.post(route("notas-compra.store"), form.value);
      };

      return {
        form,
        updateSubtotal,
      };
    },
  };
  </script>
