# 📄 SABARA — Laravel + Livewire Clone
## Product Requirements Document (PRD) untuk Vibe Coding dengan AI

---

> [!IMPORTANT]
> Dokumen ini adalah panduan lengkap untuk meng-clone aplikasi **SABARA** (Next.js + Supabase) ke **Laravel 12 + Livewire 3 + Tailwind CSS**. Dirancang agar bisa di-copy-paste langsung ke AI coding assistant untuk implementasi per-fase.

---

## 1. Ringkasan Produk

| Item | Detail |
|------|--------|
| **Nama** | SABARA (Sarana Belajar Bahasa Daerah) |
| **Deskripsi** | Web app pembelajaran bahasa daerah (Bengkulu) dengan materi, latihan interaktif, kuis, kamus, dan gamifikasi |
| **Platform** | Web Application (responsive, PWA-ready) |
| **Original Stack** | Next.js 16 + Supabase + Tailwind CSS |
| **Target Stack** | Laravel 12 + Livewire 3 + Tailwind CSS + MySQL/PostgreSQL |
| **Figma** | https://www.figma.com/design/tG6dB9o2C4EPeKnbZCIKfa/Sabara |

### Tujuan Utama
- Membantu pengguna memahami bahasa Bengkulu secara praktis
- Menyediakan media pembelajaran berbasis teknologi
- Mendukung pelestarian bahasa daerah

### Target Pengguna
- **Primary**: Generasi muda Bengkulu, mahasiswa KKN, masyarakat perantau
- **Secondary**: Pengguna umum yang ingin belajar bahasa daerah

---

## 2. Arsitektur & Tech Stack

### Tech Stack Baru (Laravel)

| Layer | Teknologi |
|-------|-----------|
| **Framework** | Laravel 12 |
| **Frontend Interaktif** | Livewire 3 |
| **Styling** | Tailwind CSS v4 |
| **Database** | MySQL 8+ atau PostgreSQL 16+ |
| **Auth** | Laravel Breeze (atau Fortify) |
| **File Storage** | Laravel Filesystem (local/S3) |
| **Icons** | Lucide (via Blade Icons) atau Heroicons |
| **Drag & Drop** | SortableJS (via Livewire plugin) |
| **Excel Export** | Laravel Excel (Maatwebsite) |

### Pemetaan Teknologi: Next.js → Laravel

| Next.js (Original) | Laravel (Target) |
|---------------------|-----------------|
| App Router (pages) | Laravel Routes + Blade Views |
| React Components | Livewire Components + Blade |
| Server Actions | Livewire Methods / Controller Actions |
| Supabase Auth | Laravel Auth (Breeze/Fortify) |
| Supabase DB (Postgres) | Eloquent ORM + MySQL/Postgres |
| Supabase Storage | Laravel Storage (public disk / S3) |
| Supabase RLS | Laravel Policies & Gates |
| `@dnd-kit` (DnD) | SortableJS + Livewire |
| `next/cache` revalidation | Livewire reactive updates |
| Middleware (Next.js) | Laravel Middleware |
| PWA (@serwist) | Laravel PWA package (opsional, fase akhir) |

---

## 3. Database Schema

### 3.1 Tabel & Migrasi

> [!NOTE]
> Semua tabel menggunakan UUID sebagai primary key. Gunakan `$table->uuid('id')->primary()` atau trait `HasUuids` di model.

#### `users` (bawaan Laravel, diperluas)
```
- id: UUID (PK)
- name: string
- email: string (unique)
- password: string (hashed)
- role: enum('user', 'admin') DEFAULT 'user'
- selected_language_id: UUID (nullable, FK → languages)
- avatar_url: string (nullable)
- email_verified_at: timestamp (nullable)
- remember_token: string (nullable)
- created_at, updated_at: timestamps
```

#### `languages`
```
- id: UUID (PK)
- code: string (unique, e.g. 'bengkulu')
- name: string (e.g. 'Bahasa Bengkulu')
- is_active: boolean DEFAULT true
- created_at, updated_at: timestamps
```

#### `materi`
```
- id: UUID (PK)
- language_id: UUID (FK → languages)
- title: string
- category: string (nama grup kategori, e.g. 'Percakapan Sehari-hari')
- description: text (nullable)
- icon: string (nullable, URL/path ke file ikon)
- created_at, updated_at: timestamps
```

#### `percakapan`
```
- id: UUID (PK)
- materi_id: UUID (FK → materi, CASCADE DELETE)
- indonesia: string
- bengkulu: string
- speaker: string DEFAULT '1' ('1' atau '2')
- audio_url: string (nullable)
- order_index: integer DEFAULT 0
- created_at, updated_at: timestamps
```

