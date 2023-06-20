<?php

use App\Helpers\Helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\FunctionsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::get('/', [RoutesController::class, 'welcome'])->name('welcome');
    // Standartpages
    Route::get('page/{type}', [RoutesController::class, 'standartpage'])->name('standartpages.show');

    // MediaPages
    Route::get('services', [RoutesController::class, 'services'])->name('services.index');
    Route::get('services/{slug}', [RoutesController::class, 'service'])->name('services.show');
    Route::get('service/edit/{code}', [RoutesController::class, 'editservice'])->name('services.edit');
    Route::get('myservices', [RoutesController::class, 'myservices'])->name('myservices.index');
    Route::get('companies', [RoutesController::class, 'companies'])->name('companies.index');
    Route::get('company/{slug}', [RoutesController::class, 'company'])->name('companies.show');

    // AuthPages
    Route::get('login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::get('forgetpassword', [AuthController::class, 'forgetpassword'])->name('auth.forgetpassword');
    Route::get('wishlist', [AuthController::class, 'wishlist'])->name('wishlist.index');
    Route::get('orders', [AuthController::class, 'orders'])->name('orders.index');
    Route::get('orders/{uid}', [AuthController::class, 'order'])->name('orders.show');
    Route::get('payments', [AuthController::class, 'payments'])->name('payments.index');
    Route::get('change_password', [AuthController::class, 'change_password'])->name('password.change');
    Route::get('change_password_view', [AuthController::class, 'change_password_view'])->name('password.change_view');
    Route::get('newpassword_view', [AuthController::class, 'newpassword_view'])->name('password.new_password');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout.index');
    Route::get('messages', [AuthController::class, 'messages'])->name('messages.index');
    Route::get('settings', [AuthController::class, 'settings'])->name('settings.index');
    Route::get("togglemultiple/{status}",[FunctionsController::class,'togglelog_multiple'])->name("log.multiple");
    Route::get("toggleservice/{status}",[FunctionsController::class,'toggleservice'])->name("service.multiple");
    Route::get('addservice', [AuthController::class, 'addservice'])->name('services.addnew');

});

Route::post("loginpost",[FunctionsController::class,'login'])->name("posts.login");
Route::post("registerpost",[FunctionsController::class,'register'])->name("posts.register");
Route::post("forgetpasswordpost",[FunctionsController::class,'forgetpassword'])->name("posts.forgetpassword");
Route::post("submitpinpost",[FunctionsController::class,'submitpin'])->name("posts.submitpin");
Route::post("updatedata",[FunctionsController::class,'updatedata'])->name("auth.updatedata");

Route::post("bookmarktoggle",[ApisController::class,'bookmarktoggle'])->name("api.bookmarktoggle");

// MessageFunctions
Route::get("fetchmessagegroups",[ChatsController::class,'fetchmessagegroups'])->name('messages.fetchmessagegroups');
Route::get("fetchattributes/{id}",[ChatsController::class,'fetchattributes'])->name('messages.fetchattributes');
Route::get("fetchmessages/{roomid}",[ChatsController::class,'fetchmessages'])->name('messages.fetchmessages');
Route::post("sendmessage/{roomid}",[ChatsController::class,'sendmessage'])->name('messages.sendmessage');
Route::post("readmessage/{messageid}",[ChatsController::class,'readmessage'])->name('messages.readmessage');

Route::get("get_image/{image}/{clasore}",[Helper::class,'getImageUrl'])->name('api.getimageurl');
Route::post('createandredirectchat', [ChatsController::class, 'create_and_redirect'])->name('api.createandredirectchat');
Route::post('registerandchatithuser',[ApisController::class,'registerandchatithuser'])->name("api.registerandchatithuser");
Route::get('authenticated',[AuthController::class,'authenticated'])->name('authenticated.get');

Route::get('sitemap',[ApisController::class,'sitemap']);

Route::fallback([RoutesController::class,'notfound']);
Route::get('locale', function () {
    return response()->json(['locale' => app()->getLocale()]);
})->name('app.getlocale');
Route::any('callback',[FunctionsController::class,'callback'])->name("guavapay.callback");
Route::post('notreadedmessages',[ApisController::class,'getnotreadedmessagescount'])->name("api.notreadedmessages");
