<?php

namespace App\Imports;

use App\Models\BackpackUser;
use App\Models\SubConstructor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SubContructorAccountsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
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
            $id = SubConstructor::where('uen', $uen)->first()->id;
            $user = BackpackUser::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'password' => $password,
                'google2fa_secret' => $google2fa_secret,
                'sub_constructor_id' => $id,
                'is_imported' => true,
            ])->refresh();
            $user->assignRole($row['role']);
            return $user;
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
//            0 => new SubContructorAccountsImport(),
//        ];
//    }

    public function onError(\Throwable $e)
    {
    }
}
