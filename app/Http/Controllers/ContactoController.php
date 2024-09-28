<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Services\ContactoService;
use App\Services\DireccionService;
use App\Services\EmailService;
use App\Services\TelefonoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{
    protected $telefonoService;
    protected $emailService;
    protected $direccionService;
    protected $contactoService;

    public function __construct(
        TelefonoService $telefonoService,
        EmailService $emailService,
        DireccionService $direccionService,
        ContactoService $contactoService
    ) {
        $this->telefonoService = $telefonoService;
        $this->emailService = $emailService;
        $this->direccionService = $direccionService;
        $this->contactoService = $contactoService;
    }

    public function index(Request $request)
    {
        $contactos = $this->contactoService->getAllContacts($request);
        return response($contactos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'notas' => 'nullable|string|max:255',
            'fecha_cumpleanios' => 'nullable|date:Y-m-d',
            'pagina_web' => 'nullable|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'telefonos' => 'nullable|array',
            'telefonos.*.id' => 'nullable|integer|exists:telefono,id',
            'telefonos.*.numero' => 'required|string|max:20',
            'emails' => 'nullable|array',
            'emails.*.id' => 'nullable|integer|exists:email,id',
            'emails.*.email' => 'required|string|email|max:255',
            'direcciones' => 'nullable|array',
            'direcciones.*.id' => 'nullable|integer|exists:direccion,id',
            'direcciones.*.direccion' => 'required|string|max:255'
        ]);
        $contacto = $this->contactoService->createContact($request->all());
        return response([
            'data' => $contacto->load(['telefonos', 'emails', 'direcciones'])
        ]);
    }

    public function show($id)
    {
        $contacto = Contacto::with([
            'telefonos',
            'emails',
            'direcciones'
        ])->findOrFail($id);
        return response([
            'data' => $contacto
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'notas' => 'nullable|string|max:255',
            'fecha_cumpleanios' => 'nullable|date:Y-m-d',
            'pagina_web' => 'nullable|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'telefonos' => 'nullable|array',
            'telefonos.*.id' => 'nullable|integer|exists:telefono,id',
            'telefonos.*.numero' => 'required|string|max:20',
            'emails' => 'nullable|array',
            'emails.*.id' => 'nullable|integer|exists:email,id',
            'emails.*.email' => 'required|string|email|max:255',
            'direcciones' => 'nullable|array',
            'direcciones.*.id' => 'nullable|integer|exists:direccion,id',
            'direcciones.*.direccion' => 'required|string|max:255'
        ]);

        $contacto = $this->contactoService->updateContact($request->all(), $id);

        return response([
            'message' => 'Contacto actualizado con éxito',
            'data' => $contacto->load(['telefonos', 'emails', 'direcciones'])
        ]);
    }

    public function destroy($id)
    {
        $this->contactoService->destroyContact($id);
        return response([
            'data' => []
        ], 201);
    }
}
