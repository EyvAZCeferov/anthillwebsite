<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Helpers\Helper;
use App\Models\CouponCodes;
use Illuminate\Http\Request;

class RaportsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $couponcodes = CouponCodes::orderBy('id', 'DESC')->get();
            $title = 'Kupon Kodlar';
            $data = [];
            $parametr = [
                'coupon_id' => $request->coupon_id ?? null,
                'starttime' => $request->starttime ?? null,
                'endtime' => $request->endtime ?? null,
                'totalpricewithoutcoupon' => 0,
                'totalpricewithcoupon' => 0,
                'totalcourierprice' => 0,
            ];

            if (isset($parametr['coupon_id']) && !empty($parametr['coupon_id']) && empty($parametr['starttime']) && $parametr['endtime']) {
                // $data = CouponCodes::whereBetween('created_at', [$request->starttime, $request->endtime])->get();
                $coupon = CouponCodes::find($parametr['coupon_id']);
                $data = Orders::where('coupon_id', $coupon->id)->orderBy('id', 'DESC')->where('status', '>', 1)->get();
                $title = $coupon->name['az_name'] . ' (' . count($data) . ')';
                $parametr['totalpricewithoutcoupon'] = $this->calculate($data, 'totalpricewithoutcoupon');
                $parametr['totalpricewithcoupon'] = $this->calculate($data, 'totalpricewithcoupon');
                $parametr['totalcourierprice'] = $this->calculate($data, 'totalcourierprice');
            } else if (isset($parametr['starttime']) && !empty($parametr['starttime']) && empty($parametr['endtime']) && empty($parametr['coupon_id'])) {
                $data = Orders::orderBy('id', 'DESC')->where('status', '>', 1)->whereBetween('created_at', [$request->starttime, now()])->get();
                $title = 'Sifarişlər ' . ' (' . count($data) . ')';
                $parametr['totalpricewithoutcoupon'] = $this->calculate($data, 'totalpricewithoutcoupon');
                $parametr['totalpricewithcoupon'] = $this->calculate($data, 'totalpricewithcoupon');
                $parametr['totalcourierprice'] = $this->calculate($data, 'totalcourierprice');
            } else if (empty($parametr['coupon_id']) && isset($parametr['starttime']) && !empty($parametr['starttime']) && isset($parametr['endtime']) && !empty($parametr['endtime'])) {
                $data = Orders::orderBy('id', 'DESC')->where('status', '>', 1)->whereBetween('created_at', [$request->starttime, $request->endtime])->get();
                $title = 'Sifarişlər ' . ' (' . count($data) . ')';
                $parametr['totalpricewithoutcoupon'] = $this->calculate($data, 'totalpricewithoutcoupon');
                $parametr['totalpricewithcoupon'] = $this->calculate($data, 'totalpricewithcoupon');
                $parametr['totalcourierprice'] = $this->calculate($data, 'totalcourierprice');
            } else if (isset($parametr['coupon_id']) && !empty($parametr['coupon_id']) && isset($parametr['starttime']) && !empty($parametr['starttime']) && isset($parametr['endtime']) && !empty($parametr['endtime'])) {
                $coupon = CouponCodes::find($parametr['coupon_id']);
                $data = Orders::where('coupon_id', $coupon->id)->orderBy('id', 'DESC')->where('status', '>', 1)->whereBetween('created_at', [$request->starttime, $request->endtime])->get();
                $title = $coupon->name['az_name'] . ' (' . count($data) . ')';
                $parametr['totalpricewithoutcoupon'] = $this->calculate($data, 'totalpricewithoutcoupon');
                $parametr['totalpricewithcoupon'] = $this->calculate($data, 'totalpricewithcoupon');
                $parametr['totalcourierprice'] = $this->calculate($data, 'totalcourierprice');
            }
            return view('raports.index', compact('data', 'title', 'parametr', 'couponcodes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }finally{
            Helper::dbdeactive();
        }
    }
    public function calculate($orders, $type)
    {
        try{if ($type == 'totalpricewithoutcoupon') {
            $price = 0;
            foreach ($orders as $order) {
                $price += floatval($order->price);
            }
            return $price;
        } else if ($type == 'totalpricewithcoupon') {
            $price = 0;
            foreach ($orders as $order) {
                $price += floatval($order->action_price);
            }
            return $price;
        } else if ($type == 'totalcourierprice') {
            $price = 0;
            foreach ($orders as $order) {
                $price += floatval($order->courier_price);
            }
            return $price;
        }}catch(\Exception $e){
            return $e->getMessage();
        }finally{
            Helper::dbdeactive();
        }
    }
}
