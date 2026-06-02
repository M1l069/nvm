<?php

namespace App\Console\Commands;

use App\Enums\InstrumentReservationStatus;
use App\Models\InstrumentReservation;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('reservations:check-overdue-reservations')]
#[Description('Zmení status rezerváciam nástroja na status po termíne')]
class CheckOverdueReservations extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $affectedRows = InstrumentReservation::where('to', '<=', now())
        ->where('status', '!=', InstrumentReservationStatus::Completed->value)
        ->where('status', '!=', InstrumentReservationStatus::Overdue->value)
            ->update(['status' => InstrumentReservationStatus::Overdue->value]);

        $this->info('Úspešne aktualizovaných {$affectedRows} rezervácií nástroja na status po termíne.');
        return 0;
    }
}
