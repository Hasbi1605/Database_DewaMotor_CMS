<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KendaraanRequest extends FormRequest
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
            'nomor_rangka' => 'required|string|max:255',
            'nomor_mesin' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun_pembuatan' => 'required|integer',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'class_category' => 'nullable|exists:categories,id',
            'brand_category' => 'nullable|exists:categories,id',
            'document_category' => 'nullable|exists:categories,id',
            'condition_category' => 'nullable|exists:categories,id',
            'photos' => 'nullable|array|max:10', // Maksimal 10 foto
            'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048' // Setiap foto maksimal 2MB
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'nomor_rangka' => 'nomor rangka',
            'nomor_mesin' => 'nomor mesin',
            'nomor_polisi' => 'nomor polisi',
            'tahun_pembuatan' => 'tahun pembuatan',
            'harga_modal' => 'harga modal',
            'harga_jual' => 'harga jual',
            'class_category' => 'kategori kelas',
            'brand_category' => 'kategori merek',
            'document_category' => 'kategori dokumen',
            'condition_category' => 'kategori kondisi',
            'photos' => 'foto kendaraan',
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
            'integer' => ':attribute harus berupa angka.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'array' => ':attribute harus berupa array.',
            'image' => ':attribute harus berupa file gambar.',
            'mimes' => ':attribute harus berupa file dengan format: :values.',
            'photos.max' => 'Maksimal :max foto yang dapat diunggah.',
            'photos.*.max' => 'Setiap foto maksimal :max KB.',
        ];
    }
}
