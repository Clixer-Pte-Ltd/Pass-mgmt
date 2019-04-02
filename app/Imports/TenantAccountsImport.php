<?php

namespace App\Imports;

use App\Models\Tenant;
use App\Models\BackpackUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class TenantAccountsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
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
            $password = DEFAULT_PASSWORD;
            $google2fa_secret = app('pragmarx.google2fa')->generateSecretKey();
            $uen = $row['company_code'];
            $id = Tenant::where('uen', $uen)->first()->id;
            return new BackpackUser([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'password' => \Hash::make($password),
                'google2fa_secret' => $google2fa_secret,
                'tenant_id' => $id,
                'is_imported' => true,
            ]);
        } catch (\Exception $ex) {
            $this->error[] = 'Company code <b>' . @$uen . '</b> not found';
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|digits:8',
        ];
    }

//    public function sheets(): array
//    {
//        return [
//            // Select by sheet index
//            0 => new TenantAccountsImport(),
//        ];
//    }

    public function onError(\Throwable $e)
    {

    }

}
