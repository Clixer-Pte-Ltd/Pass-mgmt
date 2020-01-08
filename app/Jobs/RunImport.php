<?php

namespace App\Jobs;

use App\Models\ErrorImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class RunImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $import;
    public $file;
    public $timeout = 7200;
    public $server;

    /**
     * Create a new job instance.
     *
     * @param $import
     * @param $file
     */
    public function __construct($import, $file)
    {
        $this->import = $import;
        $this->file = $file;
        $this->server = config('app.server_type');
    }

    /**
     * Execute the job.
     *
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        sleep(5);
        if ($this->server == config('app.server_type')) {
            $timeCount = strtotime('now');
            while (getSettingValueByKey(ALLOW_RUN_JOB) == 0) {
                if ((strtotime('now') - $timeCount) >= 10) {
                    throw new \Exception('Not allow timeout');
                    return false;
                }
                dump('Not Allow');
            }
            updateSetting(ALLOW_RUN_JOB, 0);
            try {
                Excel::import($this->import, $this->file);
                Storage::delete($this->file);
            } catch (\Exception $e) {
                logger([$e->getLine() => $e->getMessage()]);
            }
        }
        updateSetting(ALLOW_RUN_JOB, 1);
    }
}
