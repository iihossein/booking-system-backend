<?php

namespace Database\Seeders;

use App\Models\Expertise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class ExpertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expertises = [
            [
                'name' => 'مغز و اعصاب',
                'image' => 'Brain@4x.png',
            ],
            [
                'name' => 'قلب و عروق',
                'image' => 'Heart@4x.png',
            ],
            [
                'name' => 'عمومی',
                'image' => 'Public@4x.png',
            ],
            [
                'name' => 'داخلی',
                'image' => 'Blood@4x.png',
            ],
            [
                'name' => 'ژنتیک',
                'image' => 'Gen@4x.png',
            ],
            [
                'name' => 'گوارش',
                'image' => 'Inner@4x.png',
            ],
            [
                'name' => 'مجاری ادراری',
                'image' => 'Bimari@4x.png',
            ],
            // [
            //     'name' => 'Dermatology',
            //     'image' => 'dermatology.png',
            // ],
            // [
            //     'name' => 'Cardiology',
            //     'image' => 'cardiology.jpg',
            // ],
            // [
            //     'name' => 'Dermatology',
            //     'image' => 'dermatology.jpg',
            // ],
            
        ];
        // ادامه داده‌های دیگر







        

        foreach ($expertises as $expertise) {
            $expertiseModel = Expertise::create([
                'name' => $expertise['name'],
            ]);

            $expertiseModel->addMedia(public_path('images/' . $expertise['image']))
                ->toMediaCollection('image');
        }
    }
}
