<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AlertaReabastecimiento;
use Carbon\Carbon;

class GenerarAlertas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:generar-alertas';
    protected $signature = 'alertas:generar';
    protected $description = 'Generar alertas de reabastecimiento de inventario y vencimiento de contratos.';

    public function handle()
    {
        // Alertas de reabastecimiento
        $productos = Producto::where('cantidad', '<', 'cantidad_minima')->get();

        foreach ($productos as $producto) {
            Notification::send($producto->proveedor, new AlertaReabastecimiento($producto));
            $this->info("Alerta de reabastecimiento enviada para el producto: {$producto->nombre}");
        }

        // Alertas de vencimiento de contratos
        $proveedores = Proveedor::whereDate('fecha_vencimiento_contrato', '<=', Carbon::now()->addDays(7))->get();

        foreach ($proveedores as $proveedor) {
            Notification::send($proveedor, new AlertaReabastecimiento($proveedor));
            $this->info("Alerta de vencimiento de contrato enviada al proveedor: {$proveedor->nombre}");
        }

        $this->info('Proceso de generación de alertas completado.');
    }
}
