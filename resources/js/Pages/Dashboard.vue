<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Inertia } from '@inertiajs/inertia';


const openDropdown = ref(null);
const isHamburgerMenuOpen = ref(false);
const isMobileView = ref(false);

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

function handleClickOutside(event) {
    const dropdowns = document.querySelectorAll('.dropdown');
    let isClickInsideDropdown = false;

    dropdowns.forEach(dropdown => {
        if (dropdown.contains(event.target)) {
            isClickInsideDropdown = true;
        }
    });

    if (!isClickInsideDropdown) {
        closeDropdown();
    }
}

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <AppLayout title="Dashboard">
        <button
            v-if="isMobileView"
            @click="toggleHamburgerMenu"
            class="focus:outline-none p-2 rounded-lg bg-indigo-600 text-white shadow-md"
        >
            <i v-if="!isHamburgerMenuOpen" class="bx bx-menu text-3xl"></i>
            <i v-else class="bx bx-x text-3xl"></i>
        </button>

        <nav
            v-if="!isMobileView || isHamburgerMenuOpen"
            class="bg-white p-4 rounded-lg shadow-md w-full sm:w-auto mt-2 sm:mt-0"
        >
            <ul class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-6 text-lg">
                <li class="relative dropdown" @click.stop="toggleDropdown('inventario')">
                    <span class="hover:text-indigo-600 cursor-pointer font-semibold transition duration-150">Inventario</span>
                    <ul
                        v-if="openDropdown === 'inventario'"
                        class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                    >
                        <li><a href="/inventario" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Inventario</a></li>
                        <li><a href="/productos" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Producto</a></li>
                        <li><a href="/reportes/inventario" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Reporte de inventario</a></li>
                        <li><a href="/almacenes" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Almacén</a></li>
                    </ul>
                </li>

                <li class="relative dropdown" @click.stop="toggleDropdown('ventas')">
                    <span class="hover:text-indigo-600 cursor-pointer font-semibold transition duration-150">Ventas</span>
                    <ul
                        v-if="openDropdown === 'ventas'"
                        class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                    >
                        <li><a href="/notas-venta" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Nota de Venta</a></li>
                    </ul>
                </li>

                <li class="relative dropdown" @click.stop="toggleDropdown('compras')">
                    <span class="hover:text-indigo-600 cursor-pointer font-semibold transition duration-150">Compras</span>
                    <ul
                        v-if="openDropdown === 'compras'"
                        class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                    >
                        <li><a href="/nota-compra" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Nota de Compra</a></li>
                    </ul>
                </li>

                <li class="relative dropdown" @click.stop="toggleDropdown('admin')">
                    <span class="hover:text-indigo-600 cursor-pointer font-semibold transition duration-150">Administrador de Usuario</span>
                    <ul
                        v-if="openDropdown === 'admin'"
                        class="absolute bg-white rounded-lg shadow-lg z-10 mt-2 w-48"
                    >
                        <li><a href="/proveedores" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Proveedor</a></li>
                        <li><a href="/bitacora" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Visualizar Bitácora</a></li>
                        <li><a href="/users" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Usuario</a></li>
                        <li><a href="/reservas" class="block px-4 py-2 hover:bg-indigo-100 transition duration-150">Gestionar Fecha de Reserva</a></li>
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

<style scoped>

</style>
