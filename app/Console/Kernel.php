<?php

namespace App\Console;

use App\Console\Commands\CheckKeywords;
use App\Console\Commands\CheckPhoneNumbers;
use App\Console\Commands\CheckSenderID;
use App\Console\Commands\CheckSessionWhatSender;
use App\Console\Commands\CheckSubscription;
use App\Console\Commands\CheckUserPreferences;
use App\Console\Commands\CleanDatabase;
use App\Console\Commands\ClearCampaign;
use App\Console\Commands\DiafaanDLR;
use App\Console\Commands\InitPlugin;
use App\Console\Commands\RunAutomation;
use App\Console\Commands\RunCampaign;
use App\Console\Commands\RunEveryTenSeconds;
use App\Console\Commands\SendScheduleAPIMessage;
use App\Console\Commands\SMPPDLRReports;
use App\Console\Commands\UpdateDemo;
use App\Console\Commands\UpdateImartGroupDLR;
use App\Console\Commands\VisionUpInboundMessage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            CheckSubscription::class,
            CheckKeywords::class,
            CheckPhoneNumbers::class,
            CheckSenderID::class,
            CheckUserPreferences::class,
            RunCampaign::class,
            UpdateDemo::class,
            VisionUpInboundMessage::class,
            UpdateImartGroupDLR::class,
            CheckSessionWhatSender::class,
            ClearCampaign::class,
            SendScheduleAPIMessage::class,
            RunAutomation::class,
            SMPPDLRReports::class,
            RunEveryTenSeconds::class,
            InitPlugin::class,
            CleanDatabase::class,
            DiafaanDLR::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('queue:work --queue=automation,default,batch --timeout=120 --tries=1 --max-time=180 --stop-when-empty')->everyMinute();
        $schedule->command('campaign:run')->everyMinute();
        $schedule->command('sms:schedule-api-message')->everyMinute();
        $schedule->command('subscription:check')->hourly();
        $schedule->command('keywords:check')->daily();
        $schedule->command('numbers:check')->daily();
        $schedule->command('senderid:check')->daily();
        $schedule->command('user:preferences')->daily();
        $schedule->command('automation:run')->everyFiveMinutes();
        $schedule->command('app:clean-database')->daily();

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
