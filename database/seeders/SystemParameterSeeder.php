<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SystemParameter;

class SystemParameterSeeder extends Seeder
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
                'name' => 'Main title of the protocol pdf', 
                'key' => 'PDF_PROTOCOL_TITLE_1', 
                'value' => 'My Laboratory | Clinical, bacteriological and immunological analyzes', 
                'category' => 'PDF Protocol', 
                'description' => 'The title of the letterhead when generating a pdf protocol'
            ], [
                'name' => 'First line of the pdf protocol', 
                'key' => 'PDF_PROTOCOL_TEXT_LINE_1', 
                'value' => 'My street, my Country and my State of my Laboratory', 
                'category' => 'PDF Protocol', 
                'description' => 'First line of the letterhead when generating a PDF protocol'
            ], [
                'name' => 'Second line of the pdf protocol', 
                'key' => 'PDF_PROTOCOL_TEXT_LINE_2', 
                'value' => '+1 (212) 123-4567, secretary@mylaboratory.com', 
                'category' => 'PDF Protocol', 
                'description' => 'Second line of the letterhead when generating a PDF protocol'
            ],[
                'name' => 'Third line of the pdf protocol', 
                'key' => 'PDF_PROTOCOL_TEXT_LINE_3', 
                'value' => 'www.mylaboratory.com', 
                'category' => 'PDF Protocol', 
                'description' => 'Third line of the letterhead when generating a PDF protocol'
            ],
        ]);
    }
}
