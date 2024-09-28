<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contacto';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'notas',
        'fecha_cumpleaños',
        'pagina_web',
        'empresa'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get all of the telefonos for the Contactos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function telefonos(): HasMany
    {
        return $this->hasMany(Telefono::class, 'id_contacto');
    }

    /**
     * Get all of the direcciones for the Contacto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class, 'id_contacto');
    }

    /**
     * Get all of the emails for the Contacto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails(): HasMany
    {
        return $this->hasMany(Email::class, 'id_contacto');
    }
}
