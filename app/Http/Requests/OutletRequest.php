<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutletRequest extends FormRequest
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
            'nama' => 'required|min:2|max:100',
            'alamat' => 'required',
            'tlp' => 'required|min:6|max:15',
        ];
    }

    public function messages()
    {
        return[
            'nama.required' => 'Nama Harus di isi',
            'nama.min' => 'Nama Minimal 2 karakter',
            'nama.max' => 'Nama Maksimal 2 karakter',
            'alamat.required' => 'Alamat Harus di isi',
            'tlp.required' => 'No. Telepon Harus di Isi',
            'tlp.min' => 'No. Telepon Tidak Valid',
            'tlp.max' => 'No. Telepon Tidak Valid'
        ];
    }
}
