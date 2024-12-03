<template>
    <div>
        <h1>Actualizar Estado de Nota de Venta</h1>
        <form @submit.prevent="submit">
            <div>
                <label>Estado:</label>
                <select v-model="form.estado">
                    <option value="pendiente">Pendiente</option>
                    <option value="pagada">Pagada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>
            <div v-if="form.estado === 'cancelada'">
                <label>Motivo:</label>
                <textarea v-model="form.motivo"></textarea>
            </div>
            <button type="submit">Guardar</button>
        </form>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        id: Number,
    },
    setup(props) {
        const form = useForm({
            estado: '',
            motivo: '',
        });

        const submit = () => {
            form.put(route('notas-venta.estado', props.id));
        };

        return { form, submit };
    },
};
</script>
