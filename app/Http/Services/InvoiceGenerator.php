<?php

namespace App\Http\Services;

use App\Models\SurvivorRegistration;
use Illuminate\Support\Facades\Http;
use App\Models\User;

/***
 *
 * $this sends outgoing payment invoice to user.
 *
 ****/
class InvoiceGenerator {


    public function __construct(public User $user, public SurvivorRegistration $survivorRegistration)
    {
       //
    }

    private function getTotal()
    {
        return $this->survivorRegistration->pool->entry_cost + 5;
    }

    private function create()
    {


        try {
            $response = Http::accept('application/json')->post("https://".env('MERCHANT_DOMAIN').'/api/createCashiersInvoice?auth_token='.env('MERCHANT_TOKEN'),[
                'user_id' => $this->user->id,
                'username' => $this->user->name,
                'amount' => $this->getTotal(),
                'ip' => '0.0.0.0', //must be set
                'duration' => '365 days', //must be set
                'shop_hash' => $this->survivorRegistration->id,
                'type'=> 69, //must
                'product'=> 0, //must be set
            ]);

            if ($response->ok())
            {
                return $response->json('invoice_url');
            }
        } catch(\Throwable $e)
        {
            report($e);
        }

        return false;
    }

    public function render()
    {
        return $this->create();
    }

    public function makeInvoice()
    {
        return $this->create();
    }

}