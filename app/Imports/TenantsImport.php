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
use Illuminate\Validation\Rule;

class TenantsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $error = [];
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $tenancyStartDate = Carbon::createFromFormat('d/m/Y', $row['tenancy_start_date']);
            $tenancyEndDate = Carbon::createFromFormat('d/m/Y', $row['tenancy_end_date']);
            if ($tenancyEndDate < $tenancyStartDate) {
                throw new \Exception("Tenant <b>{$row['name']}</b> has tenancy end date must after tenancy start date");
            };
            if ($tenancyEndDate < Carbon::now()) {
                throw new \Exception("Tenant <b>{$row['name']}</b> has tenancy end date must after now");
            };
            return new Tenant([
                'name' => $row['name'],
                'uen' => $row['company_code'],
                'tenancy_start_date' => Carbon::createFromFormat(DATE_FORMAT, $row['tenancy_start_date']),
                'tenancy_end_date' => Carbon::createFromFormat(DATE_FORMAT, $row['tenancy_end_date'])
            ]);
        } catch (\Exception $ex) {
            $this->error[] = $ex->getMessage();
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
