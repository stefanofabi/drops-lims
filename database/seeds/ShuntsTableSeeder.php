<?php

use Illuminate\Database\Seeder;
use App\Shunt;

class ShuntsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Shunt::insert([
            [
            'name' => "Laboratorio Sur",
            'mail' => "contacto@laboratoriosur.com.ar",
            'address' => "Fernandez Oro 42",
            'phone' => "4775293",
            ],
            [
            'name' => "Laboratorios IDAC",
            'mail' => "contacto@idac.com.ar",
            'address' => "Mengelle 1850",
            'phone' => "4776320",
            ]
        ]);
        
    }

}
