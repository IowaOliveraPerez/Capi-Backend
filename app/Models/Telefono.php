<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefono extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'telefono';
    protected $fillable = [
        'id_contacto',
        'numero'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class, 'id_contacto');
    }
}
