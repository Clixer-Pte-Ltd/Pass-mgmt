<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\SubConstructor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SubContructorsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $error;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $tenant_id = Tenant::where('uen', $row['tenant_company_code'])->first()->id;
            return new SubConstructor([
                'name' => $row['name'],
                'uen' => $row['company_code'],
                'tenancy_start_date' => Carbon::createFromFormat(DATE_FORMAT, $row['tenancy_start_date']),
                'tenancy_end_date' => Carbon::createFromFormat(DATE_FORMAT, $row['tenancy_end_date']),
                'tenant_id' => $tenant_id,
            ]);
        } catch (\Exception $ex) {
            if (is_null(Tenant::where('uen', $row['tenant_company_code'])->first())) {
                $this->error[] = 'Tenant Company code <b>' . @$row['tenant_company_code'] . '</b> not found';
            }
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
            'tenant_company_code' => 'required'
        ];
    }

//    public function sheets(): array
//    {
//        return [
//            // Select by sheet index
//            0 => new SubContructorsImport(),
//        ];
//    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }
}
