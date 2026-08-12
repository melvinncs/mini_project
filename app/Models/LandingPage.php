<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $table = 'LandingPage';

    protected $fillable = [
        'hero_badge_1', 'hero_badge_2', 'hero_badge_3',
        'hero_title_line1', 'hero_title_highlight', 'hero_title_line2',
        'hero_description', 'hero_btn_primary_text', 'hero_btn_secondary_text', 'hero_image',
        'drama_tag', 'drama_title', 'drama_desc',
        'artikel_tag', 'artikel_title', 'artikel_desc',
        'footer_brand_short', 'footer_brand_name', 'footer_description',
    ];

    // Selalu ambil (atau buat) baris pertama — landing page cuma punya 1 data
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'hero_description' => 'Temukan informasi drama terbaru, drama populer, detail pemeran, genre, rating, dan episode. Semua dalam satu platform.',
            'drama_desc' => 'Drama Korea terbaru yang sedang populer',
            'artikel_desc' => 'Berita, review, dan informasi menarik seputar drama Korea',
            'footer_description' => 'Portal informasi drama Korea terlengkap. Temukan drama terbaru, populer, detail pemeran, genre, rating, dan episode.',
        ]);
    }
}