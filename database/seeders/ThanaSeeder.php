<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Thana;
use Illuminate\Database\Seeder;

class ThanaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Dhaka' => 'Savar|সাভার,Dhamrai|ধামরাই,Keraniganj|কেরানীগঞ্জ,Nawabganj|নবাবগঞ্জ,Dohar|দোহার',
            'Gazipur' => 'Gazipur Sadar|গাজীপুর সদর,Kaliakair|কালিয়াকৈর,Kaliganj|কালীগঞ্জ,Kapasia|কাপাসিয়া,Sreepur|শ্রীপুর',
            'Narayanganj' => 'Araihazar|আড়াইহাজার,Bandar|বন্দর,Narayanganj Sadar|নারায়ণগঞ্জ সদর,Rupganj|রূপগঞ্জ,Sonargaon|সোনারগাঁও',
            'Narsingdi' => 'Belabo|বেলাবো,Monohardi|মনোহরদী,Narsingdi Sadar|নরসিংদী সদর,Palash|পলাশ,Raipura|রায়পুরা,Shibpur|শিবপুর',
            'Manikganj' => 'Daulatpur|দৌলতপুর,Ghior|ঘিওর,Harirampur|হরিরামপুর,Manikganj Sadar|মানিকগঞ্জ সদর,Saturia|সাটুরিয়া,Shibalaya|শিবালয়,Singair|সিংগাইর',
            'Munshiganj' => 'Gazaria|গজারিয়া,Lohajang|লৌহজং,Munshiganj Sadar|মুন্সিগঞ্জ সদর,Sirajdikhan|সিরাজদিখান,Sreenagar|শ্রীনগর,Tongibari|টংগীবাড়ী',
            'Tangail' => 'Basail|বাসাইল,Bhuapur|ভূঞাপুর,Delduar|দেলদুয়ার,Dhanbari|ধনবাড়ী,Ghatail|ঘাটাইল,Gopalpur|গোপালপুর,Kalihati|কালিহাতী,Madhupur|মধুপুর,Mirzapur|মির্জাপুর,Nagarpur|নাগরপুর,Sakhipur|সখীপুর,Tangail Sadar|টাঙ্গাইল সদর',
            'Kishoreganj' => 'Austagram|অষ্টগ্রাম,Bajitpur|বাজিতপুর,Bhairab|ভৈরব,Hossainpur|হোসেনপুর,Itna|ইটনা,Karimganj|করিমগঞ্জ,Katiadi|কটিয়াদী,Kishoreganj Sadar|কিশোরগঞ্জ সদর,Kuliarchar|কুলিয়ারচর,Mithamain|মিঠামইন,Nikli|নিকলী,Pakundia|পাকুন্দিয়া,Tarail|তারাইল',
            'Faridpur' => 'Alfadanga|আলফাডাঙ্গা,Bhanga|ভাঙ্গা,Boalmari|বোয়ালমারী,Charbhadrasan|চরভদ্রাসন,Faridpur Sadar|ফরিদপুর সদর,Madhukhali|মধুখালী,Nagarkanda|নগরকান্দা,Sadarpur|সদরপুর,Saltha|সালথা',
            'Gopalganj' => 'Gopalganj Sadar|গোপালগঞ্জ সদর,Kashiani|কাশিয়ানী,Kotalipara|কোটালীপাড়া,Muksudpur|মুকসুদপুর,Tungipara|টুংগীপাড়া',
            'Madaripur' => 'Kalkini|কালকিনি,Madaripur Sadar|মাদারীপুর সদর,Rajoir|রাজৈর,Shibchar|শিবচর,Dasar|ডাসার',
            'Shariatpur' => 'Bhedarganj|ভেদরগঞ্জ,Damudya|ডামুড্যা,Gosairhat|গোসাইরহাট,Naria|নড়িয়া,Shariatpur Sadar|শরীয়তপুর সদর,Zanjira|জাজিরা',
            'Rajbari' => 'Baliakandi|বালিয়াকান্দি,Goalanda|গোয়ালন্দ,Kalukhali|কালুখালী,Pangsha|পাংশা,Rajbari Sadar|রাজবাড়ী সদর',
            'Chattogram' => 'Anwara|আনোয়ারা,Banshkhali|বাঁশখালী,Boalkhali|বোয়ালখালী,Chandanaish|চন্দনাইশ,Fatikchhari|ফটিকছড়ি,Hathazari|হাটহাজারী,Lohagara|লোহাগাড়া,Mirsharai|মীরসরাই,Patiya|পটিয়া,Rangunia|রাঙ্গুনিয়া,Raozan|রাউজান,Sandwip|সন্দ্বীপ,Satkania|সাতকানিয়া,Sitakunda|সীতাকুণ্ড,Chattogram Sadar|চট্টগ্রাম সদর',
            "Cox's Bazar" => "Chakaria|চকরিয়া,Cox's Bazar Sadar|কক্সবাজার সদর,Kutubdia|কুতুবদিয়া,Maheshkhali|মহেশখালী,Pekua|পেকুয়া,Ramu|রামু,Teknaf|টেকনাফ,Ukhia|উখিয়া",
            'Noakhali' => 'Begumganj|বেগমগঞ্জ,Chatkhil|চাটখিল,Companiganj|কোম্পানীগঞ্জ,Hatiya|হাতিয়া,Kabirhat|কবিরহাট,Senbagh|সেনবাগ,Sonaimuri|সোনাইমুড়ী,Subarnachar|সুবর্ণচর,Noakhali Sadar|নোয়াখালী সদর',
            'Lakshmipur' => 'Kamalnagar|কমলনগর,Lakshmipur Sadar|লক্ষ্মীপুর সদর,Raipur|রায়পুর,Ramganj|রামগঞ্জ,Ramgati|রামগতি',
            'Feni' => 'Chhagalnaiya|ছাগলনাইয়া,Daganbhuiyan|দাগনভূঞা,Feni Sadar|ফেনী সদর,Parshuram|পরশুরাম,Sonagazi|সোনাগাজী,Fulgazi|ফুলগাজী',
            'Cumilla' => 'Adarsha Sadar|আদর্শ সদর,Brahmanpara|ব্রাহ্মণপাড়া,Burichang|বুড়িচং,Chandina|চান্দিনা,Chauddagram|চৌদ্দগ্রাম,Cumilla Sadar Dakshin|সদর দক্ষিণ,Daudkandi|দাউদকান্দি,Debidwar|দেবিদ্বার,Homna|হোমনা,Laksam|লাকসাম,Meghna|মেঘনা,Monoharganj|মনোহরগঞ্জ,Muradnagar|মুরাদনগর,Nangalkot|নাঙ্গলকোট,Titas|তিতাস',
            'Brahmanbaria' => 'Akhaura|আখাউড়া,Ashuganj|আশুগঞ্জ,Bancharampur|বাঞ্ছারামপুর,Bijoynagar|বিজয়নগর,Brahmanbaria Sadar|ব্রাহ্মণবাড়িয়া সদর,Kasba|কসবা,Nabinagar|নবীনগর,Nasirnagar|নাসিরনগর,Sarail|সরাইল',
            'Chandpur' => 'Chandpur Sadar|চাঁদপুর সদর,Faridganj|ফরিদগঞ্জ,Haimchar|হাইমচর,Haziganj|হাজীগঞ্জ,Kachua|কচুয়া,Matlab Dakshin|মতলব দক্ষিণ,Matlab Uttar|মতলব উত্তর,Shahrasti|শাহরাস্তি',
            'Khagrachhari' => 'Dighinala|দীঘিনালা,Khagrachhari Sadar|খাগড়াছড়ি সদর,Lakshmichhari|লক্ষ্মীছড়ি,Mahalchhari|মহালছড়ি,Manikchhari|মানিকছড়ি,Matiranga|মাটিরাঙ্গা,Panchhari|পানছড়ি,Ramgarh|রামগড়',
            'Rangamati' => 'Baghaichhari|বাঘাইছড়ি,Barkal|বরকল,Kawkhali|কাউখালী,Kaptai|কাপ্তাই,Juraichhari|জুরাছড়ি,Langadu|লংগদু,Naniarchar|নানিয়ারচর,Rajasthali|রাজস্থলী,Rangamati Sadar|রাঙ্গামাটি সদর,Belaichhari|বিলাইছড়ি',
            'Bandarban' => 'Alikadam|আলীকদম,Bandarban Sadar|বান্দরবান সদর,Lama|লামা,Naikhongchhari|নাইক্ষ্যংছড়ি,Rowangchhari|রোয়াংছড়ি,Ruma|রুমা,Thanchi|থানচি',
            'Rajshahi' => 'Bagha|বাঘা,Bagmara|বাগমারা,Charghat|চারঘাট,Durgapur|দুর্গাপুর,Godagari|গোদাগাড়ী,Mohanpur|মোহনপুর,Paba|পবা,Puthia|পুঠিয়া,Tanore|তানোর,Rajshahi Sadar|রাজশাহী সদর',
            'Bogura' => 'Adamdighi|আদমদীঘি,Bogura Sadar|বগুড়া সদর,Dhunot|ধুনট,Gabtali|গাবতলী,Kahaloo|কাহালু,Nandigram|নন্দীগ্রাম,Sariakandi|সারিয়াকান্দি,Shajahanpur|শাজাহানপুর,Sherpur|শেরপুর,Shibganj|শিবগঞ্জ,Sonatola|সোনাতলা',
            'Pabna' => 'Atgharia|আটঘরিয়া,Bera|বেড়া,Bhangura|ভাঙ্গুড়া,Chatmohar|চাটমোহর,Ishwardi|ঈশ্বরদী,Pabna Sadar|পাবনা সদর,Santhia|সাঁথিয়া,Sujanagar|সুজানগর',
            'Sirajganj' => 'Belkuchi|বেলকুচি,Chauhali|চৌহালী,Kamarkhanda|কামারখন্দ,Kazipur|কাজীপুর,Raiganj|রায়গঞ্জ,Shahjadpur|শাহজাদপুর,Sirajganj Sadar|সিরাজগঞ্জ সদর,Tarash|তাড়াশ,Ullahpara|উল্লাপাড়া',
            'Natore' => 'Bagatipara|বাগাতিপাড়া,Baraigram|বড়াইগ্রাম,Gurudaspur|গুরুদাসপুর,Lalpur|লালপুর,Natore Sadar|নাটোর সদর,Singra|সিংড়া,Naldanga|নলডাঙ্গা',
            'Naogaon' => 'Atrai|আত্রাই,Badalgachhi|বদলগাছী,Dhamoirhat|ধামইরহাট,Manda|মান্দা,Mohadevpur|মহাদেবপুর,Naogaon Sadar|নওগাঁ সদর,Niamatpur|নিয়ামতপুর,Patnitala|পত্নীতলা,Porsha|পোরশা,Raninagar|রাণীনগর,Sapahar|সাপাহার',
            'Chapainawabganj' => 'Bholahat|ভোলাহাট,Chapainawabganj Sadar|চাঁপাইনবাবগঞ্জ সদর,Gomastapur|গোমস্তাপুর,Nachole|নাচোল,Shibganj|শিবগঞ্জ',
            'Joypurhat' => 'Akkelpur|আক্কেলপুর,Joypurhat Sadar|জয়পুরহাট সদর,Kalai|কালাই,Khetlal|ক্ষেতলাল,Panchbibi|পাঁচবিবি',
            'Khulna' => 'Batiaghata|বটিয়াঘাটা,Dacope|দাকোপ,Dumuria|ডুমুরিয়া,Dighalia|দিঘলিয়া,Koyra|কয়রা,Paikgachha|পাইকগাছা,Phultala|ফুলতলা,Rupsha|রূপসা,Terokhada|তেরখাদা',
            'Jashore' => 'Abhaynagar|অভয়নগর,Bagherpara|বাঘারপাড়া,Chaugachha|চৌগাছা,Jhikargachha|ঝিকরগাছা,Keshabpur|কেশবপুর,Jashore Sadar|যশোর সদর,Manirampur|মণিরামপুর,Sharsha|শার্শা',
            'Satkhira' => 'Assasuni|আশাশুনি,Debhata|দেবহাটা,Kalaroa|কলারোয়া,Kaliganj|কালীগঞ্জ,Satkhira Sadar|সাতক্ষীরা সদর,Shyamnagar|শ্যামনগর,Tala|তালা',
            'Bagerhat' => 'Bagerhat Sadar|বাগেরহাট সদর,Chitalmari|চিতলমারী,Fakirhat|ফকিরহাট,Kachua|কচুয়া,Mollahat|মোল্লাহাট,Mongla|মোংলা,Morrelganj|মোড়লগঞ্জ,Rampal|রামপাল,Sarankhola|শরণখোলা',
            'Kushtia' => 'Bheramara|ভেড়ামারা,Daulatpur|দৌলতপুর,Khoksa|খোকসা,Kumarkhali|কুমারখালী,Kushtia Sadar|কুষ্টিয়া সদর,Mirpur|মিরপুর',
            'Jhenaidah' => 'Harinakunda|হরিণাকুণ্ডু,Jhenaidah Sadar|ঝিনাইদহ সদর,Kaliganj|কালীগঞ্জ,Kotchandpur|কোটচাঁদপুর,Maheshpur|মহেশপুর,Shailkupa|শৈলকুপা',
            'Magura' => 'Magura Sadar|মাগুরা সদর,Mohammadpur|মোহাম্মদপুর,Shalikha|শালিখা,Sreepur|শ্রীপুর',
            'Narail' => 'Kalia|কালিয়া,Lohagara|লোহাগড়া,Narail Sadar|নড়াইল সদর',
            'Chuadanga' => 'Alamdanga|আলমডাঙ্গা,Chuadanga Sadar|চুয়াডাঙ্গা সদর,Damurhuda|দামুড়হুদা,Jibannagar|জীবননগর',
            'Meherpur' => 'Gangni|গাংনী,Meherpur Sadar|মেহেরপুর সদর,Mujibnagar|মুজিবনগর',
            'Barishal' => 'Agailjhara|আগৈলঝাড়া,Babuganj|বাবুগঞ্জ,Bakerganj|বাকেরগঞ্জ,Banaripara|বানারীপাড়া,Barishal Sadar|বরিশাল সদর,Gaurnadi|গৌরনদী,Hizla|হিজলা,Mehendiganj|মেহেন্দিগঞ্জ,Muladi|মুলাদী,Wazirpur|উজিরপুর',
            'Patuakhali' => 'Bauphal|বাউফল,Dashmina|দশমিনা,Dumki|দুমকি,Galachipa|গলাচিপা,Kalapara|কলাপাড়া,Mirzaganj|মির্জাগঞ্জ,Patuakhali Sadar|পটুয়াখালী সদর,Rangabali|রাঙ্গাবালী',
            'Bhola' => 'Bhola Sadar|ভোলা সদর,Burhanuddin|বোরহানউদ্দিন,Char Fasson|চরফ্যাশন,Daulatkhan|দৌলতখান,Lalmohan|লালমোহন,Manpura|মনপুরা,Tazumuddin|তজুমদ্দিন',
            'Pirojpur' => 'Bhandaria|ভান্ডারিয়া,Kawkhali|কাউখালী,Mathbaria|মঠবাড়িয়া,Nazirpur|নাজিরপুর,Nesarabad|নেছারাবাদ,Pirojpur Sadar|পিরোজপুর সদর,Zianagar|জিয়ানগর',
            'Barguna' => 'Amtali|আমতলী,Bamna|বামনা,Barguna Sadar|বরগুনা সদর,Betagi|বেতাগী,Patharghata|পাথরঘাটা,Taltali|তালতলী',
            'Jhalokathi' => 'Jhalokathi Sadar|ঝালকাঠি সদর,Kathalia|কাঠালিয়া,Nalchity|নলছিটি,Rajapur|রাজাপুর',
            'Sylhet' => 'Balaganj|বালাগঞ্জ,Beanibazar|বিয়ানীবাজার,Bishwanath|বিশ্বনাথ,Companiganj|কোম্পানীগঞ্জ,Dakshin Surma|দক্ষিণ সুরমা,Fenchuganj|ফেঞ্চুগঞ্জ,Golapganj|গোলাপগঞ্জ,Gowainghat|গোয়াইনঘাট,Jaintiapur|জৈন্তাপুর,Kanaighat|কানাইঘাট,Osmani Nagar|ওসমানীনগর,Sylhet Sadar|সিলেট সদর,Zakiganj|জকিগঞ্জ',
            'Moulvibazar' => 'Barlekha|বড়লেখা,Juri|জুড়ী,Kamalganj|কমলগঞ্জ,Kulaura|কুলাউড়া,Moulvibazar Sadar|মৌলভীবাজার সদর,Rajnagar|রাজনগর,Sreemangal|শ্রীমঙ্গল',
            'Habiganj' => 'Ajmiriganj|আজমিরীগঞ্জ,Bahubal|বাহুবল,Baniyachong|বানিয়াচং,Chunarughat|চুনারুঘাট,Habiganj Sadar|হবিগঞ্জ সদর,Lakhai|লাখাই,Madhabpur|মাধবপুর,Nabiganj|নবীগঞ্জ,Sayestaganj|শায়েস্তাগঞ্জ',
            'Sunamganj' => 'Bishwamvarpur|বিশ্বম্ভরপুর,Chhatak|ছাতক,Derai|দিরাই,Dharampasha|ধর্মপাশা,Dowarabazar|দোয়ারাবাজার,Jagannathpur|জগন্নাথপুর,Jamalganj|জামালগঞ্জ,Sulla|শাল্লা,Sunamganj Sadar|সুনামগঞ্জ সদর,Tahirpur|তাহিরপুর',
            'Rangpur' => 'Badarganj|বদরগঞ্জ,Gangachara|গঙ্গাচড়া,Kaunia|কাউনিয়া,Rangpur Sadar|রংপুর সদর,Mithapukur|মিঠাপুকুর,Pirgachha|পীরগাছা,Pirganj|পীরগঞ্জ,Taraganj|তারাগঞ্জ',
            'Dinajpur' => 'Birampur|বিরামপুর,Birganj|বীরগঞ্জ,Biral|বিরল,Bochaganj|বোচাগঞ্জ,Chirirbandar|চিরিরবন্দর,Dinajpur Sadar|দিনাজপুর সদর,Fulbari|ফুলবাড়ী,Ghoraghat|ঘোড়াঘাট,Hakimpur|হাকিমপুর,Kaharole|কাহারোল,Khansama|খানসামা,Nawabganj|নবাবগঞ্জ,Parbatipur|পার্বতীপুর',
            'Gaibandha' => 'Fulchhari|ফুলছড়ি,Gaibandha Sadar|গাইবান্ধা সদর,Gobindaganj|গোবিন্দগঞ্জ,Palashbari|পলাশবাড়ী,Sadullapur|সাদুল্লাপুর,Saghata|সাঘাটা,Sundarganj|সুন্দরগঞ্জ',
            'Kurigram' => 'Bhurungamari|ভুরুঙ্গামারী,Char Rajibpur|চর রাজিবপুর,Chilmari|চিলমারী,Kurigram Sadar|কুড়িগ্রাম সদর,Nageshwari|নাগেশ্বরী,Phulbari|ফুলবাড়ী,Rajarhat|রাজারহাট,Raumari|রৌমারী,Ulipur|উলিপুর',
            'Lalmonirhat' => 'Aditmari|আদিতমারী,Hatibandha|হাতীবান্ধা,Kaliganj|কালীগঞ্জ,Lalmonirhat Sadar|লালমনিরহাট সদর,Patgram|পাটগ্রাম',
            'Nilphamari' => 'Dimla|ডিমলা,Domar|ডোমার,Jaldhaka|জলঢাকা,Kishoreganj|কিশোরগঞ্জ,Nilphamari Sadar|নীলফামারী সদর,Saidpur|সৈয়দপুর',
            'Panchagarh' => 'Atwari|আটোয়ারী,Boda|বোদা,Debiganj|দেবীগঞ্জ,Panchagarh Sadar|পঞ্চগড় সদর,Tetulia|তেঁতুলিয়া',
            'Thakurgaon' => 'Baliadangi|বালিয়াডাঙ্গী,Haripur|হরিপুর,Pirganj|পীরগঞ্জ,Ranisankail|রানীশংকৈল,Thakurgaon Sadar|ঠাকুরগাঁও সদর',
            'Mymensingh' => 'Bhaluka|ভালুকা,Dhobaura|ধোবাউড়া,Fulbaria|ফুলবাড়িয়া,Gaffargaon|গফরগাঁও,Gauripur|গৌরীপুর,Haluaghat|হালুয়াঘাট,Ishwarganj|ঈশ্বরগঞ্জ,Mymensingh Sadar|ময়মনসিংহ সদর,Muktagachha|মুক্তাগাছা,Nandail|নান্দাইল,Phulpur|ফুলপুর,Tarakanda|তারাকান্দা,Trishal|ত্রিশাল',
            'Jamalpur' => 'Bakshiganj|বকশীগঞ্জ,Dewanganj|দেওয়ানগঞ্জ,Islampur|ইসলামপুর,Jamalpur Sadar|জামালপুর সদর,Madarganj|মাদারগঞ্জ,Melandaha|মেলান্দহ,Sarishabari|সরিষাবাড়ী',
            'Netrokona' => 'Atpara|আটপাড়া,Barhatta|বারহাট্টা,Durgapur|দুর্গাপুর,Kalmakanda|কলমাকান্দা,Kendua|কেন্দুয়া,Khaliajuri|খালিয়াজুরী,Madan|মদন,Mohanganj|মোহনগঞ্জ,Netrokona Sadar|নেত্রকোণা সদর,Purbadhala|পূর্বধলা',
            'Sherpur' => 'Jhenaigati|ঝিনাইগাতী,Nakla|নকলা,Nalitabari|নালিতাবাড়ী,Sherpur Sadar|শেরপুর সদর,Sreebardi|শ্রীবরদী',
        ];

        foreach ($data as $districtName => $thanaString) {
            $district = District::where('name_en', $districtName)->first();

            if (! $district) {
                continue;
            }

            foreach (explode(',', $thanaString) as $pair) {
                [$nameEn, $nameBn] = explode('|', $pair, 2);

                Thana::updateOrCreate(
                    ['district_id' => $district->id, 'name_en' => trim($nameEn)],
                    ['name_bn' => trim($nameBn)]
                );
            }
        }
    }
}
