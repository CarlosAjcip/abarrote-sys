<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
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
        // dd($this->all());
        return [
            'proveedore_id' => 'required|exists:proveedores,id',
            'comprobantes_id' => 'required|exists:comprobantes,id',
            'numero_comprobante' => 'required|unique:compras,numero_comprobante|max:255',
            'impuesto' => 'required',
            'fecha_hora' => 'required',
            'total' => 'required'
        ];
    }
}
