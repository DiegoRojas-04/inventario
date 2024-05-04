<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_hora',
        'numero_comprobante',
        'estado',
        'comprobante_id',

    ];


    public function comprobante(){
        return $this->belongsTo(Comprobante::class);
    }

    public function insumos(){
        return $this->belongsToMany(Insumo::class)->withTimestamps()->withPivot('cantidad');

    }
}
