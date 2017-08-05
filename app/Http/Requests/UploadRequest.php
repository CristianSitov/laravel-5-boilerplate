<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        $photos = count($this->input('image'));
        foreach(range(0, $photos) as $index) {
            $rules['image.' . $index] = 'image|mimes:jpeg,png|max:6000';
        }

        return $rules;
    }
}
