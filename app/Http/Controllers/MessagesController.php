<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if(isset($request->sender_id) && !empty($request->sender_id)){
                $data=messages($request->sender_id,'sender');
            }else if(isset($request->receiver_id) && !empty($request->receiver_id)){
                $data=messages($request->receiver_id,'receiver');
            }else{
                $data = messages();
            }
            return view('messages.index', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $data = messages($id,'id');
            $data->delete();
            return redirect()->back()->with("success", "Uğurlu. Məlumat silindi");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        } finally {
            Helper::dbdeactive();
        }
    }
}
