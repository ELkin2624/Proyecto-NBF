<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Alertas from '@/Components/alertas.vue'; // Importa el componente de alertas
import axios from 'axios';


const openDropdown = ref(null);
const isHamburgerMenuOpen = ref(false);
const isMobileView = ref(false);
<<<<<<< HEAD

const alertas = ref([]); // Array para las alertas
=======
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5

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

<<<<<<< HEAD
// Función para obtener alertas del servidor
async function fetchAlertas() {
    try {
        const response = await axios.get('/alertas');
        alertas.value = response.data;
    } catch (error) {
        console.error('Error al obtener alertas:', error);
    }
}

=======
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
    document.addEventListener('click', handleClickOutside);
<<<<<<< HEAD
    fetchAlertas(); // Cargar alertas al montar el componente
=======
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
    document.removeEventListener('click', handleClickOutside);
});
</script>


<template>
    <AppLayout title="Dashboard">
<<<<<<< HEAD
        <!-- Botón del menú en vista móvil -->
=======
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
        <button
            v-if="isMobileView"
            @click="toggleHamburgerMenu"
            class="focus:outline-none p-2 rounded-lg bg-indigo-600 text-white shadow-md"
        >
            <i v-if="!isHamburgerMenuOpen" class="bx bx-menu text-3xl"></i>
            <i v-else class="bx bx-x text-3xl"></i>
        </button>

<<<<<<< HEAD
        <!-- Menú lateral -->
        <aside
            v-if="!isMobileView || isHamburgerMenuOpen"
            class="main-sidebar sidebar-dark-primary elevation-4"
            style="position: fixed; top: 0; left: 0; height: 100%; width: 250px; transition: transform 0.3s ease-in-out;"
        >
            <div class="sidebar">
                <p class="menu-title">PAQUETES:</p>
                <nav class="mt-12">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link" @click.stop="toggleDropdown('inventario')">
                                <p>Inventario <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul v-if="openDropdown === 'inventario'" class="nav nav-treeview">
                                <li class="nav-item"><a href="/inventario" class="nav-link"><p>Gestionar Inventario</p></a></li>
                                <li class="nav-item"><a href="/productos" class="nav-link"><p>Gestionar Producto</p></a></li>
                                <li class="nav-item"><a href="/reportes/inventario" class="nav-link"><p>Reporte de inventario</p></a></li>
                                <li class="nav-item"><a href="/almacenes" class="nav-link"><p>Gestionar Almacén</p></a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" @click.stop="toggleDropdown('ventas')">
                                <p>
                                    Ventas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul v-if="openDropdown === 'ventas'" class="nav nav-treeview">
                                <li class="nav-item"><a href="/notas-venta" class="nav-link"><p>Gestionar Nota de Venta</p></a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" @click.stop="toggleDropdown('compras')">
                                <p>
                                    Compras
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul v-if="openDropdown === 'compras'" class="nav nav-treeview">
                                <li class="nav-item"><a href="/notas-compra" class="nav-link"><p>Gestionar Nota de Compra</p></a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" @click.stop="toggleDropdown('admin')">
                                <p>
                                    Administrador de Usuarios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul v-if="openDropdown === 'admin'" class="nav nav-treeview">
                                <li class="nav-item"><a href="/proveedores" class="nav-link"><p>Gestionar Proveedor</p></a></li>
                                <li class="nav-item"><a href="/Bitacora" class="nav-link"><p>Visualizar Bitácora</p></a></li>
                                <li class="nav-item"><a href="/users" class="nav-link"><p>Gestionar Usuario</p></a></li>
                                <li class="nav-item"><a href="/reservas" class="nav-link"><p>Gestionar Fecha de Reserva</p></a></li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <div class="contact-info">
                    <p>CONTACTANOS: 71662110</p>
                </div>
            </div>
        </aside>
=======
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
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5

        <div class="content-wrapper" style="margin-left: 250px; padding-top: 10px;">
            <!-- Componente de alertas -->
            <Alertas :alertas="alertas" />

            <div class="content-wrapper" style="margin-left: 250px; padding-top: 10px;">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <Welcome />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<style scoped>
<<<<<<< HEAD
.menu-title {
    color: #FFD700;
    font-size: 30px;
    margin-top: 30px;
    font-weight: bolder;
    padding: 5px;
}

.sidebar {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.contact-info {
    color: #fff;
    font-size: 14px;
    padding: 15px;
    background-color: #2B1E66;
    text-align: center;
    border-radius: 20px;
    margin-top: 70px;
}

.main-sidebar {
    background-color: #8C85F7;
    border-right: 5px solid #8078fc;
    border-left: 5px solid #8078fc;
}

.nav-link {
    color: #fff;
    padding: 15px;
    font-weight: bold;
    transition: background-color 0.3s ease, color 0.3s ease;
    display: block;
}

.nav-link:hover {
    background-color: #2B1E66;
    color: #fff;
    border-radius: 5px;
}

.nav-sidebar {
    display: block;
}

.nav-treeview {
    display: none;
    margin-left: 15px;
}

.nav-item:hover .nav-treeview {
    display: block;
}

.nav-treeview .nav-item .nav-link {
    color: #ffffff;
    padding-left: 20px;
    font-size: 15px;
}

.nav-treeview .nav-item .nav-link:hover {
    background-color: rgba(214, 33, 175, 0.5);
    color: #fffb04;
}

.nav-item > .nav-link:focus, .nav-item > .nav-link.active {
    background-color: #2B1E66;
    color: #ffffff;
    border-radius: 11px;
}

@media (max-width: 650px) {
    .main-sidebar {
        width: 100%;
    }
}
=======

>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
</style>
