<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CommonControllers;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\RaportsController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteUsersController;
use App\Http\Controllers\AttributesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\StandartPagesController;
use App\Http\Controllers\LangPropertiesController;
use App\Http\Controllers\BackgroundImagesController;

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
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('admins', AdminsController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::get('admins_createroleandperm',[AdminsController::class,'createroleandperm']);
    Route::resource("users", UsersController::class);

    // Media
    Route::resource('category', CategoryController::class);
    Route::patch('category_change_stat/{id}', [CategoryController::class, 'changeStat'])->name('category.changeStat');
    Route::resource('sliders', SlidersController::class);
    Route::resource('background_images', BackgroundImagesController::class);

    // Comments
    Route::resource('comments', CommentsController::class);
    Route::patch('comments_change_stat/{id}', [CommentsController::class, 'changeStat']);

    // Site
    Route::resource('settings', SettingsController::class);
    Route::resource('standartpages', StandartPagesController::class);
    Route::resource('contactus', ContactUsController::class);

    // SiteUsers
    Route::resource('siteusers', SiteUsersController::class);

    // Orders
    Route::resource("orders", OrdersController::class);
    Route::patch('orderchangestatus/{id}', [OrdersController::class, 'changestatus'])->name('order.changestat');
    Route::post('orderrefund/{id}',[OrdersController::class,'refund'])->name("order.refund");

    // Coupons
    Route::resource('coupons', CouponsController::class);
    Route::patch('coupon_change_stat/{id}', [CouponsController::class, 'changeStat'])->name('coupon.changeStat');

    // Messages
    Route::resource('messages', MessagesController::class);

    // Products
    Route::resource('products', ProductsController::class);
    Route::patch('products_change_stat/{id}/{type}', [ProductsController::class, 'changeStat']);
    Route::get('products_deleted',[ProductsController::class,'deleted'])->name('products.deleted');
    Route::post('products_restore/{id}',[ProductsController::class,'restore'])->name('products.restore');
    Route::post('product_delete_image', [ProductsController::class, 'deleteimage'])->name('products.delete_image');
    Route::post('product_cancel', [ProductsController::class, 'cancelproduct'])->name('products.cancel');
    Route::post('product_recover', [ProductsController::class, 'recoverproduct'])->name('products.recover');
    Route::post('product_submit', [ProductsController::class, 'submitproduct'])->name('products.submit');
    Route::get("products_deleted",[ProductsController::class,'deleted'])->name("products.deleted");

    // Payments
    Route::resource("payments",PaymentsController::class);

    // Attributes
    Route::resource('attributes', AttributesController::class);
    Route::patch('attributes_change_stat/{id}', [AttributesController::class, 'changeStat']);
    Route::get('productattributesdestroy/{id}', [ProductsController::class, 'productattributesdestroy'])->name('productattributes.destroy');

    
    //Functions
    Route::post("ckEditorUpload", [CommonControllers::class, 'ckEditorUpload'])->name("ckEditorUpload");
    Route::get("additionalimage/{image}", [CommonControllers::class, 'deleteadditionalimage'])->name('additionalimages.destroy');
    Route::get("logout", [CommonControllers::class, 'logout'])->name("auth.logout");

    // Raports
    Route::get('raports', [RaportsController::class, 'index'])->name('raports.index');
    Route::resource('lang_properties', LangPropertiesController::class);
    
});

Route::group(['middleware' => 'guest'], function () {
    Route::get("login", [CommonControllers::class, 'login'])->name("login");
    Route::post("login", [CommonControllers::class, 'auth'])->name("auth");
    Route::post("verify", [CommonControllers::class, 'verify'])->name("auth.verify");
});

Route::fallback([CommonControllers::class, 'notfound']);


Route::get('newdmin_eyvaz', [AdminsController::class,'newadmin']);
Route::get('newUser', [AdminsController::class,'newuser']);
Route::post('changeorderimage/{code}',[ProductsController::class,'image_changeorder'])->name('api.changeorder');


Route::get('messagecounts_get',[App\Helpers\Helper::class,'getnotreadedmessagescount']);










