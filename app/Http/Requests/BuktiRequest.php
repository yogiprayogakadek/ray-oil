<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuktiRequest extends FormRequest
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
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'bukti_pembayaran.required' => 'Bukti pembayaran harus diisi',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa gambar',
            'bukti_pembayaran.max' => 'Bukti pembayaran tidak boleh lebih dari 2MB',
        ];
    }
}

