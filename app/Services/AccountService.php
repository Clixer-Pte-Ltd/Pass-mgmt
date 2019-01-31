<?php
namespace App\Services;

use App\Models\BackpackUser;
use Illuminate\Support\Collection;
use App\Models\Tenant;

class AccountService
{
	private $passHolder;

	public function __construct()
	{
	}

    //get all account has roles
    public function getAccountsHasRoles($roles = [])
    {
        return BackpackUser::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        });
    }

	//get all CAG admin
	public function allAirportAccounts()
	{
	    return $this->getAccountsHasRoles(config('backpack.cag.roles'))->get();
	}

	//get all company admin has roles
    public function allCompanyAccountHasRoles($tenant = true, $subConstructor = false, $roles = [COMPANY_CO_ROLE], $company = null)
    {
        $query = BackpackUser::query();
        if ($tenant && !$subConstructor) {
            $query =  $this->getAccountsHasRoles($roles)->whereNotNull('tenant_id');
        }

        if (!$tenant && $subConstructor) {
            $query = $this->getAccountsHasRoles($roles)->whereNotNull('sub_constructor_id');
        }

        if ($tenant && $subConstructor) {
            $query = $this->getAccountsHasRoles($roles);
        }

        if (!is_null($company)) {
            $companyColumn = $company instanceof Tenant ? 'tenant_id' : 'sub_constructor_id';
            $query->where($companyColumn, $company->id);
        }
        return $query->get();
    }

//    //get company account has role relate pass holder
//    public function getCompanyAccountRelatedToPassHolder($passHolder = null, $roles = [])
//    {
//        if (!is_null($passHolder) && !is_null($passHolder->company)) {
//
//            $companyId = $passHolder->company->companyable->id;
//            $companyColumn = $passHolder->company->companyable instanceof Tenant ? 'tenant_id' : 'sub_constructor_id';
//
//            return $this->getAccountsHasRoles($roles)->where($companyColumn, $companyId)->get();
//        }
//        return collect([]);
//    }

//    //get all account has role relate passholder
//    public function getAccountRelatedToPassHolder($passHolder = null, $cagAdmin = false, $cagStaff = false, $cagWiewer = false,
//                                                $companyCo = false, $companyAs = false, $companyViewer = false)
//    {
//        $admins = collect([]);
//        if (!is_null($passHolder)) {
//            $adminsCagRoles = collect([$cagAdmin, $cagStaff, $cagWiewer])->filter(function ($role, $key) {
//                return $role;
//            });
//            $adminsCompanyRoles = collect([$companyCo, $companyAs, $companyViewer])->filter(function ($role, $key) {
//                return $role;
//            });
//
//            if ($adminsCagRoles->count()) {
//                $admins = linkCollection($admins, $this->getAccountsHasRoles($adminsCagRoles->toArray())->get());
//            }
//            if ($adminsCompanyRoles->count()) {
//                $admins = linkCollection($admins, $this->getCompanyAccountRelatedToPassHolder($passHolder, $adminsCompanyRoles->toArray()));
//            }
//        }
//        return $admins;
//    }

    //get all account of company contants passholder
	private function allCompanyAccountsOfPassHolder($passHolder)
	{
	    if (isset($passHolder->company)) {
            $companyOfPassHolder = $passHolder->company->companyable;
            return isset($companyOfPassHolder) ? $companyOfPassHolder->accounts : collect([]);
        }
        return collect([]);
    }

    //get all account (cag + admin) relate pass holder
	public function getAllAccountRelatedToPassHolder($passHolders)
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

	//get all account relate company
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