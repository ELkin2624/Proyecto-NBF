<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center my-8">Gestión de Usuarios y Roles</h1>

        <!-- Crear Usuario -->
        <div class="bg-white shadow-xl rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Crear Nuevo Usuario</h2>
            <form @submit.prevent="createUser" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" v-model="newUser.name" id="name" class="w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
                        <input type="email" v-model="newUser.email" id="email" class="w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select v-model="newUser.rol" id="role" class="w-full border border-gray-300 rounded-lg p-2" required>
                            <option value="admin">Administrador</option>
                            <option value="cliente">Cliente</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg px-4 py-2 mt-4">Crear Usuario</button>
            </form>
        </div>

        <!-- Listado de Usuarios -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Listado de Usuarios</h2>
            <input v-model="search" placeholder="Buscar usuario..." class="border border-gray-300 rounded-lg p-2 w-full mb-4" />

            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="border border-gray-300 bg-gray-200 text-center text-sm font-semibold text-gray-900">
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Rol</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    <tr v-for="user in filteredUsers" :key="user.id_usuario" class="border-b border-gray-200 hover:bg-gray-80">
                        <td class="border border-gray-300 p-3">{{ user.name }}</td>
                        <td class="border border-gray-300 p-3">{{ user.email }}</td>
                        <td class="border border-gray-300 p-3 capitalize">{{ user.rol }}</td>
                        <td class="border border-gray-300 p-3 text-center">
                            <div class="flex justify-center space-x-3">
                                <button @click="editUser(user)" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-md px-4 py-1 transition-transform transform hover:scale-105 shadow-md">
                                    Editar
                                </button>
                                <button @click="deleteUser(user.id_usuario)" class="bg-red-500 hover:bg-red-600 text-white rounded-md px-4 py-1 transition-transform transform hover:scale-105 shadow-md">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para editar usuario -->
        <div v-if="editingUser" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                <h2 class="text-2xl mb-4">Editar Usuario</h2>
                <form @submit.prevent="updateUser" class="space-y-4">
                    <div>
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" v-model="editingUser.name" id="edit-name" class="w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div>
                        <label for="edit-email" class="block text-sm font-medium text-gray-700">Correo</label>
                        <input type="email" v-model="editingUser.email" id="edit-email" class="w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div>
                        <label for="edit-role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select v-model="editingUser.rol" id="edit-role" class="w-full border border-gray-300 rounded-lg p-2" required>
                            <option value="admin">Administrador</option>
                            <option value="cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-6 py-2 transition-transform transform hover:scale-105 shadow-md">
                            Guardar Cambios
                        </button>
                        <button @click="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white rounded-md px-6 py-2 transition-transform transform hover:scale-105 shadow-md">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Auditoría y Seguimiento -->
        <div v-if="auditLogs && auditLogs.length" class="bg-white shadow rounded-lg p-6 my-8">
            <h2 class="text-2xl font-semibold mb-4">Auditoría y Seguimiento</h2>
            <button @click="generateReport" class="bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg px-4 py-2">Generar Informe de Actividades</button>
            <div v-if="auditLogs.length" class="mt-4">
                <h3 class="text-lg font-semibold">Últimas Actividades</h3>
                <ul class="list-disc pl-5">
                    <li v-for="log in auditLogs" :key="log.id" class="text-sm text-gray-700">
                        {{ log.message }} - {{ log.created_at }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        users: {
            type: Array,
            default: () => []
        },
        auditLogs: {
            type: Array,
            default: () =>[]
        },
    },
    data() {
        return {
            newUser: {
                name: '',
                email: '',
                rol: 'cliente',
            },
            editingUser: null,
            search: '',
        };
    },
    computed: {
        filteredUsers() {
            return this.users.filter(user =>
                user.name.toLowerCase().includes(this.search.toLowerCase()) ||
                user.email.toLowerCase().includes(this.search.toLowerCase())
            );
        },
    },
    methods: {
        createUser() {
            Inertia.post('/users', this.newUser, {
                onSuccess: () => {
                    this.newUser = { name: '', email: '', rol: 'cliente' }; // Limpiar formulario
                },
            });
        },
        updateRole(id_usuario, rol) {
            Inertia.post(`/roles/${id_usuario}`, { rol });
        },
        editUser(user) {
            this.editingUser = { ...user }; // Clonar el usuario
        },
        updateUser() {
            Inertia.put(`/users/${this.editingUser.id_usuario}`, this.editingUser, {
                onSuccess: () => {
                    this.editingUser = null; // Cerrar modal
                },
            });
        },
        cancelEdit() {
            this.editingUser = null; // Cancelar la edición
        },
        deleteUser(id_usuario) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                Inertia.delete(`/users/${id_usuario}`);
            }
        },
        generateReport() {
            Inertia.post('/audit/report');
        },
    },
};
</script>

<style scoped>
/* Agrega estilos personalizados aquí si es necesario */
</style>
