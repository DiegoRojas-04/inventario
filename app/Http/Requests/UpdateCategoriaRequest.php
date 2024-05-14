<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoriaId = $this->route('categoria'); // Obtener el ID de la categoría de la ruta
    
        return [
            'nombre' => [
                'required',
                'max:60',
                Rule::unique('categorias', 'nombre')->ignore($categoriaId),
            ],
            'descripcion' => 'nullable|max:255',
        ];
    }
}
