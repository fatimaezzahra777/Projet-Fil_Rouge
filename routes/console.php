<?php

use App\Models\Activite;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('activites:finalize-expired', function () {
    Activite::Fin();

    $this->info('Les activites expirees ont ete finalisees.');
})->purpose('Attribue les points des activites passees puis supprime ces activites');

Schedule::command('activites:finalize-expired')->dailyAt('00:10');
