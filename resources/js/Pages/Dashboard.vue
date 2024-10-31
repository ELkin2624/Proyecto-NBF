<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Inertia } from '@inertiajs/inertia';


const openDropdown = ref(null);
const isHamburgerMenuOpen = ref(false);
const isMobileView = ref(false);
const openDropdown2 = ref(null);

const toggleDropdown2 = (dropdownName) => {
    openDropdown2.value = openDropdown2.value === dropdownName ? null : dropdownName;
};

const closeDropdown2 = () => {
    openDropdown2.value = null;
};

function toggleDropdown(menu) {
    openDropdown.value = openDropdown.value === menu ? null : menu;
}

function closeDropdown() {
    openDropdown.value = null;
}

function toggleHamburgerMenu() {
    isHamburgerMenuOpen.value = !isHamburgerMenuOpen.value;
}

function handleResize() {
    isMobileView.value = window.innerWidth < 650;
}

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
});
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- Botón de menú hamburguesa en vista móvil -->
                <button
                    v-if="isMobileView"
                    @click="toggleHamburgerMenu"
                    class="focus:outline-none p-2 rounded-lg relative z-20"
                >
                    <!-- Alternar entre el icono de hamburguesa y la X -->
                    <i v-if="!isHamburgerMenuOpen" class="bx bx-menu text-3xl"></i>
                    <i v-else class="bx bx-x text-3xl"></i>
                </button>

                <!-- Menú de navegación -->
                <nav
                    v-if="!isMobileView || isHamburgerMenuOpen"
                    class="bg-white p-3 rounded-lg shadow-md w-full sm:w-auto mt-2 sm:mt-0"
                >
                    <ul class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-6 text-lg">
                        <!-- Inventario Dropdown -->
                        <li class="relative" @click="toggleDropdown('inventario')">
                            <span class="hover:text-gray-900 cursor-pointer">Inventario</span>
                            <ul
                                v-if="openDropdown === 'inventario'"
                                class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                            >
                                <li><a href="/inventario" class="block px-4 py-2 hover:bg-gray-200">Gestionar Inventario</a></li>
                                <li><a href="/productos" class="block px-4 py-2 hover:bg-gray-200">Gestionar Producto</a></li>
                                <li><a href="/consultar-inventario" class="block px-4 py-2 hover:bg-gray-200">Consultar Inventario</a></li>
                                <li><a href="/almacenes" class="block px-4 py-2 hover:bg-gray-200">Gestionar Almacén</a></li>
                            </ul>
                        </li>

                        <!-- Ventas Dropdown -->
                        <li class="relative" @click="toggleDropdown('ventas')">
                            <span class="hover:text-gray-900 cursor-pointer">Ventas</span>
                            <ul
                                v-if="openDropdown === 'ventas'"
                                class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                            >
                                <li><a href="/notas-venta" class="block px-4 py-2 hover:bg-gray-200">Gestionar Nota de Venta</a></li>
                            </ul>
                        </li>

                        <!-- Compras Dropdown -->
                        <li class="relative" @click="toggleDropdown('compras')">
                            <span class="hover:text-gray-900 cursor-pointer">Compras</span>
                            <ul
                                v-if="openDropdown === 'compras'"
                                class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                            >
                                <li><a href="/notas-compra" class="block px-4 py-2 hover:bg-gray-200">Gestionar Nota de Compra</a></li>
                            </ul>
                        </li>

                        <!-- Administrador de Usuario Dropdown -->
                        <li class="relative" @click="toggleDropdown('admin')">
                            <span class="hover:text-gray-900 cursor-pointer">Administrador de Usuario</span>
                            <ul
                                v-if="openDropdown === 'admin'"
                                class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                            >
                                <li><a href="/proveedores" class="block px-4 py-2 hover:bg-gray-200">Gestionar Proveedor</a></li>
                                <li><a href="/bitacora" class="block px-4 py-2 hover:bg-gray-200">Visualizar Bitácora</a></li>
                                <li><a href="/users" class="block px-4 py-2 hover:bg-gray-200">Gestionar Usuario</a></li>
                                <li><a href="/reservas" class="block px-4 py-2 hover:bg-gray-200">Gestionar Fecha de Reserva</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>