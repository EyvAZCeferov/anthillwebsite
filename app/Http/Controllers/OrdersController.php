<?php

namespace App\Http\Controllers;

use App\Helpers\GuavaPay;
use App\Models\Orders;
use App\Helpers\Helper;
use App\Mail\GeneralMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Orders::orderBy("id", 'DESC')->with(['from','touser'])->get();
            return view('orders.index', compact("data"));
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
        return redirect()->back()->with("error", "Səhifə tapılmadı");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back()->with("error", "Səhifə tapılmadı");
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
            $data = orders($id, 'id');
            return view('orders.show', ['data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        return redirect()->back()->with("error", "Səhifə tapılmadı");
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
        return redirect()->back()->with("error", "Səhifə tapılmadı");
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
            $data = Orders::find($id);
            $data->delete();
            return redirect()->back()->with('info', 'Uğurlu');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
    public function changestatus($id, Request $request)
    {
        try {
            $order = orders($id, 'id');
            $order->update([
                "status" => $request->status
            ]);
            
            Mail::send(new GeneralMail('order', $order->to_id, $id));

            return redirect()->back()->with("success", 'Status dəyişdirildi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }

    public function refund($id,Request $request){
        try{
            $order=Orders::find($id);
            $guavapayresult=GuavaPay::refund($order->payment->id,$request->price,'az');
            if(!empty($guavapayresult));
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
}
