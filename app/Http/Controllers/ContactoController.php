<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
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

    public function __construct(
        TelefonoService $telefonoService,
        EmailService $emailService,
        DireccionService $direccionService
    ) {
        $this->telefonoService = $telefonoService;
        $this->emailService = $emailService;
        $this->direccionService = $direccionService;
    }

    public function index()
    {
        $contactos = Contacto::with([
            'telefonos',
            'emails',
            'direcciones'
        ])->get();
        return response([
            'data' => $contactos
        ]);
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

        $contacto = Contacto::create([
            'nombre' => $request->nombre,
            'notas' => $request->notas,
            'fecha_cumpleanios' => $request->fecha_cumpleanios,
            'pagina_web' => $request->pagina_web,
            'empresa' => $request->empresa,
        ]);

        $this->telefonoService->updateTelefonos($contacto, $request->telefonos);
        $this->emailService->updateEmails($contacto, $request->emails);
        $this->direccionService->updateDirecciones($contacto, $request->direcciones);

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

        $contacto = Contacto::findOrFail($id);
        $contacto->update($request->only([
            'nombre',
            'notas',
            'fecha_cumpleanios',
            'pagina_web',
            'empresa'
        ]));

        $this->telefonoService->updateTelefonos($contacto, $request->telefonos);
        $this->emailService->updateEmails($contacto, $request->emails);
        $this->direccionService->updateDirecciones($contacto, $request->direcciones);

        return response()->json(['message' => 'Contacto actualizado con éxito', 'data' => $contacto], 200);
    }

    public function destroy($id)
    {
        $contacto = Contacto::findOrFail($id);
        $contacto->delete();

        return response([
            'data' => []
        ], 201);
    }
}
