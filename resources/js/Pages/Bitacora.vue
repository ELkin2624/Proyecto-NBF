<template>
  <div class="bitacora-container">
    <h1 class="title">Bitácora de Actividades</h1>

    <!-- Filtros -->
    <div class="filters mb-3">
      <label>Usuario:
        <select v-model="filtros.usuario">
          <option value="">Todos</option>
          <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.name">
            {{ usuario.name }}
          </option>
        </select>
      </label>

      <label>Acción:
        <input type="text" v-model="filtros.accion" placeholder="Buscar acción">
      </label>

      <label>Fecha Inicio:
        <input type="date" v-model="filtros.fechaInicio">
      </label>

      <label>Fecha Fin:
        <input type="date" v-model="filtros.fechaFin">
      </label>

      <button @click="filtrarBitacora">Aplicar Filtros</button>
    </div>

    <!-- Tabla de bitácora -->
    <table id="bitacoraTable" class="bitacora-table table table-striped">
      <thead>
        <tr>
          <th>Acción</th>
          <th>IP Usuario</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Detalles</th>
          <th>Tabla Asociada</th>
          <th>Usuario</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="registro in logsFiltrados" :key="registro.id_bitacora">
          <td>{{ registro.accion }}</td>
          <td>{{ registro.ip_usuario }}</td>
          <td>{{ registro.fecha }}</td>
          <td>{{ registro.hora }}</td>
          <td>{{ registro.detalles }}</td>
          <td>{{ registro.tabla_asociada }}</td>
          <td>{{ registro.usuario ? registro.usuario.name : 'N/A' }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Paginación -->
    <div v-if="bitacora.links" class="pagination">
      <button
        v-for="link in bitacora.links"
        :key="link.label"
        :disabled="!link.url || link.active"
        @click="fetchPage(link.url); registrarAccion('Navegar', 'Página de la bitácora', 'bitacora')"
        v-html="link.label"
        :class="{ active: link.active }"
        class="pagination-button"
      ></button>
    </div>

  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import $ from 'jquery';
import 'datatables.net-bs5';

export default {
  props: {
    bitacora: {
      type: Object,
      required: true,
    },
    usuarios: {
      type: Array,
      default: () => []
    },
  },
  data() {
    return {
      filtros: {
        usuario: '',
        accion: '',
        fechaInicio: '',
        fechaFin: ''
      },
      logsFiltrados: this.bitacora.data,
    };
  },
  methods: {
    fetchPage(url) {
      if (url) Inertia.visit(url);
    },
          filtrarBitacora() {
        this.logsFiltrados = this.bitacora.data.filter(log => {
          const coincideUsuario = !this.filtros.usuario || log.usuario.nombre === this.filtros.usuario;
          const coincideAccion = !this.filtros.accion || log.accion.toLowerCase().includes(this.filtros.accion.toLowerCase());
          const coincideFechaInicio = !this.filtros.fechaInicio || new Date(log.fecha) >= new Date(this.filtros.fechaInicio);
          const coincideFechaFin = !this.filtros.fechaFin || new Date(log.fecha) <= new Date(this.filtros.fechaFin);
          return coincideUsuario && coincideAccion && coincideFechaInicio && coincideFechaFin;
        });

  // Reinicia DataTables para reflejar los cambios
  $('#bitacoraTable').DataTable().clear().rows.add(this.logsFiltrados).draw();
}

  },
  mounted() {
    // Inicializa DataTables al montar el componente
    $('#bitacoraTable').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  },
  watch: {
    bitacora: {
      handler(newVal) {
        this.logsFiltrados = newVal.data;
      },
      deep: true
    }
  }
};
</script>



<style scoped>
/* Contenedor principal */
.bitacora-container {
  padding: 25px;
  background-color: #F8F9FA;
  border-radius: 15px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}


/* Título */
.title {
  font-size: 28px;
  font-weight: bold;
  color: #2B1E66;
  text-align: center;
  margin-bottom: 20px;
}
/* Filtros */
.filters label {
  display: inline-block;
  margin-right: 20px;
  font-size: 16px;
  font-weight: 600;
  color: #333;
  margin-bottom: 10px;
}

.filters select, 
.filters input[type="text"], 
.filters input[type="date"] {
  padding: 12px 20px;
  font-size: 14px;
  border-radius: 8px; 
  border: 1px solid #ccc; /* Borde suave */
  background-color: #f7f7f7; /* Fondo suave */
  transition: border-color 0.3s ease, background-color 0.3s ease;
  width: 250px; /* Ancho más grande */
  margin-bottom: 10px;
}

.filters select:focus, 
.filters input[type="text"]:focus, 
.filters input[type="date"]:focus {
  border-color: #8C85F7; /* Borde azul cuando está en foco */
  background-color: #f2f2f7; /* Fondo más claro cuando está en foco */
  outline: none;
}

.filters button {
  padding: 12px 25px;
  background-color: #8C85F7;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.filters button:hover {
  background-color: #6f56d0;
}


/* Tabla */
.bitacora-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #FFFFFF;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  overflow: hidden;
  margin-top: 20px;
  
}

.bitacora-table th {
  background-color: #8C85F7;
  color: #FFFFFF;
  padding: 12px;
  font-size: 16px;
  font-weight: bold;
  text-align: left;
}

.bitacora-table td {
  padding: 10px;
  font-size: 16px;
  color: #4A4A4A;
  border-bottom: 1px solid #E0E0E0;
}

.bitacora-table tbody tr:hover {
  background-color: rgba(214, 33, 175, 0.2);
}



/* Paginación */
.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
}

.pagination-button {
  background-color: #8C85F7;
  color: #FFFFFF;
  border: none;
  padding: 8px 16px;
  margin: 0 5px;
  border-radius: 5px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.pagination-button:hover {
  background-color: #2B1E66;
}

.pagination-button.active {
  background-color: #FFD700;
  font-weight: bold;
}
</style>