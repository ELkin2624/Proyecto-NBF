<script>
import axios from 'axios';  // Asegúrate de importar axios

export default {
  props: {
    bitacora: {
      type: Object,
      required: true,
    },
  },
  methods: {
    fetchPage(url) {
      if (url) Inertia.visit(url);
    },

    // Método para registrar una acción en la bitácora
    registrarAccion(accion, detalles, tablaAsociada) {
      // Llamada POST a la API de Laravel para registrar la acción
      axios.post('/registro-accion', {
        accion: accion,
        detalles: detalles,
        tabla_asociada: tablaAsociada,
      })
      .then(response => {
        console.log('Acción registrada:', response.data);
      })
      .catch(error => {
        console.error('Error al registrar la acción:', error);
      });
    },
  },
};
</script>
