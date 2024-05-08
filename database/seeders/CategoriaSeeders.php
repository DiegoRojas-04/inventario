<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::insert([
            [ 'nombre' => 'Categoria1'],
            [ 'nombre' => 'Categoria2'],
            [ 'nombre' => 'Categoria3']
        ]);
    }
}
