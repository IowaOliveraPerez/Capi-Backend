<?php

namespace App\Services;

use App\Models\Contacto;
use App\Models\Direccion;

class DireccionService
{
    public function updateDirecciones(Contacto $contacto, array $direcciones)
    {
        $direccionIds = collect($direcciones)->pluck('id')->filter();
        $contacto->direcciones()->whereNotIn('id', $direccionIds)->delete();
        foreach ($direcciones as $direccion) {
            if (isset($direccion['id'])) {
                Direccion::where('id', $direccion['id'])->update(['direccion' => $direccion['direccion']]);
            } else {
                $contacto->direcciones()->create(['direccion' => $direccion['direccion']]);
            }
        }
    }
}
