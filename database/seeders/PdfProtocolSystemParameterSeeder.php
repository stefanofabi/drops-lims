<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SystemParameter;

class PdfProtocolSystemParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        SystemParameter::insert([
            [
                'name' => 'Main title of the protocol pdf', 
                'key' => 'PDF_PROTOCOL_TITLE_1', 
                'value' => 'My Laboratory | Clinical, bacteriological and immunological analyzes', 
                'category' => 'PDF Protocol', 
                'description' => 'The title of the letterhead when generating a pdf protocol'
            ], [
                'name' => 'First line of the pdf protocol', 
                'key' => 'PDF_PROTOCOL_TEXT_LINE_1', 
                'value' => 'My street, My Country and My State of My Laboratory', 
                'category' => 'PDF Protocol', 
                'description' => 'First line of the letterhead when generating a PDF protocol'
            ], [
                'name' => 'Second line of the pdf protocol', 
                'key' => 'PDF_PROTOCOL_TEXT_LINE_2', 
                'value' => '+1 (212) 123-4567, secretary@mylaboratory.com', 
                'category' => 'PDF Protocol', 
                'description' => 'Second line of the letterhead when generating a PDF protocol'
            ], [
                'name' => 'Third line of the pdf protocol', 
                'key' => 'PDF_PROTOCOL_TEXT_LINE_3', 
                'value' => 'www.mylaboratory.com', 
                'category' => 'PDF Protocol', 
                'description' => 'Third line of the letterhead when generating a PDF protocol'
            ], [
                'name' => 'Letterhead Font Family', 
                'key' => 'PDF_PROTOCOL_LETTERHEAD_FONT_FAMILY', 
                'value' => 'monospace, system-ui', 
                'category' => 'PDF Protocol', 
                'description' => 'The font family used in the pdf protocol letterhead. You can specify alternative sources by separating them with commas'
            ], [
                'name' => 'Letterhead background color', 
                'key' => 'PDF_PROTOCOL_LETTERHEAD_BACKGROUND_COLOR', 
                'value' => '#FFFFA6', 
                'category' => 'PDF Protocol', 
                'description' => 'The font family used in the pdf protocol letterhead. You can specify alternative sources by separating them with commas'
            ], [
                'name' => 'Protocol Information Font Family', 
                'key' => 'PDF_PROTOCOL_INFO_FONT_FAMILY', 
                'value' => 'monospace, system-ui', 
                'category' => 'PDF Protocol', 
                'description' => 'The font family used in the pdf protocol information. You can specify alternative sources by separating them with commas'
            ], [
                'name' => 'Protocol Information background color', 
                'key' => 'PDF_PROTOCOL_PROTOCOL_INFORMATION_BACKGROUND_COLOR', 
                'value' => '#F2EFEE', 
                'category' => 'PDF Protocol', 
                'description' => 'The font family used in the pdf protocol information. You can specify alternative sources by separating them with commas'
            ], [
                'name' => 'Font Family', 
                'key' => 'PDF_PROTOCOL_FONT_FAMILY', 
                'value' => 'Times, system-ui', 
                'category' => 'PDF Protocol', 
                'description' => 'The font family used in the pdf protocol. You can specify alternative sources by separating them with commas'
            ]
            
        ]);
    }
}
