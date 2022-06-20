<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendaftaranRequest extends FormRequest
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
        $rules =  [
            'nama' => 'required|string|max:50|min:3',
            'tempat_lahir' => 'required|string|max:50|min:3',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'alamat' => 'required|string|max:50',
            'telp' => 'required|regex:/^[0-9]{12}$/',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required',
            'password' => 'required|min:8|same:password_confirmation',
            'password_confirmation' => 'required|min:8|same:password',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
            'unique' => ':attribute sudah digunakan',
            'mimes' => ':attribute harus berupa file :values',
            'image' => ':attribute harus berupa file gambar',
            'same' => ':attribute tidak sama dengan :other',
            'date' => ':attribute harus berupa tanggal',
            'numeric' => ':attribute harus berupa angka',
            'regex' => ':attribute panjang 12 karakter',
        ];
    }

    public function attributes()
    {
        return [
            'nama' => 'nama',
            'tempat_lahir' => 'Tempat lahir',
            'tanggal_lahir' => 'Tanggal lahir',
            'alamat' => 'Alamat',
            'jenis_kelamin' => 'Jenis kelamin',
            'no_hp' => 'No HP',
            'foto' => 'Foto',
            'email' => 'email',
            'password' => 'Password',
            'password_confirmation' => 'Konfirmasi Password',
        ];
    }
}
