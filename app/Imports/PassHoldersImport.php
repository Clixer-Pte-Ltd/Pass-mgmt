<?php

namespace App\Imports;

use App\Events\PassHolderCreated;
use App\Models\ErrorImport;
use App\Models\PassHolder;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class PassHoldersImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    use Importable;

    public $errors = []; // lưu kết quả errors cuối
    public $success = []; // lưu kết quả thành công cuối
    public $dataSql = []; // lưu data import và check validate
    public $data = []; // lưu data import và check validate
    public $dataRow; // lưu data row ban đầu
    public $currentErrors = []; // lưu các lỗi trong quá trình validate
    public $currentData = [];
    public $count = 1;
    public $header = [
        'Row', 'Passholder Name', 'Pass Number', 'PassExpirydate', 'Nationality', 'Company', 'RU Name', 'RU Email', 'AS Name',
        'AS Email', 'Zone', 'Errors'
    ];
    public $nameFile = '';
    public $code;
    public $row = 1;
    public $time;

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
            try {
                $country = Country::where('name', $row['nationality'])->first();
                $company_uen_in = strtolower($row['company']);
                $company = Company::whereRaw('lower(name) = ?', [$company_uen_in])->first();
                $zones = explode(',', $row['zone']);
                $passExpiryDate = $row['passexpirydate'] ? Carbon::createFromFormat('m/d/Y', $row['passexpirydate']) : $row['passexpirydate'];

                $this->currentData = [
                    'applicant_name' => $row['passholder_name'],
                    'pass_number' => $row['pass_number'],
                    'pass_expiry_date' => $passExpiryDate,
                    'country' => $country,
                    'company' => $company,
                    'ru_name' => $row['ru_name'],
                    'ru_email' => $row['ru_email'],
                    'as_name' => $row['as_name'],
                    'as_email' => $row['as_email']
                ];
                $this->customValidate();
                if (count($this->currentErrors)) {
                    throw new \Exception('Error validate');
                }
                $this->currentData['pass_expiry_date'] = $this->currentData['pass_expiry_date']->format('Y-m-d') . " 00:00:00";
                $this->currentData['country_id'] = $this->currentData['country']->id;
                $this->currentData['company_uen'] = $this->currentData['company']->uen;
                $this->currentData['nric'] = $this->currentData['pass_number'];
                unset($this->currentData['country']);
                unset($this->currentData['company']);
                unset($this->currentData['pass_number']);
                foreach ($this->currentData as $key => $value) {
                    $this->currentData[$key] = addslashes($value);
                }
                $this->currentData['zones'] = $zones;
                $this->data[] = $this->currentData;
                $this->dataSql[] = "(
                '{$this->currentData['applicant_name']}','{$this->currentData['nric']}',
                '{$this->currentData['pass_expiry_date']}',{$this->currentData['country_id']},
                '{$this->currentData['company_uen']}','{$this->currentData['ru_name']}',
                '{$this->currentData['ru_email']}','{$this->currentData['as_name']}',
                '{$this->currentData['as_email']}')";
            } catch (\Exception $ex) {
                dump($ex->getMessage());
                $this->dataRow[] = implode('; ', $this->currentErrors);
                $this->errors[] = $this->dataRow;
            }
        }
        if (count($this->dataSql)) {
            $sql = trim(preg_replace(
                '/\s\s+/',
                ' ',
                "INSERT INTO pass_holders 
                        (`applicant_name`, `nric`, `pass_expiry_date`,`country_id`, `company_uen`,`ru_name`, `ru_email`, `as_name`, `as_email`) 
                        VALUES " . implode(',', $this->dataSql) . ";"));
            \DB::insert($sql);
            foreach ($this->data as $data) {
                event(new PassHolderCreated(PassHolder::where('nric', $data['nric'])->first(), $data['zones']));
            }
            $this->data = [];
            $this->dataSql = [];
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

    public function customValidate()
    {
        if (!$this->currentData['pass_expiry_date'] || $this->currentData['pass_expiry_date'] < Carbon::now()) {
            $this->currentErrors[] = 'Passholder ' . $this->currentData['passholder_name']. 'has pass expiry date must after now';
        };

        if (!$this->currentData['country']) {
            $this->currentErrors[] = 'Country ' . @$this->currentData['nationality'] . ' not found';
        }

        if (!$this->currentData['company']) {
            $this->currentErrors[] = 'Company code ' . @$this->currentData['nationality'] . ' not found';
        }

        $validator = Validator::make(
            $this->currentData,
            [
                'applicant_name' => 'required',
                'pass_number' => "required|unique:pass_holders,nric,{$this->currentData['pass_number']}",
                'as_name' => 'required',
                'as_email' => 'required',
            ],
        );

        if ($validator->fails()) {
            $message = collect($validator->errors()->messages())->map(function ($error, $key) {
                return implode('; ', $error);
            })->implode('; ');

            $this->currentErrors[] = $message;
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
