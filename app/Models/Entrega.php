<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fecha_hora',
        'numero_comprobante',
        'estado',
        'servicio_id',
        'user_id',
        'comprobante_id',

    ];

    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comprobante(){
        return $this->belongsTo(Comprobante::class);
    }
    
    public function insumos(){
        return $this->belongsToMany(Insumo::class)->withTimestamps()->withPivot('cantidad');
    }
}