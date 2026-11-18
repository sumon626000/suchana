<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['title_bn' => 'প্রশিক্ষণ ক্লাস', 'title_en' => 'Training Class', 'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=900&q=80&auto=format&fit=crop'],
            ['title_bn' => 'ক্লাসরুম', 'title_en' => 'Classroom', 'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=900&q=80&auto=format&fit=crop'],
            ['title_bn' => 'শিক্ষার্থী', 'title_en' => 'Students', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=900&q=80&auto=format&fit=crop'],
            ['title_bn' => 'ল্যাব', 'title_en' => 'Lab', 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=900&q=80&auto=format&fit=crop'],
            ['title_bn' => 'লাইব্রেরি', 'title_en' => 'Library', 'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=900&q=80&auto=format&fit=crop'],
        ];

        foreach ($rows as $i => $row) {
            Gallery::updateOrCreate(
                ['image' => $row['image']],
                $row + ['sort_order' => $i + 1, 'is_active' => true]
            );
        }
    }
}
