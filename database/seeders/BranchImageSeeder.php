<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'Main Branch, Dhaka' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=900&q=80&auto=format&fit=crop',
            'Chattogram Branch' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=900&q=80&auto=format&fit=crop',
            'Rajshahi Branch' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=900&q=80&auto=format&fit=crop',
            'Khulna Branch' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=900&q=80&auto=format&fit=crop',
        ];

        foreach ($images as $name => $image) {
            Branch::where('name_en', $name)->update(['image' => $image]);
        }
    }
}
