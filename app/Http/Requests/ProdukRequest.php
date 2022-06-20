<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProdukRequest extends FormRequest
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
        $rules = [
            'id_kategori' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            // 'stok' => 'required',
        ];

        if (!Request::instance()->has('id')) {
            $rules += [
                'foto' => 'required',
                'foto.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        } else {
            $rules += [
                'foto' => 'nullable',
                'foto.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar',
            'max' => ':attribute tidak boleh lebih dari 2MB',
        ];
    }

    public function attributes()
    {
        return [
            'id_kategori' => 'Kategori',
            'nama' => 'Nama produk',
            'deskripsi' => 'Deskripsi',
            'harga' => 'Harga',
            // 'stok' => 'Stok',
            'foto' => 'Foto',
        ];
    }
}
