<?php

namespace App\Http\Services;

use App\Models\Pool;
use Illuminate\Support\Facades\Http;
use App\Models\User;

/***
 *
 * $this sends outgoing payment invoice to user.
 * Merchant: https://github.com/BataBoom/SatsBB
 *
 ****/
class InvoiceGenerator {

    public $total;
    public $type;

    public function __construct(public User $user, public Pool $pool)
    {
        if($this->user->id == $this->pool->creator_id) {
            $this->total = $this->pool->entry_cost + $pool->guaranteed_prize + 5;
            $this->type = 2;
        } else {
            $this->total =  $this->pool->entry_cost;
            $this->type = 1;
        }
    }

    private function create()
    {


        try {
            $response = Http::accept('application/json')->post("https://".env('MERCHANT_DOMAIN').'/api/createSurvivorInvoice?auth_token='.env('MERCHANT_TOKEN'),[
                'user_id' => $this->user->id,
                'username' => $this->user->name,
                'amount' => $this->total,
                'ip' => '0.0.0.0', //must be set
                'duration' => '365 days', //must be set
                'type'=> $this->type,
                'product'=> $this->pool->id,
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
