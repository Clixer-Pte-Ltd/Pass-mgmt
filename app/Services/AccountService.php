<?php
namespace App\Services;

use App\Models\BackpackUser;
use App\Models\PassHolder;

class AccountService
{
	private $passHolder;

	public function __construct(PassHolder $passHolder)
	{
		$this->passHolder = $passHolder;
	}

	private function allAirportAccounts() 
	{
		return BackpackUser::role(AIRPORT_TEAM_ROLE)->get();
	}

	private function allCompanyAccountsOfPassHolder() 
	{
		$companyOfPassHolder = $this->passHolder->company->companyable;
        return isset($companyOfPassHolder) ? $companyOfPassHolder->accounts : collect([]);
	}

	public function getAccountRelatedToPassHolder()
	{
		$admins = $this->allAirportAccounts();
		return $admins->merge($this->allCompanyAccountsOfPassHolder());
	}
}