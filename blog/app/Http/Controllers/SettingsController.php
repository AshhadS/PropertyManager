<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PropertyType;
use App\Model\PropertySubType;
use App\Model\Currency;
use App\Model\PaymentType;

use Datatables;
use Illuminate\Support\Facades\DB;
use Debugbar;
use Sentinel;
use Redirect;
class SettingsController extends Controller
{
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

	    return Redirect::to('admin');
    }

    function editPropertyType (Request $request){
    	$propertytype = PropertyType::find($request->propertyTypeID);
    	$propertytype->propertyDescription = $request->$propertyDescription;
    	$propertytype->save();

	    return Redirect::to('admin');
    }

    function deletePropertyType ($propertytype){
    	$propertytype = PropertyType::find($propertytype);
    	$propertytype->delete();

	    return Redirect::to('admin');
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
        $propertysubtype->propertyTypeID = $request->propertySubTypeDescription;
        $propertysubtype->save();

        return Redirect::to('admin');
    }

    function editPropertySubType (Request $request){
        $propertysubtype = PropertySubType::find($request->propertyTypeID);
        $propertysubtype->propertySubTypeDescription = $request->$propertySubTypeDescription;
        $propertysubtype->propertyTypeID = $request->$propertyTypeID;
        $propertysubtype->save();

        return Redirect::to('admin');
    }

    function deletePropertySubType ($propertysubtype){
        $propertysubtype = PropertySubType::find($propertysubtype);
        $propertysubtype->delete();

        return Redirect::to('admin');
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

        return Redirect::to('admin');
    }

    function editCurrency (Request $request){
        $currency = Currency::find($request->currencyID);
        $currency->currencyCode = $request->$currencyCode;
        $currency->save();

        return Redirect::to('admin');
    }

    function deleteCurrency ($currency){
        $currency = Currency::find($currency);
        $currency->delete();

        return Redirect::to('admin');
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

        return Redirect::to('admin');
    }

    function editPaymentType(Request $request){
        $paymenttype = PaymentType::find($request->paymenTypeID);
        $paymenttype->paymentDescription = $request->$paymentDescription;
        $paymenttype->save();

        return Redirect::to('admin');
    }

    function deletePaymentType($paymenttype){
        $paymenttype = PaymentType::find($paymenttype);
        $paymenttype->delete();

        return Redirect::to('admin');
    }

    /*************************************************************************/


    /**
     * Roles
     */
    function showRoles(){
        $paymenttypes = Role::all();

        return view('settings.paymenttypes', [
            'paymenttypes' => $paymenttypes,
        ]);
    }

    function createRole(Request $request){
        $paymenttype = new Role;
        $paymenttype->paymentDescription = $request->paymentDescription;
        $paymenttype->save();

        return Redirect::to('admin');
    }

    function editRole(Request $request){
        $paymenttype = Role::find($request->paymenTypeID);
        $paymenttype->paymentDescription = $request->$paymentDescription;
        $paymenttype->save();

        return Redirect::to('admin');
    }

    function deleteRole($paymenttype){
        $paymenttype = Role::find($paymenttype);
        $paymenttype->delete();

        return Redirect::to('admin');
    }

    /*************************************************************************/
}
 