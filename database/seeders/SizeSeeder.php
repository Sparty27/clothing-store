<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Універсальний',
            'XS',
            'S',
            'M',
            'L',
            'XL',
            'XXL',
            'XXXL',
            'XXXXL',
        ];

        for ($i=34; $i < 50; $i++) { 
            $data[] = $i;
        }

        foreach ($data as $size) {
            Size::firstOrCreate([
                'name' => $size,
            ]);
        }
    }
}
