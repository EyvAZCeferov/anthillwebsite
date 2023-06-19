<?php

namespace App\Http\Controllers;

use Image;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BackgroundImages;
use Illuminate\Support\Facades\Storage;

class BackgroundImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = BackgroundImages::orderBy('created_at','DESC')->get();
            return view('media.background_images.index', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
            $pages=['register','login','forget_password','reset_password','new_password'];
            return view('media.background_images.create_edit', ['pages' => $pages]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
            $data=new BackgroundImages();
            $imageurl=null;
            if ($request->hasFile("image")) {
                $imageName = Str::slug($request->type) . "-image-" . time() . '.' . $request->file("image")->extension();
                $path = public_path('uploads/bgimages/' . $imageName);

                Image::make($request->file("image")->getRealPath())->encode('jpg', 70)
                    ->save($path);
                $imageurl=$imageName;
            }

            $data->image=$imageurl;
            $data->type=$request->type;
            $data->save();
            return redirect(route('background_images.index'))->with('success','Əlavə edildi');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $pages=['register','login','forget_password','reset_password','new_password'];
            $data=BackgroundImages::find($id);
            return view('media.background_images.create_edit', ['pages' => $pages,'data'=>$data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
            $data=BackgroundImages::find($id);
            if ($request->hasFile("image")) {
                $imageName = Str::slug($request->type) . "-image-" . time() . '.' . $request->file("image")->extension();
                $path = public_path('uploads/bgimages/' . $imageName);

                Image::make($request->file("image")->getRealPath())->encode('jpg', 70)
                    ->save($path);
                $data->update([
                    "image" => $imageName,
                ]);
            }

            $data->update([
                "type"=>$request->type
            ]);
            return redirect(route('background_images.index'))->with('success','Yeniləndi');

        } catch (\Exception $e) {
            return false;
        }finally{
            Helper::dbdeactive();
        }
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
            if (Storage::disk("uploads")->exists("bgimages/" . BackgroundImages::where("id", $id)->first()->image)) {
                Storage::disk("uploads")->delete("bgimages/" . BackgroundImages::where("id", $id)->first()->image);
            }

            BackgroundImages::where("id", $id)->delete();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
}
