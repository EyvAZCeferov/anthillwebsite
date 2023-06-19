<?php

namespace App\Jobs;

use App\Helpers\Helper;
use App\Models\ProductEncodedImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Image;

class FileUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product_images_id, $image;

    /**
     * Create a new job instance.
     *
     * @param string $product_images_id
     * @param string $image
     * @return void
     */
    public function __construct($product_images_id, $image)
    {
        $this->product_images_id = $product_images_id;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    //     try {
    //         $product_images = ProductEncodedImages::where('id', $this->product_images_id)->latest()->first();

    //         $encoded_watermaker_images = ProductEncodedImages::where('id', $this->product_images_id)->first()->encoded_watermaker_images ?? [];
    //         $encoded_thumbnail_images = ProductEncodedImages::where('id', $this->product_images_id)->first()->encoded_thumbnail_images ?? [];
    //         $original_compressed_images = ProductEncodedImages::where('id', $this->product_images_id)->first()->original_compressed_images ?? [];
           
    //         $parts = explode('/', $this->image);
    //         $filename = end($parts);
    //         $jpg = Image::make($this->image);

    //         // Original_compressed
    //         $jpg->encode('jpg', 70)->save(public_path('/products_compressed/') . $filename);
    //         $imageUrl_compressed_original = Helper::image_upload($jpg->stream(), 'products_compressed/' . $product_images->code, $filename, $jpg->basePath());
    //         if (File::exists(public_path('/products_compressed/') . $filename)) {
    //             File::delete(public_path('/products_compressed/') . $filename);
    //         }
    //         array_push($original_compressed_images,  $imageUrl_compressed_original);
    //         // Original_compressed

    //         // Watermarked
    //         $bigsize = $jpg->getWidth() / 12;
    //         $jpg_watermarked = $jpg->text(env('IMAGE_WATERMARKER_WRITE'), $jpg->getWidth() / 2, $jpg->getHeight() / 2, function ($font) use ($bigsize) {
    //             $font->file(public_path('assets/fonts/Poppins/Poppins-Bold.ttf'));
    //             $font->size($bigsize);
    //             $font->color(array(255, 255, 255, 0.3));
    //             $font->align('center');
    //             $font->valign('center');
    //             $font->angle(0);
    //         })->save(public_path('/products_watermarked/') . $filename);

    //         $imageUrl_watermarked = Helper::image_upload($jpg_watermarked->stream(), 'products_watermarked/' . $product_images->code, $filename, $jpg_watermarked->basePath());
    //         if (File::exists(public_path('/products_watermarked/') . $filename)) {
    //             File::delete(public_path('/products_watermarked/') . $filename);
    //         }
    //         array_push($encoded_watermaker_images,  $imageUrl_watermarked);
    //         // Watermarked

    //         // Resized and Thumbnailed
    //         $jpg_thumbnail = $jpg
    //             ->resize(85, 63)
    //             ->save(public_path('/products_thumbnail/') . $filename);

    //         $imageUrl_encoded_thumbnail = Helper::image_upload($jpg_thumbnail->stream(), 'products_thumbnail/' . $product_images->code, $filename, $jpg_thumbnail->basePath());
    //         if (File::exists(public_path('/products_thumbnail/') . $filename)) {
    //             File::delete(public_path('/products_thumbnail/') . $filename);
    //         }
    //         array_push($encoded_thumbnail_images,  $imageUrl_encoded_thumbnail);
    //         ProductEncodedImages::where('id', $this->product_images_id)->update([
    //             'encoded_watermaker_images' => $encoded_watermaker_images,
    //             'encoded_thumbnail_images' => $encoded_thumbnail_images,
    //             'original_compressed_images' => $original_compressed_images,
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }

    // }
}
}
