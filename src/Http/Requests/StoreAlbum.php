<?php

namespace Itstructure\MFU\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAlbum
 * @package Itstructure\MFU\Http\Requests
 */
class StoreAlbum extends FormRequest
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
            'title' => 'required|string|regex:/^[\w\s\-\.]+$/|min:3|max:64',
            'description' => 'required|string|regex:/^[\w\s\-\.]+$/|min:3|max:191'
        ];
    }
}
