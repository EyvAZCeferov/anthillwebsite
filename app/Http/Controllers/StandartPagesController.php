<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\MetaSEO;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StandartPages;
use App\Models\AdditionalPictures;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class StandartPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = StandartPages::orderBy('created_at','DESC')->get();
            return view('sayt.standartpages.index', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('sayt.standartpages.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|min:3',
                'az_description' => 'required|min:3',
                'type'=>"required|string"
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $description = [
                'az_description' => $request->az_description,
                'ru_description' => isset($request->ru_description) ? $request->ru_description : trim(GoogleTranslate::trans($request->az_description, 'ru')),
                'en_description' => isset($request->en_description) ? $request->en_description : trim(GoogleTranslate::trans($request->az_description, 'en')),
                'tr_description' => isset($request->tr_description) ? $request->tr_description : trim(GoogleTranslate::trans($request->az_description, 'tr')),
            ];

            $name = [
                'az_name' => $request->az_name,
                'ru_name' => isset($request->ru_name) ? $request->ru_name : trim(GoogleTranslate::trans($request->az_name, 'ru')),
                'en_name' => isset($request->en_name) ? $request->en_name : trim(GoogleTranslate::trans($request->az_name, 'en')),
                'tr_name' => isset($request->tr_name) ? $request->tr_name : trim(GoogleTranslate::trans($request->az_name, 'tr')),
            ];

            $slugs = [
                'az_slug' => Str::slug(trim($name['az_name'])),
                'ru_slug' => Str::slug(trim($name['ru_name'])),
                'en_slug' => Str::slug(trim($name['en_name'])),
            ];

            $image = null;
            if ($request->hasFile('image')) {
                $logoname = env('APP_NAME') . time() . '.' . $request->file("image")->extension();
                $image = Helper::image_upload($request->file('image'), 'standartpages', $logoname);
            }

            $about = new StandartPages();
            $about->name = $name;
            $about->slugs = $slugs;
            $about->description = $description;
            $about->type = $request->type;
            $about->image = $image;
            $about->save();


            $meta_title = [
                'az_meta_title' => trim($request->az_meta_title) ?? $name['az_name'],
                'ru_meta_title' => $request->ru_meta_title ?? $name['ru_name'],
                'en_meta_title' => $request->en_meta_title ?? $name['en_name'],
            ];

            $meta_description = [
                'az_meta_description' => trim($request->az_meta_description) ?? $meta_title['az_meta_title'],
                'ru_meta_description' => $request->ru_meta_description ?? $meta_title['ru_meta_title'],
                'en_meta_description' => $request->en_meta_description ?? $meta_title['en_meta_title'],
            ];

            $meta_keywords = [
                'az_meta_keywords' => $request->az_meta_keywords ?? trim($name['az_name']),
                'ru_meta_keywords' => $request->ru_meta_keywords ?? trim($name['ru_name']),
                'en_meta_keywords' => $request->en_meta_keywords ?? trim($name['en_name']),
            ];

        
            $seo = new MetaSEO();
            $seo->name = $meta_title;
            $seo->description = $meta_description;
            $seo->keywords = $meta_keywords;
            $seo->type = "standartpages";
            $seo->element_id = $about->id;
            $seo->save();

            return redirect(route('standartpages.index'))->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StandartPages  $standartpage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = StandartPages::where("id", $id)->first();
            return view('sayt.standartpages.create', ['data' => $data]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|min:3',
                'az_description' => 'required|min:3',
                'type'=>"required|string"
              
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $standartpage = StandartPages::find($id);

            $name = [
                'az_name' => trim($request->az_name),
                'ru_name' => $request->ru_name ?? trim(GoogleTranslate::trans($request->az_name, 'ru')),
                'en_name' => $request->en_name ?? trim(GoogleTranslate::trans($request->az_name, 'en')),
            ];

            $description = [
                'az_description' => trim($request->az_description) ?? null,
                'ru_description' => $request->ru_description ?? trim(GoogleTranslate::trans($request->az_description, 'ru')),
                'en_description' => $request->en_description ?? trim(GoogleTranslate::trans($request->az_description, 'en')),
            ];

            $slugs = [
                'az_slug' => Str::slug(trim($name['az_name'])),
                'ru_slug' => Str::slug(trim($name['ru_name'])),
                'en_slug' => Str::slug(trim($name['en_name'])),
            ];

            if ($request->hasFile('image')) {
                $imagename = env('APP_NAME') . time() . '.' . $request->file("image")->extension();
                $imageurl = Helper::image_upload($request->file('image'), 'standartpages', $imagename);

                $standartpage->update([
                    'image' => $imageurl,
                ]);
            }

            $standartpage->name = $name;
            $standartpage->slugs = $slugs;
            $standartpage->description = $description;
            $standartpage->type = $request->type;
            $standartpage->update();


            $meta_title = [
                'az_meta_title' => trim($request->az_meta_title) ?? $name['az_name'],
                'ru_meta_title' => $request->ru_meta_title ?? $name['ru_name'],
                'en_meta_title' => $request->en_meta_title ?? $name['en_name'],
            ];

            $meta_description = [
                'az_meta_description' => trim($request->az_meta_description) ?? $meta_title['az_meta_title'],
                'ru_meta_description' => $request->ru_meta_description ?? $meta_title['ru_meta_title'],
                'en_meta_description' => $request->en_meta_description ?? $meta_title['en_meta_title'],
            ];

            $meta_keywords = [
                'az_meta_keywords' => $request->az_meta_keywords ?? trim($name['az_name']),
                'ru_meta_keywords' => $request->ru_meta_keywords ?? trim($name['ru_name']),
                'en_meta_keywords' => $request->en_meta_keywords ?? trim($name['en_name']),
            ];

        
            $seo = MetaSEO::where('type','standartpages')->where("element_id",$id)->first();
            $seo->name = $meta_title;
            $seo->description = $meta_description;
            $seo->keywords = $meta_keywords;
            $seo->type = "standartpages";
            $seo->element_id = $standartpage->id;
            $seo->update();
            return redirect(route('standartpages.index'))->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StandartPages  $standartpages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {           
            StandartPages::where("id", $id)->delete();
            return redirect()->back()->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
    public function uploadimg(){
        return view('sayt.standartpages.uploadimg');
    }
}
