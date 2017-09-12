<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PropertyType;
use App\Model\PropertySubType;
use App\Model\Currency;
use App\Model\PaymentType;
use App\Model\Company;
use App\Model\Country;
use App\Model\Supplier;
use App\Model\Customer;
use App\Model\ChartOfAccount;
use App\Model\Roles;
use App\Model\Bank;
use App\Model\BankAccount;

use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Sentinel;
use Redirect;
use Carbon\Carbon;
class SettingsController extends Controller
{
    function admin() {
        $propertytypes = PropertyType::all();
        return view('admin_page',[
            'propertytypes' => $propertytypes,
        ]);
    }

    /**
     * Property Types
     */

    function showPropertyTypes(){
    	$propertytypes = PropertyType::all();

    	return view('settings.propertytypes', [
    		'propertytypes' => $propertytypes,
    	]);
    }

    function createPropertyType(Request $request){
    	$propertytype = new PropertyType;
    	$propertytype->propertyDescription = $request->propertyDescription;
    	$propertytype->save();

	    // return 'true';
    }

    function editPropertyType (Request $request){
    	$propertytype = PropertyType::find($request->pk);
        $propertytype->{$request->name} = $request->value;

        $propertytype->save();
        return $propertytype;
    }

    function deletePropertyType ($propertytype){
    	$propertytype = PropertyType::find($propertytype);
    	$propertytype->delete();

	    return 'true';
    }

    /*************************************************************************/


    /**
     * Property Types
     */

    function showPropertySubTypes(){
        $propertysubtypes = PropertySubType::all();
        $propertytypes = PropertyType::all();

        return view('settings.propertysubtypes', [
            'propertysubtypes' => $propertysubtypes,
            'propertytypes' => $propertytypes,
        ]);
    }

    function createPropertySubType(Request $request){
        $propertysubtype = new PropertySubType;
        $propertysubtype->propertySubTypeDescription = $request->propertySubTypeDescription;
        $propertysubtype->propertyTypeID = $request->propertyTypeID;
        $propertysubtype->save();

        return 'true';
    }

    function editPropertySubType (Request $request){
        $propertysubtype = PropertySubType::find($request->pk);
        $propertysubtype->{$request->name} = $request->value;

        $propertysubtype->save();
        return $propertysubtype;
    }

    function deletePropertySubType ($propertysubtype){
        $propertysubtype = PropertySubType::find($propertysubtype);
        $propertysubtype->delete();

        return 'true';
    }

    /*************************************************************************/



    /**
     * Currency
     */
    function showCurrency(){
        $currency = Currency::all();

        return view('settings.currency', [
            'currency' => $currency,
        ]);
    }

    function createCurrency(Request $request){
        $currency = new Currency;
        $currency->currencyCode = $request->currencyCode;
        $currency->save();

        return 'true';
    }

    function editCurrency (Request $request){
        $currency = Currency::find($request->pk);
        $currency->{$request->name} = $request->value;

        $currency->save();
        return $currency;
    }

    function deleteCurrency ($currency){
        $currency = Currency::find($currency);
        $currency->delete();

        return 'true';
    }

    /*************************************************************************/


    /**
     * Payment Type
     */
    function showPaymentType(){
        $paymenttypes = PaymentType::all();

        return view('settings.paymenttypes', [
            'paymenttypes' => $paymenttypes,
        ]);
    }

    function createPaymentType(Request $request){
        $paymenttype = new PaymentType;
        $paymenttype->paymentDescription = $request->paymentDescription;
        $paymenttype->save();

        return 'true';
    }

    function editPaymentType(Request $request){
        $paymenttype = PaymentType::find($request->pk);
        $paymenttype->{$request->name} = $request->value;

        $paymenttype->save();
        return $paymenttype;
    }

    function deletePaymentType($paymenttype){
        $paymenttype = PaymentType::find($paymenttype);
        $paymenttype->delete();

        return 'true';
    }

    /*************************************************************************/


    /**
     * Roles
     */
    function showRoles(){
        $roles = Roles::all();

        return view('settings.roles', [
            'roles' => $roles,
        ]);
    }

    function createRole(Request $request){
        $role = new Roles;
        $role->paymentDescription = $request->paymentDescription;
        $role->save();

        return 'true';
    }

    function editRole(Request $request){
        $role = Roles::find($request->pk);
        $role->{$request->name} = $request->value;

        $role->save();
        return $role;
    }

    function deleteRole($role){
        $role = Roles::find($role);
        $role->delete();

        return 'true';
    }

    /*************************************************************************/



    /**
     * Company
     */
    function editCompany($company){
        $company = Company::find($company);
        $countries = Country::all();

        return view('settings.company', [
            'company' => $company,
            'countries' => $countries,
        ]);
    }

    function updateCompany(Request $request){
        $company = Company::find($request->id);
        
        $company->companyCode = $request->companyCode; 
        $company->companyName = $request->companyName; 
        $company->address = $request->address; 
        $company->city = $request->city; 
        $company->telephoneNumber = $request->telephoneNumber; 
        $company->faxNumber = $request->faxNumber; 
        $company->countryID = $request->countryID; 
        $company->save();
        
        return 'true';
    }

    

    /*************************************************************************/

    /**
     * Supplier
     */
    function showSuppliers(){
        $suppliers = Supplier::all();

        return view('settings.suppliers', [
            'suppliers' => $suppliers,
        ]);
    }

