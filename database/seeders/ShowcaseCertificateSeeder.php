<?php

namespace Database\Seeders;

use App\Models\ShowcaseCertificate;
use Illuminate\Database\Seeder;

class ShowcaseCertificateSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title_bn' => 'ইংলিশ ফোর ওয়ার্ক সনদ',
                'title_en' => 'English for Work Certificate',
                'subtitle_bn' => 'NSDA অনুমোদিত · Level 2',
                'subtitle_en' => 'NSDA Approved · Level 2',
                'image' => 'images/certificates/demo-english.jpg',
            ],
            [
                'title_bn' => 'জাপানিজ ভাষা সনদ',
                'title_en' => 'Japanese Language Certificate',
                'subtitle_bn' => 'JLPT ট্র্যাক · ৩ মাস',
                'subtitle_en' => 'JLPT Track · 3 Months',
                'image' => 'images/certificates/demo-japanese.jpg',
            ],
            [
                'title_bn' => 'হাউজ কিপিং সনদ',
                'title_en' => 'Housekeeping Certificate',
                'subtitle_bn' => 'দক্ষতা সনদ · Level 2',
                'subtitle_en' => 'Competency Certificate · Level 2',
                'image' => 'images/certificates/demo-housekeeping.jpg',
            ],
            [
                'title_bn' => 'এন্টারপ্রনারশিপ সনদ',
                'title_en' => 'Entrepreneurship Certificate',
                'subtitle_bn' => 'প্রিমিয়াম এক্সিলেন্স · Level 4',
                'subtitle_en' => 'Premium Excellence · Level 4',
                'image' => 'images/certificates/demo-entrepreneur.jpg',
            ],
        ];

        foreach ($rows as $i => $row) {
            ShowcaseCertificate::updateOrCreate(
                ['image' => $row['image']],
                $row + ['sort_order' => $i + 1, 'is_active' => true]
            );
        }
    }
}
