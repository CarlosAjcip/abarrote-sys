<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentacionesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $presentaciones = $this->route('presentaciones');
        $caracteristicaId = $presentaciones->caracteristica->id;

        return [
            'nombre' => 'required|max:60|unique:caracteristicas,nombre,' . $caracteristicaId,
            'descripcion' => 'nullable|max:255'
        ];
    }
}
