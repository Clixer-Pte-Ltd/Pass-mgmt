<?php

namespace App\Imports;

use App\Models\Tenant;
use App\Models\BackpackUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class TenantAccountsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, RegistersEventListeners;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $password = str_random(8);
            $google2fa_secret = app('pragmarx.google2fa')->generateSecretKey();
            $uen = $row['company_uen'];
            $id = Tenant::where('uen', $uen)->first()->id;
            return new BackpackUser([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'password' => $password,
                'google2fa_secret' => $google2fa_secret,
                'tenant_id' => $id
            ]);
        } catch (\Exception $ex) {
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

    public function onError(\Throwable $e)
    {
        dd($e);
    }

    public function onFailure(Failure ...$failures)
    {
        dd($failures);
    }
}