#### `soal_latihan`
```
- id: UUID (PK)
- materi_id: UUID (FK → materi, CASCADE DELETE)
- question: text
- options: JSON (array pilihan atau array objek matching)
- answer: string
- type: enum('multiple_choice', 'matching', 'audio', 'reading') DEFAULT 'multiple_choice'
- audio_url: string (nullable)
- level: integer DEFAULT 1
- star: integer DEFAULT 1
- created_at, updated_at: timestamps
```

#### `soal_kuis`
```
- id: UUID (PK)
- language_id: UUID (FK → languages, nullable)
- question: text
- options: JSON (array pilihan)
- answer: string
- difficulty: enum('Mudah', 'Sedang', 'Sulit') DEFAULT 'Mudah'
- type: string DEFAULT 'multiple_choice'
- created_at, updated_at: timestamps
```

#### `kamus`
```
- id: UUID (PK)
- indonesia: string
- bengkulu: string
- contoh: text (nullable)
- audio_url: string (nullable)
- created_at, updated_at: timestamps
```

#### `quiz_results`
```
- id: UUID (PK)
- user_id: UUID (FK → users, CASCADE DELETE)
- score: integer DEFAULT 0
- total_questions: integer DEFAULT 0
- created_at, updated_at: timestamps
```

#### `latihan_progress`
```
- id: UUID (PK)
- user_id: UUID (FK → users, CASCADE DELETE)
- materi_id: UUID (FK → materi, CASCADE DELETE)
- level: integer DEFAULT 1
- stars: integer DEFAULT 0
- score: integer DEFAULT 0
- created_at, updated_at: timestamps

- UNIQUE constraint: (user_id, materi_id, level)
```

#### `sound_effects`
```
- id: UUID (PK)
- type: enum('correct', 'wrong', 'complete')
- label: string
- audio_url: string
- updated_at: timestamp
```

#### `visitor_logs`
```
- id: UUID (PK)
- session_id: string
- path: string
- user_agent: text
- created_at: timestamp
```

### 3.2 Model Relationships (Eloquent)

```
User
  ├── hasMany QuizResult
  ├── hasMany LatihanProgress
  └── belongsTo Language (selected_language)

Language
  ├── hasMany Materi
  └── hasMany User

Materi
  ├── belongsTo Language
  ├── hasMany Percakapan
  ├── hasMany SoalLatihan
  └── hasMany LatihanProgress

Percakapan → belongsTo Materi
SoalLatihan → belongsTo Materi
SoalKuis → belongsTo Language (nullable)
QuizResult → belongsTo User
LatihanProgress → belongsTo User, belongsTo Materi
```

---

## 4. Roles & Authorization

### Role System
| Role | Akses |
|------|-------|
| **user** | Belajar materi, latihan, kuis, kamus, profil, lihat leaderboard |
| **admin** | Semua fitur user + CRUD materi/soal/kamus + manajemen user + analytics |

### Laravel Implementation
- Gunakan **Gate/Policy** atau middleware `role:admin`
- Middleware `auth` untuk semua route di `(main)`
- Middleware `role:admin` untuk semua route di `/admin`
- Guest bisa akses: `/login`, `/register`, `/loginadmin`

---

## 5. Routing Map

### Public Routes (Guest)
| Route | Method | Controller/Livewire | Deskripsi |
|-------|--------|---------------------|-----------|
| `/` | GET | Redirect → `/login` | Root redirect |
| `/login` | GET/POST | `Auth\LoginController` | Login user |
| `/register` | GET/POST | `Auth\RegisterController` | Registrasi user |
| `/loginadmin` | GET/POST | `Auth\AdminLoginController` | Login admin |

### User Routes (auth middleware)
| Route | Method | Controller/Livewire | Deskripsi |
|-------|--------|---------------------|-----------|
| `/pilih-bahasa` | GET | `Livewire\PilihBahasa` | Pilih bahasa daerah |
| `/beranda` | GET | `Livewire\Beranda` | Dashboard utama + statistik |
| `/pelajaran/{materiId}` | GET | `Livewire\Pelajaran` | Detail materi & daftar level |
| `/latihan` | GET | `Livewire\Latihan` | Mode latihan interaktif |
| `/kuis` | GET | `Livewire\Kuis` | Mode kuis + leaderboard |
| `/profil` | GET | `Livewire\Profil` | Profil user & statistik |

