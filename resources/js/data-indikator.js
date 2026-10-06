// ============================================================================
// DATA CONTOH INDIKATOR - SIGAP KENCANA (PROVINSI JAWA TENGAH)
// ============================================================================
// File ini memuat MASTER_INDIKATOR untuk mendukung multi-indikator.
// Saat ini disiapkan 2 contoh:
// 1. "stunting" (Data Terisi Lengkap - 35 Kab/Kota)
// 2. "kemiskinan_ekstrem" (Data Belum Terinput / Kosong)
// ============================================================================

// Data Indikator 35 Kabupaten/Kota Jawa Tengah (Stunting)
export const DATA_INDIKATOR_KAB_KOTA = {
    "33.01": { nama: "Cilacap", nilai: 13.5 },
    "33.02": { nama: "Banyumas", nilai: 16.2 },
    "33.03": { nama: "Purbalingga", nilai: 14.8 },
    "33.04": { nama: "Banjarnegara", nilai: 21.4 },
    "33.05": { nama: "Kebumen", nilai: 17.5 },
    "33.06": { nama: "Purworejo", nilai: 11.2 },
    "33.07": { nama: "Wonosobo", nilai: 22.1 },
    "33.08": { nama: "Magelang", nilai: 15.6 },
    "33.09": { nama: "Boyolali", nilai: 9.8 },
    "33.10": { nama: "Klaten", nilai: 12.3 },
    "33.11": { nama: "Sukoharjo", nilai: 8.5 },
    "33.12": { nama: "Wonogiri", nilai: 11.9 },
    "33.13": { nama: "Karanganyar", nilai: 9.2 },
    "33.14": { nama: "Sragen", nilai: 16.8 },
    "33.15": { nama: "Grobogan", nilai: 18.3 },
    "33.16": { nama: "Blora", nilai: 19.5 },
    "33.17": { nama: "Rembang", nilai: 17.2 },
    "33.18": { nama: "Pati", nilai: 13.1 },
    "33.19": { nama: "Kudus", nilai: 9.4 },
    "33.20": { nama: "Jepara", nilai: 14.2 },
    "33.21": { nama: "Demak", nilai: 18.7 },
    "33.22": { nama: "Semarang", nilai: 10.5 },
    "33.23": { nama: "Temanggung", nilai: 16.4 },
    "33.24": { nama: "Kendal", nilai: 15.8 },
    "33.25": { nama: "Batang", nilai: 14.9 },
    "33.26": { nama: "Pekalongan", nilai: 17.8 },
    "33.27": { nama: "Pemalang", nilai: 20.9 },
    "33.28": { nama: "Tegal", nilai: 19.1 },
    "33.29": { nama: "Brebes", nilai: 23.5 },
    "33.72": { nama: "Kota Surakarta", nilai: 7.8 },
    "33.73": { nama: "Kota Salatiga", nilai: 8.9 },
    "33.74": { nama: "Kota Semarang", nilai: 6.4 },
    "33.75": { nama: "Kota Pekalongan", nilai: 13.9 },
    "33.76": { nama: "Kota Tegal", nilai: 12.7 },
};

// Data Tren Bulanan Prevalensi Rata-Rata Provinsi Jawa Tengah (Jan - Des)
export const DATA_TREN_BULANAN_PROVINSI = {
    "2024": [15.2, 15.0, 14.8, 14.7, 14.5, 14.3, 14.1, 14.0, 13.8, 13.7, 13.5, 13.4],
    "2023": [16.8, 16.6, 16.4, 16.2, 16.1, 15.9, 15.7, 15.6, 15.5, 15.3, 15.2, 15.1],
    "2022": [18.4, 18.2, 18.0, 17.9, 17.7, 17.5, 17.4, 17.2, 17.1, 16.9, 16.8, 16.7],
    "2021": [20.1, 19.9, 19.8, 19.6, 19.4, 19.3, 19.1, 19.0, 18.8, 18.7, 18.5, 18.3]
};

export const LABEL_BULAN_TREN = [
    "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
];

// ============================================================================
// MASTER INDIKATOR (MULTI-INDIKATOR REGISTRY)
// ============================================================================
export const MASTER_INDIKATOR = {
    stunting: {
        id: "stunting",
        nama: "Prevalensi Stunting Balita",
        satuan: "%",
        deskripsi: "Persentase balita dengan status stunting berdasarkan pengukuran wilayah",
        hasData: true,
        ambangBatas: {
            normal: { max: 10.0, label: "Normal", color: "#10b981", borderColor: "#059669", bgLight: "#ecfdf5", desc: "< 10.0%" },
            waspada: { min: 10.1, max: 15.0, label: "Waspada", color: "#f59e0b", borderColor: "#d97706", bgLight: "#fffbeb", desc: "10.1% - 15.0%" },
            siaga: { min: 15.1, max: 20.0, label: "Siaga", color: "#f97316", borderColor: "#ea580c", bgLight: "#fff7ed", desc: "15.1% - 20.0%" },
            awas: { min: 20.1, label: "Awas", color: "#ef4444", borderColor: "#dc2626", bgLight: "#fef2f2", desc: "≥ 20.1%" },
        },
        dataKabKota: DATA_INDIKATOR_KAB_KOTA,
        trenBulanan: DATA_TREN_BULANAN_PROVINSI,
    },
    kemiskinan_ekstrem: {
        id: "kemiskinan_ekstrem",
        nama: "Persentase Kemiskinan Ekstrem",
        satuan: "%",
        deskripsi: "Persentase penduduk yang tergolong dalam kemiskinan ekstrem",
        hasData: false, // SIMULASI DATA KOSONG / BELUM TERINPUT
        ambangBatas: {
            normal: { max: 1.5, label: "Normal", color: "#10b981", borderColor: "#059669", bgLight: "#ecfdf5", desc: "< 1.5%" },
            waspada: { min: 1.6, max: 3.5, label: "Waspada", color: "#f59e0b", borderColor: "#d97706", bgLight: "#fffbeb", desc: "1.6% - 3.5%" },
            siaga: { min: 3.6, max: 6.0, label: "Siaga", color: "#f97316", borderColor: "#ea580c", bgLight: "#fff7ed", desc: "3.6% - 6.0%" },
            awas: { min: 6.1, label: "Awas", color: "#ef4444", borderColor: "#dc2626", bgLight: "#fef2f2", desc: "≥ 6.1%" },
        },
        dataKabKota: {}, // Kosong
        trenBulanan: {},  // Kosong
    }
};

