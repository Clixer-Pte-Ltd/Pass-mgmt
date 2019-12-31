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
     * @return void
     */
    public function __construct($import, $file)
    {
        $this->import = $import;
        $this->file = $file;
        $this->server = env('SERVER_TYPE');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->server == env('SERVER_TYPE')) {
            try {
                Excel::import($this->import, $this->file);
                Storage::delete($this->file);
            } catch (\Exception $e) {
//            dump([$e->getLine() => $e->getMessage()]);
                logger([$e->getLine() => $e->getMessage()]);
            }
        }
    }
}
