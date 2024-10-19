<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
      <div class="text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-8">Bienvenido</h1>
        <h2 class="text-xl mb-4">Elige tu tipo de cuenta</h2>
        <div class="flex justify-center space-x-8">
          <!-- Admin -->
          <Link href="/login?role=admin" class="block p-4 bg-white rounded shadow-lg hover:bg-gray-200">
            <i class='bx bx-user-circle text-6xl mb-2'></i>
            <p class="text-center">Admin</p>
          </Link>

          <!-- Cliente -->
          <Link href="/login?role=client" class="block p-4 bg-white rounded shadow-lg hover:bg-gray-200">
            <i class='bx bxs-user-circle text-6xl mb-2'></i>
            <p class="text-center">Cliente</p>
          </Link>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
  </script>

