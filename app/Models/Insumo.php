<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'stock',
        'requiere_lote',
        'riesgo',
        'vida_util',
        'id_categoria',
        'id_marca',
        'id_presentacion',
    ];

    public function compras()
    {
        return $this->belongsToMany(Compra::class)->withTimestamps()->withPivot('cantidad');
    }

    public function entregas()
    {
        return $this->belongsToMany(Entrega::class)->withTimestamps()->withPivot('cantidad');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function presentacione()
    {
        return $this->belongsTo(Presentacione::class, 'id_presentacion');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

  
    public function caracteristicas()
    {
        return $this->hasMany(InsumoCaracteristica::class);
    }
}
