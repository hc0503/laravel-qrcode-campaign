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

Auth::routes();

Route::group(['middleware' => ['auth','locked']], function () {
  // User dashboard
  Route::get('/', 'DashboardController@userDashboard')->name('user-dashboard');
  Route::get('dashboard', 'DashboardController@userDashboard')->name('user-dashboard');

  // Profile
  Route::get('/profiles/{user}', 'ProfileController@showProfile')->name('profile-show');
  Route::get('/profiles/{user}/edit', 'ProfileController@editProfile')->name('profile-edit');
  Route::post('/profiles/{user}', 'ProfileController@updateProfile')->name('profile-update');
  Route::post('/profiles/{user}/reset', 'ProfileController@changePassword')->name('profile-reset');

  // Campaigns
  Route::resource('campaigns', 'CampaignController');

  // QRCode
  Route::get('qrcode/generate/{campaign}', 'QRCodeController@generateQRCode')->name('qrcode-generate');

  // coordinates
  Route::get('coordinates', 'DashboardController@getCoordinates')->name('get-coordinates');

  Route::group(['middleware' => ['permission:user_manage'], 'prefix' => 'admin'], function () {
    // Roles
    Route::resource('roles', 'Admin\RoleController');

    // Users
    Route::resource('users', 'Admin\UserController');
    Route::post('users/setlock', 'Admin\UserController@setLock');

    // Admin dashboard
    Route::get('/', 'Admin\DashboardController@adminDashboard');
    Route::post('campaigns/delete', 'CampaignController@ajaxDelete');
  });
});

// Locked page
Route::get('locked', 'HomeController@lockedPage');

// QR code track
Route::get('qrcode/track/{campaign}', 'QRCodeController@qrcodeTrack')->name('qrcode-track');

// locale Route
Route::get('lang/{locale}',[LanguageController::class,'swap']);