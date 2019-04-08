<?php

namespace App\Imports;

use App\Events\AccountImported;
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
            $password = uniqid() . str_random(10);
            $google2fa_secret = app('pragmarx.google2fa')->generateSecretKey();
            $uen = $row['company_code'];

            $teCompany = Tenant::where('uen', $uen)->first();
            if (is_null($teCompany)) {
                throw new \Exception( 'Company code <b>' . @$uen . '</b> not found');
            } else {
                $id = $teCompany->id;
            }
            $user = BackpackUser::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'password' => $password,
                'google2fa_secret' => $google2fa_secret,
                'tenant_id' => $id,
                'is_imported' => true,
                'first_password' => $password
            ])->refresh();
            $user->assignRole($row['role']);
            event(new AccountImported($user));
            return $user;
        } catch (\Exception $ex) {
            $this->error[] = $ex->getMessage();
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|digits:8',
            'role' => 'required'
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
