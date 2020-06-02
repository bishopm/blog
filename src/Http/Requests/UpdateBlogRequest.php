<?php

namespace Bishopm\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'status' => 'required',
            'summary' => 'required',
            'slug' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
        ];
    }
}
