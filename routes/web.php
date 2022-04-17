<?php

use Illuminate\Support\Facades\Route;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $client = new CoinGeckoClient();
    // // // $data = $client->ping();
    // $data = $data = $client->simple()->getPrice('0x,absorber,bitcoin,tron,tether,eos,litecoin,ethereum,abulaba,acala', 'usd,rub,gbp,aud');
    // // // $data = $data = $client->coins()->getList();
    // dd($data);

    return view('welcome');
});
