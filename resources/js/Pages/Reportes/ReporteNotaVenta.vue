<template>
    <div>
        <h1>Reportes de Ventas</h1>
        <form @submit.prevent="filtrar">
            <div>
                <label>Fecha Inicio:</label>
                <input type="date" v-model="form.fecha_inicio" />
            </div>
            <div>
                <label>Fecha Fin:</label>
                <input type="date" v-model="form.fecha_fin" />
            </div>
            <button type="submit">Generar Reporte</button>
        </form>

        <div v-if="reporte">
            <h2>Resumen</h2>
            <p>Ventas Totales: {{ reporte.ventas_totales }}</p>
            <p>Productos Vendidos: {{ reporte.productos_vendidos }}</p>
            <p>Métodos de Pago Utilizados:</p>
            <ul>
                <li v-for="(count, metodo) in reporte.metodos_pago" :key="metodo">
                    {{ metodo }}: {{ count }} ventas
                </li>
            </ul>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Monto Total</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="venta in ventas" :key="venta.id">
                    <td>{{ venta.id }}</td>
                    <td>{{ venta.fecha }}</td>
                    <td>{{ venta.monto_total }}</td>
                    <td>{{ venta.metodo_pago.nombre }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        ventas: Array,
        reporte: Object,
    },
    setup() {
        const form = useForm({
            fecha_inicio: '',
            fecha_fin: '',
        });

        const filtrar = () => {
            form.get(route('reportes.index'));
        };

        return { form, filtrar };
    },
};
</script>
