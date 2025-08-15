<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class FinishPastAppointments extends Command
{
    protected $signature = 'appointments:finish';
    protected $description = 'Marca como finished (azul) todos os agendamentos confirmados já encerrados';

    public function handle()
    {
        $now = Carbon::now()->toDateTimeString();

        $count = Appointment::query()
            ->where('status', 'confirmed')
            ->where('end_date', '<', $now)
            ->update([
                'status'     => 'finished',
                'color'      => 'blue',
                'updated_at' => $now,
            ]);

        $this->info("Finalizados: {$count}");
        return 0;
    }
}
