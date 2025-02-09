<?php

namespace Database\Seeders;

use App\Enums\ContactEnum;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raws = [
            [
                'type' => ContactEnum::PHONE,
                'data' => ['phone' => '+38 (050) 024 34 92'],
                'is_active' => true,
            ],
            [
                'type' => ContactEnum::EMAIL,
                'data' => ['email' => 'clothing.store@gmail.com'],
                'is_active' => true,
            ],            
            [
                'type' => ContactEnum::ADDRESS,
                'data' => ['address' => 'м. Луцьк, вул. Львівська, 75', 'coordinates' => '50.72617174210902, 25.29612439992365'],
                'is_active' => true,
            ],
        ];

        foreach ($raws as $index => $raw) {
            Contact::firstOrCreate([
                'type' => $raw['type'],
            ],[
                'data' => $raw['data'],
                'is_active' => $raw['is_active'],
            ]);
        }
    }
}
