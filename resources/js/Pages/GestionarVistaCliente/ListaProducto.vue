<template>
     <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased">

        <nav class="fixed z-50 w-full top-0 bg-gradient-to-r from-indigo-100 to-white/95 backdrop-blur-xl shadow-md transition-all duration-300 ease-in-out">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">

                <div class="flex items-center space-x-3">
                    <i class="bx bx-store-alt bx-md text-indigo-700"></i>
                    <span class="text-2xl font-bold text-indigo-700 tracking-tight transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        MiTienda
                    </span>
                </div>

                <div class="items-center space-x-2">
                    <template v-if="!auth.user">
                        <Link href="/role-selection" class="px-4 py-2 text-indigo-600 font-semibold hover:bg-indigo-50 rounded-lg transition-all duration-300 ease-in-out">
                            Iniciar sesión
                        </Link>
                        <Link href="/register" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out">
                            Registrarse
                        </Link>
                    </template>

                    <template v-else>
                        <div class="hidden lg:flex items-center space-x-6 px-4 py-2">
                            <Link v-for="link in navLinks" :key="link.href" :href="link.href" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 transition-colors group">
                                <component :is="link.icon" class="inline-block w-5 h-5 group-hover:scale-110 transition-transform" />
                                <span class="group-hover:font-semibold">{{ link.label }}</span>
                            </Link>
                            <Link href="/soporte" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 transition-colors group">
                                <i class="bx bx-support bx-sm group-hover:rotate-12 transition-transform"></i>
                                <span class="group-hover:font-semibold">Soporte</span>
                            </Link>
                            <Link href="/logout" method="post" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 transition-colors group">
                                <i class="bx bx-door-open bx-sm group-hover:scale-110"></i>
                                <span class="group-hover:font-semibold">Cerrar Sesión</span>
                            </Link>
                        </div>

                        <!-- Botón menú hamburguesa -->
                        <div class="lg:hidden">
                            <button @click="toggleMobileMenu" class="text-indigo-600 hover:text-indigo-800 focus:outline-none transition duration-300 ease-in-out">
                                <i class="bx bx-menu-alt-right bx-md"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Menú móvil -->
        <div>
        <!-- Overlay -->
            <div
                v-if="mobileMenuOpen"
                class="lg:hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity duration-300 ease-in-out"
                @click="toggleMobileMenu"
            ></div>

            <!-- Contenido del menú -->
            <div
                :class="[
                    'lg:hidden fixed top-0 right-0 w-64 h-full bg-indigo-700 text-white space-y-6 p-6 shadow-xl transition transform ease-in-out duration-300 z-50',
                    mobileMenuOpen ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0'
                ]"
            >
                <button @click="toggleMobileMenu" class="absolute top-4 right-4 text-white hover:text-indigo-300 transition-colors">
                    <i class="bx bx-x bx-md"></i>
                </button>

                <div class="mt-12 space-y-6">
                    <Link v-for="link in navLinks" :key="link.href" :href="link.href" class="flex items-center space-x-3 hover:text-indigo-300 transition-colors" @click="toggleMobileMenu">
                        <component :is="link.icon" class="h-6 w-6" />
                        <span>{{ link.label }}</span>
                    </Link>
                    <Link href="/soporte" class="flex items-center space-x-3 hover:text-indigo-300 transition-colors">
                        <i class="bx bx-support bx-sm"></i>
                        <span>Soporte</span>
                    </Link>
                    <Link href="/logout" method="post" class="flex items-center space-x-3 hover:text-indigo-300 transition-colors">
                        <i class="bx bx-door-open bx-sm"></i>
                        <span>Cerrar Sesión</span>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Header con barra de búsqueda -->
        <header class="bg-white shadow py-6">
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <h1 class="text-3xl font-extrabold text-indigo-600">Productos</h1>
                <!-- Barra de búsqueda -->
                <div class="relative w-full max-w-md">
                    <input
                        v-model="filters.search"
                        type="text"
                        placeholder="Buscar productos..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        @input="debouncedSearch"
                    />
                    <!-- Icono de búsqueda -->
                    <svg
                        class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Filtros laterales -->
                <aside class="lg:col-span-3 space-y-4">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-bold text-gray-900 mb-2">Filtros</h2>
                        <!-- Categorías -->
                        <div class="border-t pt-2">
                            <button
                                class="w-full flex justify-between items-center text-gray-800 hover:text-indigo-600 font-medium"
                                @click="toggleFilter('categorias')"
                            >
                                Categorías
                                <svg
                                    :class="{ 'rotate-180': activeFilters.categorias }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transition-transform"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-if="activeFilters.categorias" class="mt-3 space-y-2">
                                <label
                                    v-for="categoria in categorias"
                                    :key="categoria.id_categoria"
                                    class="flex items-center space-x-2"
                                >
                                    <input
                                        type="checkbox"
                                        :value="categoria.id_categoria"
                                        v-model="filters.categorias"
                                        class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        @change="applyFilters"
                                    />
                                    <span class="text-gray-700">{{ categoria.nombre }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Marcas -->
                        <div class="border-t pt-2">
                            <button
                                class="w-full flex justify-between items-center text-gray-800 hover:text-indigo-600 font-medium"
                                @click="toggleFilter('marcas')"
                            >
                                Marcas
                                <svg
                                    :class="{ 'rotate-180': activeFilters.marcas }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transition-transform"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-if="activeFilters.marcas" class="mt-3 space-y-2">
                                <label
                                    v-for="marca in marcas"
                                    :key="marca.id_marca"
                                    class="flex items-center space-x-2"
                                >
                                    <input
                                        type="checkbox"
                                        :value="marca.id_marca"
                                        v-model="filters.marcas"
                                        class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        @change="applyFilters"
                                    />
                                    <span class="text-gray-700">{{ marca.nombre }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Ordenar por -->
                        <div class="border-t pt-2">
                            <button
                                class="w-full flex justify-between items-center text-gray-800 hover:text-indigo-600 font-medium"
                                @click="toggleFilter('orden')"
                            >
                                Ordenar por
                                <svg
                                    :class="{ 'rotate-180': activeFilters.orden }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transition-transform"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-if="activeFilters.orden" class="mt-3">
                                <select
                                    v-model="filters.orden"
                                    class="w-full rounded-lg border-gray-300 text-gray-700 focus:ring-indigo-500 focus:border-indigo-500"
                                    @change="applyFilters"
                                >
                                    <option value="nombre_asc">Nombre: A-Z</option>
                                    <option value="nombre_desc">Nombre: Z-A</option>
                                    <option value="precio_asc">Precio: Menor a Mayor</option>
                                    <option value="precio_desc">Precio: Mayor a Menor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Lista de productos -->
                <div class="lg:col-span-9">
                    <!-- Loading state -->
                    <div v-if="loading" class="flex justify-center items-center h-64">
                        <svg class="w-8 h-8 animate-spin text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <!--Grid de productos-->
                    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="producto in productos.data"
                            :key="producto.codigo"
                            class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all hover:-translate-y-2 hover:shadow-xl"
                        >
                            <Link :href="route('vistap.show', producto.codigo)" class="block">
                                <div class="relative pt-[100%] overflow-hidden group">
                                    <img
                                        v-if="producto.imagen_url"
                                        :src="`/storage/${producto.imagen_url}`"
                                        :alt="producto.nombre"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                    />
                                    <div v-else class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                                        <span class="text-gray-400">No disponible</span>
                                    </div>

                                    <!-- Botón de favoritos -->
                                    <button class="absolute top-4 right-4 bg-white/70 p-2 rounded-full hover:bg-white/90 transition-colors">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <!--Detalles del producto-->
                                <div class="p-4">
                                    <h3 class="font-bold text-lg text-gray-800 line-clamp-2">
                                        {{ producto.nombre }}
                                    </h3>
                                    <div class="mt-2 flex items-center">
                                        <div class="flex items-center">
                                            <!-- Rating stars -->
                                            <div class="flex">
                                                <template v-for="n in 5" :key="n">
                                                    <svg
                                                        class="w-4 h-4"
                                                        :class="n <= (producto.rating || 0) ? 'text-yellow-400' : 'text-gray-300'"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </template>
                                            </div>
                                            <span class="ml-1 text-sm text-gray-500">
                                                ({{ producto.reviews_count || 0 }})
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <p class="text-xl font-bold text-gray-900">
                                            ${{ producto.precioxmenor }}
                                        </p>
                                        <button
                                            @click.prevent="addToCart(producto)"
                                            class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-colors flex items-center space-x-2"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>Agregar</span>
                                        </button>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>


                    <!-- Paginación -->
                    <div v-if="productos.links && !loading" class="mt-8">
                        <div class="flex justify-center gap-2">
                            <template v-for="(link, index) in productos.links" :key="index">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    class="px-4 py-2 rounded-md"
                                    :class="[
                                        link.active
                                            ? 'bg-indigo-600 text-white'
                                            : 'bg-white text-gray-700 hover:bg-gray-50'
                                    ]"
                                    v-html="link.label"
                                />
                                <span
                                    v-else
                                    class="px-4 py-2 text-gray-400 cursor-not-allowed"
                                    v-html="link.label"
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
  </template>

<script setup>
    import { ref, reactive, onMounted } from 'vue'
    import { Link, router, usePage } from '@inertiajs/vue3'
    import debounce from 'lodash/debounce'
    import { HomeIcon, HeartIcon, ShoppingCartIcon, User2Icon } from 'lucide-vue-next'
    import axios from 'axios'

    const loading = ref(false)
    const { auth } = usePage().props;

    const props = defineProps({
        productos: Object,
        categorias: {
            type: Array,
            default: () => [],
        },
        marcas: {
            type: Array,
            default: () => [],
        },
        filters: {
            type: Object,
            default: () => ({
                search: '', // Asegura que 'search' siempre tenga un valor
                categorias: [],
                marcas: [],
                orden: 'nombre_asc',
            }),
        },
    })

    const mobileMenuOpen = ref(false)

    const toggleMobileMenu = () => {
        mobileMenuOpen.value = !mobileMenuOpen.value
    }

    const navLinks = [
        {
            href: route('profile.show'),
            label: 'Perfil',
            icon: User2Icon
        },
        {
            href: '/vistaproductos',
            label: 'Inicio',
            icon: HomeIcon
        },
        {
            href: '/favoritos',
            label: 'Favoritos',
            icon: HeartIcon
        },
        {
            href: '/carrito',
            label: 'Carrito',
            icon: ShoppingCartIcon
        }
    ]

    const filters = reactive({
        search: props.filters.search || '',
        categorias: props.filters.categorias || [],
        marcas: props.filters.marcas || [],
        orden: props.filters.orden || 'nombre_asc'
    })

    // Estado para controlar qué filtros están colapsados
    const activeFilters = reactive({
        categorias: true,
        marcas: true,
        orden: false,
    })

    const toggleFilter = (filter) => {
        activeFilters[filter] = !activeFilters[filter]
    }

    // Búsqueda con debounce
    const debouncedSearch = debounce(() => {
        applyFilters()
    }, 300)

    function applyFilters() {
        loading.value = true
        const [campo, direccion] = filters.orden.split('_')

        router.get(route('vistap.index'),
        {
            search: filters.search,
            categoria: filters.categorias.join(','),
            marca: filters.marcas.join(','),
            orden: campo,
            direccion: direccion
        },
        {
            preserveState: true,
            preserveScroll: true,
            onFinish: () => {
                loading.value = false
            }
        }
        )
    }

    async function addToCart(producto) {
        if (!auth.user) {
            alert('Debes iniciar sesión para añadir productos al carrito.');
            return;
        }
        try {
            const response = await axios.post('/carrito/agregar', {
                codigo_producto: producto.codigo,
                cantidad: 1,
            });
            alert(response.data.message); // Mostrar mensaje de éxito
        } catch (error) {
            console.error('Error al agregar al carrito:', error.response?.data?.message || error.message);
        }
    }

    // Opcional: Limpiar el debounce cuando el componente se desmonta
    onMounted(() => {
        return () => {
            debouncedSearch.cancel()
        }
    })
</script>
