<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:255|min:5',
            'email'=>'required|string|email|unique:contacts,email',
            'contact'=>'required|string|digits:9|numeric',
        ];
    }

    public function messages()
    {
        return [
          'unique'=>'This :attribute has already been registered'
        ];
    }
}
