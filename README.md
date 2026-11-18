# Suchana — SMTTI Institute Management System

A full institute-management web application for **Suchana Medical & Technical Training Institute (SMTTI)** — public landing site, student accounts, online admission, admin panel, attendance and certificates.

Built with **Laravel 13 (PHP 8.5) + SQLite + Blade**, matching the original Suchana landing-page design (Hind Siliguri font, green/blue/red/purple palette, two logos side by side, site name **Suchana**).

---

## Requirements

- PHP 8.3+ (tested on PHP 8.5) with `pdo_sqlite`, `mbstring`, `dom`, `zip`, `gd`
- Composer 2.x
- No MySQL needed — uses SQLite (`database/database.sqlite`)

## Setup

```bash
composer install
cp .env.example .env          # Windows: Copy-Item .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

## Run

```bash
php artisan serve
```

Open http://127.0.0.1:8000

## Default logins (from seeder, password: `password`)

| Role | Login (username / mobile / email) | Password |
|------|------------------------------------|----------|
| Admin | `admin` / `01700000000` / `admin@suchana.test` | `password` | লগইন: **`/admin/login`** |
| Trainer | `trainer` / `01700000001` / `trainer@suchana.test` | `password` |
| Student | `student` / `01700000002` / `student@suchana.test` | `password` |

## Key URLs

| Area | URL |
|------|-----|
| Public landing | `/` |
| Courses / detail | `/courses`, `/courses/{id}` |
| Branches / About / Contact / Notices | `/branches`, `/about`, `/contact`, `/notices` |
| Privacy / Terms / FAQ | `/privacy`, `/terms`, `/faq` |
| Student register / login | `/register`, `/login` |
| Student dashboard | `/student` |
| Online application | `/apply` |
| Application tracking | `/track` |
| Admin login (আলাদা) | `/admin/login` |
| Admin panel | `/admin` |
| Site settings | `/admin/settings` |
| Support inbox | `/admin/support` |
| Districts / Thanas | `/admin/districts`, `/admin/thanas` |
| Gallery | `/admin/gallery` |
| Notification templates | `/admin/notifications` |
| Attendance (admin + trainer) | `/attendance` |
| Attendance report | `/admin/attendance/report` |
| Certificates (admin) | `/admin/certificates` |
| Certificate print/download | `/certificate/{no}` |
| Certificate verification | `/verify` |

## 10-phase build (all complete)

1. **Foundation** — Laravel 13 + SQLite, packages (Sanctum, DomPDF, QR), design system, 2 logos
2. **Schema & models** — users/roles, staff, courses, batches, branches, notices, districts (64 seeded), applications, attendances, certificates, settings; NID + bank account encrypted at rest
3. **Public landing** — two logos side-by-side, dynamic course slider, authority photos, courses, branches, about, contact, notices, BN/EN toggle, dark mode
4. **Student auth** — register (name/mobile/Gmail/username), login, dashboard with profile, applications, attendance, certificates
5. **Online application** — NID-based form (NID, district, thana, bank account, preferred course), unique `SMTTI-YYYY-NNNNN` number, status tracking, duplicate guard
6. **Admin core** — dashboard stats + CRUD for courses, staff/authority, branches, notices
7. **Applications & students** — filter/search, verify/approve/cancel/waitlist, seat decrement on approval, student list/detail, activate/deactivate
8. **Attendance** — tick-mark checklist, auto date/time/course, one row per student/course/day (duplicate-proof), admin + trainer access
9. **Reports & certificates** — attendance reports (course/date range), auto + manual certificate generation, printable certificate with unique number, public verification
10. **Hardening** — role middleware, encrypted PII, DB backup command, docs, responsive layout

## Admin — A2Z control

- **অ্যাডভান্স অ্যাডমিন UI**: গ্রুপ করা সাইডবার (Overview / Content / Admissions / System), টপবার, কুইক অ্যাকশন, ডার্ক মোড, মোবাইল ড্রয়ার।
- **ভাষা সিলেক্ট (বাংলা / English)**: অ্যাডমিনের উপরে ডানদিকে — পুরো অ্যাডমিন UI ভাষা বদলায় (নেভিগেশন, শিরোনাম, বাটন, টেবিল হেডার, ফর্ম লেবেল)।
- **থিম কালার**: অ্যাডমিন → সেটিংস → থিম কালার — আকাশি (ডিফল্ট), গাঢ়, সবুজ, বেগুনি, লাল, টিল, কমলা।
- **লোগো**: অ্যাডমিন → সেটিংস থেকে দুটি লোগো আপলোড (না দিলে ডিফল্ট লোগো)।
- **সাপোর্ট ইমেইল**: `help@suchana.bd`; সাপোর্ট আইকনে WhatsApp / Facebook / **YouTube** (URL দিলে) / Live Chat।
- **গ্যালারি লাইটবক্স (✕ বাটন)**: ছবিতে ক্লিক করলে বড় হয়, ✕ বা Esc-এ বন্ধ; আপলোডে সাথে সাথে **প্রিভিউ + ✕ রিমুভ**।
- **সেটিংস** (`/admin/settings`): সাইটের নাম, ট্যাগলাইন, হিরো ব্যাজ, ফোন, ইমেইল, ঠিকানা, WhatsApp নম্বর, Facebook/YouTube/Instagram URL, লাইভ চ্যাট, "আমাদের সম্পর্কে"।
- **সহায়তা বার্তা** (`/admin/support`): লাইভ চ্যাট বার্তা + এক ক্লিকে WhatsApp রিপ্লাই।
- **জেলা ও উপজেলা** (`/admin/districts`, `/admin/thanas`): ৬৪ জেলা + ৪৮৮ উপজেলা CRUD; আবেদন ফর্মে জেলা-ভিত্তিক উপজেলা ড্রপডাউন।
- **গ্যালারি** (`/admin/gallery`): ছবি আপলোড, হোমপেজে গ্যালারি সেকশন।
- **নোটিফিকেশন** (`/admin/notifications`): SMS/ইমেইল টেমপ্লেট + স্বয়ংক্রিয় লগ।
- **রিপোর্ট এক্সপোর্ট**: আবেদন ও উপস্থিতি — CSV (Excel) + প্রিন্ট/PDF।
- **কনটেন্ট**: কোর্স, ব্যাচ, কর্তৃপক্ষ, ব্রাঞ্চ, নোটিশ, আবেদন, শিক্ষার্থী, উপস্থিতি, সার্টিফিকেট — সব CRUD।
- পাবলিক সাইটের ডান-নিচে ভাসমান **WhatsApp / Facebook / Live Chat** আইকন; সেটিংসে খালি রাখলে আইকন দেখাবে না।

## Premium animations (public site only)

- স্ক্রল রিভিল (staggered), অ্যানিমেটেড গ্রেডিয়েন্ট হেডলাইন, ভাসমান হিরো ব্লব, প্যারালাক্স হিরো ছবি
- অটো-স্ক্রলিং মার্কি ব্যান্ড, স্ট্যাট কাউন্ট-আপ, কার্ড শাইন, বাটন শিমার, গ্যালারি জুম
- স্ক্রল প্রগ্রেস বার + ব্যাক-টু-টপ বাটন, ✕ সহ গ্যালারি লাইটবক্স
- `prefers-reduced-motion` সম্মান করে; **অ্যাডমিন প্যানেলে কোনো অ্যানিমেশন নেই** (শুধু `body.site`-এ স্কোপড)।

## Useful commands

```bash
php artisan migrate:fresh --seed   # reset database with demo data
php artisan db:backup              # copy SQLite DB to storage/app/backups/
```

## Notes

- Certificates open as a print-ready page — use **Print / PDF download** (browser print → Save as PDF).
- NID and bank account numbers are stored encrypted; they are decrypted automatically for admin views.
- Toggle Bengali/English and light/dark from the header.
