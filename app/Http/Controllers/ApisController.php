<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\ProductEncodedImages;

class ApisController extends Controller
{
   public function image_upload(Request $request,$clasore){
      try {
         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $filename=$clasore.'-'.time().'.'.$image->extension();
             $image = Helper::image_upload($request->file('image'), $clasore,$filename);
 
             return $image;
         } else {
             return response()->json(['status' => 'error', 'message' => 'Yüklenecek bir resim bulunamadı']);
         }
     } catch (\Exception $e) {
         return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
     }
   }

   public function imageupload(Request $request, $token)
    {
        try {
            if (!empty($request->file('file'))) {
                $imageName = null;

                if (isset($request->file) && !empty($request->file) && $request->hasFile('file')) {
                    $imageName = Helper::image_upload($request->file('file'), 'products');
                }
                $images = new ProductEncodedImages();
                $images->original_images = $imageName;
                $images->order_a = count(product_encoded_images($token, 'token')) + 1;
                $images->token = $token;
                $images->save();

                return $imageName;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
    public function uploaded_images($token)
    {
        $images = ProductEncodedImages::where('token', $token)->whereNotNull('original_images')->orderBy("order_a", 'ASC')->get();
        $imagesArray = [];
        foreach ($images as $image) {
            $imagesArray[] = [
                'name' => $image->original_images,
                'size' => 10,
                'path' => Helper::getImageUrl($image->original_images, 'products'),
            ];
        }

        return response()->json($imagesArray);
    }
    public function imagedelete(Request $request, $token)
    {
        try {
            $productimages = product_encoded_images($token, 'token_original_images', $request->filename);
            if (!empty($productimages)) {
                Helper::delete_image($request->filename, "products/" . $token);

                $productimages->delete();
                return true;
            } else {
                return 'a';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public function image_changeorder($token, Request $request)
    {
        try {
            $images = product_encoded_images($token, 'token');

            foreach ($request->data as $key => $value) {
                $image = $images->firstWhere('original_images', $value);
                if ($image) {
                    $image->update(['order_a' => $key]);
                }
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
   
}
