<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class SslCommerz
{
    public static function initPayment($request, $invoice)
    {
        $paymentUrl = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
        $store_id = "test_store";
        $store_passwd = "";

        $success_url = "http://127.0.0.1:8000/api/v1/success";
        $fail_url = "http://127.0.0.1:8000/api/v1/fail";
        $cancel_url = "http://127.0.0.1:8000/api/v1/cancel";
        $ipn_url = "http://127.0.0.1:8000api/v1/ipn";

        $response = Http::asForm()->post($paymentUrl, [
            'store_id' => $store_id,
            'store_passwd' => $store_passwd,
            'total_amount' => $invoice->total_amount,
            'currency' => 'BDT',
            'tran_id' => $invoice->invoice_id,
            'success_url' => $success_url.'?invoice_id='.$invoice->invoice_id,
            'fail_url' => $fail_url.'?invoice_id='.$invoice->invoice_id,
            'cancel_url' => $cancel_url.'?invoice_id='.$invoice->invoice_id,
            'ipn_url' => $ipn_url,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_mobile' => $request->mobile_no,
            'customer_address' => $request->address,
            'customer_city' => $request->city,
            'customer_state' => $request->state,
            'customer_postcode' => $request->post_code,
            'customer_country' => 'Bangladesh',
        ]);

        return $response->json();

    }
}
