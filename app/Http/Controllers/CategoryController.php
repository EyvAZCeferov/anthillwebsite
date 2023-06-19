<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\MetaSEO;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoryAttributes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('media.category.index');
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
            return view('media.category.create');
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
                'az_name' => 'required|string|max:255|min:1',
                'image' => 'image|mimes:jpg,jpeg,pjpeg,pjp,avif,jfif,bmp,ico,cur,png,gif,svg,webp,tif,tiff',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

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
                'tr_slug' => Str::slug(trim($name['tr_name'])),
            ];


            $imageName = "";
            if ($request->hasFile("image")) {
                $imageName = Helper::image_upload($request->file('image'), 'category');
            }

            $data = new Categories();
            $data->name = $name;
            $data->slugs = $slugs;
            $data->image = $imageName;
            $data->top_id = $request->top_id;
            $data->status = $request->status;
            $data->icon = $request->icon;
            $data->color = strtoupper($request->color) ?? null;
            $data->save();

           
            if (isset($request->attributesfor) && !empty($request->attributes)) {
                foreach ($request->attributes as $attribute) {
                    $categoryattribute = new CategoryAttributes();
                    $categoryattribute->category_id = $data->id;
                    $categoryattribute->attribute_group_id = $attribute;
                    $categoryattribute->save();
                }
            }

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
            $seo->type = "category";
            $seo->element_id = $data->id;
            $seo->save();

            return redirect(route("category.index"))->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = categories($id);
            return view('media.category.show', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Categories::where('id',$id)->with(["seo",'top_category','alt_categoryes','products','attributes'])->first();
            return view('media.category.edit', ['data' => $data]);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = categories($id);
            $validator = Validator::make($request->all(), [
                'az_name' => 'required|string|max:255|min:1',
                'image' => 'image|mimes:jpg,jpeg,pjpeg,pjp,avif,jfif,bmp,ico,cur,png,gif,svg,webp,tif,tiff',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            if ($request->hasFile('image')) {
                if (!empty($data->image)) {
                    Helper::delete_image($data->image, 'category');
                }
                $imageurl = Helper::image_upload($request->image, "category");
                $data->update([
                    'image' => $imageurl,
                ]);
            }

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
                'tr_slug' => Str::slug(trim($name['tr_name'])),
            ];
            $data = Categories::find($id);

            if ($request->hasFile("image")) {
                $imageName = Helper::image_upload($request->file('image'), 'category');
                $data->update(['image'=>$imageName]);
            }

            $data->name = $name;
            $data->slugs = $slugs;
            $data->top_id = $request->top_id ?? null;
            $data->status = $request->status??1;
            $data->icon = $request->icon;
            $data->color = strtoupper($request->color) ?? null;
            $data->update();
          
            if (isset($request->attributesfor) && !empty($request->attributesfor)) {
                foreach (CategoryAttributes::where('category_id', $id)->get() as $atta) {
                    $atta->delete();
                }
                foreach ($request->attributesfor as $attribute) {
                    $categoryattribute = new CategoryAttributes();
                    $categoryattribute->category_id = $data->id;
                    $categoryattribute->attribute_group_id = $attribute;
                    $categoryattribute->save();
                }
            }

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
                'az_meta_keywords' => $request->az_meta_keywords ?? $name['az_name'],
                'ru_meta_keywords' => $request->ru_meta_keywords ?? $name['ru_name'],
                'en_meta_keywords' => $request->en_meta_keywords ?? $name['en_name'],
            ];

            $seo = MetaSEO::where('type','category')->where("element_id",$id)->first();
            $seo->name = $meta_title;
            $seo->description = $meta_description;
            $seo->keywords = $meta_keywords;
            $seo->update();


            return redirect(route("category.index"))->with('info', 'Uğurlu');
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
    public function changeStat(Request $request, $id)
    {
        try {
            $category=categories($id);
            $category->update([
                "status" => !$request->status,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }finally{
            Helper::dbdeactive();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = categories($id);
            if (!empty($data->image)) {
                Helper::delete_image($data->image, 'category');
            }
           
            $data->delete();
            MetaSEO::where("element_id", $id)->where("type", 'category')->delete();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
}
