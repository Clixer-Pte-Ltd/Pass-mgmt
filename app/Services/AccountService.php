<?php
namespace App\Services;

use App\Models\BackpackUser;

class AccountService
{
	private $passHolder;

	public function __construct()
	{
	}

	private function allAirportAccounts()
	{
		return BackpackUser::role(AIRPORT_TEAM_ROLE)->get();
	}

	private function allCompanyAccountsOfPassHolder($passHolder)
	{
		$companyOfPassHolder = $passHolder->company->companyable;
        return isset($companyOfPassHolder) ? $companyOfPassHolder->accounts : collect([]);
	}

	public function getAccountRelatedToPassHolder($passHolder)
	{
		$admins = $this->allAirportAccounts();
		return $admins->merge($this->allCompanyAccountsOfPassHolder($passHolder));
	}

	public function getAccountRelateCompany($company)
    {
        $admins = $this->allAirportAccounts();
        return $admins->merge($company->accounts);
    }
}