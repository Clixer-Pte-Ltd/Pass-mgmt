<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassHolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'applicant_name' => 'required',
            'nric' => 'required',
            'pass_expiry_date' => 'required|date',
            'country_id' => 'required',
            'company_uen' => 'required',
            'ru_name' => 'required',
            'ru_email' => 'required|email',
            'as_name' => 'required',
            'as_email' => 'required|email',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
