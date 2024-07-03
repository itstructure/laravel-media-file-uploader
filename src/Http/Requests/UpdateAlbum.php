<?php

namespace Itstructure\MFU\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAlbum
 * @package Itstructure\MFU\Http\Requests
 */
class UpdateAlbum extends FormRequest
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
            'title' => 'required|string|min:3|max:64',
            'description' => 'required|string|min:3|max:2048'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => __('uploader::validation.required'),
            'string' => __('uploader::validation.string'),
            'min' => __('uploader::validation.min'),
            'max' => __('uploader::validation.max'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => __('uploader::main.title'),
            'description' => __('uploader::main.description'),
        ];
    }
}
