# Analisis Detail Aplikasi Kelulusan Web

Aplikasi Kelulusan Web ini merupakan platform berbasis Laravel yang dirancang khusus untuk memfasilitasi sekolah dalam mengelola dan mendistribusikan pengumuman kelulusan siswa secara online. Sistem ini memungkinkan sekolah untuk mengatur jadwal kelulusan, mengelola data siswa, menginput nilai, serta mempublikasikan pengumuman terkait proses kelulusan.

---

## 👥 Daftar Pengguna (User List) & Hak Akses

Sistem ini memiliki dua peran utama, yaitu:

### 1. Administrator (Admin)
Admin adalah staf sekolah atau panitia kelulusan yang memiliki akses penuh ke sistem *backend* (Admin Dashboard).
**Hak Akses:**
- Mengelola data master (Periode, Kelas, Pengguna).
- Mengelola data siswa dan nilai ujian secara massal (Import/Export Excel).
- Menentukan status kelulusan siswa.
- Mengatur konfigurasi sistem dan pratinjau sertifikat/SKL (Surat Keterangan Lulus).
- Membuat dan mempublikasikan pengumuman.

### 2. Siswa / Tamu (Guest)
Siswa adalah pengguna akhir yang mengakses portal publik (*frontend*). Mereka tidak perlu melakukan proses *login* akun yang rumit, melainkan menggunakan kredensial seperti NIS (Nomor Induk Siswa) untuk mencari data mereka pada waktu yang telah ditentukan oleh sekolah.
**Hak Akses:**
- Mengecek status kelulusan (Lulus / Tidak Lulus) beserta nilai akhir.
- Melihat dan membaca pengumuman publik yang diterbitkan sekolah.
- Mengunduh / mencetak Surat Keterangan Lulus (jika diaktifkan).

---

## 🛠️ Fitur dan Fungsi Aplikasi

Aplikasi ini dibagi menjadi dua area utama: **Area Publik (Frontend)** dan **Area Admin (Backend)**.

### A. Fitur Area Publik (Siswa)
1. **Halaman Beranda & Cek Kelulusan (`/`)**
   - **Fungsi:** Form utama bagi siswa untuk memasukkan data pencarian (seperti Nomor Ujian atau NIS).
   - **Penjelasan:** Sistem akan mencocokkan data yang diinput dengan database. Jika waktu pengumuman yang diatur oleh Admin belum tiba, sistem akan memblokir akses dan menampilkan hitung mundur (countdown). Jika sudah dibuka, sistem akan menampilkan status kelulusan siswa beserta rincian nilai ujian.
2. **Portal Pengumuman (`/announcements`)**
   - **Fungsi:** Halaman yang menampilkan daftar informasi atau pengumuman dari sekolah.
   - **Penjelasan:** Siswa dapat membaca informasi penting pasca-kelulusan, seperti jadwal cap tiga jari, pengembalian buku, atau pendaftaran ijazah.

### B. Fitur Area Admin (Backend)
1. **Dashboard (`/admin`)**
   - **Fungsi:** Halaman ringkasan statistik aplikasi.
   - **Penjelasan:** Menampilkan metrik penting secara visual seperti total siswa, jumlah siswa lulus/tidak lulus, total kelas, dan informasi periode kelulusan yang sedang aktif.

2. **Manajemen Periode Kelulusan (`/admin/graduation-periods`)**
   - **Fungsi:** Mengatur tahun ajaran dan jadwal pengumuman kelulusan.
   - **Penjelasan:** Admin dapat menentukan Tahun Ajaran, Semester, serta mengatur Tanggal dan Jam pengumuman. Fitur ini sangat krusial karena otomatis membatasi akses siswa di halaman publik sebelum waktu yang ditentukan (countdown timer).

3. **Manajemen Kelas (`/admin/school-classes`)**
   - **Fungsi:** Pendataan kelas yang ada pada periode tertentu.
   - **Penjelasan:** Berisi fungsi CRUD (Create, Read, Update, Delete) untuk mendata Nama Kelas, Jurusan, Tingkat, serta Wali Kelas.

4. **Manajemen Siswa (`/admin/students`)**
   - **Fungsi:** Mengelola data individu siswa yang akan diumumkan kelulusannya.
   - **Penjelasan:** Admin dapat menambahkan siswa secara manual, atau menggunakan fitur **Import/Export Excel** untuk memasukkan data siswa dalam jumlah besar. Terdapat template Excel yang bisa diunduh agar format sesuai. Data mencakup NIS, Nama, Kelas, Status Kelulusan, Nilai Rata-rata, dan Catatan khusus.

5. **Manajemen Nilai (`/admin/grades`)**
   - **Fungsi:** Mengelola rincian nilai mata pelajaran untuk setiap siswa.
   - **Penjelasan:** Mendukung penginputan nilai Ujian, nilai Sekolah, dan Nilai Akhir per mata pelajaran. Sama seperti data siswa, fitur ini mendukung fitur **Import/Export Excel** agar guru/admin tidak perlu menginput satu per satu.

6. **Manajemen Pengumuman (`/admin/announcements`)**
   - **Fungsi:** Modul pembuatan artikel atau berita sekolah.
   - **Penjelasan:** Admin dapat membuat, mengedit, dan mempublikasikan pengumuman. Status publikasi (Draft/Published) bisa diubah kapan saja.

7. **Pengaturan Sistem & Sertifikat (`/admin/settings`)**
   - **Fungsi:** Modul dinamis untuk mengubah konfigurasi aplikasi.
   - **Penjelasan:** Mengatur variabel penting seperti Nama Sekolah, Nama Kepala Sekolah, NIP, Logo Sekolah. Selain itu, terdapat fitur **Pratinjau Sertifikat (Certificate Preview)** untuk melakukan validasi tata letak teks dan desain Surat Keterangan Lulus (SKL) yang akan di-generate oleh sistem untuk siswa.

