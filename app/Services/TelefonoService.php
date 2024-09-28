<?php

namespace App\Services;

use App\Models\Contacto;
use App\Models\Telefono;

class TelefonoService
{
    public function updateTelefonos(Contacto $contacto, array $telefonos)
    {
        $telefonosIds = collect($telefonos)->pluck('id')->filter();
        $contacto->telefonos()->whereNotIn('id', $telefonosIds)->delete();
        foreach ($telefonos as $telefono) {
            if (isset($telefono['id'])) {
                Telefono::where('id', $telefono['id'])->update(['numero' => $telefono['numero']]);
            } else {
                $contacto->telefonos()->create(['numero' => $telefono['numero']]);
            }
        }
    }
}