### Admin Routes (auth + role:admin middleware)
| Route | Method | Controller/Livewire | Deskripsi |
|-------|--------|---------------------|-----------|
| `/admin` | GET | `Livewire\Admin\Dashboard` | Dashboard admin + statistik |
| `/admin/materi` | GET | `Livewire\Admin\MateriIndex` | CRUD daftar materi |
| `/admin/materi/{id}` | GET | `Livewire\Admin\MateriDetail` | Edit materi + percakapan + soal |
| `/admin/kuis` | GET | `Livewire\Admin\KuisIndex` | CRUD soal kuis |
| `/admin/users` | GET | `Livewire\Admin\UsersIndex` | Manajemen user |
| `/admin/pengunjung` | GET | `Livewire\Admin\PengunjungIndex` | Statistik pengunjung |
| `/admin/sound-effects` | GET | `Livewire\Admin\SoundEffects` | Kelola sound effects |

---

## 6. Fitur Detail per Halaman

### 6.1 🔐 Autentikasi

#### Login (`/login`)
- Form: email + password
- Setelah login → cek `selected_language_id`:
  - Jika `null` → redirect ke `/pilih-bahasa`
  - Jika ada → redirect ke `/beranda`
- Tampilkan link ke `/register`

#### Register (`/register`)
- Form: nama lengkap + email + password + konfirmasi password
- Auto-create profile (via Eloquent Observer atau event)
- Setelah register → redirect ke `/pilih-bahasa`

#### Login Admin (`/loginadmin`)
- Form: email + password
- Validasi role admin setelah login
- Jika bukan admin → logout + tampilkan error "Akses ditolak"
- Jika admin → redirect ke `/admin`

---

### 6.2 🌐 Pilih Bahasa (`/pilih-bahasa`)

**Purpose**: User memilih bahasa daerah yang ingin dipelajari.

**Data**:
- Fetch `languages` WHERE `is_active = true`
- Tampilkan sebagai grid card dengan nama bahasa

**Interaksi**:
- Klik card → update `users.selected_language_id`
- Redirect ke `/beranda`

**Livewire Component**: `PilihBahasa`
```
Properties: $languages, $selectedId
Methods: selectLanguage($languageId)
```

---

### 6.3 🏠 Beranda / Dashboard (`/beranda`)

**Purpose**: Halaman utama setelah login. Menampilkan profil singkat, ranking, dan daftar materi berdasarkan kategori.

**Data yang ditampilkan**:
- Avatar user + nama + bahasa yang dipilih
- **Ranking global** (posisi user di antara semua user berdasarkan total poin)
- **Total poin** = (sum latihan_progress.score × 10) + max(quiz_results.score)
- **Daftar kategori materi** dikelompokkan berdasarkan `category` name:
  - Setiap card menampilkan: icon, title, description
  - Progress bar: completed levels / total levels per materi
  - Klik → navigasi ke `/pelajaran/{materiId}`

**Livewire Component**: `Beranda`
```
Properties: $user, $stats (totalPoints, rank), $categories (grouped materi)
Computed: getUserRank(), getTotalPoints(), getGroupedMateri()
```

**Perhitungan Rank** (Laravel equivalent of RPC `get_user_rank`):
```php
// Hitung total poin setiap user, rank berdasarkan poin tertinggi
// Poin = sum(latihan_progress.score * 10) + max(quiz_results.score)
// Rank = posisi user di urutan descending
```

---

### 6.4 📚 Pelajaran Detail (`/pelajaran/{materiId}`)

**Purpose**: Menampilkan detail materi, percakapan terkait, dan daftar level latihan.

**Data**:
- Materi info (title, category, description, icon)
- Daftar `percakapan` sorted by `order_index`
  - Tampilkan dialog 2 orang (speaker 1 & 2)
  - Indonesia ↔ Bengkulu side-by-side
  - Tombol play audio jika `audio_url` tersedia
- Daftar level latihan yang tersedia (dari `soal_latihan` grouped by level)
- Progress user per level (dari `latihan_progress`)

**Interaksi**:
- Klik level → navigasi ke `/latihan?categoryId={id}&level={level}`
- Tampilkan bintang yang sudah didapat per level

**Livewire Component**: `Pelajaran`
```
Properties: $materi, $percakapan, $levels, $progress
```

---

### 6.5 🎮 Latihan / Practice Mode (`/latihan`)

**Purpose**: Mode latihan interaktif tanpa tekanan skor. Feedback langsung setiap jawaban.

**Query Params**: `?categoryId={uuid}&level={int}`

**Jenis Soal & Interaksi**:

