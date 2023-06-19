<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\ProductsController;


Route::get("flush",function(){
    Cache::flush();
    return "Cache Flushed";
});
Route::delete('delete_image', [ApisController::class,'deleteimage'])->name('api.deleteimage');

Route::post('upload_from_excell/{skip}',[ApisController::class,'upload_from_excell'])->name('api.upload_from_excell');
Route::get('translate/{lang}',[ApisController::class,'translate'])->name('translate');
Route::post("apiuploadimage",[ApisController::class,'uploadImgs'])->name('apiuploadimage');

Route::post('rotateproduct/{code}',[ProductsController::class,'rotateproduct'])->name('api.rotateproduct');



Route::post("image_upload/{clasore}",[ApisController::class,'image_upload'])->name("api.image_upload");


Route::post('imageupload/{token}', [ApisController::class, 'imageupload'])->name("api.imageuploadproduct");
Route::delete('imagedelete/{token}', [ApisController::class, 'imagedelete'])->name("api.imagedeleteproduct");
Route::get('uploaded_images/{token}', [ApisController::class, 'uploaded_images'])->name('api.uploaded_images');

Route::get("migrate",function(){
    Artisan::call('migrate');
    return "Migration Success";
});