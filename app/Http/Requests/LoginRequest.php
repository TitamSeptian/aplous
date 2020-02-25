<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'uname'=>'required',
            'pwd'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'uname.required'=>'Username Tidak Boleh Kosong !',
            'pwd.required'=>'Password Tidak Boleh Kosong !'
        ];
    }
}
