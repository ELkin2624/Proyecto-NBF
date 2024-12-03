<template>
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tu Carrito</h1>

        <div v-if="carrito && carrito.items.length" class="space-y-4">
            <div
                v-for="item in carrito.items"
                :key="item.id_carrito_item"
                class="flex items-center justify-between bg-white shadow-md p-4 rounded-lg"
            >
                <div class="flex items-center space-x-4">
                    <img
                        :src="`/storage/${item.producto.imagen_url}`"
                        alt="Producto"
                        class="w-16 h-16 sm:w-24 sm:h-24 lg:w-32 lg:h-32 rounded object-cover"
                    />
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ item.producto.nombre }}</h2>
                        <p class="text-gray-500">Precio unitario: {{ item.precio_unitario }} Bs</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <label for="cantidad" class="text-gray-600">Cantidad:</label>
                            <input
                                type="number"
                                min="1"
                                :value="item.cantidad"
                                class="w-16 p-1 border border-gray-300 rounded"
                                @input="validateQuantity($event.target.value, item.id_carrito_item)"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <p class="text-lg font-semibold text-indigo-600">
                        Bs {{ (item.cantidad * item.precio_unitario).toFixed(2) }}
                    </p>
                    <button
                        @click="removeItem(item.id_carrito_item)"
                        class="px-6 py-2 text-red-500 rounded-lg hover:text-red-700 transition"
                    >
                        Eliminar
                    </button>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button
                    @click="generarPedido"
                    :disabled="isLoading || !isCartValid"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                >
                    <span v-if="isLoading">Procesando...</span>
                    <span v-else>Confirmar Pedido</span>
                </button>
                <button
                    @click="generarCotizacion"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                    Generar Cotización
                </button>
            </div>

            <div class="text-right">
                <p class="text-lg font-bold text-gray-800">
                    Total: Bs {{ carrito.items.reduce((total, item) => total + item.cantidad * item.precio_unitario, 0).toFixed(2) }}
                </p>
                <button
                    class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                >
                    Proceder al Pago
                </button>
            </div>
        </div>

      <div v-else class="text-center">
        <p class="text-gray-600">Tu carrito está vacío.</p>
        <Link href="/vistaproductos" class="text-indigo-600 underline mt-4">Explorar productos</Link>
      </div>
    </div>
  </template>

  <script>
    import axios from "axios";

    export default {
        props: {
            carrito: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isLoading: false,
            };
        },

        computed: {
            isCartValid() {
                return this.carrito.items.every(item => item.cantidad > 0);
            },
        },

        methods: {
            async removeItem(itemId) {
                try {
                    await this.$inertia.post('/carrito/item', { id_carrito_item: itemId });
                    await this.$inertia.reload();
                } catch (error) {
                    console.error("Error eliminando producto del carrito:", error);
                }
            },

            validateQuantity(value, itemId) {
                const cantidad = parseInt(value);
                if (isNaN(cantidad) || cantidad <= 0) {
                    alert('La cantidad debe ser mayor que cero');
                    return;
                }
                this.updateQuantity(itemId, cantidad);
            },

            async updateQuantity(itemId, cantidad) {
                try {
                    await axios.patch("/carrito/item", {
                        id_carrito_item: itemId,
                        cantidad: parseInt(cantidad),
                    });
                    this.$inertia.reload(); // Recarga la página para reflejar los cambios
                } catch (error) {
                    console.error("Error actualizando la cantidad:", error);
                }
            },

            async generarPedido() {
                this.isLoading = true;
                try {
                    const response = await axios.post('/pedido/generar');
                    if (response.data.url) {
                        window.location.href = response.data.url; // Redirige a la URL de Stripe
                    } else {
                        throw new Error('No se recibió una URL válida para el pago.');
                    }
                } catch (error) {
                    console.error('Error generando pedido:', error);
                    const message = error.response?.data?.message || 'Ocurrió un error inesperado. Intenta nuevamente.';
                    alert(message);
                } finally {
                    this.isLoading = false;
                }
            },

            async generarCotizacion() {
                window.open(route('cotizacion.pdf'), '_blank');
            },
        },
    };
  </script>