#### 1. `multiple_choice` (Pilih Terjemahan)
- Tampilkan pertanyaan (kata/kalimat)
- 4 tombol opsi jawaban
- Klik jawaban → highlight hijau (benar) / merah (salah)
- Play sound effect sesuai hasil

#### 2. `matching` (Pasangkan Kata)
- Tampilkan 2 kolom: Indonesia & Bengkulu
- **Drag and drop** untuk mencocokkan pasangan
- Gunakan **SortableJS** via Alpine.js atau Livewire plugin
- Validasi setelah semua dipasangkan

#### 3. `audio` (Pilih Kata yang Didengar)
- Tombol play audio
- 4 tombol opsi teks
- Klik jawaban → validasi

#### 4. `reading` (Pemahaman Bacaan)
- Tampilkan passage (teks bacaan)
- Pertanyaan terkait bacaan
- 4 opsi jawaban
- Question disimpan sebagai JSON: `{"passage": "...", "q": "..."}`

**Flow Latihan**:
1. Load soal berdasarkan `categoryId` + `level`
2. Tampilkan soal satu per satu
3. Setiap jawaban → feedback langsung + sound effect
4. Selesai → tampilkan summary (skor, bintang)
5. Simpan ke `latihan_progress` (upsert berdasarkan user_id + materi_id + level)

**Sound Effects**:
- Fetch dari tabel `sound_effects` (type: correct/wrong/complete)
- Play menggunakan JavaScript Audio API

**Livewire Component**: `Latihan`
```
Properties: $questions, $currentIndex, $score, $stars, $isComplete
          $categoryId, $level, $soundEffects
Methods: submitAnswer($answer), nextQuestion(), saveProgress()
         shuffleQuestions(), playSound($type)
```

> [!TIP]
> Untuk drag-and-drop matching, gunakan Alpine.js + SortableJS. Livewire menangani validasi server-side, Alpine menangani UI interaksi real-time.

---

### 6.6 📝 Kuis / Assessment Mode (`/kuis`)

**Purpose**: Mengukur pemahaman pengguna. Soal random dari bank soal global.

**Data**:
- **Leaderboard** (top users berdasarkan max quiz score)
  - Podium top 3 dengan medal (gold/silver/bronze)
  - Tabel ranking sisa
- **Quiz info**: total soal tersedia, CTA mulai kuis

