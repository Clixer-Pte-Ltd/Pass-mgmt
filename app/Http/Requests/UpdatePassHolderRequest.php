<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassHolderRequest extends FormRequest
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
        $except = request()->get('id');
        if (backpack_user()->checkRestrictionPassField()) {
            $nric = "unique:pass_holders,nric,{$except}";
            $pass_expiry_date = "date|after:today";
        } else {
            $nric = "required|unique:pass_holders,nric,{$except}";
            $pass_expiry_date = "required|date|after:today";
        }
        return [
            'applicant_name' => 'required',
            'nric' => $nric,
            'pass_expiry_date' => $pass_expiry_date,
            'country_id' => 'required',
            'as_name' => 'required',
            'as_email' => 'required',
            'zones' => 'required'
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
            'nric' => 'Pass Number',
            'applicant_name' => 'Passholder Name'
        ];
    }
}
