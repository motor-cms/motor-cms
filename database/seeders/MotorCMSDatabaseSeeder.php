<?php

namespace Motor\CMS\Database\Seeders;

use Illuminate\Database\Seeder;

class MotorCMSDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MotorCMSDefaultPageSeeder::class,
            MotorCMSDefaultPageNavigationTreeSeeder::class,
        ]);
    }
}
