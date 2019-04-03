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
        if (backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]) &&  \Route::current()->getName() == "crud.tenant-pass-holder.update") {
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
            'ru_name' => 'required',
            'ru_email' => 'required',
            'as_name' => 'required',
            'as_email' => 'required',
        ];
    }
}
