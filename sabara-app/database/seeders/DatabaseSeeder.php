<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Materi;
use App\Models\Percakapan;
use App\Models\SoalLatihan;
use App\Models\SoalKuis;
use App\Models\Kamus;
use App\Models\SoundEffect;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin SABARA',
            'email' => 'admin@sabara.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create demo user
        $user = User::create([
            'name' => 'User Demo',
            'email' => 'user@sabara.id',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create Language: Bahasa Bengkulu
        $bengkulu = Language::create([
            'code' => 'bengkulu',
            'name' => 'Bahasa Bengkulu',
            'is_active' => true,
        ]);

        // Update user selected language
        $user->update(['selected_language_id' => $bengkulu->id]);
        $admin->update(['selected_language_id' => $bengkulu->id]);

        // Create sample Materi
        $materi1 = Materi::create([
            'language_id' => $bengkulu->id,
            'title' => 'Sapaan & Salam',
            'category' => 'Percakapan Sehari-hari',
            'description' => 'Belajar sapaan dan salam dalam Bahasa Bengkulu',
        ]);

        $materi2 = Materi::create([
            'language_id' => $bengkulu->id,
            'title' => 'Di Pasar',
            'category' => 'Percakapan Sehari-hari',
            'description' => 'Belajar percakapan jual beli di pasar',
        ]);

        $materi3 = Materi::create([
            'language_id' => $bengkulu->id,
            'title' => 'Angka & Bilangan',
            'category' => 'Kosakata Dasar',
            'description' => 'Belajar angka dan bilangan dalam Bahasa Bengkulu',
        ]);

        // Create sample Percakapan for Materi 1
        Percakapan::create([
            'materi_id' => $materi1->id,
            'indonesia' => 'Selamat pagi, apa kabar?',
            'bengkulu' => 'Selamat pagi, apo kaba?',
            'speaker' => '1',
            'order_index' => 0,
        ]);
        Percakapan::create([
            'materi_id' => $materi1->id,
            'indonesia' => 'Baik, terima kasih. Kamu dari mana?',
            'bengkulu' => 'Baik, terimo kasih. Kau dari mano?',
            'speaker' => '2',
            'order_index' => 1,
        ]);
        Percakapan::create([
            'materi_id' => $materi1->id,
            'indonesia' => 'Saya dari Bengkulu. Senang bertemu denganmu.',
            'bengkulu' => 'Aku dari Bengkulu. Senang betemu dengan kau.',
            'speaker' => '1',
            'order_index' => 2,
        ]);

        // Create sample Soal Latihan for Materi 1
        SoalLatihan::create([
            'materi_id' => $materi1->id,
            'question' => 'Apa arti "Apo kaba?" dalam Bahasa Indonesia?',
            'options' => json_encode(['Apa kabar?', 'Siapa kamu?', 'Dari mana?', 'Mau kemana?']),
            'answer' => 'Apa kabar?',
            'type' => 'multiple_choice',
            'level' => 1,
            'star' => 1,
        ]);
        SoalLatihan::create([
            'materi_id' => $materi1->id,
            'question' => 'Bagaimana mengatakan "Terima kasih" dalam Bahasa Bengkulu?',
            'options' => json_encode(['Terimo kasih', 'Makasih nian', 'Terima kasih', 'Suwun']),
            'answer' => 'Terimo kasih',
            'type' => 'multiple_choice',
            'level' => 1,
            'star' => 1,
        ]);
        SoalLatihan::create([
            'materi_id' => $materi1->id,
            'question' => 'Pasangkan kata berikut:',
            'options' => json_encode([
                ['indonesia' => 'Selamat pagi', 'bengkulu' => 'Selamat pagi'],
                ['indonesia' => 'Apa kabar', 'bengkulu' => 'Apo kaba'],
                ['indonesia' => 'Terima kasih', 'bengkulu' => 'Terimo kasih'],
            ]),
            'answer' => 'correct_order',
            'type' => 'matching',
            'level' => 1,
            'star' => 2,
        ]);

        // Create sample Soal Kuis
        SoalKuis::create([
            'language_id' => $bengkulu->id,
            'question' => 'Apa arti kata "nian" dalam Bahasa Bengkulu?',
            'options' => json_encode(['Sangat/sekali', 'Tidak', 'Banyak', 'Sedikit']),
            'answer' => 'Sangat/sekali',
            'difficulty' => 'Mudah',
        ]);
        SoalKuis::create([
            'language_id' => $bengkulu->id,
            'question' => 'Bagaimana mengatakan "Saya mau makan" dalam Bahasa Bengkulu?',
            'options' => json_encode(['Aku ndak makan', 'Aku nak makan', 'Sayo nak makan', 'Aku mau makan']),
            'answer' => 'Aku nak makan',
            'difficulty' => 'Sedang',
        ]);

        // Create sample Kamus
        Kamus::create([
            'indonesia' => 'Apa kabar',
            'bengkulu' => 'Apo kaba',
            'contoh' => 'Apo kaba? Lamo dak jumpo.',
        ]);
        Kamus::create([
            'indonesia' => 'Terima kasih',
            'bengkulu' => 'Terimo kasih',
            'contoh' => 'Terimo kasih nian yo.',
        ]);
        Kamus::create([
            'indonesia' => 'Sangat/sekali',
            'bengkulu' => 'Nian',
            'contoh' => 'Raso nyo enak nian.',
        ]);

        // Create Sound Effects
        SoundEffect::create([
            'type' => 'correct',
            'label' => 'Jawaban Benar',
            'audio_url' => '/audio/sound_effects/correct.mp3',
        ]);
        SoundEffect::create([
            'type' => 'wrong',
            'label' => 'Jawaban Salah',
            'audio_url' => '/audio/sound_effects/wrong.mp3',
        ]);
        SoundEffect::create([
            'type' => 'complete',
            'label' => 'Latihan Selesai',
            'audio_url' => '/audio/sound_effects/complete.mp3',
        ]);
    }
}
