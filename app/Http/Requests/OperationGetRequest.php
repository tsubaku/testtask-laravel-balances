<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OperationGetRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|max:2',
        ];
    }

    /**
     * Create the error JSON response
     *
     * @param Validator $validator
     */

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 400));
    }

    /**
     * Custom error messages
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'search.max' => 'The length of the search phrase should be no more than 200',
        ];
    }

}
