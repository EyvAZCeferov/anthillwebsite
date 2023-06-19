<?php

namespace App\Helpers;

use App\Models\Orders;
use GuzzleHttp\Client;
use App\Models\Payments;
use GuzzleHttp\TransferStats;

class GuavaPay
{
    public static function createorder($order_id, $language)
    {
        $order = Payments::find($order_id);
        $params = [
            "userName" => env("GUAVAPAY_USERNAME"),
            "password" => env("GUAVAPAY_PASSWORD"),
            "orderNumber" => $order->data['orderid'],
            "amount" => intval($order->amount) ?? 1,
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
            "amount" => $amount * 100,
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
    public static function checkstatus($order_id, $language)
    {
        $order = Payments::where('transaction_id', $order_id)->first();
        $params = [
            "user" => env("GUAVAPAY_USERNAME"),
            "password" => env("GUAVAPAY_PASSWORD"),
            "sid" => env("GUAVAPAY_SID"),
            "mdorder" => $order_id,
        ];
        $client = new Client();
        // $urlbase=env('GUAVAPAY_URL');
        $urlbase = "https://epg.guavapay.com";
        $url = $urlbase . '/transaction/' . env('GUAVAPAY_BANK') . '/status';
        $response = $client->get($url, [
            'query' => $params
        ]);
        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody);
        $order->update(['frompayment' => $responseData]);
        return true;
    }
}
