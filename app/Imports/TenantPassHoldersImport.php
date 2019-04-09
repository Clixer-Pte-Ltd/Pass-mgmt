<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Country;
use App\Models\PassHolder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use App\Models\Company;

class TenantPassHoldersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
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
            $country = Country::where('name', $row['nationality'])->first();
            if (is_null($country)) {
                throw new \Exception('Country <b>' . @$row['nationality'] . '</b> not found');
            } else {
                $country_id = $country->id;
            }

            $company_uen_in = strtolower($row['company']);
            $company = Company::whereRaw('lower(name) = ?', [$company_uen_in])->first();
            if (is_null($company)) {
                throw new \Exception('Company <b>' . @$row['company'] . '</b> not found');
            } else {
                $company_uen = $company->uen;
            }

            $currentCompany = backpack_user()->getCompany();
            $uens = $currentCompany instanceof Collection ? $currentCompany->pluck('uen')->toArray() : [$currentCompany->uen];
            if (!in_array($company_uen, $uens)) {
                throw new \Exception('Not allow import pass holder in company ' . $row['company'] . '<br>');
            }

            $zones = explode(',', $row['zone']);
            session()->put(SESS_ZONES, $zones);

            return new PassHolder([
                'applicant_name' => $row['applicant_name'],
                'nric' => $row['pass_number'],
                'pass_expiry_date' => Carbon::createFromFormat(DATE_FORMAT, $row['passexpirydate']),
                'country_id' => $country_id,
                'company_uen' => $company_uen,
                'ru_name' => $row['ru_name'],
                'ru_email' => $row['ru_email'],
                'as_name' => $row['as_name'],
                'as_email' => $row['as_email']
            ]);
        } catch (\Exception $ex) {
            $this->error[] = $ex->getMessage();
            return null;
        }
    }

    public function rules(): array
    {
        $except = request()->get('pass_number');
        return [
            'applicant_name' => 'required',
            'pass_number' => "required|unique:pass_holders,nric,{$except}",
            'passexpirydate' => 'required|after:today',
            'nationality' => 'required',
            'ru_name' => 'required',
            'ru_email' => 'required',
            'as_name' => 'required',
            'as_email' => 'required',
        ];
    }
//
//    public function sheets(): array
//    {
//        return [
//            // Select by sheet index
//            0 => new TenantPassHoldersImport(),
//        ];
//    }

    public function onError(\Throwable $e)
    {
    }
}
