<?php

use Illuminate\Database\Seeder;

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
        DB::table('shunts')->insert([
            'name' => "Laboratorio Sur",
            'mail' => "contacto@laboratoriosur.com.ar",
            'address' => "Fernandez Oro 42",
            'phone' => "4775293",
        ]);


        DB::table('shunts')->insert([
            'name' => "Laboratorios IDAC",
            'mail' => "contacto@idac.com.ar",
            'address' => "Mengelle 1850",
            'phone' => "4776320",
        ]);
    }

}
