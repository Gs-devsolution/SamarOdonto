<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class AppointmentPresenter extends Presenter
{
    public function status(): string
    {
        switch ($this->entity->status) {
            case 'pending':
                return 'Pendente';
            case 'confirmed':
                return 'Confirmado';
            case 'cancelled':
                return 'Cancelado';
            case 'finished':
                return 'Finalizado';
            default:
                // fallback seguro caso apareça algo fora do esperado
                return ucfirst((string) $this->entity->status);
        }
    }
}
