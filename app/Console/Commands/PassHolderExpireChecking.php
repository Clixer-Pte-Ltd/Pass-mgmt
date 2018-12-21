<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\PassHolder;
use Illuminate\Console\Command;
use App\Events\PassHolderExpired;
use App\Events\PassHolderExpireSoon;

class PassHolderExpireChecking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:pass_holder:checking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking pass holder expiry';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $passHoldersExprireSoon =  $this->getPassHolderExpireSoon();
        // foreach ($passHoldersExprireSoon as $pass) {
        //     event(new PassHolderExpireSoon($pass));
        // }

        $this->handlePassExpired();
    }

    public function getPassHolderExpireSoon()
    {
        return PassHolder::orWhere(function ($query) {
            $query->where('pass_expiry_date', '<=', Carbon::now()->addWeeks(4))
                        ->where('pass_expiry_date', '>', Carbon::now()->addWeeks(4)->subDay());
        })
                    ->orWhere(function ($query) {
                        $query->where('pass_expiry_date', '<=', Carbon::now()->addWeeks(3))
                        ->where('pass_expiry_date', '>', Carbon::now()->addWeeks(3)->subDay());
                    })
                    ->orWhere(function ($query) {
                        $query->where('pass_expiry_date', '<=', Carbon::now()->addWeeks(2))
                        ->where('pass_expiry_date', '>', Carbon::now()->addWeeks(2)->subDay());
                    })
                    ->orWhere(function ($query) {
                        $query->where('pass_expiry_date', '<=', Carbon::now()->addWeeks(1))
                        ->where('pass_expiry_date', '>', Carbon::now()->addWeeks(1)->subDay());
                    })
                    ->get();
    }

    private function getPassHolderExpired()
    {
        return PassHolder::where('status', PASS_STATUS_VALID)->where('pass_expiry_date', '<', Carbon::now());
    }

    private function handlePassExpired()
    {
        $pass_expired_query = $this->getPassHolderExpired();
        $pass_expired = $pass_expired_query->get();
        $pass_expired_query->update(['status' => PASS_STATUS_BLACKLISTED]);
        foreach ($pass_expired as $pass) {
            event(new PassHolderExpired($pass));
        }
    }
}
