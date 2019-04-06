<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantRequest extends FormRequest
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
        $uen = $tenancy_start_date = $tenancy_end_date = '';
        if (!backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE])) {
            $uen =  "required|unique:tenants,uen,{$except}|unique:sub_constructors,uen";
            $tenancy_start_date = 'required|date';
            $tenancy_end_date = 'required|date|after:today|after:tenancy_start_date';
        }
        return [
            'name' => 'required',
            'uen' => $uen,
            'tenancy_start_date' => $tenancy_start_date,
            'tenancy_end_date' => $tenancy_end_date,
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
