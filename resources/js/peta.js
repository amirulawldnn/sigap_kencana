import L from "leaflet";
import {
    getIndikatorWilayah,
    getIndikatorAktif,
    getStatusIndikator,
} from "./data-indikator.js";

const map = L.map("map").setView([-7.15, 110.14], 8);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors",
}).addTo(map);

let currentIndicatorId = "stunting";

// =====================================
// LAYER
// =====================================

const provinsiLayer = L.layerGroup();
const kabupatenKotaLayer = L.layerGroup().addTo(map);
const kecamatanLayer = L.layerGroup();


// =====================================
// SINKRONISASI KARTU METRIK DASHBOARD (4 STATUS)
// =====================================

function updateDashboardStats() {
    const ind = getIndikatorAktif(currentIndicatorId);
    const elNormal = document.getElementById("stat-count-normal");
    const elWaspada = document.getElementById("stat-count-waspada");
    const elSiaga = document.getElementById("stat-count-siaga");
    const elAwas = document.getElementById("stat-count-awas");

    if (!ind.hasData || !ind.dataKabKota || Object.keys(ind.dataKabKota).length === 0) {
        if (elNormal) elNormal.innerHTML = `0 <span class="stat-unit">Kab/Kota</span>`;
        if (elWaspada) elWaspada.innerHTML = `0 <span class="stat-unit">Kab/Kota</span>`;
        if (elSiaga) elSiaga.innerHTML = `0 <span class="stat-unit">Kab/Kota</span>`;
        if (elAwas) elAwas.innerHTML = `0 <span class="stat-unit">Kab/Kota</span>`;
        return;
    }

    const values = Object.values(ind.dataKabKota);
    const batas = ind.ambangBatas;

    const normalCount = values.filter((v) => v.nilai <= batas.normal.max).length;
    const waspadaCount = values.filter(
        (v) => v.nilai > batas.normal.max && v.nilai <= batas.waspada.max
    ).length;
    const siagaCount = values.filter(
        (v) => v.nilai > batas.waspada.max && v.nilai <= batas.siaga.max
    ).length;
    const awasCount = values.filter((v) => v.nilai >= batas.awas.min).length;

    if (elNormal)
        elNormal.innerHTML = `${normalCount} <span class="stat-unit">Kab/Kota</span>`;
    if (elWaspada)
        elWaspada.innerHTML = `${waspadaCount} <span class="stat-unit">Kab/Kota</span>`;
    if (elSiaga)
        elSiaga.innerHTML = `${siagaCount} <span class="stat-unit">Kab/Kota</span>`;
    if (elAwas)
        elAwas.innerHTML = `${awasCount} <span class="stat-unit">Kab/Kota</span>`;
}

function setWilayahAktif(nama, info) {
    if (!info || !info.status) return;

    // Sorot kartu kategori yang sesuai dengan wilayah yang diklik
    document.querySelectorAll(".stat-card").forEach((card) => {
        card.classList.remove("stat-card-active");
    });
    const targetCard = document.querySelector(`.stat-card-${info.status.key}`);
    if (targetCard) {
        targetCard.classList.add("stat-card-active");
    }
}

function resetWilayahAktif() {
    document.querySelectorAll(".stat-card").forEach((card) => {
        card.classList.remove("stat-card-active");
    });
}

// Reset sorot kartu saat klik di luar poligon
map.on("click", function (e) {
    if (!e.originalEvent._isPolygonClick) {
        resetWilayahAktif();
    }
});


// =====================================
// TOMBOL MUNDUR (BACK BUTTON)
// =====================================

let currentLevel = "kabupaten"; // Default langsung tampilkan level Kabupaten/Kota

const backControl = L.control({ position: "topright" });

backControl.onAdd = function () {
    const div = L.DomUtil.create("div", "leaflet-bar");
    div.innerHTML = `
        <button id="btn-back" style="
            display: none;
            background: white;
            border: 2px solid #ccc;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        ">⬅ Kembali ke Kabupaten/Kota</button>
    `;
    return div;
};

backControl.addTo(map);

const btnBack = document.getElementById("btn-back");

btnBack.addEventListener("click", function () {
    if (currentLevel === "kecamatan") {
        kecamatanLayer.clearLayers();
        map.removeLayer(kecamatanLayer);
        map.setView([-7.15, 110.14], 8);

        loadKabupatenKota();
    } else if (currentLevel === "provinsi") {
        provinsiLayer.clearLayers();
        map.removeLayer(provinsiLayer);
        map.setView([-7.15, 110.14], 8);

        loadKabupatenKota();
    }
});

function updateBackButton(level) {
    currentLevel = level;
    if (level === "kabupaten") {
        btnBack.style.display = "none";
    } else if (level === "kecamatan") {
        btnBack.style.display = "block";
        btnBack.innerText = "⬅ Kembali ke Seluruh Kab/Kota";
    }
}


// =====================================
// LOAD KABUPATEN / KOTA (CHOROPLETH INDIKATOR)
// =====================================

