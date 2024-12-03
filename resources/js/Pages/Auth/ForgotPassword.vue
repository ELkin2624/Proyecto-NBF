<script setup>
import { ref } from 'vue'; // Asegúrate de importar ref
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

// Mensaje para mostrar después del envío
const message = ref('');

const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => {
            if (form.wasSuccessful) { // Corrige aquí
                message.value = 'Email enviado, verifique su correo';
                setTimeout(() => {
                    // Redirigir a la página de login
                    window.location.href = route('login');
                }, 2000);
            } else {
                message.value = '';
            }
        }
    });
};
</script>

<template>
    <Head title="Forgot Password" />

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <AuthenticationCard>
            <template #logo>
                <AuthenticationCardLogo />
            </template>

            <div class="mb-4 text-sm text-gray-600">
                ¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña que te permitirá elegir una nueva.
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div v-if="message" class="mb-4 font-medium text-sm text-green-600">
                {{ message }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="flex items-center justify-center mt-4">
                    <PrimaryButton
                        :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                        :disabled="form.processing"
                        class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out rounded-md shadow-lg text-white"
                    >
                        Enviar enlace para restablecer contraseña
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticationCard>
    </div>

</template>
