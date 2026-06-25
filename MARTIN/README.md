# 🗺️ PostGIS → Martin → MapLibre — Panduan Lengkap

Stack: **PostgreSQL/PostGIS** → **Martin** (tile server) → **MapLibre GL JS** (viewer)

---

## 📁 Struktur Project

```
martin-maplibre/
├── config/
│   └── martin.yaml        ← konfigurasi Martin
├── public/
│   └── index.html         ← MapLibre viewer
└── README.md
```

---

## STEP 1 — Pastikan Data Ada di PostGIS

Buka pgAdmin atau psql, jalankan query ini untuk cek tabel kamu:

```sql
-- Cek tabel dan kolom geometry-nya
SELECT table_name, column_name, type
FROM geometry_columns
WHERE f_table_schema = 'public';

-- Cek SRID kolom geom (harus 4326 untuk web map, atau 3857)
SELECT ST_SRID(geom) FROM namatabelmu LIMIT 1;
```

### Kalau SRID bukan 4326, ubah dulu:

```sql
-- Ubah SRID ke 4326 (WGS84) — standard untuk web
ALTER TABLE namatabelmu
  ALTER COLUMN geom TYPE geometry(MultiPolygon, 4326)
  USING ST_Transform(geom, 4326);
```

### Wajib: tambahkan spatial index supaya tile-nya cepat

```sql
CREATE INDEX idx_namatabelmu_geom
  ON namatabelmu USING GIST (geom);
```

---

## STEP 2 — Install Martin

Martin adalah tile server ringan yang baca langsung dari PostGIS dan serve MVT (Mapbox Vector Tiles).

### Option A: Download binary langsung (paling simpel)

1. Buka: https://github.com/maplibre/martin/releases
2. Download versi terbaru untuk OS kamu:
   - Windows: `martin-x86_64-pc-windows-msvc.zip`
   - Mac (Intel): `martin-x86_64-apple-darwin.tar.gz`
   - Mac (Apple Silicon): `martin-aarch64-apple-darwin.tar.gz`
   - Linux: `martin-x86_64-unknown-linux-gnu.tar.gz`
3. Extract, taruh `martin` (atau `martin.exe`) di folder project

### Option B: Via Docker

```bash
docker pull ghcr.io/maplibre/martin
```

---

## STEP 3 — Edit `config/martin.yaml`

Buka file `config/martin.yaml`, ganti bagian ini:

```yaml
postgres:
  connection_string: "postgresql://USER:PASSWORD@HOST:PORT/DBNAME"
```

Contoh kalau database lokal:

```yaml
  connection_string: "postgresql://postgres:mypassword@localhost:5432/smarttax"
```

---

## STEP 4 — Jalankan Martin

### Pakai binary:

```bash
# Windows (dari folder project)
./martin.exe --config config/martin.yaml

# Mac/Linux
./martin --config config/martin.yaml
```

### Pakai Docker:

```bash
docker run -p 3000:3000 \
  ghcr.io/maplibre/martin \
  postgresql://postgres:password@host.docker.internal:5432/smarttax
```

Martin akan running di `http://localhost:3000`

### Verifikasi Martin berjalan:

Buka browser → `http://localhost:3000/catalog`

Kamu akan lihat JSON berisi semua tabel yang ter-publish, contoh:
```json
{
  "tiles": {
    "public.namatabelmu": {
      "content_type": "application/x-protobuf",
      "minzoom": 0,
      "maxzoom": 22
    }
  }
}
```

---

## STEP 5 — Edit `public/index.html`

Cari baris konfigurasi di bagian atas script:

```javascript
const MARTIN_URL   = 'http://localhost:3000';   // URL Martin
const TABLE_NAME   = 'public.namatabelmu';       // ⚠️ GANTI INI
const CENTER_LNG   = 106.8456;                   // Longitude Jakarta
const CENTER_LAT   = -6.2088;
```

Ganti `public.namatabelmu` dengan nama tabel kamu yang muncul di `/catalog`.

---

## STEP 6 — Serve `index.html` dengan Live Server (VSC)

Jangan buka `index.html` langsung dari file (akan error CORS).
Harus lewat HTTP server.

### Pakai VSCode Live Server:

1. Install extension **"Live Server"** (Ritwick Dey) di VSCode
2. Klik kanan `public/index.html` → **"Open with Live Server"**
3. Otomatis buka di `http://127.0.0.1:5500/public/index.html`

### Atau pakai Python (kalau udah install):

```bash
cd public
python -m http.server 8080
# Buka: http://localhost:8080
```

---

## STEP 7 — Cek Hasilnya

Kalau semua benar:
- 🟢 Dot hijau di header = Martin terkoneksi
- Peta muncul dengan layer persil warna-warni sesuai status pembayaran
- Klik persil → info atribut muncul di sidebar kanan

---

## 🐛 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Dot merah, layer tidak muncul | Martin belum jalan, cek terminal Martin |
| Tile muncul tapi posisi salah | SRID salah, cek `ST_SRID(geom)` dan transform ke 4326 |
| Error CORS di console | Pastikan buka via Live Server, bukan file:// |
| Layer kosong tapi tidak error | Nama `source-layer` di HTML harus sama persis dengan yang di `/catalog` |
| Martin tidak bisa connect ke DB | Cek connection string, pastikan PostgreSQL running |

---

## 💡 Tips: Cek Tile Langsung

Kamu bisa tes tile MVT langsung di browser:

```
http://localhost:3000/public.namatabelmu/13/6486/4054
```

Format: `/{table}/{z}/{x}/{y}` — kalau response-nya bukan error berarti tile sudah serve dengan benar.
