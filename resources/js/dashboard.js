// =====================================
// TOGGLE SIDEBAR
// =====================================

const btnToggleSidebar = document.getElementById("btn-toggle-sidebar");
const brandWrapper = document.querySelector(".brand-wrapper");
const sidebar = document.querySelector(".sidebar");

if (btnToggleSidebar && sidebar) {
    btnToggleSidebar.addEventListener("click", function (e) {
        e.stopPropagation();
        sidebar.classList.toggle("collapsed");
    });
}

// Klik logo saat collapsed untuk memperluas kembali
if (brandWrapper && sidebar) {
    brandWrapper.addEventListener("click", function () {
        if (sidebar.classList.contains("collapsed")) {
            sidebar.classList.remove("collapsed");
        }
    });
}

// =====================================
// FILTER PERIODE & INDIKATOR (GLOBAL CONTROL)
// =====================================
const filterIndikator = document.getElementById("filter-indikator");
const filterTahun = document.getElementById("filter-tahun");
const filterBulan = document.getElementById("filter-bulan");

let currentActiveIndicator = "stunting";

function handleIndicatorChange() {
    currentActiveIndicator = filterIndikator ? filterIndikator.value : "stunting";

    // Kirim event global agar peta dan modul lain mengetahui perubahan indikator
    window.dispatchEvent(
        new CustomEvent("indicatorChanged", {
            detail: {
                indicatorId: currentActiveIndicator,
            },
        })
    );

    // Update list wilayah perlu perhatian & chart tren
    updateAttentionList(currentActiveIndicator);
    const selectedYear = filterTahun ? filterTahun.value : "2024";
    initTrendChart(selectedYear, currentActiveIndicator);
}

function handlePeriodChange() {
    const selectedYear = filterTahun ? filterTahun.value : "2024";
    const selectedMonth = filterBulan ? filterBulan.value : null;

    // Trigger event custom agar peta atau kartu sinkron
    window.dispatchEvent(
        new CustomEvent("periodChanged", {
            detail: {
                year: selectedYear,
                month: selectedMonth,
                indicatorId: currentActiveIndicator,
            },
        })
    );

    initTrendChart(selectedYear, currentActiveIndicator);
}

if (filterIndikator) {
    filterIndikator.addEventListener("change", handleIndicatorChange);
}

if (filterTahun) {
    filterTahun.addEventListener("change", handlePeriodChange);
}

if (filterBulan) {
    filterBulan.addEventListener("change", handlePeriodChange);
}

// =====================================
// CHART TREN UTAMA PROVINSI (BULANAN)
// =====================================
import Chart from "chart.js/auto";
import {
    getTrenBulananProvinsi,
    getStatusIndikator,
    getIndikatorAktif,
    getTopWilayahPerhatian,
} from "./data-indikator.js";

let trendChartInstance = null;

