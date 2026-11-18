<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffDemoSeeder extends Seeder
{
    public function run(): void
    {
        // AI-generated demo portraits (randomuser.me) + short bios.
        $rows = [
            [
                'name' => 'Md. Abdul Karim',
                'photo' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'bio' => 'প্রতিষ্ঠানের চেয়ারম্যান; শিক্ষা ও ব্যবস্থাপনায় ২০+ বছরের অভিজ্ঞতা।',
            ],
            [
                'name' => 'Prof. Rahim Uddin',
                'photo' => 'https://randomuser.me/api/portraits/men/45.jpg',
                'bio' => 'ভাইস চেয়ারম্যান; কারিকুলাম ও প্রশিক্ষণের মান উন্নয়নে নেতৃত্ব দেন।',
            ],
            [
                'name' => 'Engr. Shahidul Islam',
                'photo' => 'https://randomuser.me/api/portraits/men/12.jpg',
                'bio' => 'ব্যবস্থাপনা পরিচালক; প্রযুক্তি ও অবকাঠামো উন্নয়নে দায়িত্বপ্রাপ্ত।',
            ],
            [
                'name' => 'Dr. Nasrin Sultana',
                'photo' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'bio' => 'প্রশিক্ষণ পরিচালক; স্বাস্থ্য ও টেকনিক্যাল কোর্স তত্ত্বাবধান করেন।',
            ],
            [
                'name' => 'Md. Trainer',
                'photo' => 'https://randomuser.me/api/portraits/men/78.jpg',
                'bio' => 'প্রধান প্রশিক্ষক; ইংরেজি ও জাপানিজ ভাষা প্রশিক্ষণে অভিজ্ঞ।',
            ],
        ];

        foreach ($rows as $row) {
            Staff::where('name', $row['name'])->update([
                'photo' => $row['photo'],
                'bio' => $row['bio'],
            ]);
        }
    }
}
