<?php

use App\Jobs\SendDailySalesReportJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new SendDailySalesReportJob())
    ->dailyAt(env('DAILY_SALES_REPORT_TIME', '20:00'))
    ->timezone(config('app.timezone', 'UTC'))
    ->name('daily-sales-report');