// Backward-compatibility alias
export const KONFIGURASI_INDIKATOR = MASTER_INDIKATOR.stunting;

/**
 * Mendapatkan konfigurasi indikator aktif
 */
export function getIndikatorAktif(id = "stunting") {
    return MASTER_INDIKATOR[id] || MASTER_INDIKATOR.stunting;
}

/**
 * Mendapatkan status & pewarnaan berdasarkan nilai indikator
 */
export function getStatusIndikator(nilai, idIndikator = "stunting") {
    if (nilai === null || nilai === undefined || isNaN(nilai)) {
        return {
            key: "nodata",
            label: "Belum Terinput",
            color: "#94a3b8",
            borderColor: "#64748b",
            bgLight: "#f8fafc",
            desc: "Data belum tersedia"
        };
    }

    const ind = getIndikatorAktif(idIndikator);
    const batas = ind.ambangBatas;

    if (nilai <= batas.normal.max) {
        return { key: "normal", ...batas.normal };
    } else if (nilai <= batas.waspada.max) {
        return { key: "waspada", ...batas.waspada };
    } else if (nilai <= batas.siaga.max) {
        return { key: "siaga", ...batas.siaga };
    } else {
        return { key: "awas", ...batas.awas };
    }
}

/**
 * Mendapatkan data indikator lengkap untuk suatu kode kabupaten/kota
 */
export function getIndikatorWilayah(kodeKabupatenKota, idIndikator = "stunting") {
    const ind = getIndikatorAktif(idIndikator);
    const data = ind.dataKabKota[kodeKabupatenKota];

    if (!ind.hasData || !data || data.nilai === null) {
        return {
            nama: data?.nama || "Kabupaten/Kota",
            nilai: null,
            satuan: ind.satuan,
            status: {
                key: "nodata",
                label: "Belum Terinput",
                color: "#94a3b8",
                borderColor: "#64748b",
                bgLight: "#f8fafc",
                desc: "Data belum diinput"
            }
        };
    }

    const status = getStatusIndikator(data.nilai, idIndikator);
    return {
        nama: data.nama,
        nilai: data.nilai,
        satuan: ind.satuan,
        status: status
    };
}

/**
 * Mendapatkan daftar wilayah teratas yang perlu perhatian
 */
export function getTopWilayahPerhatian(idIndikator = "stunting", limit = 5) {
    const ind = getIndikatorAktif(idIndikator);
    if (!ind.hasData || Object.keys(ind.dataKabKota).length === 0) {
        return [];
    }

    const list = Object.entries(ind.dataKabKota).map(([kode, item]) => {
        return {
            kode,
            nama: item.nama,
            nilai: item.nilai,
            status: getStatusIndikator(item.nilai, idIndikator)
        };
    });

    // Urutkan nilai dari tertinggi ke terendah
    list.sort((a, b) => b.nilai - a.nilai);
    return list.slice(0, limit);
}

/**
 * Mendapatkan data tren bulanan Jawa Tengah untuk tahun yang dipilih
 */
export function getTrenBulananProvinsi(tahun = "2024", idIndikator = "stunting") {
    const ind = getIndikatorAktif(idIndikator);

    if (!ind.hasData || !ind.trenBulanan || !ind.trenBulanan[tahun] || ind.trenBulanan[tahun].length === 0) {
        return {
            tahun: tahun,
            hasData: false,
            labels: LABEL_BULAN_TREN,
            values: [],
            rataRata: null,
            terendah: null,
            tertinggi: null,
            perubahan: null,
            satuan: ind.satuan
        };
    }

    const values = ind.trenBulanan[tahun];
    const sum = values.reduce((acc, curr) => acc + curr, 0);
    const avg = Number((sum / values.length).toFixed(1));
    const min = Math.min(...values);
    const max = Math.max(...values);
    const minIndex = values.indexOf(min);
    const maxIndex = values.indexOf(max);
    const diff = Number((values[values.length - 1] - values[0]).toFixed(1));

    return {
        tahun: tahun,
        hasData: true,
        labels: LABEL_BULAN_TREN,
        values: values,
        rataRata: avg,
        terendah: { nilai: min, bulan: LABEL_BULAN_TREN[minIndex] },
        tertinggi: { nilai: max, bulan: LABEL_BULAN_TREN[maxIndex] },
        perubahan: diff,
        satuan: ind.satuan
    };
}