**Flow Kuis**:
1. Klik "Mulai Kuis"
2. Load soal random dari `soal_kuis` (filter by user's `selected_language_id`)
3. Tampilkan soal satu per satu (multiple choice)
4. Setiap jawaban → feedback langsung
5. Selesai → tampilkan summary skor
6. Simpan ke `quiz_results`

**Leaderboard Calculation**:
```php
// get_leaderboard equivalent:
User::select('users.id', 'users.name', 'users.avatar_url')
    ->selectRaw('MAX(quiz_results.score) as max_score')
    ->join('quiz_results', 'users.id', '=', 'quiz_results.user_id')
    ->groupBy('users.id', 'users.name', 'users.avatar_url')
    ->orderByDesc('max_score')
    ->limit(20)
    ->get();
```

**Livewire Component**: `Kuis`
```
Properties: $leaderboard, $questions, $currentIndex, $score,
           $isQuizActive, $isComplete, $totalQuestions
Methods: startQuiz(), submitAnswer($answer), nextQuestion(),
         saveResult(), getLeaderboard()
```

---

### 6.7 👤 Profil (`/profil`)

**Purpose**: Manajemen profil user dan statistik pembelajaran.

**Data yang ditampilkan**:
- Avatar (bisa di-upload)
- Nama lengkap (bisa diedit)
- Email (read-only)
- Bahasa yang dipilih
- **Statistik**:
  - Total poin
  - Ranking global
  - Total latihan selesai
  - Akurasi rata-rata
  - Poin latihan
  - Skor kuis tertinggi

**Interaksi**:
- Form edit: nama + upload avatar baru
- Upload avatar → simpan ke Laravel Storage (public disk)
- Tombol logout

**Livewire Component**: `Profil`
```
Properties: $user, $stats, $name, $avatar
Methods: updateProfile(), uploadAvatar(), logout()
```

---

### 6.8 🔧 Admin Dashboard (`/admin`)

**Layout**: Sidebar navigasi (desktop) + bottom nav (mobile)

#### Sidebar Menu:
- 📊 Dashboard
- 📚 Materi
- 📝 Kuis
- 👥 Users
- 👁️ Pengunjung
- 🔊 Sound Effects
- 🚪 Logout

#### Dashboard Page (`/admin`)
**Data**:
- Total materi
- Total soal latihan
- Total soal kuis
- Total users
- **Language switcher** (dropdown untuk filter data admin per bahasa)

---

### 6.9 📚 Admin Materi (`/admin/materi`)

**Purpose**: CRUD materi pembelajaran + sub-content (percakapan & soal latihan).

#### Daftar Materi (`/admin/materi`)
- Tabel dengan kolom: title, category, jumlah percakapan, jumlah soal
- Tombol: Tambah, Edit, Hapus
- Filter by language (sesuai admin language switcher)

#### Form Tambah/Edit Materi
- Fields: title, category, description, icon (upload file)
- Modal atau halaman terpisah

#### Detail Materi (`/admin/materi/{id}`)
**2 Tab/Section**:

**Tab 1: Percakapan**
- Daftar percakapan sorted by `order_index`
- **Drag & drop reorder** (SortableJS)
- Per item: indonesia, bengkulu, speaker (1/2)
- Tombol: Tambah, Edit, Hapus per baris

**Tab 2: Soal Latihan**
- Daftar soal grouped by level + star
- Per soal tampilkan: type, question (preview), level, star
- Form tambah soal dengan dynamic fields berdasarkan `type`:
  - **multiple_choice**: question + 4 opsi (A-D) + pilih jawaban benar + level + star
  - **matching**: dynamic pairs (indonesia ↔ bengkulu) + level + star
  - **audio**: upload audio file + 4 opsi + jawaban benar + level + star
  - **reading**: passage + pertanyaan + 4 opsi + jawaban benar + level + star
    - Opsi "Update passage untuk semua soal reading di materi ini"
- Tombol: Tambah, Edit, Hapus, **Duplikat** per soal
- **Bulk Create**: bulk import soal (JSON format)

**Livewire Components**:
```
Admin\MateriIndex - Daftar + filter
Admin\MateriForm - Create/Edit modal
Admin\MateriDetail - Detail page with tabs
Admin\PercakapanManager - CRUD + reorder percakapan
Admin\SoalLatihanManager - CRUD + bulk create soal
Admin\SoalLatihanForm - Dynamic form per type
```

---

### 6.10 📝 Admin Kuis (`/admin/kuis`)

**Purpose**: CRUD bank soal kuis global.

**Daftar**:
- Tabel: question (preview), difficulty, opsi count
- Filter by difficulty
- Tombol: Tambah, Edit, Hapus

**Form**:
- Fields: question, 4 opsi (A-D), pilih jawaban benar, difficulty (Mudah/Sedang/Sulit)

**Livewire Component**: `Admin\KuisIndex`

---

### 6.11 👥 Admin Users (`/admin/users`)

**Purpose**: Melihat daftar user dan mengubah role.

**Data**:
- Tabel: nama, email, role, created_at
- Tombol toggle role (user ↔ admin)
- Opsional: Export ke Excel

**Livewire Component**: `Admin\UsersIndex`

---

### 6.12 👁️ Admin Pengunjung (`/admin/pengunjung`)

**Purpose**: Analytics pengunjung website.

**Data**:
- Total page views
- Total unique visitors
- Top halaman yang dikunjungi
- Chart harian (page views vs unique visitors)
- Tabel log terbaru (path, user agent, timestamp)

**Tracking**:
- Middleware atau Livewire component `VisitorTracker` yang log setiap kunjungan halaman
- Session ID berbasis browser (cookie)

**Livewire Component**: `Admin\PengunjungIndex`

---

### 6.13 🔊 Admin Sound Effects (`/admin/sound-effects`)

**Purpose**: Upload custom audio untuk feedback soal.

**Data**:
- 3 entries fixed: correct, wrong, complete
- Masing-masing: label, current audio URL, tombol play, tombol upload baru

**Interaksi**:
- Upload file audio → simpan ke storage `audio/sound_effects/`
- Update URL di database

**Livewire Component**: `Admin\SoundEffects`

---

## 7. Layout & Navigation

### User Layout
- **Bottom Navigation Bar** (mobile-first, fixed bottom):
  - 🏠 Beranda (`/beranda`)
  - 📚 Pelajaran (link ke beranda, scroll ke materi)
  - 📝 Kuis (`/kuis`)
  - 👤 Profil (`/profil`)
- Warna tema: hijau (primary), putih (background)
- Clean & minimal design, card-based

### Admin Layout
- **Sidebar** (desktop): menu navigasi vertikal + language switcher
- **Header**: judul halaman + avatar admin
- Responsive: sidebar collapse di mobile

---

## 8. File Storage Structure

```
storage/app/public/
├── avatars/          ← User avatar uploads
│   └── {user_id}.{ext}
├── icons/            ← Materi category icons
│   └── {random}.{ext}
├── audio/            ← Audio files
│   ├── percakapan/   ← Pronunciation audio
│   ├── soal/         ← Question audio
│   └── sound_effects/ ← Feedback sounds
│       ├── {id}_correct.mp3
│       ├── {id}_wrong.mp3
│       └── {id}_complete.mp3
```

> [!IMPORTANT]
> Jalankan `php artisan storage:link` untuk membuat symbolic link ke public.

---

## 9. Middleware

| Middleware | Route | Purpose |
|-----------|-------|---------|
| `auth` | `/beranda/*`, `/pelajaran/*`, `/latihan`, `/kuis`, `/profil`, `/pilih-bahasa` | Wajib login |
| `role:admin` | `/admin/*` | Hanya admin |
| `guest` | `/login`, `/register`, `/loginadmin` | Hanya guest |
| `language.check` | `/beranda`, `/pelajaran/*`, `/latihan`, `/kuis` | Redirect ke `/pilih-bahasa` jika belum pilih bahasa |

### Custom Middleware: `CheckLanguageSelected`
```php
// Redirect ke /pilih-bahasa jika user belum set selected_language_id
if (auth()->check() && auth()->user()->selected_language_id === null) {
    return redirect('/pilih-bahasa');
}
```

### Custom Middleware: `RoleMiddleware`
```php
// Cek role user, abort 403 jika tidak sesuai
if (auth()->user()->role !== $role) {
    abort(403, 'Akses ditolak');
}
```

---

## 10. Implementasi Plan (Fase)

> [!TIP]
> Setiap fase dirancang sebagai 1 prompt/session AI coding. Copy-paste header fase + detail ke Antigravity.

---

### 📋 FASE 0: Project Setup & Foundation
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Buat project Laravel 12 baru untuk aplikasi SABARA (pembelajaran bahasa daerah).
Setup:
1. Install Laravel 12 via composer
2. Install Livewire 3
3. Install Tailwind CSS v4
4. Setup database migrations untuk semua tabel (lihat schema di PRD Section 3)
5. Buat semua Eloquent Models dengan relationships
6. Setup Laravel Auth (Breeze) dengan customisasi:
   - Tambah field 'role', 'selected_language_id', 'avatar_url' di users
   - Modifikasi RegisterController untuk set role='user' default
7. Buat custom middleware: CheckLanguageSelected, RoleMiddleware
8. Setup routing dasar (routes/web.php) sesuai PRD Section 5
9. Buat Seeder untuk data awal: 1 admin user, 1 language (Bengkulu), sample materi
10. Setup storage link + disk configuration
```

**Deliverables**:
- [ ] Fresh Laravel project
- [ ] Semua migration files
- [ ] Semua Eloquent models
- [ ] Auth flow (login, register)
- [ ] Middleware
- [ ] Base routes
- [ ] Seeder data awal

---

### 📋 FASE 1: Authentication & Pilih Bahasa
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Implementasi authentication dan pilih bahasa untuk SABARA Laravel.

1. Halaman Login (/login):
   - Form email + password, desain bersih dengan card center
   - Setelah login: cek selected_language_id, redirect ke /pilih-bahasa jika null, /beranda jika ada
   - Link ke /register

2. Halaman Register (/register):
   - Form: nama, email, password, konfirmasi password
   - Setelah register, redirect ke /pilih-bahasa

3. Halaman Login Admin (/loginadmin):
   - Form email + password
   - Validasi role admin setelah auth. Jika bukan admin → logout + error
   - Redirect ke /admin jika berhasil

4. Halaman Pilih Bahasa (/pilih-bahasa) - Livewire Component:
   - Tampilkan grid card bahasa aktif
   - Klik → update selected_language_id
   - Redirect ke /beranda

Gunakan Tailwind CSS, tema hijau, mobile-first responsive.
```

---

### 📋 FASE 2: Beranda & Profil User
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Implementasi halaman Beranda dan Profil untuk SABARA Laravel.

1. Layout User (layouts/user.blade.php):
   - Bottom navigation bar (fixed, mobile-first): Beranda, Pelajaran, Kuis, Profil
   - Icons menggunakan Lucide/Heroicons
   - Active state indicator

2. Beranda (/beranda) - Livewire Component:
   - Header: avatar user, nama, bahasa dipilih
   - Card ranking + total poin
   - Daftar materi dikelompokkan berdasarkan category
   - Setiap materi card: icon, title, progress bar (completed/total levels)
   - Klik materi → /pelajaran/{materiId}
   - Poin = sum(latihan_progress.score × 10) + max(quiz_results.score)
   - Rank = urutan user berdasarkan total poin (descending)

3. Profil (/profil) - Livewire Component:
   - Avatar (dengan upload baru)
   - Nama (editable)
   - Email (read-only)
   - Bahasa dipilih
   - Statistik: total poin, rank, total latihan, akurasi, poin latihan, skor kuis tertinggi
   - Tombol logout
```

---

### 📋 FASE 3: Pelajaran & Latihan
**Estimasi**: 1–2 sessions

**Prompt untuk AI**:
```
Implementasi halaman Pelajaran Detail dan Mode Latihan untuk SABARA Laravel.

1. Pelajaran Detail (/pelajaran/{materiId}) - Livewire:
   - Info materi (title, category, desc, icon)
   - Daftar percakapan (dialog 2 speaker, Indonesia ↔ Bengkulu)
   - Tombol play audio jika tersedia
   - Daftar level latihan dengan progress (bintang yang didapat)
   - Klik level → /latihan?categoryId={id}&level={level}

2. Mode Latihan (/latihan?categoryId=x&level=y) - Livewire:
   - Load soal dari soal_latihan berdasarkan categoryId + level
   - Shuffle soal secara random
   - Tampilkan 1 soal per waktu dengan progress bar

   Jenis soal:
   a. multiple_choice: pertanyaan + 4 tombol. Klik → hijau/merah
   b. matching: 2 kolom drag-and-drop (gunakan SortableJS + Alpine.js)
   c. audio: tombol play + 4 opsi teks
   d. reading: passage teks + pertanyaan + 4 opsi

   Flow:
   - Jawab → feedback warna + sound effect → delay → next question
   - Selesai → summary (skor X/Y, bintang 1-3)
   - Simpan ke latihan_progress (upsert: user_id + materi_id + level)

   Sound effects: fetch dari tabel sound_effects, play via JS Audio API
```

---

### 📋 FASE 4: Kuis & Leaderboard
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Implementasi halaman Kuis dan Leaderboard untuk SABARA Laravel.

1. Halaman Kuis (/kuis) - Livewire:
   - Bagian Leaderboard:
     - Podium top 3 (medal gold/silver/bronze, avatar, nama, skor)
     - Tabel ranking sisanya
     - Ranking berdasarkan MAX quiz_results.score per user
   - CTA "Mulai Kuis" (tampilkan hanya jika ada soal tersedia)

   Flow Kuis:
   - Klik mulai → load soal random dari soal_kuis (filter language_id)
   - Multiple choice, 1 soal per waktu
   - Feedback langsung per jawaban + sound effect
   - Selesai → summary skor + simpan quiz_results

2. Tampilan kuis mirip mode latihan (konsisten UX)
```

---

### 📋 FASE 5: Admin Dashboard & Materi CRUD
**Estimasi**: 1–2 sessions

**Prompt untuk AI**:
```
Implementasi Admin Dashboard dan CRUD Materi untuk SABARA Laravel.

1. Admin Layout (layouts/admin.blade.php):
   - Sidebar (desktop): menu navigasi + language switcher dropdown
   - Header: judul halaman + avatar admin
   - Responsive: sidebar hidden di mobile, toggle button

2. Admin Dashboard (/admin) - Livewire:
   - Cards statistik: total materi, soal latihan, soal kuis, users
   - Language switcher (simpan di session/cookie)

3. Admin Materi (/admin/materi) - Livewire:
   - Tabel daftar materi (title, category, jumlah content)
   - Filter by language
   - Modal form: Tambah/Edit materi (title, category, desc, upload icon)
   - Tombol hapus dengan konfirmasi

4. Admin Materi Detail (/admin/materi/{id}) - Livewire:
   Tab Percakapan:
   - Daftar percakapan sortable (drag & drop reorder via SortableJS)
   - Form tambah/edit: indonesia, bengkulu, speaker (1/2)
   - Hapus per baris

   Tab Soal Latihan:
   - Daftar soal grouped by level+star
   - Form tambah/edit dinamis berdasarkan type:
     * multiple_choice: question + 4 opsi + answer + level + star
     * matching: dynamic pairs input + level + star
     * audio: upload audio + 4 opsi + answer + level + star
     * reading: passage + question + 4 opsi + answer + level + star
   - Duplikat soal
   - Bulk create (textarea JSON)
   - Hapus per soal
```

---

### 📋 FASE 6: Admin Kuis, Users, Sound Effects
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Implementasi halaman Admin Kuis, Users, dan Sound Effects untuk SABARA Laravel.

1. Admin Kuis (/admin/kuis) - Livewire:
   - Tabel daftar soal kuis (question preview, difficulty)
   - Filter by difficulty
   - Modal form: Tambah/Edit (question, 4 opsi, jawaban, difficulty)
   - Hapus dengan konfirmasi

2. Admin Users (/admin/users) - Livewire:
   - Tabel daftar user (nama, email, role, created_at)
   - Toggle role (user ↔ admin) per user
   - Optional: Export Excel (Laravel Excel package)

3. Admin Sound Effects (/admin/sound-effects) - Livewire:
   - 3 card fixed: correct, wrong, complete
   - Masing-masing: label, current audio, tombol play preview, form upload baru
   - Upload → simpan ke storage audio/sound_effects/ → update DB
```

---

### 📋 FASE 7: Admin Pengunjung & Analytics
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Implementasi tracking pengunjung dan analytics admin untuk SABARA Laravel.

1. Visitor Tracking Middleware/Component:
   - Log setiap page visit ke visitor_logs
   - Data: session_id (dari cookie), path, user_agent
   - Jangan log admin routes dan API

2. Admin Pengunjung (/admin/pengunjung) - Livewire:
   - Card: total page views, total unique visitors
   - Chart harian (gunakan Chart.js via CDN):
     - X axis: tanggal (7-30 hari terakhir)
     - Y axis: page views + unique visitors
   - Tabel top halaman (path + jumlah views)
   - Tabel log terbaru (path, user agent, timestamp)
```

---

### 📋 FASE 8: Polish, PWA, & Testing
**Estimasi**: 1 session

**Prompt untuk AI**:
```
Polish dan finalisasi aplikasi SABARA Laravel.

1. UI Polish:
   - Pastikan semua halaman responsive (mobile-first)
   - Loading states untuk semua Livewire component
   - Error handling yang user-friendly (flash messages, toasts)
   - Empty states (tampilan ketika data kosong)

2. PWA (Opsional):
   - Install laravel-pwa package
   - Setup manifest.json
   - Service worker untuk offline caching

3. Performance:
   - Eager loading relationships (N+1 prevention)
   - Database indexing pada kolom yang sering di-query
   - Cache leaderboard + ranking (5 menit)

4. Security:
   - Laravel Policies untuk semua model
   - Validate semua input (Form Requests)
   - Rate limiting di auth routes
   - CSRF protection (built-in Laravel)
```

---

## 11. Environment Variables

```env
APP_NAME=SABARA
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sabara
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

---

## 12. Package Dependencies

```json
{
  "require": {
    "laravel/framework": "^12.0",
    "livewire/livewire": "^3.0",
    "laravel/breeze": "^2.0",
    "maatwebsite/excel": "^3.1"
  },
  "require-dev": {
    "laravel/pint": "^1.0",
    "pestphp/pest": "^3.0"
  },
  "npm": {
    "tailwindcss": "^4.0",
    "sortablejs": "^1.15",
    "chart.js": "^4.0",
    "@tailwindcss/forms": "^0.5"
  }
}
```

---

## 13. Checklist Validasi Final

- [ ] Login/Register user berfungsi
- [ ] Login admin berfungsi (hanya role admin)
- [ ] Pilih bahasa dan redirect benar
- [ ] Beranda menampilkan materi + progress + ranking
- [ ] Pelajaran detail menampilkan percakapan + level
- [ ] Latihan semua jenis soal berfungsi (MC, matching, audio, reading)
- [ ] Sound effects berjalan saat jawab soal
- [ ] Progress latihan tersimpan di database
- [ ] Kuis berjalan dengan soal random
- [ ] Leaderboard menampilkan ranking benar
- [ ] Profil bisa diedit (nama, avatar)
- [ ] Admin CRUD materi berfungsi
- [ ] Admin CRUD percakapan + reorder drag-drop
- [ ] Admin CRUD soal latihan (semua type)
- [ ] Admin CRUD soal kuis
- [ ] Admin manage users (toggle role)
- [ ] Admin sound effects upload berfungsi
- [ ] Admin pengunjung analytics berfungsi
- [ ] Responsive di mobile
- [ ] File upload (avatar, icon, audio) berfungsi

---

> [!NOTE]
> **Cara pakai dokumen ini**: Copy-paste setiap FASE (Section 10) satu per satu ke AI coding assistant. Sertakan juga Section 3 (Database Schema) saat Fase 0, dan Section 6 (Detail Fitur) yang relevan saat masing-masing fase.
