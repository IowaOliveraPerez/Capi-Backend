<?php

namespace App\Services;

use App\Models\Contacto;
use Illuminate\Support\Facades\Log;

class ContactoService
{
    protected $telefonoService;
    protected $emailService;
    protected $direccionService;

    public function __construct(TelefonoService $telefonoService, EmailService $emailService, DireccionService $direccionService)
    {
        $this->telefonoService = $telefonoService;
        $this->emailService = $emailService;
        $this->direccionService = $direccionService;
    }

    public function getAllContacts($request)
    {
        $perPage = $request->input('page_size', 10);
        $filter = $request->input('filter', '');
        $filterWords = explode(' ', $filter);
        $query = Contacto::with(['telefonos', 'emails', 'direcciones']);
        $query->where(function ($q) use ($filterWords) {
            foreach ($filterWords as $word) {
                $q->where(function ($subquery) use ($word) {
                    $subquery->orWhere('nombre', 'LIKE', '%' . $word . '%')
                        ->orWhere('notas', 'LIKE', '%' . $word . '%')
                        ->orWhere('pagina_web', 'LIKE', '%' . $word . '%')
                        ->orWhere('empresa', 'LIKE', '%' . $word . '%');
                    $subquery->orWhereHas('telefonos', function ($q) use ($word) {
                        $q->where('numero', 'LIKE', '%' . $word . '%');
                    });
                    $subquery->orWhereHas('emails', function ($q) use ($word) {
                        $q->where('email', 'LIKE', '%' . $word . '%');
                    });
                    $subquery->orWhereHas('direcciones', function ($q) use ($word) {
                        $q->where('direccion', 'LIKE', '%' . $word . '%');
                    });
                });
            }
        });
        $contactos = $query->paginate($perPage);

        return [
            'data' => $contactos->items(),
            'total' => $contactos->total(),
            'current_page' => $contactos->currentPage(),
            'last_page' => $contactos->lastPage(),
            'per_page' => $contactos->perPage(),
        ];
    }

    public function createContact(array $data)
    {
        $contacto = Contacto::create([
            'nombre' => $data['nombre'],
            'notas' => $data['notas'],
            'fecha_cumpleanios' => $data['fecha_cumpleanios'],
            'pagina_web' => $data['pagina_web'],
            'empresa' => $data['empresa'],
        ]);

        $this->telefonoService->updateTelefonos($contacto, $data['telefonos'] ?? []);
        $this->emailService->updateEmails($contacto, $data['emails'] ?? []);
        $this->direccionService->updateDirecciones($contacto, $data['direcciones'] ?? []);

        return $contacto;
    }

    public function updateContact(array $data, $id)
    {
        $contacto = Contacto::findOrFail($id);
        $contacto->update([
            'nombre' => $data['nombre'],
            'notas' => $data['notas'],
            'fecha_cumpleanios' => $data['fecha_cumpleanios'],
            'pagina_web' => $data['pagina_web'],
            'empresa' => $data['empresa'],
        ]);

        $this->telefonoService->updateTelefonos($contacto, $data['telefonos'] ?? []);
        $this->emailService->updateEmails($contacto, $data['emails'] ?? []);
        $this->direccionService->updateDirecciones($contacto, $data['direcciones'] ?? []);

        return $contacto;
    }
}
