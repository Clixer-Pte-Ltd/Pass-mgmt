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
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubContructorAccountsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, WithMultipleSheets
{
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
            $uen = $row['company_uen'];
            $id = SubConstructor::where('uen', $uen)->first()->id;
            return new BackpackUser([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'password' => \Hash::make($password),
                'google2fa_secret' => $google2fa_secret,
                'sub_constructor_id' => $id,
                'is_imported' => true,
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

    public function sheets(): array
    {
        return [
            // Select by sheet index
            0 => new SubContructorAccountsImport(),
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
