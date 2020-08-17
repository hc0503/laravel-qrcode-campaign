<?php
  use App\Http\Controllers\LanguageController;

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


Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'DashboardController@userDashboard')->name('user-dashboard');
  Route::get('dashboard', 'DashboardController@userDashboard')->name('user-dashboard');

  // Route Campaign
  Route::resource('campaigns', 'CampaignController');
  Route::get('coordinates', 'DashboardController@getCoordinates')->name('get-coordinates');

});

// Route QRCode
Route::get('qrcode/generate/{campaign}', 'QRCodeController@generateQRCode')->name('qrcode-generate');
Route::get('qrcode/track/{campaign}', 'QRCodeController@qrcodeTrack')->name('qrcode-track');






// Route Dashboards
Route::get('/dashboard-analytics', 'DashboardController@dashboardAnalytics');

// Route Components
Route::get('/sk-layout-2-columns', 'StaterkitController@columns_2');
Route::get('/sk-layout-fixed-navbar', 'StaterkitController@fixed_navbar');
Route::get('/sk-layout-floating-navbar', 'StaterkitController@floating_navbar');
Route::get('/sk-layout-fixed', 'StaterkitController@fixed_layout');

// acess controller
Route::get('/access-control', 'AccessController@index');
Route::get('/access-control/{roles}', 'AccessController@roles');
Route::get('/modern-admin', 'AccessController@home')->middleware('permissions:approve-post');

Auth::routes();

// locale Route
Route::get('lang/{locale}',[LanguageController::class,'swap']);
