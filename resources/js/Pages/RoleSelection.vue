<!-- resources/js/Pages/RoleSelection.vue -->
<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-cover bg-center"
         style="background-image: url('https://source.unsplash.com/1600x900/?nature,water');">
        <div class="bg-white bg-opacity-70 rounded-lg shadow-2xl p-10">
            <h1 class="text-2xl font-bold mb-6 text-center">Selecciona tu Rol</h1>
            <div class="flex flex-col space-y-4">
                <button @click="selectRole('admin')" class="flex items-center justify-center p-4 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    <i class='bx bx-user-circle bx-md'></i>
                    Administrador
                </button>
                <button @click="selectRole('cliente')" class="flex items-center justify-center p-4 bg-green-500 text-white rounded-lg shadow hover:bg-green-00 transition">
                    <i class='bx bx-user bx-md'></i>
                    Cliente
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

</style>