function initTrendChart(tahun = "2024", idIndikator = "stunting") {
    const canvas = document.getElementById("trendChart");
    const chartWrapper = document.getElementById("trend-chart-wrapper");
    const emptyStateEl = document.getElementById("trend-empty-state");
    const insightPanelEl = document.getElementById("trend-insight-panel");
    const statsRowEl = document.getElementById("trend-stats-row");
    const subtitleEl = document.getElementById("trend-subtitle");

    const trenData = getTrenBulananProvinsi(tahun, idIndikator);

    if (subtitleEl) {
        subtitleEl.textContent = `Perkembangan Angka Bulanan (${tahun})`;
    }

    // Jika data kosong / belum terinput
    if (!trenData.hasData || trenData.values.length === 0) {
        if (chartWrapper) chartWrapper.style.display = "none";
        if (statsRowEl) statsRowEl.style.display = "none";
        if (insightPanelEl) insightPanelEl.style.display = "none";
        if (emptyStateEl) emptyStateEl.style.display = "flex";

        if (trendChartInstance) {
            trendChartInstance.destroy();
            trendChartInstance = null;
        }
        return;
    }

    // Jika data tersedia
    if (chartWrapper) chartWrapper.style.display = "block";
    if (statsRowEl) statsRowEl.style.display = "flex";
    if (insightPanelEl) insightPanelEl.style.display = "flex";
    if (emptyStateEl) emptyStateEl.style.display = "none";

    updateTrendUIInfo(trenData);

    if (!canvas) return;
    const ctx = canvas.getContext("2d");

    // Membuat gradien halus di bawah garis chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, "rgba(37, 99, 235, 0.28)");
    gradient.addColorStop(1, "rgba(37, 99, 235, 0.00)");

    if (trendChartInstance) {
        trendChartInstance.destroy();
    }

    trendChartInstance = new Chart(ctx, {
        type: "line",
        data: {
            labels: trenData.labels,
            datasets: [
                {
                    label: "Angka Bulanan",
                    data: trenData.values,
                    borderColor: "#2563eb",
                    borderWidth: 2.8,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: "#ffffff",
                    pointBorderColor: "#2563eb",
                    pointBorderWidth: 2.5,
                    pointRadius: 3.5,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: "#2563eb",
                    pointHoverBorderColor: "#ffffff",
                    pointHoverBorderWidth: 2.5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: "index",
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: "#0f172a",
                    titleFont: { family: "Inter, sans-serif", size: 11, weight: 500 },
                    titleColor: "#94a3b8",
                    bodyFont: { family: "Inter, sans-serif", size: 16, weight: 800 },
                    bodyColor: "#ffffff",
                    footerFont: { family: "Inter, sans-serif", size: 11, weight: 600 },
                    footerColor: "#cbd5e1",
                    padding: { top: 8, bottom: 8, left: 12, right: 12 },
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function (items) {
                            return `Perkembangan Angka Bulanan • ${items[0].label} ${trenData.tahun}`;
                        },
                        label: function (context) {
                            return `${context.parsed.y}%`;
                        },
                        afterLabel: function (context) {
                            const status = getStatusIndikator(context.parsed.y, idIndikator);
                            return `Kategori: ${status.label}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        font: { family: "Inter, sans-serif", size: 11, weight: 500 },
                        color: "#64748b",
                    },
                    border: {
                        display: false,
                    },
                },
                y: {
                    grid: {
                        color: "#f1f5f9",
                        lineWidth: 1,
                    },
                    ticks: {
                        font: { family: "Inter, sans-serif", size: 11, weight: 500 },
                        color: "#64748b",
                        callback: function (val) {
                            return val + "%";
                        },
                        stepSize: 1,
                    },
                    border: {
                        display: false,
                    },
                },
            },
        },
    });
}

function updateTrendUIInfo(trenData) {
    const insightTitleEl = document.getElementById("trend-insight-title");
    const insightDescEl = document.getElementById("trend-insight-desc");
    const avgEl = document.getElementById("trend-stat-avg");
    const minEl = document.getElementById("trend-stat-min");
    const maxEl = document.getElementById("trend-stat-max");

    const diff = trenData.perubahan;

    if (insightTitleEl) {
        if (diff < 0) {
            insightTitleEl.textContent = `Tren Menurun ${diff}%`;
        } else if (diff > 0) {
            insightTitleEl.textContent = `Tren Meningkat +${diff}%`;
        } else {
            insightTitleEl.textContent = `Tren Stabil 0.0%`;
        }
    }

    if (insightDescEl) {
        if (diff < 0) {
            insightDescEl.textContent = `Angka menunjukkan penurunan sebesar ${Math.abs(diff)}% sepanjang tahun ${trenData.tahun} dibandingkan awal tahun (${trenData.labels[0]} vs ${trenData.labels[trenData.labels.length - 1]}).`;
        } else if (diff > 0) {
            insightDescEl.textContent = `Angka menunjukkan peningkatan sebesar +${diff}% sepanjang tahun ${trenData.tahun} dibandingkan awal tahun (${trenData.labels[0]} vs ${trenData.labels[trenData.labels.length - 1]}).`;
        } else {
            insightDescEl.textContent = `Angka bertahan stabil tanpa fluktuasi signifikan sepanjang tahun ${trenData.tahun}.`;
        }
    }

    if (avgEl) avgEl.textContent = `${trenData.rataRata}%`;
    if (minEl) minEl.textContent = `${trenData.terendah?.nilai}% (${trenData.terendah?.bulan})`;
    if (maxEl) maxEl.textContent = `${trenData.tertinggi?.nilai}% (${trenData.tertinggi?.bulan})`;
}

// =====================================
// UPDATE LIST WILAYAH PERLU PERHATIAN
// =====================================
function updateAttentionList(idIndikator = "stunting") {
    const listContainer = document.getElementById("attention-list-items");
    const emptyStateEl = document.getElementById("attention-empty-state");
    const footerEl = document.getElementById("attention-footer");

    const topWilayah = getTopWilayahPerhatian(idIndikator, 5);

    if (topWilayah.length === 0) {
        if (listContainer) listContainer.style.display = "none";
        if (footerEl) footerEl.style.display = "none";
        if (emptyStateEl) emptyStateEl.style.display = "flex";
        return;
    }

    if (listContainer) listContainer.style.display = "flex";
    if (footerEl) footerEl.style.display = "block";
    if (emptyStateEl) emptyStateEl.style.display = "none";

    // Render 5 wilayah teratas
    if (listContainer) {
        listContainer.innerHTML = topWilayah
            .map((item, index) => {
                const badgeClass = `badge-${item.status.key}`;
                return `
                <div class="attention-item" data-kode="${item.kode}">
                    <div class="attention-left">
                        <span class="attention-rank">${index + 1}.</span>
                        <span class="attention-name">${item.nama}</span>
                    </div>
                    <div class="attention-badge-col">
                        <span class="badge-status ${badgeClass}">${item.status.label}</span>
                    </div>
                    <div class="attention-value-col">
                        <span class="attention-value">${item.nilai}%</span>
                    </div>
                </div>
            `;
            })
            .join("");
    }
}

// Inisialisasi saat halaman selesai dimuat
document.addEventListener("DOMContentLoaded", () => {
    const currentYear = filterTahun ? filterTahun.value : "2024";
    const activeInd = filterIndikator ? filterIndikator.value : "stunting";
    currentActiveIndicator = activeInd;

    initTrendChart(currentYear, activeInd);
    updateAttentionList(activeInd);
});