8. **Manajemen Pengguna (`/admin/users`)**
   - **Fungsi:** Pengelolaan akun akses untuk Admin.
   - **Penjelasan:** Fungsi standar CRUD untuk menambah staf lain yang diizinkan mengelola data kelulusan ini.

---

## ⚙️ Teknologi yang Digunakan
- **Framework Utama**: Laravel 12.x (PHP 8.2+)
- **Autentikasi**: Laravel Breeze (Blade stack)
- **Database**: MySQL / SQLite (mendukung model relasional yang efisien)
- **Ekspor/Impor Data**: Menggunakan library PhpSpreadsheet.
- **Frontend Admin**: Terintegrasi dengan TailwindCSS (kemungkinan menggunakan komponen Breeze yang dicustom).
- **Generator Dokumen**: Terdapat service pengolahan gambar (Image processing) terintegrasi untuk mencetak teks dan nilai ke atas file gambar template (Sertifikat/SKL).

---

## 🗄️ Daftar Tabel Database (Berdasarkan Migrasi)
1. `users` : Menyimpan data autentikasi Admin dan staf.
2. `students` : Menyimpan data siswa (NIS, Nama, id kelas, status kelulusan, dsb).
3. `school_classes` : Menyimpan master data kelas (Nama kelas, jurusan, wali kelas).
4. `grades` : Menyimpan rincian nilai mata pelajaran dari masing-masing siswa.
5. `graduation_periods` : Menyimpan konfigurasi periode kelulusan (Tahun ajaran, tanggal pengumuman).
6. `announcements` : Menyimpan data artikel/pengumuman sekolah.
7. `settings` : Menyimpan konfigurasi dinamis aplikasi (Nama sekolah, logo, dsb).
8. Tabel bawaan Laravel lainnya: `cache`, `jobs`, dsb.

---

## 🏗️ Struktur Arsitektur (Model & Controller)

### Daftar Model (`app/Models`)
Model merupakan representasi tabel dalam kode PHP (Eloquent ORM) untuk mempermudah operasi database.
1. `User.php` : Model untuk autentikasi admin.
2. `Student.php` : Model data siswa beserta relasinya (satu siswa memiliki banyak nilai, berada dalam satu kelas, dll).
3. `SchoolClass.php` : Model data kelas (berelasi dengan banyak siswa).
4. `GraduationPeriod.php` : Model untuk periode kelulusan (mengatur *active/inactive* tahun ajaran).
5. `Grade.php` : Model untuk data nilai siswa per mata pelajaran.
6. `Announcement.php` : Model untuk berita/pengumuman.
7. `Setting.php` : Model untuk mengambil/menyimpan pengaturan global aplikasi (sistem key-value).

### Daftar Controller (`app/Http/Controllers`)
Controller mengatur alur logika bisnis (Business Logic) dan menghubungkan request dari pengguna ke Model dan View.
**Public Controllers:**
1. `GraduationController.php` : Menangani *request* pencarian kelulusan di halaman beranda.
2. `AnnouncementController.php` : Menangani *request* daftar pengumuman untuk siswa/publik.
3. `ProfileController.php` : Menangani ubah profil pengguna yang sedang login.

**Admin Controllers (`app/Http/Controllers/Admin`):**
1. `DashboardController.php` : Menyiapkan data agregasi/statistik untuk halaman dashboard.
2. `StudentController.php` : Logika CRUD dan fitur Import/Export data siswa.
3. `SchoolClassController.php` : Logika CRUD data kelas.
4. `GradeController.php` : Logika CRUD dan Import/Export nilai siswa per mata pelajaran.
5. `GraduationPeriodController.php` : Logika CRUD dan pengaturan jadwal pengumuman.
6. `AnnouncementController.php` : Logika CRUD pengumuman dan publikasinya.
7. `SettingController.php` : Logika penyimpanan pengaturan sistem dan proses pratinjau SKL/Sertifikat.
8. `UserController.php` : Logika manajemen staf/admin tambahan.

---

## 🖥️ Daftar View (Tampilan Antarmuka)

View (`resources/views`) berisi template HTML/Blade yang akan dirender di browser pengguna.

**A. Publik / Tamu (Guest)**
1. `graduation/index.blade.php` : Tampilan beranda dan form input pencarian kelulusan.
2. `graduation/result.blade.php` : Tampilan hasil pencarian yang berisi detail kelulusan dan nilai siswa.
3. `announcements/index.blade.php` : Tampilan daftar pengumuman.
4. `announcements/show.blade.php` : Tampilan detail isi pengumuman.
5. `layouts/guest.blade.php` : Layout *wrapper* utama untuk tampilan pengunjung publik.

**B. Admin (Backend)**
1. `admin/dashboard.blade.php` : Halaman dashboard berisikan ringkasan data.
2. Direktori `admin/students/` : Halaman index (daftar), create (tambah), dan edit data siswa.
3. Direktori `admin/school-classes/` : Halaman index, create, dan edit kelas.
4. Direktori `admin/grades/` : Halaman pendataan nilai siswa.
5. Direktori `admin/graduation-periods/` : Halaman pengaturan periode kelulusan.
6. Direktori `admin/announcements/` : Halaman manajemen pengumuman sekolah.
7. Direktori `admin/settings/` : Halaman formulir konfigurasi sekolah dan preview surat kelulusan.
8. Direktori `admin/users/` : Halaman manajemen akun admin.
9. `layouts/app.blade.php` : Layout *wrapper* utama untuk halaman Admin (menyediakan sidebar/navbar).
