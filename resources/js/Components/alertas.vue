<template>
    <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
      <p class="font-bold">Alertas</p>
      <ul>
        <li v-for="alerta in alertas" :key="alerta.id" class="my-2">
          {{ alerta.mensaje }}
        </li>
      </ul>
    </div>
  </template>

  <script>
  export default {
    props: {
      alertas: Array,
    },
  };
  </script>*/