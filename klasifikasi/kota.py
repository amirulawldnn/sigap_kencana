import geopandas as gpd
import os

from shapely.geometry import MultiPolygon


# ============================================================
# KONFIGURASI
# ============================================================

INPUT_FILE = r"D:\sigap_kencana\gis\source\38 Provinsi Indonesia - Kabupaten.json"

OUTPUT_FILE = r"D:\sigap_kencana\gis\source\jawa-tengah-kabkota.geojson"


# ============================================================
# 1. BACA RAW GEOJSON
# ============================================================

print("Membaca file raw...")

gdf = gpd.read_file(INPUT_FILE)

print(f"Total feature awal : {len(gdf)}")
print(f"CRS                 : {gdf.crs}")


# ============================================================
# 2. CEK KOLOM
# ============================================================

print("\nKolom yang tersedia:")
print(list(gdf.columns))


# ============================================================
# 3. FILTER JAWA TENGAH
# ============================================================

print("\nFilter Jawa Tengah...")

jateng = gdf[
    gdf["WADMPR"].astype(str).str.strip().str.lower()
    == "jawa tengah"
].copy()

print(f"Feature Jawa Tengah : {len(jateng)}")

print("\nCEK KOTA MAGELANG")
print("=" * 50)

magelang = jateng[
    jateng["KDPKAB"] == "33.71"
]

print(f"Jumlah feature Kota Magelang : {len(magelang)}")

print(
    magelang[
        ["KDPKAB", "WADMKK", "geometry"]
    ].to_string()
)

print("\nTipe geometry:")
print(
    magelang.geometry.geom_type.value_counts()
)

print("\nGeometry kosong:")
print(
    magelang.geometry.is_empty.value_counts()
)

print("\nGeometry null:")
print(
    magelang.geometry.isna().value_counts()
)

# ============================================================
# 4. NORMALISASI ATRIBUT
# ============================================================

jateng["KDPKAB"] = (
    jateng["KDPKAB"]
    .astype(str)
    .str.strip()
)

jateng["WADMKK"] = (
    jateng["WADMKK"]
    .astype(str)
    .str.strip()
)


# ============================================================
# 5. TAMPILKAN DAFTAR KABUPATEN/KOTA
# ============================================================

kabkota = (
    jateng[["KDPKAB", "WADMKK"]]
    .drop_duplicates()
    .sort_values("KDPKAB")
)

print("\nKabupaten/Kota yang ditemukan:")

for _, row in kabkota.iterrows():
    print(
        f"{row['KDPKAB']} - {row['WADMKK']}"
    )

print(f"\nJumlah Kabupaten/Kota : {len(kabkota)}")


# ============================================================
# 6. DISSOLVE BERDASARKAN KDPKAB
# ============================================================

print("\nMelakukan dissolve berdasarkan KDPKAB...")

kabkota_gdf = (
    jateng
    .dissolve(
        by="KDPKAB",
        aggfunc={
            "WADMKK": "first",
            "WADMPR": "first"
        }
    )
    .reset_index()
)


# ============================================================
# 7. VALIDASI GEOMETRY
# ============================================================

print("\nMemeriksa geometry...")

invalid_count = (
    ~kabkota_gdf.geometry.is_valid
).sum()

print(f"Geometry invalid : {invalid_count}")

if invalid_count > 0:

    print("Memperbaiki geometry invalid...")

    kabkota_gdf["geometry"] = (
        kabkota_gdf.geometry.make_valid()
    )


# ============================================================
# 8. NORMALISASI GEOMETRY MENJADI MULTIPOLYGON
# ============================================================

print("\nMenormalisasi geometry menjadi MultiPolygon...")


def normalize_multipolygon(geometry):

    if geometry is None or geometry.is_empty:
        return None

    # Polygon → MultiPolygon
    if geometry.geom_type == "Polygon":
        return MultiPolygon([geometry])

    # MultiPolygon → biarkan
    if geometry.geom_type == "MultiPolygon":
        return geometry

    # GeometryCollection
    if geometry.geom_type == "GeometryCollection":

        polygons = []

        for geom in geometry.geoms:

            if geom.geom_type == "Polygon":
                polygons.append(geom)

            elif geom.geom_type == "MultiPolygon":
                polygons.extend(
                    list(geom.geoms)
                )

        if polygons:
            return MultiPolygon(polygons)

    return None


kabkota_gdf["geometry"] = (
    kabkota_gdf["geometry"]
    .apply(normalize_multipolygon)
)


# ============================================================
# 9. CEK TIPE GEOMETRY
# ============================================================

print("\nTipe geometry hasil:")

print(
    kabkota_gdf.geometry
    .geom_type
    .value_counts()
)


# ============================================================
# 10. NORMALISASI NAMA KOLOM
# ============================================================

kabkota_gdf = kabkota_gdf.rename(
    columns={
        "KDPKAB": "kode_kabkota",
        "WADMKK": "nama_kabkota",
        "WADMPR": "nama_provinsi"
    }
)

kabkota_gdf["kode_provinsi"] = "33"


# ============================================================
# 11. PILIH KOLOM OUTPUT
# ============================================================

kabkota_gdf = kabkota_gdf[
    [
        "kode_kabkota",
        "nama_kabkota",
        "kode_provinsi",
        "nama_provinsi",
        "geometry"
    ]
]


# ============================================================
# 12. PASTIKAN CRS WGS84
# ============================================================

if kabkota_gdf.crs is None:

    print(
        "\nCRS tidak tersedia, "
        "menggunakan EPSG:4326..."
    )

    kabkota_gdf = kabkota_gdf.set_crs(
        epsg=4326
    )

elif kabkota_gdf.crs.to_epsg() != 4326:

    print(
        "\nMengubah CRS menjadi EPSG:4326..."
    )

    kabkota_gdf = kabkota_gdf.to_crs(
        epsg=4326
    )


# ============================================================
# 13. HAPUS GEOMETRY KOSONG
# ============================================================

empty_count = (
    kabkota_gdf.geometry.isna()
    | kabkota_gdf.geometry.is_empty
).sum()

print(
    f"\nGeometry kosong : {empty_count}"
)

kabkota_gdf = kabkota_gdf[
    kabkota_gdf.geometry.notna()
    & ~kabkota_gdf.geometry.is_empty
].copy()


# ============================================================
# 14. SIMPAN GEOJSON
# ============================================================

os.makedirs(
    os.path.dirname(OUTPUT_FILE),
    exist_ok=True
)

print("\nMenyimpan GeoJSON...")

kabkota_gdf.to_file(
    OUTPUT_FILE,
    driver="GeoJSON"
)


# ============================================================
# 15. HASIL AKHIR
# ============================================================

print("\n" + "=" * 60)
print("SELESAI")
print("=" * 60)

print(
    f"Jumlah Kabupaten/Kota : "
    f"{len(kabkota_gdf)}"
)

print(
    f"Output : {OUTPUT_FILE}"
)

print("\nDaftar hasil:")

for _, row in kabkota_gdf.sort_values(
    "kode_kabkota"
).iterrows():

    print(
        f"{row['kode_kabkota']} - "
        f"{row['nama_kabkota']}"
    )