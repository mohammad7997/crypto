<?php

namespace App\Console;

use Carbon\Carbon;
use App\Jobs\StoreCrypto;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $seconds = 3;
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {

            $dt = Carbon::now();
            $x  = 60 / $this->seconds;

            do {
                StoreCrypto::dispatch(env('CRYPTOS_NAME','0x,absorber,bitcoin,tron,tether,eos,litecoin,ethereum,abulaba,acala'),'usd,rub,gbp,aud');

                time_sleep_until($dt->addSeconds($this->seconds)->timestamp);
            } while ($x-- > 0);
        })
        ->everyMinute();



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
