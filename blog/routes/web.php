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
	Route::get('/', function () {
	    return view('admin_template');
	});

	Route::get('/', 'DashboardController@index');

	
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
});
