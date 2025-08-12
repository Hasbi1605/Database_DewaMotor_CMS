<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenKendaraanRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'jenis_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'tanggal_expired' => 'nullable|date|after:tanggal_terbit',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string'
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'kendaraan_id' => 'kendaraan',
            'jenis_dokumen' => 'jenis dokumen',
            'nomor_dokumen' => 'nomor dokumen',
            'tanggal_terbit' => 'tanggal terbit',
            'tanggal_expired' => 'tanggal expired',
            'file' => 'file dokumen',
            'keterangan' => 'keterangan',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa teks.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'file' => ':attribute harus berupa file.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'tanggal_expired.after' => 'Tanggal expired harus setelah tanggal terbit.',
            'file.max' => 'File maksimal :max KB.',
        ];
    }
}
