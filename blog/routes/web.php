<?php
use Illuminate\Http\Request;
use App\Http\Middleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * User Login and register
 */

Route::post('/register', 'RegistrationController@postRegister');
Route::get('/login', 'LoginController@show');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');


Route::group(['middleware' => ['CustomAuth']], function () {
	/**
	 * Dashboard
	 */
	Route::get('/', 'DashboardController@index');
	Route::get('/dashboard', 'DashboardController@index');

	Route::get('/todo', function () {
	    return view('todo');
	});

	
	/**
	 * Agreements
	 */
	Route::get('/agreements','AgreementsController@index');
	Route::post('/agreement',  'AgreementsController@create');
	Route::post('/agreement/update',  'AgreementsController@update');
	Route::post('/agreement/all',  'AgreementsController@data');
	Route::delete('/agreement/{agreement}',  'AgreementsController@delete');
	Route::get('/agreement/getfields/{agreementid}','AgreementsController@getFields');

	
	/**
	 * Attachments
	 */
	Route::post('/attachment',  'AttachmentsController@create');
	Route::post('/attachment/update',  'AttachmentsController@update');
	Route::get('/attachments/{filename}',  'AttachmentsController@getFile');
	Route::get('/attachment/edit/{attachment}',  'AttachmentsController@edit');
	Route::delete('/attachment/{attachment}', 'AttachmentsController@delete');	


	/**
	 * Files
	 */
	Route::get('/images/uploads/{filename}',  'FilesController@getFile');

	/**
	 * Users
	 */
	Route::get('/users',  'UsersController@index');
	Route::get('/user/edit/{user}',  'UsersController@edit');
	Route::post('/users',  'UsersController@create');
	Route::post('/users/update',  'UsersController@update');
	Route::delete('/user/{user}', 'UsersController@delete');
	Route::post('/user/all', 'UsersController@data');
	
	/**
	 * Units
	 */
	Route::get('/units',  'UnitsController@index');
	Route::get('/unit/edit/{unit}',  'UnitsController@edit');
	Route::post('/units',  'UnitsController@create');
	Route::post('/units/update',  'UnitsController@update');
	Route::delete('/unit/{unit}', 'UnitsController@delete');
	Route::post('/unit/all', 'UnitsController@data');

	/**
	 * Property
	 */
    Route::get('props',  'PropertyController@index');
	Route::get('prop/edit/{property}',  'PropertyController@edit');
	Route::post('props',  'PropertyController@create');
	Route::post('props/update',  'PropertyController@update');
	Route::delete('prop/{property}', 'PropertyController@delete');
	Route::post('props/all', 'PropertyController@data');
    Route::post('prop/subtypelist/{propertyTypeID}',  'PropertyController@getSubtypeList');

    /**
     * Notes
     */
	Route::post('note',  'NotesController@create');
	Route::post('note/update',  'NotesController@update');
	Route::delete('note/{note}',  'NotesController@delete');


	/**
	 * Tenants
	 */
	Route::get('/tenants',  'TenantsController@index');
	Route::get('/tenant/edit/{tenant}',  'TenantsController@edit');
	Route::post('/tenants',  'TenantsController@create');
	Route::post('/tenants/update',  'TenantsController@update');
	Route::delete('/tenant/{tenant}', 'TenantsController@delete');
	Route::post('/tenants/all', 'TenantsController@data');

	/**
	 * Rental Owners
	 */
	Route::get('/rentalowners',  'RentalOwnersController@index');
	Route::get('/rentalowner/edit/{rentalowner}',  'RentalOwnersController@edit');
	Route::post('/rentalowners',  'RentalOwnersController@create');
	Route::post('/rentalowners/update',  'RentalOwnersController@update');
	Route::delete('/rentalowner/{rentalowner}', 'RentalOwnersController@delete');
	Route::post('/rentalowners/all', 'RentalOwnersController@data');

	/**
	 * Job Card
	 */
	Route::get('jobcards',  'JobCardsController@index');
	Route::get('jobcard/edit/{jobcard}',  'JobCardsController@edit');
	Route::post('jobcards',  'JobCardsController@create');
	Route::post('jobcards/update',  'JobCardsController@update');
	Route::delete('jobcard/{jobcard}', 'JobCardsController@delete');
	Route::post('jobcards/all', 'JobCardsController@data');
	Route::get('jobcard/getunit/{propertyId}',  'JobCardsController@getUnitsForProperty');
	Route::post('jobcard/getunit/{propertyId}',  'JobCardsController@getUnitsForProperty');

		/**
		 * Jobcard Attachments
		 */
		Route::post('attachment/save', 'JobCardsController@saveAttachment');
		Route::post('/jobcard-attachments/{jobcardid}', 'JobCardsController@getAttachements');
		Route::delete('/jobcard-attachments/{attachmentid}', 'JobCardsController@delete');	

		/**
		 * Job Card Comments
		 */
		Route::post('jobcardcomment',  'JobCardCommentsController@create');
		// Route::post('jobcards/update',  'JobCardCommentsController@update');
		Route::delete('jobcardcomment/{jobcardcomment}', 'JobCardCommentsController@delete');
		
		/**
		 * Jobcard Maintenance
		 */
		Route::get('jobcard/edit/{jobcard}/maintenance',  'JobCardsMaintenanceController@index');
		Route::post('jobcard/edit/maintenance', 'JobCardsMaintenanceController@create');
		Route::post('jobcard/edit/maintenance/update', 'JobCardsMaintenanceController@update');
		Route::delete('jobcard/edit/maintenance/{maintenanceItem}', 'JobCardsMaintenanceController@delete');	
		

	/**
	 * Settings
	 */
	Route::get('/admin',  'SettingsController@admin');
		/**
		 * Property Types
		 */		
		Route::get('/propertytypes', 'SettingsController@showPropertyTypes');
		Route::post('/propertytype', 'SettingsController@createPropertyType');
		Route::post('update/propertytype', 'SettingsController@editPropertyType');
		Route::delete('/propertytype/{propertytype}', 'SettingsController@deletePropertyType');

		/**
		 * Property Sub Types
		 */		
		Route::get('/propertysubtypes', 'SettingsController@showPropertysubTypes');
		Route::post('/propertysubtype', 'SettingsController@createPropertysubType');
		Route::post('update/propertysubtype', 'SettingsController@editPropertysubType');
		Route::delete('/propertysubtype/{propertysubtype}', 'SettingsController@deletePropertysubType');

		/**
		 * Currency
		 */		
		Route::get('/currency', 'SettingsController@showCurrency');
		Route::post('/currency', 'SettingsController@createCurrency');
		Route::post('update/currency', 'SettingsController@editCurrency');
		Route::delete('/currency/{currency}', 'SettingsController@deleteCurrency');

		/**
		 * Payment Type
		 */		
		Route::get('/paymenttype', 'SettingsController@showPaymentType');
		Route::post('/paymenttype', 'SettingsController@createPaymentType');
		Route::post('update/paymenttype', 'SettingsController@editPaymentType');
		Route::delete('/paymenttype/{paymenttype}', 'SettingsController@deletePaymentType');

		/**
		 * Roles
		 */		
		Route::get('/roles', 'SettingsController@showRoles');
		Route::post('/role', 'SettingsController@createRole');
		Route::post('update/role', 'SettingsController@editRole');
		Route::delete('/role/{role}', 'SettingsController@deleteRole');

		/**
		 * User
		 */		
		Route::get('/users', 'UsersController@index');/**
		
		/** 
		 * Company Details
		 */		
		Route::get('/company/edit/{company}', 'SettingsController@editCompany');
		Route::post('/company', 'SettingsController@updateCompany');

		/**
		 * Supplier
		 */		
		Route::get('/supplier', 'SettingsController@showSuppliers');
		Route::post('/supplier', 'SettingsController@createSuppliers');
		Route::post('update/supplier', 'SettingsController@editSuppliers');
		Route::delete('/supplier/{supplier}', 'SettingsController@deleteSuppliers');

		/**
		 * Chart of accounts
		 */		
		Route::get('/accounts', 'SettingsController@showChartofaccounts');
		Route::post('/account', 'SettingsController@createChartofaccounts');
		Route::post('update/account', 'SettingsController@editChartofaccounts');
		Route::delete('/account/{chartofaccounts}', 'SettingsController@deleteChartofaccounts');
		
});
