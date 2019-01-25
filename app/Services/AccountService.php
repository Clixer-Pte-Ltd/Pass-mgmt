<?php
namespace App\Services;

use App\Models\BackpackUser;
use Illuminate\Support\Collection;

class AccountService
{
	private $passHolder;

	public function __construct()
	{
	}

	public function allAirportAccounts()
	{
		return BackpackUser::role(CAG_ADMIN_ROLE)->get();
	}

	private function allCompanyAccountsOfPassHolder($passHolder)
	{
	    if (isset($passHolder->company)) {
            $companyOfPassHolder = $passHolder->company->companyable;
            return isset($companyOfPassHolder) ? $companyOfPassHolder->accounts : collect([]);
        }
        return collect([]);
    }

	public function getAccountRelatedToPassHolder($passHolders)
	{
        if (!($passHolders instanceof Collection)) {
            $passHolders = collect()->push($passHolders);
        }
        $admins = $this->allAirportAccounts();
        foreach ($passHolders as $passHolder) {
            $this->allCompanyAccountsOfPassHolder($passHolder)->map(function($ad, $index) use ($admins) {
                $admins->push($ad);
            });
        }
        return $admins;
	}

	public function getAccountRelateCompany($companies, $hasAirportPassTeam = true, $hasAdminCompany = true)
    {
        if (!($companies instanceof Collection)) {
            $companies = collect()->push($companies);
        }
        $admins = collect();
        if ($hasAdminCompany) {
            foreach ($companies as $company) {
                if (isset($company->accounts)) {
                    $company->accounts->map(function($ad, $index) use ($admins) {
                        $admins->push($ad);
                    });
                }
            }
        }
        if ($hasAirportPassTeam) {
            foreach ($this->allAirportAccounts() as $adAirport) {
                $admins->push($adAirport);
            }
        }
        return $admins;
    }
}