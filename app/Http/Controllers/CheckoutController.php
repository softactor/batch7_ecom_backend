<?php

namespace App\Http\Controllers;

use App\Events\PaymentEvent;
use App\Helpers\SslCommerz;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
        try{
            $user = auth()->user();

            $userCart = Cart::whereUserId($user->id)->get();
            if ($userCart->isEmpty())
                return $this->error(['Cart is empty'],400);

            $customerAddress = "Name:$request->name,Email:$request->email,Mobile:$request->mobile_no,City:$request->city,State:$request->state,PostCode:$request->post_code,Address:$request->address";

            $total = 0;
            foreach ($userCart as $cart) {
                $total += $cart->price * $cart->quantity;
            }

            $vat = ($total*3)/100;
            $payable = $total + $vat;

            $invoiceNo = 'INV-'.rand(100000,999999).'-'.date('Ymd').'-'.time();

            DB::beginTransaction();
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'invoice_no' => $invoiceNo,
                'total' => $total,
                'vat' => $vat,
                'payable' => $payable,
                'cust_details' => $customerAddress,
                'ship_details' => $customerAddress,
            ]);

            foreach ($userCart as $cart) {
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $cart['product_id'],
                    'quantity' => $cart['quantity'],
                    'unit_price' => $cart['price'],
                    'total_price' => $cart['price'] * $cart['quantity'],
                    'color' => $cart['color'],
                    'size' => $cart['size'],
                ]);
            }

            Cart::whereUserId($user->id)->delete();

            DB::commit();

            $sslResponse = SSLCommerz::initPayment($request, $invoice);

            return $this->success($sslResponse,['Invoice created successfully']);

        }catch (\Exception $e){
            DB::rollBack();
            return $this->error(['Something went wrong'],500);
        }



    }
}
