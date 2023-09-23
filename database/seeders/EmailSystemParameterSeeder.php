<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SystemParameter;

class EmailSystemParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        SystemParameter::insert([
            [
                'name' => 'Email title', 
                'key' => 'EMAIL_TITLE_1', 
                'value' => 'Clinical and bacteriological analysis Laboratory', 
                'category' => 'Email', 
                'description' => 'The header title of all emails'
            ], [
                'name' => 'Font size title', 
                'key' => 'EMAIL_FONT_SIZE_TITLE', 
                'value' => '18px', 
                'category' => 'Email', 
                'description' => 'The font size of the header title'
            ], [
                'name' => 'Email subtitle', 
                'key' => 'EMAIL_SUBTITLE_1', 
                'value' => 'My street, My Country and My State of My Laboratory - Phone +1 (212) 123-4567', 
                'category' => 'Email', 
                'description' => 'The header subtitle of all emails'
            ], [
                'name' => 'Font size subtitle', 
                'key' => 'EMAIL_FONT_SIZE_SUBTITLE', 
                'value' => '12px', 
                'category' => 'Email', 
                'description' => 'The font size of the header subtitle'
            ], [
                'name' => 'Font Family', 
                'key' => 'EMAIL_FONT_FAMILY', 
                'value' => 'monospace, system-ui', 
                'category' => 'Email', 
                'description' => 'The font family used in the pdf protocol. You can specify alternative sources by separating them with commas'
            ], [
                'name' => 'Box background', 
                'key' => 'EMAIL_BOX_BACKGROUND', 
                'value' => '#aedcf0', 
                'category' => 'Email', 
                'description' => 'The background color of the header and footer. You would like it to be according to the colors that represent your laboratory'
            ]
            
        ]);
    }
}
