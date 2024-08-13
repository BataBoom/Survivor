<?php

namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Events\IncomingPaymentEvent;

class IncomingPaymentController extends Controller
{


    public function index(Request $request)
    {
        $invoice = $request->all();

        log::debug($invoice);
        
        $status = false;
        $payment = Payment::updateOrCreate(
            [
                'payment_id' => $invoice['id'],
            ],
            [
                'payment_id' => $invoice['id'],
                'user_id' => $invoice['user_id'],
                'pool_id' =>  $invoice['survivor_pool'],
                'amount_usd' => $invoice['amount_original'],
                'amount_crypto' => $invoice['crypto_amount'],
                'crypto_method' => $invoice['crypto_currency'],
                'paid' => 1,
            ]);

        if ($payment->id)
        {

            Log::debug('incoming payment created successfully');

            //Regular Payment
            if($invoice['type'] === 1) {
                IncomingPaymentEvent::dispatch($payment, 1);
            } elseif($invoice['type'] === 2) {
                //Creator Payment
                IncomingPaymentEvent::dispatch($payment, 2);
            }

            return response()->json([
                'success' => 'true',
            ]);

        } else {

            Log::debug('incoming payment failed..');
            Log::debug($invoice);
            return response()->json([
                'success' => 'false',
            ]);
        }
        
    }
}