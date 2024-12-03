<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

//19/10
const role = sessionStorage.getItem('role')

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 font-semibold text-sm text-green-600 text-center">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-3">
            <div>
                <InputLabel for="email" value="Email" class="text-gray-700 font-medium" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" class="text-gray-700 font-medium" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full px-4 py-3 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-gray-600 text-sm">
                    <Checkbox v-model:checked="form.remember" name="remember" class="text-indigo-600 focus:ring-indigo-500" />
                    <span class="ml-2">Recuérdame</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-indigo-600 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    ¿Olvidaste tu contraseña?
                </Link>

                <PrimaryButton class="px-4 py-2 text-white bg-indigo-600 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-150 ease-in-out" :class="{ 'opacity-50 cursor-not-allowed': form.processing }" :disabled="form.processing">
                    Iniciar sesión
                </PrimaryButton>
            </div>

            <div v-if="role == 'cliente'" class="flex items-center justify-center mt-6 text-gray-600 text-sm">
                <span class="text-sm text-gray-600">¿No tienes una cuenta?</span>
                <Link :href="route('register')" class="ml-1 text-indigo-600 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Regístrate aquí
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>

