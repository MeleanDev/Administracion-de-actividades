<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
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
        return [
            'codigo' => ['required', 'min:3', 'max:255'],
            'Pnombre' => ['required','min:3','max:255','string'],
            'Snombre' => ['required','min:3','max:255','string'],
            'Papellido' => ['required','min:3','max:255','string'],
            'Sapellido' => ['required','min:3','max:255','string'],
            'correo' => ['required','min:3','max:255','email'],
            'telefono' => ['required','min:3','max:255'],
            'departamento_id' => ['required','min:1','max:255'],
            'foto' => [
                'image',
                'required',
                'mimes:jpeg,png',
                'max:12288', 
            ],
        ];
    }
}