    function createSuppliers(Request $request){
        $supplier = new Supplier;
        $supplier->supplierCode = '0';
        $supplier->supplierName    = $request->supplierName;
        $supplier->address = $request->address;
        $supplier->telephoneNumber = $request->telephoneNumber;
        $supplier->faxNumber   = $request->faxNumber;
        $supplier->timestamp = Carbon::now();

        $supplier->fromPropertyOwnerOrTenant = ($request->fromPropertyOwnerOrTenant) ? $request->fromPropertyOwnerOrTenant : 0 ;
        $supplier->IDFromTenantOrPropertyOwner = ($request->IDFromTenantOrPropertyOwner) ? $request->fromPropertyOwnerOrTenant : 0;
        
        $supplier->save();
        $supplier->supplierCode = sprintf("S%'05d\n", $supplier->supplierID);
        $supplier->save();

        return 'true';
    }

    function editSuppliers(Request $request){
        $supplier = Supplier::find($request->pk);
        $supplier->{$request->name} = $request->value;

        $supplier->save();
        return $supplier;
    }

    function deleteSuppliers($supplier){
        $supplier = Supplier::find($supplier);
        $supplier->delete();

        return 'true';
    }

    /*************************************************************************/

    /**
     * Chart of accounts
     */
    function showChartofaccounts(){
        $chartofaccounts = ChartOfAccount::all();

        return view('settings.chartofaccounts', [
            'chartofaccounts' => $chartofaccounts,
        ]);
    }

    function createChartofaccounts(Request $request){
        $chartofaccount = new ChartOfAccount;
        $chartofaccount->chartOfAccountID = $request->chartOfAccountID;
        $chartofaccount->chartOfAccountCode = 0;
        $chartofaccount->accountDescription = $request->accountDescription;
        $chartofaccount->mainCode = $request->mainCode;
        $chartofaccount->type = $request->type;


        $chartofaccount->save();
        $chartofaccount->chartOfAccountCode = sprintf("GL%'05d\n", $chartofaccount->chartOfAccountID);
        $chartofaccount->save();

        return 'true';
    }

    static function getAccountType($value){
        $typeMap = [
            '1' => 'Expense',
            '2' => 'Income',
            '3' => 'Current Asset',
            '4' => 'Fixed Asset',
            '5' => 'Current Liability',
            '6' => 'Long Term Liability',
            '7' => 'Equity',
            '8' => 'Non-Operating Income',
            '9' => 'Non-Operating Expense',
        ];

        return $typeMap[$value];
    }

    function editChartofaccounts(Request $request){
        $chartofaccount = ChartOfAccount::find($request->pk);
        $chartofaccount->{$request->name} = $request->value;

        $chartofaccount->save();
        return $chartofaccount;
    }

    function deleteChartofaccounts($chartofaccount){
        $chartofaccount = ChartOfAccount::find($chartofaccount);
        $chartofaccount->delete();

        return 'true';
    }

    /*************************************************************************/

    /**
     * Customer
     */
    function showCustomers(){
        $customers = Customer::all();

        return view('settings.customer', [
            'customers' => $customers,
        ]);
    }

    function createCustomer(Request $request){
        $customer = new Customer;
        $customer->customerName    = $request->customerName;
        $customer->address = $request->address;
        $customer->telephoneNumber = $request->telephoneNumber;
        $customer->faxNumber   = $request->faxNumber;
        $customer->timestamp = Carbon::now();
        $customer->createdDate = date('Y-m-d');
        $customer->updatedDate = date('Y-m-d');
        $customer->customerCode = 0;

        $customer->fromPropertyOwnerOrTenant = ($request->fromPropertyOwnerOrTenant) ? $request->fromPropertyOwnerOrTenant : 0 ;
        $customer->IDFromTenantOrPropertyOwner = ($request->IDFromTenantOrPropertyOwner) ? $request->fromPropertyOwnerOrTenant : 0;

        $customer->save();

        $customer->customerCode = sprintf("CUST%'05d\n", $customer->customerID);
        $customer->save();
        return 'true';
    }

    function editCustomer(Request $request){
        $customer = Customer::find($request->pk);
        $customer->updatedDate = date('Y-m-d');
        $customer->{$request->name} = $request->value;

        $customer->save();
        return $customer;
    }

    function deleteCustomer($customer){
        $customer = Customer::find($customer);
        $customer->delete();

        return 'true';
    }

    /*************************************************************************/

    /**
     * Banks
     */
    function showBanks(){
        $banks = Bank::all();

        return view('settings.bank', [
            'banks' => $banks,
        ]);
    }

    function createBank(Request $request){
        $bank = new Bank;
        $bank->bankName = $request->bankName;
        $bank->save();
        return 'true';
    }

    function editBank(Request $request){
        $bank = Bank::find($request->pk);
        $bank->bankName = $request->value;
        $bank->save();
        return $bank;
    }

    function deleteBank($bank){
        $bank = Bank::find($bank);
        $bank->delete();
        return 'true';
    }
    /*************************************************************************/

    /**
     * Bank Account
     */
    function showAccounts(){
        $bankAccounts = BankAccount::all();
        $banks = Bank::all();

        return view('settings.accounts', [
            'bankAccounts' => $bankAccounts,
            'banks' => $banks,
        ]);
    }

    function createAccount(Request $request){
        $bankAccounts = new BankAccount;
        $bankAccounts->accountNumber = $request->accountNumber;
        $bankAccounts->bankmasterID = $request->bankmasterID;
        $bankAccounts->save();
        return 'true';
    }

    function editAccount(Request $request){
        $bankAccounts = BankAccount::find($request->pk);
        $bankAccounts->{$request->name} = $request->value;
        $bankAccounts->save();
        return $bankAccounts;
    }

    function deleteAccount($bankAccounts){
        $bankAccounts = BankAccount::find($bankAccounts);
        $bankAccounts->delete();
        return 'true';
    }



}
 