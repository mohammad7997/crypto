<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Codenixsv\CoinGeckoApi\CoinGeckoClient;


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
        $client = new CoinGeckoClient();
        $data = $client->simple()->getPrice($this->cryptos_name'0x,bitcoin', $this->currency'usd,rub,gbp,aud');
    }
}
