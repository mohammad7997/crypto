<?php

namespace App\Jobs;

use App\Models\Crypto;
use App\Events\DataCrypto;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;


class StoreCrypto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cryptos_name;
    protected $currency;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cryptos_name,$currency)
    {
        $this->cryptos_name = $cryptos_name;
        $this->currency = $currency;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get information from coin gecko client
        $client = new CoinGeckoClient();
        $information = $client->simple()->getPrice($this->cryptos_name, $this->currency);

        // save or update data
        foreach($information as $key => $data)
        {
            Crypto::updateOrCreate(
                // matches parameter
                ['crypto_name' => $key],

                // save parameter
                [
                'crypto_name' => $key,
                'usd' =>  $data['usd'],
                'gbp' =>  $data['gbp'],
                'aud' =>  $data['aud'],
                'rub' =>  $data['rub'],
            ]);
        }

        event(new DataCrypto($information));
        
    }
}
