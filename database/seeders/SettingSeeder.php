<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['title', 'MapLearn - Định vị tri thức - dẫn lối tư duy'],
            ['keywords', ''],
            ['description', ''],
            ['logo_url', ''],
            // ['banner', ['']]
            ['address', 'Thủ Đức, TP.HCM'],
            ['phone', '0812665001'],
            ['email', 'phamhoangtuanqn@gmail.com'],
            ['facebook', [
                'name' => 'Facebook MapLearn',
                'value' => 'https://www.facebook.com/mapstudy.vn'
            ]],
            ['youtube', [
                'name' => 'Thầy Vũ Ngọc Anh - Chuyên luyện thi Vật lý',
                'value' => 'https://www.youtube.com/@thayvnachuyenluyenthivatly'
            ]],
            ['tiktok', [
                'name' => 'Thầy Vũ Ngọc Anh - Chuyên luyện thi Vật lý',
                'value' => 'https://www.youtube.com/@thayvnachuyenluyenthivatly'
            ]],
            ['messenger', [
                'name' => 'Messenger MapLearn',
                'value' => 'https://www.facebook.com/messages/t/105592185119255'
            ]],
            ['maintenance_mode', '0'] // bảo trì
        ];


        foreach ($settings as $setting) {
            $value = is_array($setting[1]) ? json_encode($setting[1]) : $setting[1];

            Setting::create([
                'name' => $setting[0],
                'value' => $value
            ]);
        }
    }
}
