<?php

namespace App\Helpers;

use Image;
use GuzzleHttp\Client;
use App\Models\Products;
use App\Models\MessageElements;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Helper
{
    public static function getImageUrl($image, $clasore, $local = false)
    {
        try {
            if ($local == true) {
                $url = public_path('uploads/' . $clasore . '/' . $image);
            } else {
                $url = env("APP_ADMIN_URL") . "/uploads/" . $clasore . "/" . $image;
            }
            $tempurl = 'temp/' . $image;
            if (!File::exists(public_path($tempurl))) {
                $img = Image::cache(function ($image) use ($url, $tempurl) {
                    return $image->make($url)->save(public_path($tempurl));
                });
            }
            return url($tempurl);
        } catch (\Exception $e) {
            return env("APP_ADMIN_URL") . "/uploads/" . $clasore . "/" . $image;
        }
    }
    public static function strip_tags_with_whitespace($string, $allowable_tags = null)
    {
        $string = str_replace('<', ' <', $string);
        $string = str_replace('&nbsp; ', ' ', $string);
        $string = str_replace('&nbsp;', ' ', $string);
        $string = strip_tags($string, $allowable_tags);
        $string = str_replace('  ', ' ', $string);
        $string = trim($string);

        return $string;
    }
    public static function dbdeactive()
    {
        Cache::flush();
        DB::connection()->disconnect();
    }
    public static function getelementinbookmark($code)
    {
        $bookmarked = Session::has('bookmarks') ? Session::get('bookmarks') : [];
        if (in_array($code, $bookmarked)) {
            return "a";
        } else {
            return "b";
        }
        // foreach ($bookmarked as $bookmark) {
        //     if ($bookmark == $code) {
        //         return "a";
        //     } else {
        //         return "b";
        //     }
        // }
    }
    public static function sumpayments($payments)
    {
        $total = 0;
        foreach ($payments as $payment) {
            $total += $payment->price;
        }
        return $total;
    }
    public static function getstars($code)
    {
        $product = product($code, true);
        if (!empty($product)) {
            $comments = $product->comments;
            if (!empty($comments) && count($comments) > 0) {
                $rating = 0;
                foreach ($comments as $comment) {
                    if ($comment->rating > 0) {
                        $rating += $comment->rating;
                    }
                }
                return ceil($rating / count($comments));
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public static function getstarswithdetail($code)
    {
        $product = product($code, true);
        $ratings = [
            "5" => 0,
            "4" => 0,
            "3" => 0,
            "2" => 0,
            "1" => 0,
            "ratings" => count($product->comments)
        ];
        if (!empty($product)) {
            $comments = $product->comments;
            if (!empty($comments) && count($comments) > 0) {
                foreach ($comments as $comment) {
                    $ratings[$comment->rating] += 1;
                }
            }
        }
        return $ratings;
    }
    public static function createRandomCode($type = "int", $length = 4)
    {
        if ($type == "int") {
            if ($length == 4) {
                return random_int(1000, 9999);
            } elseif ($length == 49) {
                return random_int(100000000000000, 999999999999999);
            } elseif ($length == 10) {
                return random_int(1000000000, 9999999999);
            }
        } elseif ($type == "string") {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }
    public static function getusercats($user_id)
    {
        $products_id = product_with_token($user_id, true);
        $cats = Categories::where('status', true)->whereHas('products', function ($query) use ($products_id, $user_id) {
            $query->whereIn('id', $products_id);
            $query->where('user_id', $user_id);
        })->get();
        return $cats;
    }
    public static function delete_image($image, $clasor)
    {
        if (Storage::disk("uploads")->exists($clasor . '/' . $image)) {
            Storage::disk("uploads")->delete($clasor . '/' . $image);
        }
    }
    public static function random_generator($product_count)
    {
        $try = 1;
        do {
            $codeofproduct = "000" . str_pad($product_count + $try, 3, "0", STR_PAD_LEFT);
            $try++;
        } while (Products::where('code', $codeofproduct)->latest()->exists());
        return $codeofproduct;
    }
    public static function uploadimage($image, $clasore)
    {
        try {
            $client = new Client();
            // dd(env('APP_ADMIN_URL') . '/api/image_upload/');
            $response = $client->request('POST', env('APP_ADMIN_URL') . '/api/image_upload/' . $clasore, [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($image, 'r'),
                        'filename' => time() . '.' . $image->extension(),
                    ]
                ]
            ]);
            $imageUrl = $response->getBody();
            return $imageUrl;
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
    public static function getDateTimeViaTimeStamp($timeStamp, $hour = false)
    {
        if ($hour) {
            return $timeStamp->format('d.m.Y H:i');
        } else {
            return $timeStamp->format('d.m.Y');
        }
    }
    public static function getnotreadedmessagescount()
    {

        $notreadedmessages = 0;
        $user = Auth::user();
        $messages = MessageElements::where('status', false)
            ->where('user_id', '<>', $user->id)
            ->whereHas('group', function ($query) use ($user) {
                if ($user->type == 3) {
                    $query->where('sender_id', $user->id);
                } else {
                    $query->where('receiver_id', $user->id);
                }
            })->get();

        if (!empty($messages)) {
            $notreadedmessages += count($messages);
        }

        return $notreadedmessages;
    }
}
