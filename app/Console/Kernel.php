<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
     
     protected $commands = [
         Commands\GreetingsWelcome::class,
         Commands\BeforeNumDays::class,
         Commands\LeaveBalance::class,
         Commands\TwiceMonth::class,
         Commands\TwiceMonth2::class,
         Commands\RoomStatus::class,
         Commands\LastLogin::class,
         Commands\TruckExpire::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('twicemonthend:sms')->monthlyOn(15, '9:00');
        $schedule->command('twicemonth:sms')->monthlyOn(1, '9:00');
        $schedule->command('beforenum:days')->dailyAt('9:00');
        $schedule->command('leave:balance')->yearlyOn(1, 1, '00:00');
         $schedule->command('truck:expire')->dailyAt('9:00');
        
        $schedule->command('roomstatus:change')->daily();
        
        
        $schedule->command('last:login')->cron('0 0 */7 * *');
        
        // $schedule->command('greetings:test')->everyMinute();
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
