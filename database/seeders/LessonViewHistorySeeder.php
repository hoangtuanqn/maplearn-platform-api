<?php

namespace Database\Seeders;

use App\Models\LessonViewHistory;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class LessonViewHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = Payment::where('status', 'paid')->get();
        foreach ($payments as $payment) {
            $course = $payment->course;
            $lessons = $course->lessons;
            foreach ($lessons as $lesson) {
                LessonViewHistory::create([
                    'user_id' => $payment->user_id,
                    'lesson_id' => $lesson->id,
                    'progress' => $lesson->duration,
                    'is_completed' => true,
                    'created_at' => now(),
                ]);
            }
        }
    }
}
