<?php

namespace App\Http\Controllers;

use Image;
use App\Helpers\Helper;
use App\Models\Sliders;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Sliders::all();
            return view('media.sliders.index', ['data' => $data]);
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
            return view('media.sliders.create_edit');
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
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,png,gif,svg',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $description = [
                'az_description' => trim($request->az_description) ?? null,
                'ru_description' => $request->ru_description ?? trim($request->az_description) ? trim(GoogleTranslate::trans($request->az_description, 'ru')) : null,
                'en_description' => $request->en_description ?? trim($request->az_description) ? trim(GoogleTranslate::trans($request->az_description, 'en')) : null,
            ];

            $fileName = "slider-" . time() . '.' . $request->file("image")->extension();
            $path = public_path('uploads/sliders/' . $fileName);

            Image::make($request->file("image")->getRealPath())->encode('jpg', 70)
                    ->save($path);


            $data = new Sliders();
            $data->description = $description;
            $data->image = $fileName;
            $data->url = $request->url;
            $data->order = $request->order;
            $data->save();
            return redirect(route("sliders.index"))->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
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
            return view('media.sliders.create_edit', ['data' => Sliders::where("id", $id)->first()]);
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
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpg,png,gif,svg',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $data =  Sliders::find($id);


            if ($request->hasFile("image")) {
                if (Storage::disk("uploads")->exists("sliders/" . Sliders::where("id", $id)->first()->image)) {
                    Storage::disk("uploads")->delete("sliders/" . Sliders::where("id", $id)->first()->image);
                }
                $fileName = "slider-" . time() . '.' . $request->file("image")->extension();
                $path = public_path('uploads/sliders/' . $fileName);

                Image::make($request->file("image")->getRealPath())->encode('jpg', 70)
                        ->save($path);


                $data->update([
                    'image' => $fileName
                ]);
            }

            $description = [
                'az_description' => trim($request->az_description) ?? null,
                'ru_description' => $request->ru_description ?? trim($request->az_description) ? trim(GoogleTranslate::trans($request->az_description, 'ru')) : null,
                'en_description' => $request->en_description ?? trim($request->az_description) ? trim(GoogleTranslate::trans($request->az_description, 'en')) : null,
            ];


            $data->description = $description;
            $data->url = $request->url;
            $data->order = $request->order;
            $data->update();
            return redirect(route("sliders.index"))->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
            if (Storage::disk("uploads")->exists("sliders/" . Sliders::where("id", $id)->first()->image)) {
                Storage::disk("uploads")->delete("sliders/" . Sliders::where("id", $id)->first()->image);
            }
            Sliders::where("id", $id)->delete();
            return redirect()->back()->with('info', trans('additional.messages.successful'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
