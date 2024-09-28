<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacto';
    protected $fillable = [
        'nombre',
        'notas',
        'fecha_cumpleanios',
        'pagina_web',
        'empresa'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function telefonos(): HasMany
    {
        return $this->hasMany(Telefono::class, 'id_contacto');
    }

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class, 'id_contacto');
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'id_contacto');
    }
}
