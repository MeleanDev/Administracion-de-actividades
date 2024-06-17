<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'foto',
        'codigo',
        'Pnombre',
        'Snombre',
        'Papellido',
        'Sapellido',
        'telefono',
        'correo',
        'departamento_id',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }
}
