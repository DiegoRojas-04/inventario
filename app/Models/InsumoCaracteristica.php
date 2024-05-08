<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumoCaracteristica extends Model
{
    use HasFactory;

    protected $fillable = [
        'insumo_id',
        'invima',
        'lote',
        'vencimiento',
        'cantidad',
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }
}
