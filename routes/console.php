<?php

use App\Jobs\SendDailySalesReportJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new SendDailySalesReportJob())
    ->dailyAt(env('DAILY_SALES_REPORT_TIME', '18:06'))
    ->timezone(config('app.timezone', 'UTC'))
    ->before(fn () => Log::info('Scheduler: daily-sales-report starting', [
        'at' => now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
    ]))
    ->after(fn () => Log::info('Scheduler: daily-sales-report finished', [
        'at' => now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
    ]))
    ->onFailure(fn () => Log::error('Scheduler: daily-sales-report failed', [
        'at' => now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
    ]))
    ->name('daily-sales-report');
