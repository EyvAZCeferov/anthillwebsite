<?php

namespace App\Helpers;

use App\Models\Orders;
use GuzzleHttp\Client;
use App\Models\Payments;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\DB;

class GUAVAPAY
{
    public static function createorder($order_id, $language)
    {
        $order = Payments::find($order_id);
        $params = [
            "userName" => env("GUAVAPAY_USERNAME"),
            "password" => env("GUAVAPAY_PASSWORD"),
            "orderNumber" => $order->data['orderid'],
            "amount" => intval($order->amount) * 100 ?? 1,
            "currency" => "978",
            "language" => 'en',
            "returnUrl" => route("guavapay.callback"),
            "jsonParams" => '{"request":"PAY","bank":"' . env("GUAVAPAY_BANK") . '","description":"' . $order->data['name'][$language . '_name'] . '","sid":"' . env("GUAVAPAY_SID") . '"}'
        ];
        $client = new Client();
        $url = env("GUAVAPAY_URL") . '/epg/rest/register.do';

        $response = $client->get($url, [
            'query' => $params
        ]);
        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody);
        $order->update(['transaction_id' => $responseData->orderId]);

        return $responseData->formUrl;
    }
    public static function refund($order_id, $amount, $language = 'az')
    {
        $order = Payments::find($order_id);
        $params = [
            "userName" => env("GUAVAPAY_USERNAME"),
            "password" => env("GUAVAPAY_PASSWORD"),
            "orderId" => $order->transaction_id,
            "amount" => intval($amount) * 100,
            "jsonParams" => '{"request":"PAY","bank":"' . env("GUAVAPAY_BANK") . '","description":"' . $order->data['name'][$language . '_name'] . '","sid":"' . env("GUAVAPAY_SID") . '"}'
        ];
        $client = new Client();
        $url = env("GUAVAPAY_URL") . '/epg/rest/refund.do';

        $response = $client->get($url, [
            'query' => $params
        ]);
        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody);
        if (!isset($responseData->errorCode) && empty($responseData->errorCode)) {
            $order->update(['amount' => $amount]);
            return $responseData;
        } else {
            return 'error';
        }
    }
    public static function checkstatus($order_id)
    {
        $order = Payments::where('transaction_id', $order_id)->first();
        $params = [
            "user" => env("GUAVAPAY_USERNAME"),
            "password" => env("GUAVAPAY_PASSWORD"),
            "sid" => env("GUAVAPAY_SID"),
            "mdorder" => $order_id,
        ];
        $client = new Client();
        $url = env('GUAVAPAY_URL') . '/transaction/' . env('GUAVAPAY_BANK') . '/status';
        $response = $client->post($url, [
            'query' => $params
        ]);
        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody, true);
        $neworder = Orders::where('id',$order->data['order_id'])->first();
        if(isset($responseData->Success) && $responseData->Success==true){
            $order->payment_status=1;
            $order->save();
        }
        $order->update(['frompayment' => $responseData]);
        if(!empty($neworder) && isset($neworder->id)){
            return $neworder;
        }
    }
}
