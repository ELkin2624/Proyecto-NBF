<!-- resources/js/Pages/RoleSelection.vue -->
<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-cover bg-center px-4 sm:px-0"
        style="background-image: url('https://source.unsplash.com/1600x900/?nature,water');">
        <div class="bg-white bg-opacity-80 rounded-lg shadow-2xl p-6 sm:p-10 max-w-sm sm:max-w-md w-full transform transition-all duration-500 ease-in-out hover:scale-105">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-2 text-center">Bienvenido</h1>
            <p class="text-base sm:text-lg text-gray-600 text-center mb-6">Selecciona tu rol para continuar</p>
            <div class="flex flex-col space-y-4">
                <button @click="selectRole('admin')"
                        class="flex items-center justify-center sm:justify-between px-4 sm:px-6 py-3 sm:py-4 bg-blue-600 text-white rounded-lg shadow-lg transform hover:scale-105 hover:bg-blue-700 transition-all duration-200 w-full">
                    <i class='bx bx-user-circle bx-lg'></i>
                    <span class="ml-2 sm:ml-4 font-semibold">Administrador</span>
                </button>
                <button @click="selectRole('cliente')"
                        class="flex items-center justify-center sm:justify-between px-4 sm:px-6 py-3 sm:py-4 bg-green-600 text-white rounded-lg shadow-lg transform hover:scale-105 hover:bg-green-700 transition-all duration-200 w-full">
                    <i class='bx bx-user bx-lg'></i>
                    <span class="ml-2 sm:ml-4 font-semibold">Cliente</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        selectRole(role) {
            sessionStorage.setItem('role', role);
            if (role === 'admin') {
                this.$inertia.visit('/login');
            } else {
                this.$inertia.visit('/login');
            }
        }
    }
}
</script>

<style scoped>
/* Animación de entrada */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 20px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}
.bg-opacity-80 {
    animation: fadeInUp 0.6s ease-out;
}
</style>