function loadKabupatenKota() {
    updateBackButton("kabupaten");
    updateDashboardStats();

    fetch("/api/kabupaten-kota")
        .then((response) => response.json())
        .then((data) => {
            kabupatenKotaLayer.clearLayers();

            let kabupatenLayersMap = {};

            const geoJsonLayer = L.geoJSON(data, {
                style: function (feature) {
                    const info = getIndikatorWilayah(
                        feature.properties.kode_kabupaten_kota,
                        currentIndicatorId
                    );
                    return {
                        color: info.status.borderColor || "#ffffff",
                        weight: 1.5,
                        fillColor: info.status.color || "#94a3af",
                        fillOpacity: info.nilai === null ? 0.35 : 0.72,
                    };
                },
                onEachFeature: function (feature, layer) {
                    const kode = feature.properties.kode_kabupaten_kota;
                    kabupatenLayersMap[kode] = layer;

                    const info = getIndikatorWilayah(kode, currentIndicatorId);

                    // Tooltip ringkas saat kursor menyorot
                    const tooltipText = info.nilai !== null
                        ? `<strong>${feature.properties.nama_kabupaten_kota}</strong>: ${info.nilai}% (${info.status.label})`
                        : `<strong>${feature.properties.nama_kabupaten_kota}</strong>: Data Belum Terinput`;

                    layer.bindTooltip(tooltipText, { sticky: true, opacity: 0.95 });

                    // Popup detail dengan kartu badge
                    layer.bindPopup(
                        `
                        <div class="popup-card">
                            <div class="popup-title">${feature.properties.nama_kabupaten_kota}</div>
                            <div class="popup-meta">
                                <div class="popup-val">${info.nilai !== null ? info.nilai + "%" : "Belum Terinput"}</div>
                                <div class="popup-badge" style="background: ${info.status.bgLight}; color: ${info.status.color}; border: 1px solid ${info.status.borderColor};">
                                    <span class="popup-badge-dot" style="background: ${info.status.color};"></span>
                                    ${info.status.label}
                                </div>
                            </div>
                            <div class="popup-footer">Kode: ${feature.properties.kode_kabupaten_kota} &bull; Klik ganda untuk drill-down kecamatan</div>
                        </div>
                    `,
                        { className: "custom-map-popup" }
                    );

                    // Event Hover & Klik
                    layer.on({
                        mouseover: function (e) {
                            const target = e.target;
                            target.setStyle({
                                weight: 2.5,
                                color: "#0f172a",
                                fillOpacity: info.nilai === null ? 0.55 : 0.88,
                            });
                            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                target.bringToFront();
                            }
                        },
                        mouseout: function (e) {
                            geoJsonLayer.resetStyle(e.target);
                        },
                        click: function (e) {
                            e.originalEvent._isPolygonClick = true;
                            setWilayahAktif(
                                feature.properties.nama_kabupaten_kota,
                                info
                            );
                        },
                        dblclick: function (e) {
                            kabupatenKotaLayer.clearLayers();
                            loadKecamatan(
                                feature.properties.kode_kabupaten_kota
                            );
                        },
                    });
                },
            }).addTo(kabupatenKotaLayer);

            map.addLayer(kabupatenKotaLayer);

            // Hubungkan klik daftar wilayah prioritas ke peta interaktif
            document.querySelectorAll(".attention-item").forEach((item) => {
                item.onclick = function () {
                    const kode = this.getAttribute("data-kode");
                    const targetLayer = kabupatenLayersMap[kode];
                    if (targetLayer) {
                        map.flyToBounds(targetLayer.getBounds(), {
                            padding: [40, 40],
                            maxZoom: 9.5,
                            duration: 0.8,
                        });
                        targetLayer.openPopup();
                        const info = getIndikatorWilayah(kode, currentIndicatorId);
                        setWilayahAktif(info.nama, info);
                    }
                };
            });
        });
}

// Listener saat indikator diganti
window.addEventListener("indicatorChanged", (e) => {
    currentIndicatorId = e.detail?.indicatorId || "stunting";
    const ind = getIndikatorAktif(currentIndicatorId);
    const mapIndicatorName = document.getElementById("map-indicator-name");
    if (mapIndicatorName) {
        mapIndicatorName.textContent = ind.nama;
    }
    loadKabupatenKota();
});

// Panggil pertama kali saat halaman dibuka: Langsung tampilkan 35 Kab/Kota berwarna tematik
loadKabupatenKota();


// =====================================
// LOAD KECAMATAN
// =====================================

function loadKecamatan(kodeKabupatenKota) {
    updateBackButton("kecamatan");

    fetch(`/api/kecamatan/${kodeKabupatenKota}`)
        .then((response) => response.json())
        .then((data) => {
            kecamatanLayer.clearLayers();

            const geoJsonLayer = L.geoJSON(data, {
                style: {
                    color: "#16a34a",
                    weight: 1,
                    fillColor: "#4ade80",
                    fillOpacity: 0.3,
                },
                onEachFeature: function (feature, layer) {
                    layer.bindPopup(`
                        <strong>${feature.properties.nama_kecamatan}</strong><br>
                        Kab/Kota: ${feature.properties.nama_kabupaten_kota}<br>
                        Kode: ${feature.properties.kode_kecamatan}
                    `);
                },
            }).addTo(kecamatanLayer);

            map.addLayer(kecamatanLayer);
            map.fitBounds(geoJsonLayer.getBounds());
        });
}

// =====================================
// SINKRONISASI UKURAN PETA OTOMATIS
// =====================================

const mapContainer = document.getElementById("map");
if (mapContainer && window.ResizeObserver) {
    const resizeObserver = new ResizeObserver(() => {
        map.invalidateSize();
    });
    resizeObserver.observe(mapContainer);
} else {
    document.getElementById("btn-toggle-sidebar")?.addEventListener("click", function () {
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    });
}
