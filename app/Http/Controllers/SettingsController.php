<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = setting();
            return view('sayt.settings', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'az_description' => 'required|min:3|max:300',
                'az_address' => 'required|min:3|max:300',
                'az_title' => 'required|min:3|max:300',
                'az_open_hours' => 'required|min:3|max:300',
                'logo' => 'image|mimes:jpg,jpeg,pjpeg,pjp,avif,jfif,bmp,ico,cur,png,gif,svg,webp,tif,tiff',
            ]);
            $data=Settings::find($id);
            if ($validator->failed()) {
                return redirect()->back()->with('error', $validator->errors());
            }
            if ($request->hasFile('logo')) {
                $logoname = env('APP_NAME') . time() . '.' . $request->file("logo")->extension();
                $imageurl = Helper::image_upload($request->file('logo'), 'settings', $logoname);
                $data->update(['logo'=>$imageurl]);
            }

            if ($request->hasFile('icon')) {
                $iconname = env('APP_NAME') . time() . '.' . $request->file("icon")->extension();
                $imageurl = Helper::image_upload($request->file('icon'), 'settings', $iconname);

                $data->update([
                    "icon"=>$imageurl
                ]);
            }

            $title = [
                'az_title' => trim($request->az_title) ?? " ",
                'ru_title' => isset($request->ru_title) ? $request->ru_title : trim(GoogleTranslate::trans($request->az_title, 'ru')),
                'en_title' => isset($request->en_title) ? $request->en_title : trim(GoogleTranslate::trans($request->az_title, 'en')),
                'tr_title' => isset($request->tr_title) ? $request->tr_title : trim(GoogleTranslate::trans($request->az_title, 'tr')),
            ];

            $open_hours = [
                'az_open_hours' => trim($request->az_open_hours) ?? " ",
                'ru_open_hours' => isset($request->ru_open_hours) ? $request->ru_open_hours : trim(GoogleTranslate::trans($request->az_open_hours, 'ru')),
                'en_open_hours' => isset($request->en_open_hours) ? $request->en_open_hours : trim(GoogleTranslate::trans($request->az_open_hours, 'en')),
                'tr_open_hours' => isset($request->tr_open_hours) ? $request->tr_open_hours : trim(GoogleTranslate::trans($request->az_open_hours, 'tr')),
            ];

            $description = [
                'az_description' => trim($request->az_description) ?? " ",
                'ru_description' => isset($request->ru_description) ? $request->ru_description : trim(GoogleTranslate::trans($request->az_description, 'ru')),
                'en_description' => isset($request->en_description) ? $request->en_description : trim(GoogleTranslate::trans($request->az_description, 'en')),
                'tr_description' => isset($request->tr_description) ? $request->tr_description : trim(GoogleTranslate::trans($request->az_description, 'tr')),
            ];

            $address = [
                'az_address' => trim($request->az_address) ?? " ",
                'ru_address' => isset($request->ru_address) ? $request->ru_address : trim(GoogleTranslate::trans($request->az_address, 'ru')),
                'en_address' => isset($request->en_address) ? $request->en_address : trim(GoogleTranslate::trans($request->az_address, 'en')),
                'tr_address' => isset($request->tr_address) ? $request->tr_address : trim(GoogleTranslate::trans($request->az_address, 'tr')),
            ];

            $social_media = [
                'facebook_url' => $request->facebook_url ?? " ",
                'instagram_url' => $request->instagram_url ?? " ",
                'mobile_phone' => $request->mobile_phone ?? " ",
                'home_phone' => $request->home_phone ?? " ",
                'whatsapp' => $request->whatsapp ?? " ",
                'email' => $request->email ?? " ",
                'gmaps_url' => $request->gmaps_url ?? " ",
                'youtube_url' => $request->youtube_url ?? " ",
                'tiktok' => $request->tiktok ?? " ",
                'log_enabled' => "passive",
                'active_service' => "active",
                'yandex_metrica' => $request->yandex_metrica ?? " ",
                'GOOGLE_ANALYSTICS_MEASUREMENT_ID' => $request->GOOGLE_ANALYSTICS_MEASUREMENT_ID ?? " ",
            ];

            $data->title = $title;
            $data->description = $description;
            $data->address = $address;
            $data->social_media = $social_media;
            $data->open_hours = $open_hours;
            $data->save();

            foreach(languages() as $lang){
                $lang->update(['status'=>false]);
            }

            if(isset($request->languages) && !empty($request->languages)){
                $keys = array_keys($request->languages);
                foreach($keys as $key){
                    $lang=languages($key);
                    $lang->update(['status'=>true]);
                }
            }

            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'az_description' => 'required|min:3|max:300',
                'az_address' => 'required|min:3|max:300',
                'az_title' => 'required|min:3|max:300',
                'az_open_hours' => 'required|min:3|max:300',

                'logo' => 'image|mimes:jpg,jpeg,pjpeg,pjp,avif,jfif,bmp,ico,cur,png,gif,svg,webp,tif,tiff',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $title = [
                'az_title' => trim($request->az_title) ?? " ",
                'ru_title' => isset($request->ru_title) ? $request->ru_title : trim(GoogleTranslate::trans($request->az_title, 'ru')),
                'en_title' => isset($request->en_title) ? $request->en_title : trim(GoogleTranslate::trans($request->az_title, 'en')),
                'tr_title' => isset($request->tr_title) ? $request->tr_title : trim(GoogleTranslate::trans($request->az_title, 'tr')),
            ];

            $open_hours = [
                'az_open_hours' => trim($request->az_open_hours) ?? " ",
                'ru_open_hours' => isset($request->ru_open_hours) ? $request->ru_open_hours : trim(GoogleTranslate::trans($request->az_open_hours, 'ru')),
                'en_open_hours' => isset($request->en_open_hours) ? $request->en_open_hours : trim(GoogleTranslate::trans($request->az_open_hours, 'en')),
                'tr_open_hours' => isset($request->tr_open_hours) ? $request->tr_open_hours : trim(GoogleTranslate::trans($request->az_open_hours, 'tr')),
            ];

            $description = [
                'az_description' => trim($request->az_description) ?? " ",
                'ru_description' => isset($request->ru_description) ? $request->ru_description : trim(GoogleTranslate::trans($request->az_description, 'ru')),
                'en_description' => isset($request->en_description) ? $request->en_description : trim(GoogleTranslate::trans($request->az_description, 'en')),
                'tr_description' => isset($request->tr_description) ? $request->tr_description : trim(GoogleTranslate::trans($request->az_description, 'tr')),
            ];

            $address = [
                'az_address' => trim($request->az_address) ?? " ",
                'ru_address' => isset($request->ru_address) ? $request->ru_address : trim(GoogleTranslate::trans($request->az_address, 'ru')),
                'en_address' => isset($request->en_address) ? $request->en_address : trim(GoogleTranslate::trans($request->az_address, 'en')),
                'tr_address' => isset($request->tr_address) ? $request->tr_address : trim(GoogleTranslate::trans($request->az_address, 'tr')),
            ];

            $social_media = [
                'facebook_url' => $request->facebook_url ?? " ",
                'instagram_url' => $request->instagram_url ?? " ",
                'mobile_phone' => $request->mobile_phone ?? " ",
                'home_phone' => $request->home_phone ?? " ",
                'whatsapp' => $request->whatsapp ?? " ",
                'email' => $request->email ?? " ",
                'gmaps_url' => $request->gmaps_url ?? " ",
                'youtube_url' => $request->youtube_url ?? " ",
                'tiktok' => $request->tiktok ?? " ",
                'log_enabled' => "passive",
                'active_service' => "active",
                'yandex_metrica' => $request->yandex_metrica ?? " ",
                'GOOGLE_ANALYSTICS_MEASUREMENT_ID' => $request->GOOGLE_ANALYSTICS_MEASUREMENT_ID ?? " ",
            ];
            $imageurl = null;
            if ($request->hasFile('logo')) {
                $logoname = env('APP_NAME') . time() . '.' . $request->file("logo")->extension();
                $imageurl = Helper::image_upload($request->file('logo'), 'settings', $logoname);
            }

            $iconurl = null;
            if ($request->hasFile('icon')) {
                $iconname = env('APP_NAME') . time() . '.' . $request->file("icon")->extension();
                $iconurl = Helper::image_upload($request->file('icon'), 'settings', $iconname);
            }

            $data = new Settings();
            $data->title = $title;
            $data->description = $description;
            $data->address = $address;
            $data->social_media = $social_media;
            $data->open_hours = $open_hours;
            $data->logo = $imageurl;
            $data->icon = $iconurl;
            $data->save();

            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
}
