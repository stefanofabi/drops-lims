<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SystemParameter;

class GeneralSystemParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        SystemParameter::insert([
            [
                'name' => 'Laboratory name',
                'key' => 'LABORATORY_NAME',  
                'value' => 'My Laboratory', 
                'category' => 'General', 
                'description' => 'The name of your laboratory'
            ], [
                'name' => 'Logo',
                'key' => 'LOGO_IMAGE',  
                'value' => 'images/logo.png', 
                'category' => 'General', 
                'description' => 'The logo of your laboratory that will appear in the main menu, in the pdf protocols, in the emails sent, etc.'
            ], [
                'name' => 'Secretary Email',
                'key' => 'SECRETARY_EMAIL',  
                'value' => 'secretary@laboratory', 
                'category' => 'General', 
                'description' => 'This email is the one your patients will contact if they need help'
            ], [
                'name' => 'Date format',
                'key' => 'DATE_FORMAT',  
                'value' => 'Y-m-d', 
                'category' => 'General', 
                'description' => 'This will be the format in which the dates will be displayed both within the system and in emails and pdfs'
            ], [
                'name' => 'Decimals',
                'key' => 'DECIMALS',  
                'value' => '2', 
                'category' => 'General', 
                'description' => 'The number of decimals to display when the number is floating'
            ], [
                'name' => 'Decimal separator',
                'key' => 'DECIMAL_SEPARATOR',  
                'value' => '.', 
                'category' => 'General', 
                'description' => 'Decimal separator by which all system numbers, emails and pdfs will be formatted'
            ], [
                'name' => 'Thousands separator',
                'key' => 'THOUSANDS_SEPARATOR',  
                'value' => ',', 
                'category' => 'General', 
                'description' => 'Thousands separator by which all system numbers, emails and pdfs will be formatted'
            ]
            
        ]);
    }
}
