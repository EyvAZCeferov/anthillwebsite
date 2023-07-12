<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\LangProperties;
use Illuminate\Http\Request;

class LangPropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = lang_properties();
            return view('sayt.lang_properties.index', ['data' => $data]);
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
            return view('sayt.lang_properties.create_edit');
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
            $data = lang_properties($request->keyword, 'keyword');
            if (!empty($data)) {
                return redirect()->back()->with('error', trans('additional.messages.dataisfound'));
            } else {
                $data=new LangProperties();
                $data->keyword=$request->keyword;
                $data->lang=$request->lang??'en';
                $data->name=$request->name;
                $data->save();

                return redirect(route('lang_properties.index'))->with('success', trans('additional.messages.created'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
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
            $data = lang_properties($id, 'id');
            return view('sayt.lang_properties.create_edit', compact('data'));
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
            $data = lang_properties($id, 'id');
            if (empty($data)) {
                return redirect()->back()->with('error', trans('additional.forms.notfound'));
            } else {
                $data->lang=$request->lang??'en';
                $data->name=$request->name;
                $data->update();
                return redirect(route('lang_properties.index'))->with('success', trans('additional.messages.updated'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
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
            $data = lang_properties($id, 'id');
            $data->delete();
            return redirect()->back()->with('success', trans('additional.messages.deleted'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
}
