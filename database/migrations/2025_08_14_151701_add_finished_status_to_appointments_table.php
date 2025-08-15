<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFinishedStatusToAppointmentsTable extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE appointments
            MODIFY status ENUM('pending','confirmed','cancelled','finished') NOT NULL DEFAULT 'pending'
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE appointments
            MODIFY status ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending'
        ");
    }
}
