<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Branch;
use App\Models\Course;
use App\Models\District;
use App\Models\Notice;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Admin',
            'username' => 'admin',
            'email' => 'admin@suchana.test',
            'mobile' => '01700000000',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $trainer = User::create([
            'name' => 'Md. Trainer',
            'username' => 'trainer',
            'email' => 'trainer@suchana.test',
            'mobile' => '01700000001',
            'password' => 'password',
            'role' => 'trainer',
        ]);

        $student = User::create([
            'name' => 'Demo Student',
            'username' => 'student',
            'email' => 'student@suchana.test',
            'mobile' => '01700000002',
            'password' => 'password',
            'role' => 'student',
        ]);

        foreach ([
            ['name' => 'Md. Abdul Karim', 'designation' => 'Chairman', 'sort_order' => 1],
            ['name' => 'Prof. Rahim Uddin', 'designation' => 'Vice Chairman', 'sort_order' => 2],
            ['name' => 'Engr. Shahidul Islam', 'designation' => 'Managing Director', 'sort_order' => 3],
            ['name' => 'Dr. Nasrin Sultana', 'designation' => 'Director (Training)', 'sort_order' => 4],
            ['name' => 'Md. Trainer', 'designation' => 'Chief Instructor', 'sort_order' => 5],
        ] as $staff) {
            Staff::create($staff);
        }

        $courses = [
            [
                'name_bn' => 'ইংলিশ ফোর ওয়ার্ক',
                'name_en' => 'English for Work',
                'level' => 'Level 2',
                'duration_bn' => '২১ দিন',
                'duration_en' => '21 Days',
                'eligibility_bn' => 'কমপক্ষে অষ্টম শ্রেণি পাস, বয়স ১৮–৪৫ বছর',
                'eligibility_en' => 'Minimum Class 8 pass, age 18-45',
                'description_bn' => 'কর্মক্ষেত্রে ইংরেজি যোগাযোগ, সিভি ও ইন্টারভিউ দক্ষতা।',
                'description_en' => 'Workplace English, CV and interview skills.',
                'seats_total' => 40,
                'seats_available' => 40,
                'fee' => 0,
                'stipend_male' => 4500,
                'stipend_female' => 6000,
                'image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80&auto=format&fit=crop',
                'application_deadline' => now()->addMonths(2),
                'sort_order' => 1,
            ],
            [
                'name_bn' => 'জাপানিজ ভাষা',
                'name_en' => 'Japanese Language',
                'level' => 'Level 2',
                'duration_bn' => '৩ মাস',
                'duration_en' => '3 Months',
                'eligibility_bn' => 'এইচএসসি পাস, বয়স ১৮–৪০ বছর',
                'eligibility_en' => 'HSC pass, age 18-40',
                'description_bn' => 'JLPT N5/N4 প্রস্তুতি ও জাপানে কাজের সুযোগ।',
                'description_en' => 'JLPT N5/N4 preparation and job opportunities in Japan.',
                'seats_total' => 30,
                'seats_available' => 30,
                'fee' => 0,
                'stipend_male' => 4500,
                'stipend_female' => 6000,
                'image' => 'https://images.unsplash.com/photo-1480796927426-f609979314bd?w=1200&q=80&auto=format&fit=crop',
                'application_deadline' => now()->addMonths(2),
                'sort_order' => 2,
            ],
            [
                'name_bn' => 'হাউজ কিপিং',
                'name_en' => 'Housekeeping',
                'level' => 'Level 2',
                'duration_bn' => '২১ দিন',
                'duration_en' => '21 Days',
                'eligibility_bn' => 'কমপক্ষে অষ্টম শ্রেণি পাস, বয়স ১৮–৪৫ বছর',
                'eligibility_en' => 'Minimum Class 8 pass, age 18-45',
                'description_bn' => 'হোটেল, রেস্টুরেন্ট ও হাসপাতালের হাউজ কিপিং দক্ষতা।',
                'description_en' => 'Housekeeping skills for hotels, restaurants and hospitals.',
                'seats_total' => 40,
                'seats_available' => 40,
                'fee' => 0,
                'stipend_male' => 4500,
                'stipend_female' => 6000,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1200&q=80&auto=format&fit=crop',
                'application_deadline' => now()->addMonths(2),
                'sort_order' => 3,
            ],
            [
                'name_bn' => 'এন্টারপ্রনারশিপ ডেভেলপমেন্ট',
                'name_en' => 'Entrepreneurship Development',
                'level' => 'Level 4',
                'duration_bn' => '২ মাস',
                'duration_en' => '2 Months',
                'eligibility_bn' => 'স্নাতক বা ডিপ্লোমা, বয়স ২০–৪৫ বছর',
                'eligibility_en' => 'Graduate or Diploma, age 20-45',
                'description_bn' => 'ব্যবসায়িক আইডিয়া, বাজার সম্প্রসারণ ও ব্যবস্থাপনা দক্ষতা।',
                'description_en' => 'Business ideas, market expansion and management skills.',
                'seats_total' => 25,
                'seats_available' => 25,
                'fee' => 0,
                'stipend_male' => 4500,
                'stipend_female' => 6000,
                'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200&q=80&auto=format&fit=crop',
                'application_deadline' => now()->addMonths(2),
                'sort_order' => 4,
            ],
        ];

        $courseModels = [];
        foreach ($courses as $course) {
            $courseModels[] = Course::create($course);
        }

        $batches = [
            ['course' => 0, 'name_bn' => 'ব্যাচ ০১', 'name_en' => 'Batch 01', 'time_bn' => 'শনি–বৃহঃ, সকাল ৯টা–১২টা', 'time_en' => 'Sat–Thu, 9 AM–12 PM', 'seats' => 40],
            ['course' => 1, 'name_bn' => 'ব্যাচ ০২', 'name_en' => 'Batch 02', 'time_bn' => 'রবি–বৃহঃ, বিকাল ৩টা–৫টা', 'time_en' => 'Sun–Thu, 3 PM–5 PM', 'seats' => 30],
            ['course' => 2, 'name_bn' => 'ব্যাচ ০৩', 'name_en' => 'Batch 03', 'time_bn' => 'শনি–সোম, সকাল ১০টা–১টা', 'time_en' => 'Sat–Mon, 10 AM–1 PM', 'seats' => 40],
            ['course' => 3, 'name_bn' => 'ব্যাচ ০৪', 'name_en' => 'Batch 04', 'time_bn' => 'শুক্র–শনি, বিকাল ২টা–৫টা', 'time_en' => 'Fri–Sat, 2 PM–5 PM', 'seats' => 25],
        ];

        foreach ($batches as $batch) {
            Batch::create([
                'course_id' => $courseModels[$batch['course']]->id,
                'trainer_id' => $trainer->id,
                'name_bn' => $batch['name_bn'],
                'name_en' => $batch['name_en'],
                'time_bn' => $batch['time_bn'],
                'time_en' => $batch['time_en'],
                'seats' => $batch['seats'],
            ]);
        }

        foreach ([
            ['name_bn' => 'প্রধান শাখা, ঢাকা', 'name_en' => 'Main Branch, Dhaka', 'address' => 'House 12, Road 5, Dhanmondi, Dhaka 1205', 'phone' => '01700000000'],
            ['name_bn' => 'চট্টগ্রাম শাখা', 'name_en' => 'Chattogram Branch', 'address' => 'Jamal Khan, Chattogram 4000', 'phone' => '01700000010'],
            ['name_bn' => 'রাজশাহী শাখা', 'name_en' => 'Rajshahi Branch', 'address' => 'Shaheb Bazar, Rajshahi 6100', 'phone' => '01700000020'],
            ['name_bn' => 'খুলনা শাখা', 'name_en' => 'Khulna Branch', 'address' => 'Shibbari, Khulna 9100', 'phone' => '01700000030'],
        ] as $i => $branch) {
            Branch::create($branch + ['sort_order' => $i + 1]);
        }

        foreach ([
            ['title_bn' => 'ভর্তি চলছে — নতুন ব্যাচ শুরু', 'title_en' => 'Admission Open — New Batches Starting', 'body_bn' => 'সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণে ভর্তি চলছে। দ্রুত আবেদন করুন।', 'body_en' => 'Free government-funded training admission is open. Apply early.', 'type' => 'admission'],
            ['title_bn' => 'পরীক্ষার সময়সূচি প্রকাশ', 'title_en' => 'Exam Schedule Published', 'body_bn' => 'সকল কোর্সের চূড়ান্ত পরীক্ষার সময়সূচি প্রকাশ করা হয়েছে।', 'body_en' => 'Final exam schedules for all courses have been published.', 'type' => 'exam'],
            ['title_bn' => 'ফলাফল প্রকাশ', 'title_en' => 'Result Published', 'body_bn' => 'গত ব্যাচের ফলাফল প্রকাশিত হয়েছে। লগইন করে দেখুন।', 'body_en' => 'Results of the last batch are published. Please log in to view.', 'type' => 'result'],
        ] as $i => $notice) {
            Notice::create($notice + ['published_at' => now()->subDays($i), 'is_active' => true]);
        }

        $this->call(SettingsSeeder::class);

        $districts = [
            ['Dhaka', 'ঢাকা', 'Dhaka', 'ঢাকা'], ['Gazipur', 'গাজীপুর', 'Dhaka', 'ঢাকা'], ['Narayanganj', 'নারায়ণগঞ্জ', 'Dhaka', 'ঢাকা'],
            ['Narsingdi', 'নরসিংদী', 'Dhaka', 'ঢাকা'], ['Manikganj', 'মানিকগঞ্জ', 'Dhaka', 'ঢাকা'], ['Munshiganj', 'মুন্সিগঞ্জ', 'Dhaka', 'ঢাকা'],
            ['Tangail', 'টাঙ্গাইল', 'Dhaka', 'ঢাকা'], ['Kishoreganj', 'কিশোরগঞ্জ', 'Dhaka', 'ঢাকা'], ['Faridpur', 'ফরিদপুর', 'Dhaka', 'ঢাকা'],
            ['Gopalganj', 'গোপালগঞ্জ', 'Dhaka', 'ঢাকা'], ['Madaripur', 'মাদারীপুর', 'Dhaka', 'ঢাকা'], ['Shariatpur', 'শরীয়তপুর', 'Dhaka', 'ঢাকা'],
            ['Rajbari', 'রাজবাড়ী', 'Dhaka', 'ঢাকা'],
            ['Chattogram', 'চট্টগ্রাম', 'Chattogram', 'চট্টগ্রাম'], ['Cox\'s Bazar', 'কক্সবাজার', 'Chattogram', 'চট্টগ্রাম'], ['Noakhali', 'নোয়াখালী', 'Chattogram', 'চট্টগ্রাম'],
            ['Lakshmipur', 'লক্ষ্মীপুর', 'Chattogram', 'চট্টগ্রাম'], ['Feni', 'ফেনী', 'Chattogram', 'চট্টগ্রাম'], ['Cumilla', 'কুমিল্লা', 'Chattogram', 'চট্টগ্রাম'],
            ['Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', 'Chattogram', 'চট্টগ্রাম'], ['Chandpur', 'চাঁদপুর', 'Chattogram', 'চট্টগ্রাম'], ['Khagrachhari', 'খাগড়াছড়ি', 'Chattogram', 'চট্টগ্রাম'],
            ['Rangamati', 'রাঙ্গামাটি', 'Chattogram', 'চট্টগ্রাম'], ['Bandarban', 'বান্দরবান', 'Chattogram', 'চট্টগ্রাম'],
            ['Rajshahi', 'রাজশাহী', 'Rajshahi', 'রাজশাহী'], ['Bogura', 'বগুড়া', 'Rajshahi', 'রাজশাহী'], ['Pabna', 'পাবনা', 'Rajshahi', 'রাজশাহী'],
            ['Sirajganj', 'সিরাজগঞ্জ', 'Rajshahi', 'রাজশাহী'], ['Natore', 'নাটোর', 'Rajshahi', 'রাজশাহী'], ['Naogaon', 'নওগাঁ', 'Rajshahi', 'রাজশাহী'],
            ['Chapainawabganj', 'চাঁপাইনবাবগঞ্জ', 'Rajshahi', 'রাজশাহী'], ['Joypurhat', 'জয়পুরহাট', 'Rajshahi', 'রাজশাহী'],
            ['Khulna', 'খুলনা', 'Khulna', 'খুলনা'], ['Jashore', 'যশোর', 'Khulna', 'খুলনা'], ['Satkhira', 'সাতক্ষীরা', 'Khulna', 'খুলনা'],
            ['Bagerhat', 'বাগেরহাট', 'Khulna', 'খুলনা'], ['Kushtia', 'কুষ্টিয়া', 'Khulna', 'খুলনা'], ['Jhenaidah', 'ঝিনাইদহ', 'Khulna', 'খুলনা'],
            ['Magura', 'মাগুরা', 'Khulna', 'খুলনা'], ['Narail', 'নড়াইল', 'Khulna', 'খুলনা'], ['Chuadanga', 'চুয়াডাঙ্গা', 'Khulna', 'খুলনা'],
            ['Meherpur', 'মেহেরপুর', 'Khulna', 'খুলনা'],
            ['Barishal', 'বরিশাল', 'Barishal', 'বরিশাল'], ['Patuakhali', 'পটুয়াখালী', 'Barishal', 'বরিশাল'], ['Bhola', 'ভোলা', 'Barishal', 'বরিশাল'],
            ['Pirojpur', 'পিরোজপুর', 'Barishal', 'বরিশাল'], ['Barguna', 'বরগুনা', 'Barishal', 'বরিশাল'], ['Jhalokathi', 'ঝালকাঠি', 'Barishal', 'বরিশাল'],
            ['Sylhet', 'সিলেট', 'Sylhet', 'সিলেট'], ['Moulvibazar', 'মৌলভীবাজার', 'Sylhet', 'সিলেট'], ['Habiganj', 'হবিগঞ্জ', 'Sylhet', 'সিলেট'],
            ['Sunamganj', 'সুনামগঞ্জ', 'Sylhet', 'সিলেট'],
            ['Rangpur', 'রংপুর', 'Rangpur', 'রংপুর'], ['Dinajpur', 'দিনাজপুর', 'Rangpur', 'রংপুর'], ['Gaibandha', 'গাইবান্ধা', 'Rangpur', 'রংপুর'],
            ['Kurigram', 'কুড়িগ্রাম', 'Rangpur', 'রংপুর'], ['Lalmonirhat', 'লালমনিরহাট', 'Rangpur', 'রংপুর'], ['Nilphamari', 'নীলফামারী', 'Rangpur', 'রংপুর'],
            ['Panchagarh', 'পঞ্চগড়', 'Rangpur', 'রংপুর'], ['Thakurgaon', 'ঠাকুরগাঁও', 'Rangpur', 'রংপুর'],
            ['Mymensingh', 'ময়মনসিংহ', 'Mymensingh', 'ময়মনসিংহ'], ['Jamalpur', 'জামালপুর', 'Mymensingh', 'ময়মনসিংহ'], ['Netrokona', 'নেত্রকোণা', 'Mymensingh', 'ময়মনসিংহ'],
            ['Sherpur', 'শেরপুর', 'Mymensingh', 'ময়মনসিংহ'],
        ];

        foreach ($districts as $d) {
            District::create(['name_en' => $d[0], 'name_bn' => $d[1], 'division_en' => $d[2], 'division_bn' => $d[3]]);
        }

        $this->call(ThanaSeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(ShowcaseCertificateSeeder::class);
        $this->call(NotificationTemplateSeeder::class);
        $this->call(StaffDemoSeeder::class);
        $this->call(BranchImageSeeder::class);
    }
}
