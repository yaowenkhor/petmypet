<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/selectrole', function () {
    return view('auth.select-role');
});
Route::get('/selectrole/redirect', [App\Http\Controllers\Auth\LoginController::class, 'loginSelectRole'])->name('login.select.role');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(App\Http\Controllers\Auth\RegisterController::class)->group(function () {

    Route::get('adopter/register', 'displayAdopterRegisterForm')->name('adopter.login.form');
    Route::get('organization/register', 'displayOrganizationRegisterForm')->name('organization.login.form');
    Route::get('admin/register', 'displayAdminRegisterForm')->name('admin.login.form');


    //Create routing for user register as a adopter
    Route::post('adopter/register', 'createAdopter')->name('adopter.register');
    //Create routing for user register as a organization
    Route::post('organization/register', 'createOrganization')->name('organization.register');
    //Create routing for user register as a admin
    Route::post('admin/register', 'createAdmin')->name('admin.register');
});

Route::controller(App\Http\Controllers\Auth\LoginController::class)->group(function () {

    Route::get('adopter/login', 'displayAdopterLoginForm')->name('adopter.login.form');
    Route::get('organization/login', 'displayOrganizationLoginForm')->name('organization.login.form');
    Route::get('admin/login', 'displayAdminLoginForm')->name('admin.login.form');

    //Create routing for user login as a adopter
    Route::post('adopter/login', 'loginAdopter')->name('adopter.login');
    //Create routing for user login as a organization
    Route::post('organization/login', 'loginOrganization')->name('organization.login');
    //Create routing for user login as a admin
    Route::post('admin/login', 'loginAdmin')->name('admin.login');
});

Route::controller(App\Http\Controllers\AdminController::class)->group(function () {

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('admin/home', 'index')->name('admin.home');

        Route::post('admin/approve/{id}', 'approveOrganization')->name('admin.approve');
        Route::post('admin/reject/{id}', 'rejectOrganization')->name('admin.reject');
    });

});

Route::controller(App\Http\Controllers\AdopterController::class)->group(function () {

    Route::group(['middleware' => 'auth:adopter'], function () {
        Route::get('adopter/home', 'index')->name('adopter.home');

        // View user's profile
        Route::get('adopter/profile', 'showProfile')->name('adopter.profile');

        // Show profile edit form
        Route::get('adopter/profile', 'showEditProfile')->name('adopter.profile.editForm');

        // Submit profile update
        Route::put('adopter/edit', 'editProfile')->name('adopter.profile.update');

        // submit adoption application
        Route::post('adopter/apply/{id}', 'submitApplication')->name('adoption.submit');
    });

    

});

Route::controller(App\Http\Controllers\OrganizationController::class)->group(function () {

    Route::group(['middleware' => 'auth:organization'], function () {
        Route::get('organization/home', 'index')->name('organization.home');
        Route::get('organization/edit', 'displayEditProfileForm')->name('organization.edit.form');

        Route::post('organization/reapply', 'reapply')->name('organization.reapply');
        Route::put('organization/edit', 'edit')->name('organization.edit');

        Route::get('organization/adoptionRequests', 'viewAdoptionRequests')->name('organization.adoptionRequests');
        Route::put('organization/adoptionRequest/{id}/update','updateAdoptionStatus')->name('organization.updateAdoptionStatus');
    });


});

Route::controller(App\Http\Controllers\PetController::class)->group(function () {

    Route::group(['middleware' => 'auth:organization'], function () {
        Route::post('pet/create', 'store')->name('pet.create');
        Route::delete('pet/delete/{id}', 'destroy')->name('pet.delete');

        Route::get('pet/edit/{id}', 'displayPetUpdateForm')->name('pet.update');
        Route::put('pet/edit/{id}', 'update')->name('pet.update.submit');

        Route::get('pet/organization', 'show')->name('pet.show');
    });

    Route::get('pets/all', 'index')->name('pet.index');
    Route::get('pets/search', 'search')->name('pet.search');

    Route::get('pet/details/{id}', 'displayDetails')->name('pet.details');

    // Adopter reports a pet post
    Route::post('pet/{id}/report', 'report')->middleware('auth:adopter') ->name('pet.report');

});





