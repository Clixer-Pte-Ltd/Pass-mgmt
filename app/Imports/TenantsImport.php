<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Tenant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class TenantsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            return new Tenant([
                'name' => $row['name'],
                'uen' => $row['company_code'],
                'tenancy_start_date' => Carbon::createFromFormat(DATE_FORMAT, $row['tenancy_start_date']),
                'tenancy_end_date' => Carbon::createFromFormat(DATE_FORMAT, $row['tenancy_end_date'])
            ]);
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'company_code' => 'required|unique:tenants,uen|unique:sub_constructors,uen',
            'tenancy_start_date' => 'required',
            'tenancy_end_date' => 'required',
        ];
    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

}
