<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkdesignUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            //validaciones
            //valores de la entidad
            'user_id'       => 'required|integer',
            'category_id'   => 'required|integer',
            'title'         =>'required',
            'description'   => 'required',
            'excerpt'       =>'required',
            'publishedDate' =>'required',
            'dependency'    =>'required',
            'status'        =>'required|in:Terminado,En proceso',

        ];

        if($this->get('file'))

            $rules = array_merge($rules, ['file' => 'mimes:jpg,jpeg,png']);

        return $rules;
    }
}
