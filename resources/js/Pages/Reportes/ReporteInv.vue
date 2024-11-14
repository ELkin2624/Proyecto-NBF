<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Reporte de Inventario</h1>

        <!-- Botón para descargar el reporte en PDF -->
        <div class="text-center mb-6">
            <button @click="downloadPDF" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-lg hover:bg-blue-600">
                Descargar Reporte en PDF
            </button>
        </div>

        <!-- Tabla responsive para mostrar los datos de inventario -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="py-3 px-4 border-b text-left">Producto</th>
                        <th class="py-3 px-4 border-b text-left">Ubicación</th>
                        <th class="py-3 px-4 border-b text-left">Cantidad</th>
                        <th class="py-3 px-4 border-b text-left">Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in inventario" :key="item.producto" class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ item.producto }}</td>
                        <td class="py-2 px-4 border-b">{{ item.ubicacion }}</td>
                        <td class="py-2 px-4 border-b">{{ item.cantidad }}</td>
                        <td class="py-2 px-4 border-b">{{ item.precio_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Gráfico responsive de rendimiento de inventario -->
        <div class="chart-container mt-6">
            <canvas ref="chartCanvas" class="w-full"></canvas>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Chart, registerables } from 'chart.js'
import jsPDF from 'jspdf'
import 'jspdf-autotable'

// Registrar todos los componentes de Chart.js
Chart.register(...registerables)

export default {
    setup() {
        const inventario = ref([])
        const chartCanvas = ref(null)

        onMounted(async () => {
            try {
                const response = await axios.get('/api/reportes/inventario')
                inventario.value = response.data

                // Preparamos los datos para el gráfico
                const labels = inventario.value.map(item => item.producto)
                const data = inventario.value.map(item => item.cantidad)

                // Crear gráfico de barras con chart.js
                new Chart(chartCanvas.value, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Cantidad de Productos',
                                backgroundColor: '#42A5F5',
                                borderColor: '#1E88E5',
                                borderWidth: 2,
                                data: data
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 14,
                                        weight: 'bold',
                                    },
                                    color: '#333',
                                }
                            },
                            tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#333',
                                bodyColor: '#666',
                                borderColor: '#ddd',
                                borderWidth: 1,
                                padding: 10,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#333',
                                },
                                grid: {
                                    color: '#ddd',
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#333',
                                },
                                grid: {
                                    color: '#ddd',
                                }
                            }
                        }
                    }
                })
            } catch (error) {
                console.error('Error al cargar el inventario:', error)
            }
        })

        // Función para descargar el reporte en PDF
        const downloadPDF = () => {
            const doc = new jsPDF()

            // Agregar logo al encabezado
            doc.addImage("/images/logo.jpg", "JPEG", 14, 10, 30, 30);

            // Título del reporte
            doc.setFontSize(16)
            doc.text('Reporte de Inventario', 20, 20)

            const fecha = new Date();
            const fechaFormateada = `${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()}`;
            doc.setFontSize(12);
            doc.text("Fecha del Reporte: " + fechaFormateada, 14, 30);

            // Tabla de inventarios
            doc.setFontSize(14);
            doc.text("Inventario de Productos", 14, 40);
            doc.autoTable({
                head: [["Producto","Ubicacion", "Cantidad", "Precio"]],
                body: inventario.value.map(item => [item.producto, item.ubicacion, item.cantidad, item.precio_total]),
                startY: 50,
                theme: "grid",
                headStyles: {
                    fillColor: [52, 152, 219],
                    textColor: [255, 255, 255],
                    fontSize: 12,
                },
                bodyStyles: {
                    fontSize: 10,
                },
                columnStyles: {
                    0: { halign: "left" },
                    1: { halign: "center" },
                },
            });

            // Pie de página
            doc.setFontSize(10);
            doc.text("Página " + doc.internal.getNumberOfPages(), 180, 280);

            // Añadir el gráfico al PDF
            doc.addPage()
            doc.setFontSize(16)
            doc.text('Gráfico de Inventario', 20, 20)

            const chartImage = chartCanvas.value.toDataURL('image/png')
            doc.addImage(chartImage, 'PNG', 20, 30, 180, 120)

            // Descargar el PDF
            doc.save('reporte-inventario.pdf')
        }

        return {
            inventario,
            chartCanvas,
            downloadPDF
        }
    }
}
</script>

<style scoped>
/* Estilos opcionales para mejorar la apariencia de la tabla */
table {
    width: 100%;
    border-collapse: collapse;
}

/* Estilos para la tabla */
.table-header {
    background-color: #4A5568; /* Color de fondo */
}

th, td {
    text-align: left;
    padding: 12px 16px;
}

/* Estilos para la tabla */
.hover\:bg-gray-100:hover {
    background-color: #F7FAFC; /* Color al pasar el mouse */
}

/* Estilo para el gráfico */
.chart-container {
    height: 400px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #fff; /* Fondo blanco para el gráfico */
    margin-top: 20px;
}

/* Asegura que el gráfico se ajuste a pantallas pequeñas */
@media (max-width: 768px) {
    .chart-container {
        height: 300px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px 12px;
    }
}

/* Adaptar el diseño de la tabla para pantallas pequeñas */
@media (max-width: 640px) {
    .table-header {
        font-size: 12px;
    }
    th, td {
        padding: 8px;
    }
}
</style>

