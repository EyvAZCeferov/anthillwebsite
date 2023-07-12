<?php

use App\Helpers\GUAVAPAY;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\ChatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('flush', [ApisController::class, 'cacheflush'])->name('flush');
Route::post('get_attributes', [ApisController::class, 'get_attributes'])->name("api.get_attributes");
Route::post('imageupload/{token}', [ApisController::class, 'imageupload'])->name("api.imageuploadproduct");
Route::delete('imagedelete/{token}', [ApisController::class, 'imagedelete'])->name("api.imagedeleteproduct");
Route::post('changeorderimage/{token}', [ApisController::class, 'image_changeorder'])->name('api.changeorder');
Route::get('uploaded_images/{token}', [ApisController::class, 'uploaded_images'])->name('api.uploaded_images');
Route::post("addnewform", [ApisController::class, 'addnewform'])->name("addnew.form");
Route::post("updatenewform", [ApisController::class, 'updatenewform'])->name("updatenew.form");
Route::post("sharecomment", [ApisController::class, 'sharecomment'])->name("comments.share");

Route::get('createupayment', [ApisController::class, 'createpayment'])->name("api.createupayment");
Route::post("deleteservice", [ApisController::class, 'deleteservice'])->name("api.deleteservice");
Route::get("serviceinfo/{code}", [ApisController::class, 'serviceinfo'])->name("api.serviceinfo");
Route::post('searchinfilled', [ApisController::class, 'searchinfilled'])->name("api.searchinfilled");
Route::post('filterelements', [ApisController::class, 'filterelements'])->name("api.filterelements");


Route::get("services_user/{user_id}",[ApisController::class,'services_user'])->name('api.services_user');
Route::get("services_user_datas/{user_id}",[ApisController::class,'services_user'])->name('api.services_user');
Route::get("services_user/{user_id}/{search}",[ApisController::class,'services_user_search'])->name('api.services_user_search');
Route::get('get_category_datas/{token}/{attribute_group_id}',[ApisController::class,'get_category_datas'])->name('api.get_category_datas');
Route::post('sendform',[ApisController::class,'sendform'])->name('contactus.sendform');
Route::post('changestat_order',[ApisController::class,'changestat_order'])->name("changestat.order");

Route::get('checkpayment/{transaction_id}',[ApisController::class,'checkpayment'])->name("payment.check");
Route::get("refundpayment/{id}/{amount}",[GUAVAPAY::class,'refund'])->name('payment.refund');

Route::get('/queuework', function () {
    exec('php /var/www/anthill/Website/artisan queue:work --timeout=60');
    return "Queue work process started.";
});


Route::post('delete_attribute',[ApisController::class,'delete_attribute'])->name('attributes.delete');
