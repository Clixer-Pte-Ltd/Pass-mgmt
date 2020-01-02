<?php

namespace App\Imports;

use App\Events\AccountImported;
use App\Mail\AccountInfo;
use App\Models\ErrorImport;
use App\Models\Tenant;
use App\Models\BackpackUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class TenantAccountsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    use Importable, SkipsFailures;

    use Importable;

    public $errors = []; // lưu kết quả errors cuối
    public $success = []; // lưu kết quả thành công cuối
    public $data = []; // lưu data import và check validate
    public $dataRow; // lưu data row ban đầu
    public $currentErrors = []; // lưu các lỗi trong quá trình validate
    public $currentData = [];
    public $count = 1;
    public $header = [
        'Row', 'Name', 'Email', 'Phone', 'Company', 'Role', 'Errors'
    ];
    public $nameFile = '';
    public $code;
    public $row = 1;
    public $time;
    public $user;

    public function __construct()
    {
        $lastRecord = ErrorImport::orderBy('id', 'desc')->first();
        $this->code = $lastRecord ? $lastRecord->code + 1 : 1;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->toArray();
            $this->row++;
            $this->dataRow = [$this->row];
            $this->dataRow = array_merge($this->dataRow, array_values($row));
            $this->currentErrors = [];
            $this->currentData = [];

            try {
                $password = uniqid() . str_random(10);
                $google2fa_secret = app('pragmarx.google2fa')->generateSecretKey();
                $tenant = null;
                if (isset($row['company_code'])) $tenant = Tenant::where('uen', $row['company_code'])->first();
                if (isset($row['company_name'])) $tenant = Tenant::where('name', $row['company_name'])->first();
                $this->currentData = [
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'role' => $row['role'],
                    'tenant' => $tenant,
                    'password' => $password,
                    'google2fa_secret' => $google2fa_secret,
                ];
                $this->customValidate();
                if (count($this->currentErrors)) {
                    throw new \Exception('');
                }
                $this->currentData['tenant_id'] = $this->currentData['tenant']->id;
                $this->currentData['is_imported'] = true;
                $this->currentData['first_password'] = $password;

                unset($this->currentData['role']);
                unset($this->currentData['company_code']);
                unset($this->currentData['tenant']);

                $this->user = BackpackUser::create($this->currentData)->refresh();
                $this->user->assignRole($row['role']);

                Mail::to($this->user)->send(new AccountInfo($this->user));
                event(new AccountImported($this->user));
            } catch (\Exception $ex) {
                if ($this->user && $ex instanceof \Swift_TransportException) {
                    $this->user->update([
                        'send_info_email_log' => $ex->getMessage()
                    ]);
                }
                $this->currentErrors[] = $ex->getMessage();
                $this->dataRow[] = implode('; ', $this->currentErrors);
                $this->errors[] = $this->dataRow;
            }
        }
        if (count($this->errors)) {
            ErrorImport::create([
                'time' => $this->time,
                'code' => $this->code,
                'name' => $this->nameFile,
                'header' => json_encode($this->header),
                'errors' => json_encode($this->errors)
            ]);
            $this->errors = [];
        }
    }

    /**
     * @param $role
     * @return string|null
     */
    private function getRole($role)
    {
        if ($role == 'CO') return 'company coordinator';
        if ($role == 'AS') return 'company as';
        if ($role == 'VIEWER') return 'company viewer';
        return null;
    }
    /**
     *
     */
    public function customValidate()
    {
        if (!$this->currentData['tenant']) {
            $this->currentErrors[] = 'Company not found';
        };

        $validator = Validator::make(
            $this->currentData,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'phone' => 'required|digits:8',
                'role' => 'required'
            ],
            );

        if ($validator->fails()) {
            $message = collect($validator->errors()->messages())->map(function ($error, $key) {
                return implode('; ', $error);
            })->implode('; ');

            $this->currentErrors[] = $message;
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|digits:8',
            'role' => 'required'
        ];
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 50;
    }
}
