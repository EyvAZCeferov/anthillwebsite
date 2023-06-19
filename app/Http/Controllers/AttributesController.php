<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Attributes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data=Attributes::orderBy("order_att",'ASC')->orderBy("id",'DESC')->get();
            return view('shops.products.attributes.index',compact('data'));
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
    public function store(Request $request)
    {
        try {
            $name = [
                'az_name' => $request->name['az_name'],
                'ru_name' => isset($request->name['ru_name']) ? $request->name['ru_name'] : trim(GoogleTranslate::trans($request->name['az_name'], 'ru')),
                'en_name' => isset($request->name['en_name']) ? $request->name['en_name'] : trim(GoogleTranslate::trans($request->name['az_name'], 'en')),
                'tr_name' => isset($request->name['tr_name']) ? $request->name['tr_name'] : trim(GoogleTranslate::trans($request->name['az_name'], 'tr')),
            ];

            $slugs = [
                'az_slug' => Str::slug(trim($name['az_name'])),
                'ru_slug' => Str::slug(trim($name['ru_name'])),
                'en_slug' => Str::slug(trim($name['en_name'])),
                'tr_slug' => Str::slug(trim($name['tr_name'])),
            ];

            $data = new Attributes();
            $data->name = $name;
            $data->slugs = $slugs;
            $data->group_id = $request->group_id;
            $data->datatype = $request->datatype;
            $data->order_att = $request->order ?? 1;
            $data->save();
            
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
            return false;
        }finally{
            Helper::dbdeactive();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data=Attributes::where('id',$id)->first();
            return response()->json($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getGroups()
    {
        try {
            $data=Attributes::whereNull("group_id")->get();
            return response()->json($data);
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
            Attributes::where("id", $id)->update([
                'name->az_name' => $request->name['az_name'],
                'name->ru_name' => isset($request->name['ru_name']) ? $request->name['ru_name'] : trim(GoogleTranslate::trans($request->name['az_name'], 'ru')),
                'name->en_name' => isset($request->name['en_name']) ? $request->name['en_name'] : trim(GoogleTranslate::trans($request->name['az_name'], 'en')),
                'name->tr_name' => isset($request->name['tr_name']) ? $request->name['tr_name'] : trim(GoogleTranslate::trans($request->name['az_name'], 'tr')),
                'slugs->az_slug' => Str::slug(trim($request->name['az_name'])),
                'slugs->ru_slug' => Str::slug(GoogleTranslate::trans(trim($request->name['az_name']),'ru')),
                'slugs->en_slug' => Str::slug(GoogleTranslate::trans(trim($request->name['az_name']),'en')),
                'slugs->tr_slug' => Str::slug(GoogleTranslate::trans(trim($request->name['az_name']),'tr')),
                'group_id' => $request->group_id,
                'datatype' => $request->datatype,
                'order_att' => $request->order ?? 1,
            ]);
            
            return true;
        } catch (\Exception $e) {
            return false;
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
        // try {
        //     Attributes::where("id", $id)->update([
        //         "filter" => !$request->filter,
        //     ]);
        //     return true;
        // } catch (\Exception $e) {
        //     return false;
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $attribute=Attributes::where("id",$id)->delete();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
}
