<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP KENCANA - Dashboard Kependudukan</title>

    <!-- Font Modern -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/dashboard.css'])
</head>
<body>

    <div class="dashboard-container">
        
                <!-- SIDEBAR (KIRI) -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-wrapper" title="SIGAP KENCANA">
                    <div class="brand-logo-icon">SK</div>
                    <h2 class="brand-title">SIGAP KENCANA</h2>
                </div>
                <button id="btn-toggle-sidebar" class="btn-sidebar-toggle" title="Tutup / Buka Sidebar" aria-label="Tutup atau Buka Sidebar">
                    <!-- Ikon panah (aktif saat sidebar terbuka) -->
                    <svg class="toggle-icon icon-collapse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    <!-- Ikon garis tiga / hamburger (aktif saat sidebar ramping) -->
                    <svg class="toggle-icon icon-expand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <nav class="sidebar-nav">
                <!-- Menu Dashboard Aktif (Ada Active Pill di Kiri & Ikon Home) -->
                <a href="/dashboard" class="nav-link active" title="Dashboard">
                    <span class="active-indicator"></span>
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                        <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z" />
                    </svg>
                    <span class="nav-label">Dashboard</span>
                </a>

                <!-- Menu Peta Wilayah -->
                <a href="/peta" class="nav-link" title="Peta Tematik">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.69A1.125 1.125 0 003 6.696v11.548c0 .835.88 1.38 1.628 1.005l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                    <span class="nav-label">Peta Tematik</span>
                </a>

                <!-- Menu Data Wilayah -->
                <a href="#" class="nav-link" title="Kependudukan">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span class="nav-label">Kependudukan</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <small class="footer-full">Provinsi Jawa Tengah</small>
                <small class="footer-mini">JT</small>
            </div>
        </aside>



        <!-- AREA UTAMA -->
        <div class="main-wrapper">
            
            <!-- HEADER ATAS (MODERN FLOATING CARD) -->
            <header class="top-header">
                <!-- JUDUL HALAMAN (AREA KIRI) -->
                <div class="header-left">
                    <h1 class="header-title">Dashboard</h1>
                </div>

                <!-- AREA KANAN (SEARCH & PROFIL) -->
                <div class="header-right">
                    <!-- FITUR SEARCH WILAYAH -->
                    <div class="header-search">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text" id="header-search-input" placeholder="Cari wilayah, kabupaten, kecamatan..." autocomplete="off">
                    </div>

                    <!-- PROFIL USER (POJOK KANAN) -->
                    <div class="header-profile" title="Profil Administrator">
                        <div class="profile-avatar">
                            <span>AD</span>
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">Administrator</span>
                            <span class="profile-role">Bappeda Jateng</span>
                        </div>
                    </div>
                </div>
            </header>


            <!-- KONTEN -->
            <main class="content-body">
                
                
                <!-- HEADER DASHBOARD: UCAPAN SELAMAT DATANG & FILTER PERIODE -->
                <div class="welcome-section">
                    <div class="welcome-text">
                        <h2 class="welcome-title">Selamat Datang di <span class="app-name">SIGAP KENCANA</span></h2>
                        <p class="welcome-subtitle">Sistem Informasi Geografis Visualisasi Spasial Kependudukan Jawa Tengah</p>
                        <div class="welcome-location">
                            <svg class="location-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span>Provinsi Jawa Tengah</span>
                        </div>
                    </div>

                    <!-- GRID CONTENT / CARD FILTER PERIODE & INDIKATOR -->
                    <div class="period-filter-card">
                        <div class="filter-header">
                            <svg class="filter-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                            <span class="filter-title">Parameter & Periode</span>
                        </div>
                        <div class="filter-controls">
                            <div class="filter-item filter-item-indicator">
                                <label for="filter-indikator" class="filter-label">Pilih Indikator</label>
                                <div class="select-wrapper">
                                    <select id="filter-indikator" class="period-select">
                                        <option value="stunting" selected>Prevalensi Stunting Balita</option>
                                        <option value="kemiskinan_ekstrem">Persentase Kemiskinan Ekstrem (Data Kosong)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-item">
                                <label for="filter-tahun" class="filter-label">Tahun</label>
                                <div class="select-wrapper">
                                    <select id="filter-tahun" class="period-select">
                                        <option value="2024" selected>2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-item">
                                <label for="filter-bulan" class="filter-label">Bulan</label>
                                <div class="select-wrapper">
                                    <select id="filter-bulan" class="period-select">
                                        <option value="all">Semua Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- KARTU RINGKASAN METRIK STATUS WILAYAH (4 STATUS) -->
                <div class="stats-row">
                    <!-- KARTU 1: NORMAL -->
                    <div class="stat-card stat-card-normal">
                        <div class="stat-value" id="stat-count-normal">7 <span class="stat-unit">Kab/Kota</span></div>
                        <span class="stat-status-label">Normal</span>
                    </div>

                    <!-- KARTU 2: WASPADA -->
                    <div class="stat-card stat-card-waspada">
                        <div class="stat-value" id="stat-count-waspada">11 <span class="stat-unit">Kab/Kota</span></div>
                        <span class="stat-status-label">Waspada</span>
                    </div>

                    <!-- KARTU 3: SIAGA -->
                    <div class="stat-card stat-card-siaga">
                        <div class="stat-value" id="stat-count-siaga">12 <span class="stat-unit">Kab/Kota</span></div>
                        <span class="stat-status-label">Siaga</span>
                    </div>

                    <!-- KARTU 4: AWAS -->
                    <div class="stat-card stat-card-awas">
                        <div class="stat-value" id="stat-count-awas">4 <span class="stat-unit">Kab/Kota</span></div>
                        <span class="stat-status-label">Awas</span>
                    </div>
                </div>

                <!-- WADAH PETA (HERO MAP CARD) -->
                <div class="map-card">
                    <div class="map-card-header">
                        <div>
                            <h3 id="map-header-title">Peta Spasial Tematik Indikator Wilayah</h3>
                            <p>Visualisasi spasial: <strong id="map-indicator-name">Prevalensi Stunting Balita</strong> per Kabupaten/Kota</p>
                        </div>
                        <div class="map-card-badge">
                            <span class="badge-dot"></span> Peta Tematik Aktif
                        </div>
                    </div>
                    <div id="map"></div>
                </div>

                <!-- BARIS GRID KONTEN BAWAH (2 KOLOM: KIRI & KANAN) -->
                <div class="bottom-grid-row">
                    <!-- KOLOM KIRI: LIST WILAYAH PERLU PERHATIAN (TOP 5 KABUPATEN) -->
                    <div class="bottom-grid-col">
                        <div class="attention-card">
                            <div class="attention-header">
                                <div class="attention-title-wrapper">
                                    <h4 class="attention-title">Wilayah Perlu Perhatian</h4>
                                    <span class="attention-subtitle">5 Kabupaten dengan nilai indikator tertinggi di Jawa Tengah</span>
                                </div>
                            </div>

                            <div class="attention-list" id="attention-list-items">
                                <!-- ITEM 1: BREBES -->
                                <div class="attention-item" data-kode="33.29">
                                    <div class="attention-left">
                                        <span class="attention-rank">1.</span>
                                        <span class="attention-name">Kabupaten Brebes</span>
                                    </div>
                                    <div class="attention-badge-col">
                                        <span class="badge-status badge-awas">Awas</span>
                                    </div>
                                    <div class="attention-value-col">
                                        <span class="attention-value">23.5%</span>
                                    </div>
                                </div>

                                <!-- ITEM 2: WONOSOBO -->
                                <div class="attention-item" data-kode="33.07">
                                    <div class="attention-left">
                                        <span class="attention-rank">2.</span>
                                        <span class="attention-name">Kabupaten Wonosobo</span>
                                    </div>
                                    <div class="attention-badge-col">
                                        <span class="badge-status badge-awas">Awas</span>
                                    </div>
                                    <div class="attention-value-col">
                                        <span class="attention-value">22.1%</span>
                                    </div>
                                </div>

                                <!-- ITEM 3: BANJARNEGARA -->
                                <div class="attention-item" data-kode="33.04">
                                    <div class="attention-left">
                                        <span class="attention-rank">3.</span>
                                        <span class="attention-name">Kabupaten Banjarnegara</span>
                                    </div>
                                    <div class="attention-badge-col">
                                        <span class="badge-status badge-awas">Awas</span>
                                    </div>
                                    <div class="attention-value-col">
                                        <span class="attention-value">21.4%</span>
                                    </div>
                                </div>

                                <!-- ITEM 4: PEMALANG -->
                                <div class="attention-item" data-kode="33.27">
                                    <div class="attention-left">
                                        <span class="attention-rank">4.</span>
                                        <span class="attention-name">Kabupaten Pemalang</span>
                                    </div>
                                    <div class="attention-badge-col">
                                        <span class="badge-status badge-awas">Awas</span>
                                    </div>
                                    <div class="attention-value-col">
                                        <span class="attention-value">20.9%</span>
                                    </div>
                                </div>

                                <!-- ITEM 5: BLORA -->
                                <div class="attention-item" data-kode="33.16">
                                    <div class="attention-left">
                                        <span class="attention-rank">5.</span>
                                        <span class="attention-name">Kabupaten Blora</span>
                                    </div>
                                    <div class="attention-badge-col">
                                        <span class="badge-status badge-siaga">Siaga</span>
                                    </div>
                                    <div class="attention-value-col">
                                        <span class="attention-value">19.5%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- EMPTY STATE WILAYAH PERLU PERHATIAN -->
                            <div class="empty-state-box" id="attention-empty-state" style="display: none;">
                                <div class="empty-state-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                </div>
                                <h5 class="empty-state-title">Data Belum Terinput</h5>
                                <p class="empty-state-desc">Belum ada rekaman angka wilayah untuk indikator yang dipilih.</p>
                            </div>

                            <div class="attention-footer" id="attention-footer">
                                <button type="button" class="btn-see-all" id="btn-see-all-wilayah">
                                    <span>Lihat Semua Wilayah</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: TREN UTAMA PROVINSI -->
                    <div class="bottom-grid-col">
                        <div class="trend-card">
                            <div class="trend-header">
                                <div class="trend-title-wrapper">
                                    <h3 class="trend-title">Tren Utama Provinsi</h3>
                                    <p class="trend-subtitle" id="trend-subtitle">Perkembangan Angka Bulanan (2024)</p>
                                </div>
                            </div>

                            <!-- CHART WRAPPER (SAAT DATA ADA) -->
                            <div class="trend-chart-wrapper" id="trend-chart-wrapper">
                                <canvas id="trendChart"></canvas>
                            </div>

                            <!-- EMPTY STATE TREN BULANAN (SAAT DATA KOSONG) -->
                            <div class="empty-state-box" id="trend-empty-state" style="display: none;">
                                <div class="empty-state-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                    </svg>
                                </div>
                                <h5 class="empty-state-title">Data Tren Belum Terinput</h5>
                                <p class="empty-state-desc">Belum ada seri data bulanan untuk indikator ini pada tahun terpilih.</p>
                            </div>

                            <!-- PANEL WAWASAN DATA (UNBOXED & CLEAN MENGGUNAKAN H2) -->
                            <div class="trend-insight-clean" id="trend-insight-panel">
                                <h2 class="trend-insight-heading" id="trend-insight-title">Tren Menurun -1.8%</h2>
                                <p class="trend-insight-desc" id="trend-insight-desc">Angka menunjukkan penurunan sepanjang tahun 2024 dibandingkan awal tahun.</p>
                            </div>

                            <div class="trend-stats-row" id="trend-stats-row">
                                <div class="trend-stat-chip">
                                    <span class="chip-label">Rata-rata:</span>
                                    <span class="chip-value" id="trend-stat-avg">14.3%</span>
                                </div>
                                <div class="trend-stat-chip">
                                    <span class="chip-label">Terendah:</span>
                                    <span class="chip-value" id="trend-stat-min">13.4% (Des)</span>
                                </div>
                                <div class="trend-stat-chip">
                                    <span class="chip-label">Tertinggi:</span>
                                    <span class="chip-value" id="trend-stat-max">15.2% (Jan)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

        </div>

    </div>

    @vite(['resources/js/dashboard.js','resources/js/peta.js'])
</body>
</html>
