<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    public function cliente(){
        return $this->belongsTo(Servicio::class);
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
