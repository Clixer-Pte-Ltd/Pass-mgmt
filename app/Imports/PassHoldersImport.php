<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Country;
use App\Models\PassHolder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class PassHoldersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
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
            $expireDate = Carbon::createFromFormat('d/m/Y', $row['passexpirydate']);
            if ($expireDate < Carbon::now()) {
                throw new \Exception("Passholder <b>{$row['passholder_name']}</b> has pass expiry date must after now");
            };

            $country = Country::where('name', $row['nationality'])->first();
            if (is_null($country)) {
                throw new \Exception('Country <b>' . @$row['nationality'] . '</b> not found');
            } else {
                $country_id = $country->id;
            }

            $company_uen_in = strtolower($row['company']);
            $company =  Company::whereRaw('lower(name) = ?', [$company_uen_in])->first();
            if (is_null(Company::whereRaw('lower(name) = ?', [$company_uen_in])->first())) {
                throw new \Exception('Company code <b>' . @$company_uen_in . '</b> not found');
            } else {
                $company_uen = $company->uen;
            }
            $zones = explode(',', $row['zone']);
            session()->put(SESS_ZONES, $zones);

            return new PassHolder([
                'applicant_name' => $row['passholder_name'],
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
            'passholder_name' => 'required',
            'pass_number' => "required|unique:pass_holders,nric,{$except}",
            'passexpirydate' => 'required',
            'nationality' => 'required',
            'company' => 'required',
            'as_name' => 'required',
            'as_email' => 'required',
        ];
    }

//    public function sheets(): array
//    {
//        return [
//            // Select by sheet index
//            0 => new PassHoldersImport(),
//        ];
//    }

    public function onError(\Throwable $e)
    {
        dd($e);
    }
}
