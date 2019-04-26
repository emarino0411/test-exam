<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class banUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (session()->has('is_logged') == true)
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason'   => 'string',
        ];
    }
}
