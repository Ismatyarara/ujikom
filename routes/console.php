<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



use Illuminate\Support\Facades\Schedule;

// ... isi yang sudah ada sebelumnya ...

Schedule::command('obat:kirim-reminder')->everyMinute();
