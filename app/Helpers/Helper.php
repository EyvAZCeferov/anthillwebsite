<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Products;
use App\Models\Settings;
use App\Models\Attributes;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use App\Models\Notifications;
use App\Models\ProductComments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Helper
{
    public static function getDateTimeViaTimeStamp($timeStamp)
    {
        return $timeStamp->format('d.m.Y H:i');
    }
    public static function explodestring($data, $seperator, $key)
    {
        $string = explode($seperator, $data);
        return $string[$key];
    }


    public static function image_upload($image, $clasor, $imagename = null, $path = null)
    {
        $filename = $imagename ?? time() .Helper::createRandomCode('string',15).'.'. $image->extension();
        $image->storeAs($clasor, $filename, 'uploads');
        return $filename;
    }
    public static function getImageUrl($image, $clasore)
    {
        $url = env("APP_URL") . "/uploads/" . $clasore . "/" . $image;
        if ($url != null) {
            return $url;
        }
        return null;
    }

    public static function delete_image($image, $clasor)
    {
      
        // }else{
        // return false;
        // }
    }

    public static function random_generator($digits)
    {
        srand((float) microtime() * 10000000);
        //Array of alphabets or numeric ,you can define
        $input = array("0", "1", "2", "3", "4");

        $random_generator = ""; // Initialize the string to store random numbers
        for ($i = 1; $i < $digits + 1; $i++) { // Loop the number of times of required digits

            if (rand(1, 2) == 1) { // to decide the digit should be numeric or alphabet
                // Add one random alphabet
                $rand_index = array_rand($input);
                $random_generator .= $input[$rand_index]; // One char is added
            } else {
                // Add one numeric digit between 1 and 10
                $random_generator .= rand(1, 10); // one number is added
            }
            // end of if else
        }
        // end of for loop

        if (Products::where('code', $random_generator)->latest()->first() != null) {
            self::random_generator(7);
        }

        return $random_generator;
    }

    
    public static function createRandomCode($type = "int", $length = 4)
    {
        if ($type == "int") {
            if ($length == 4) {
                return random_int(1000, 9999);
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

    public static function htmlDecode($text)
    {
        $decoded_text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $decoded_text = preg_replace_callback('/&#(\d+);?/m', function ($match) {
            return chr(intval($match[1]));
        }, $decoded_text);
        return $decoded_text;
    }
  
    public static function arraytostring($data)
    {
        $img = str_replace(array("'", "\"", ",", '[', ']', ','), "",  $data);
        $url = stripslashes($img);

        // URL'yi düzgün bir formata getir
        $url = json_decode('"' . $url . '"');
        // $url = urlencode($url);
        return $url;
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
   
    public static function dbdeactive(){
        DB::connection()->disconnect();
        Cache::flush();
    }
    
}
