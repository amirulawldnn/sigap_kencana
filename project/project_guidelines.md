# SIGAP KENCANA - Project & Coding Guidelines

Dokumen ini memuat standar arsitektur, konvensi kode, dan alur kerja kolaborasi untuk pengembangan aplikasi SIGAP KENCANA.

---

## 1. Alur Kolaborasi (Collaboration Workflow)
1. **Sepakati Scope**: Tentukan dan kunci target/tahapan pengerjaan terlebih dahulu sebelum coding.
2. **Eksekusi Bertahap**: AI memandu step-by-step dengan potongan kode dan penjelasan; Developer mengeksekusi langsung pada project.
3. **Validasi per Tahap**: Setiap komponen divalidasi tampilannya di browser sebelum melangkah ke komponen berikutnya.

---

## 2. Standar Struktur & Blade Template
* **Layout Induk**: Gunakan `resources/views/layouts/app.blade.php` sebagai kerangka utama.
* **Modular Partials**: Komponen UI dipecah ke dalam `resources/views/partials/`:
  * `partials/sidebar.blade.php`: Navigasi samping.
  * `partials/header.blade.php`: Topbar / breadcrumb / status.
  * `partials/stats.blade.php`: Kartu ringkasan metrik.
  * `partials/map.blade.php`: Wadah peta & panel pendukung.
* **Prinsip**: File halaman utama (`dashboard.blade.php`) hanya bertindak sebagai perakit (*assembler*) potongan-potongan partials tersebut.

---

## 3. Standar CSS & Design System
* **Tokens / CSS Variables**: Semua warna dan variabel umum didefinisikan di level `:root` pada CSS:
  * `--primary`: `#2563eb` (Biru utama)
  * `--primary-light`: `#eff6ff` (Biru lembut / background aktif)
  * `--bg-body`: `#f8fafc` (Latar belakang halaman)
  * `--bg-surface`: `#ffffff` (Latar belakang kartu/sidebar/modal)
  * `--border-color`: `#e2e8f0` (Garis pembatas halus)
  * `--text-main`: `#0f172a` (Teks utama)
  * `--text-muted`: `#64748b` (Teks sekunder/keterangan)
  * `--radius-sm`: `6px`, `--radius-md`: `10px`, `--radius-lg`: `14px`
* **Penamaan Class**: Gunakan format **kebab-case** semantik (misal: `.stat-card`, `.nav-link`, `.active-indicator`).

---

## 4. Standar JavaScript & GIS (Leaflet)
* **Pemisahan Peran**:
  * `dashboard.js`: Menangani interaksi DOM murni (toggle sidebar, filter dropdown, animasi UI).
  * `peta.js`: Menangani murni fungsionalitas peta Leaflet (layer, event click GeoJSON, drill-down hirarki, tombol back).
* **Standar Format Data Spasial**:
  * Seluruh endpoint API GIS mengembalikan GeoJSON standar (`FeatureCollection` / `Feature`).
  * Setiap properti wajib memuat identitas wilayah (`kode_...`, `nama_...`).

---

## 5. Standar Backend & Database
* **Database Fields**: Gunakan format `snake_case` (contoh: `kode_kabupaten_kota`, `nama_kecamatan`).
* **PostGIS Standard**: Gunakan SRS `4326` (WGS 84) untuk konsistensi koordinat geografis Leaflet.
