<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="bg-[#092E5C] flex flex-col lg:flex-row items-center"> <!-- Cambia a columna en pantallas pequeñas -->
        <div class="p-6 lg:p-8 bg-[#092E5C] border-b border-black flex flex-col lg:flex-row justify-between items-center w-full">
            
            <ApplicationLogo class="block h-12 w-auto mb-4 lg:mb-0 lg:mr-6" /> <!-- Margen inferior en pantallas pequeñas -->

            <div class="flex flex-col items-center lg:items-start text-center lg:text-left"> 
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-medium text-white mt-4 lg:mt-0"> <!-- Ajuste de tamaño del texto -->
                    Bienvenido a NBF, tu tienda de accesorios móviles :)
                </h1>

                <p class="mt-4 lg:mt-6 text-white leading-relaxed text-sm md:text-base lg:text-lg">
                    En NBF, ofrecemos una amplia variedad de accesorios para tus dispositivos móviles. Explora nuestra gama de productos y descubre la calidad y diseño que necesitas para personalizar y proteger tu dispositivo.
                </p>
            </div>
        </div>
    </div>
</template>