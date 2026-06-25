<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta PBB-P2 — Geoportal Jakarta SmartTax</title>

    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css" />
    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            overflow: hidden;
            height: 100vh;
        }

        /* ── NAVBAR ── */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 56px;
            background: rgba(2, 6, 23, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            gap: 16px;
        }

        #navbar .logo img { height: 30px; width: auto; display: block; }
        #navbar .logo { text-decoration: none; flex-shrink: 0; }

        #navbar nav { display: flex; gap: 2px; }
        #navbar nav a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            padding: 5px 10px;
            border-radius: 6px;
            transition: color .15s;
            white-space: nowrap;
        }
        #navbar nav a:hover  { color: #e2e8f0; }
        #navbar nav a.active { color: #f97316; font-weight: 600; }

        #navbar .auth-btn {
            background: #f97316;
            color: #fff;
            border: none;
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            flex-shrink: 0;
        }
        #navbar .auth-btn:hover { background: #ea6c0a; }

        /* ── MAP ── */
        #map { position: absolute; top: 56px; left: 0; right: 0; bottom: 0; }

        /* ── PANEL KIRI ── */
        #panel {
            position: absolute;
            top: 68px;
            left: 12px;
            width: 210px;
            background: rgba(2, 6, 23, 0.90);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 12px;
            z-index: 10;
        }

        .panel-head {
            padding: 12px 14px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .panel-head h2 { font-size: 13px; font-weight: 700; color: #22d3ee; margin-bottom: 2px; }
        .panel-head p  { font-size: 11px; color: #475569; }

        .panel-body { padding: 12px 14px; }

        .sec-label {
            font-size: 10px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 8px;
        }

        .leg-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #cbd5e1;
            margin-bottom: 7px;
        }
        .leg-swatch {
            width: 12px; height: 12px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        hr.divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.07);
            margin: 10px 0;
        }

        .toggle-row {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: #94a3b8; cursor: pointer;
        }
        .toggle-row input[type=checkbox] { accent-color: #22d3ee; }

        /* ── STAT CHIP ── */
        #stat {
            position: absolute;
            bottom: 36px; right: 50px;
            background: rgba(2,6,23,0.88);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 11px;
            color: #64748b;
            z-index: 10;
            pointer-events: none;
        }

        /* ── MAPLIBRE POPUP OVERRIDE ── */
        .maplibregl-popup-content {
            background: #0f172a !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
            border-radius: 12px !important;
            padding: 0 !important;
            box-shadow: 0 12px 40px rgba(0,0,0,.7) !important;
            color: #e2e8f0 !important;
            min-width: 220px;
            overflow: hidden;
        }
        .maplibregl-popup-close-button {
            color: #475569 !important;
            font-size: 18px !important;
            right: 10px !important;
            top: 8px !important;
            line-height: 1 !important;
        }
        .maplibregl-popup-close-button:hover { color: #94a3b8 !important; }
        .maplibregl-popup-tip { border-top-color: #1e293b !important; }

        /* ── POPUP CONTENT ── */
        .pop-header {
            padding: 12px 14px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .pop-header .pop-title {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 4px;
        }
        .pop-header .pop-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: .02em;
        }
        .badge-lunas   { background: rgba(34,197,94,.15); color: #4ade80; border: 1px solid rgba(34,197,94,.3); }
        .badge-belum   { background: rgba(239,68,68,.15);  color: #f87171; border: 1px solid rgba(239,68,68,.3); }
        .badge-nol     { background: rgba(245,158,11,.15); color: #fbbf24; border: 1px solid rgba(245,158,11,.3); }
        .badge-default { background: rgba(71,85,105,.2);   color: #94a3b8;  border: 1px solid rgba(71,85,105,.3); }

        .pop-body { padding: 10px 14px 12px; }

        .pop-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
            padding: 4px 0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            font-size: 12px;
        }
        .pop-row:last-child { border-bottom: none; }
        .pop-key   { color: #64748b; flex-shrink: 0; }
        .pop-val   { color: #e2e8f0; font-weight: 500; text-align: right; }

        /* ── BASEMAP BUTTON ── */
        .bm-btn {
            flex: 1;
            font-size: 11px; font-weight: 600;
            padding: 5px 4px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.04);
            color: #64748b;
            cursor: pointer;
            transition: all .15s;
        }
        .bm-btn:hover { color: #e2e8f0; border-color: rgba(255,255,255,0.25); }

        /* ── TOAST ERROR ── */
        #toast {
            position: absolute;
            bottom: 40px; left: 50%;
            transform: translateX(-50%);
            background: rgba(127,29,29,.92);
            border: 1px solid rgba(239,68,68,.4);
            color: #fca5a5;
            font-size: 11px;
            padding: 8px 16px;
            border-radius: 8px;
            z-index: 20;
            max-width: 480px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- ── NAVBAR ── -->
<header id="navbar">
    <a href="{{ url('/home') }}" class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Bapenda">
    </a>

    <nav>
        <a href="{{ url('/home') }}">Beranda</a>
        <a href="{{ url('/katalog/pbb-p2') }}" class="active">Katalog</a>
        <a href="{{ url('/tentang') }}">Tentang</a>
        <a href="{{ url('/struktur') }}">Struktur</a>
    </nav>

    <div style="flex-shrink:0;">
        @auth
            <span style="font-size:13px;color:#475569;margin-right:8px;">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button style="background:none;border:none;color:#f87171;font-size:13px;cursor:pointer;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="auth-btn">Login</a>
        @endauth
    </div>
</header>

<!-- ── MAP ── -->
<div id="map"></div>

<!-- ── SIDE PANEL ── -->
<aside id="panel">
    <div class="panel-head">
        <h2>Peta PBB-P2</h2>
        <p>Data Tanah · BAPENDA DKI Jakarta</p>
    </div>
    <div class="panel-body">

        {{-- LEGENDA STATUS --}}
        <p class="sec-label">Status Pembayaran</p>
        <div class="leg-item"><span class="leg-swatch" style="background:#22c55e;"></span>Sudah Bayar</div>
        <div class="leg-item"><span class="leg-swatch" style="background:#ef4444;"></span>Belum Bayar / Belum Lunas</div>
        <div class="leg-item"><span class="leg-swatch" style="background:#f59e0b;"></span>PBB Bayar 0 Rupiah</div>
        <div class="leg-item"><span class="leg-swatch" style="background:#475569;"></span>Lainnya / N/A</div>

        <hr class="divider">

        {{-- LAYER LIST --}}
        <p class="sec-label">Daftar Layer</p>

        <label class="toggle-row" style="margin-bottom:8px;">
            <input type="checkbox" id="toggleBidang" checked>
            <span class="leg-swatch" style="background:linear-gradient(135deg,#22c55e,#ef4444);border-radius:2px;"></span>
            Layer Bidang PBB-P2
        </label>

        <label class="toggle-row" style="margin-bottom:8px;">
            <input type="checkbox" id="toggleKecamatan" checked>
            <span class="leg-swatch" style="background:transparent;border:3px solid #fbbf24;border-radius:2px;"></span>
            Layer Batas Kecamatan
        </label>

        <label class="toggle-row" style="margin-bottom:8px;">
            <input type="checkbox" id="toggleKelurahan" checked>
            <span class="leg-swatch" style="background:transparent;border:2px dashed #ffffff;border-radius:2px;"></span>
            Layer Batas Kelurahan
        </label>

        <hr class="divider">

        {{-- BASEMAP SWITCHER --}}
        <p class="sec-label">Basemap</p>
        <div style="display:flex;gap:6px;">
            <button class="bm-btn" id="bm-dark" onclick="setBasemap('dark')" style="border-color:rgba(34,211,238,.5);color:#22d3ee;">Dark</button>
            <button class="bm-btn" id="bm-osm"  onclick="setBasemap('osm')">OSM</button>
            <button class="bm-btn" id="bm-sat"  onclick="setBasemap('satellite')">Satelit</button>
        </div>

    </div>
</aside>

<!-- ── STAT ── -->
<div id="stat">Memuat…</div>

@if(isset($error))
<div id="toast">⚠ {{ $error }}</div>
@endif

<script>
const MARTIN_URL = '{{ env("MARTIN_URL", "http://localhost:3000") }}';
const TABLE      = 'data_tanah';

// ── WARNA BERDASARKAN STATUS PEMBAYARAN ───────────────────────────────────────
const STATUS_COLORS = {
    'SUDAH BAYAR'             : '#22c55e',
    'BELUM BAYAR / BELUM LUNAS': '#ef4444',
    'PBB BAYAR 0 RUPIAH'      : '#f59e0b',
};

const statusColor = [
    'match',
    ['coalesce', ['get', 'status_pem'], ''],
    'SUDAH BAYAR',              '#22c55e',
    'BELUM BAYAR / BELUM LUNAS','#ef4444',
    'PBB BAYAR 0 RUPIAH',       '#f59e0b',
    /* default */               '#475569'
];

// ── INIT MAP — style awal memuat semua 3 basemap sekaligus ───────────────────
const map = new maplibregl.Map({
    container : 'map',
    center    : [106.779, -6.276],
    zoom      : 14,
    attributionControl: false,
    style: {
        version: 8,
        // glyphs untuk label kelurahan
        glyphs: 'https://fonts.openmaptiles.org/{fontstack}/{range}.pbf',
        sources: {
            'bm-dark': { type: 'raster', tileSize: 256,
                tiles: ['https://basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png'],
                attribution: '© CARTO © OpenStreetMap' },
            'bm-osm':  { type: 'raster', tileSize: 256,
                tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
                attribution: '© OpenStreetMap contributors' },
            'bm-sat':  { type: 'raster', tileSize: 256,
                tiles: ['https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}'],
                attribution: '© Google' }
        },
        layers: [
            { id: 'bm-dark', type: 'raster', source: 'bm-dark' },
            { id: 'bm-osm',  type: 'raster', source: 'bm-osm',  layout: { visibility: 'none' } },
            { id: 'bm-sat',  type: 'raster', source: 'bm-sat',  layout: { visibility: 'none' } }
        ]
    }
});

map.addControl(new maplibregl.NavigationControl({ showCompass: true }), 'bottom-right');
map.addControl(new maplibregl.ScaleControl({ unit: 'metric' }), 'bottom-left');
map.addControl(new maplibregl.AttributionControl({ compact: true }), 'bottom-right');

// tombol Dark aktif secara default
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('bm-dark');
    if (btn) { btn.style.borderColor = 'rgba(34,211,238,.5)'; btn.style.color = '#22d3ee'; }
});

// auto-fit ke bounds data dari Martin
fetch(`${MARTIN_URL}/${TABLE}`)
    .then(r => r.json())
    .then(meta => {
        if (meta.bounds) {
            const [w, s, e, n] = meta.bounds;
            map.fitBounds([[w, s], [e, n]], { padding: 80, maxZoom: 14, duration: 800 });
        }
    })
    .catch(() => {});

// ── LOAD DATA LAYER ───────────────────────────────────────────────────────────
map.on('load', () => {

    // ── DATA TANAH ────────────────────────────────────────────────────────────
    map.addSource('tanah', {
        type      : 'vector',
        tiles     : [`${MARTIN_URL}/${TABLE}/{z}/{x}/{y}`],
        minzoom   : 0,
        maxzoom   : 22,
        promoteId : 'gid'
    });

    map.addLayer({
        id: 'tanah-fill', type: 'fill', source: 'tanah', 'source-layer': TABLE,
        paint: {
            'fill-color'  : statusColor,
            'fill-opacity': ['interpolate', ['linear'], ['zoom'], 10, 0.55, 16, 0.75]
        }
    });

    map.addLayer({
        id: 'tanah-line', type: 'line', source: 'tanah', 'source-layer': TABLE,
        paint: {
            'line-color': 'rgba(0,0,0,0.35)',
            'line-width': ['interpolate', ['linear'], ['zoom'], 10, 0.2, 15, 0.8, 18, 1.5]
        }
    });

    map.addLayer({
        id: 'tanah-hover', type: 'fill', source: 'tanah', 'source-layer': TABLE,
        paint: {
            'fill-color'  : '#ffffff',
            'fill-opacity': ['case', ['boolean', ['feature-state', 'hovered'], false], 0.28, 0]
        }
    });

    // ── SOURCE + LAYER BATAS KECAMATAN ──────────────────────────────────────
    map.addSource('kecamatan', {
        type    : 'vector',
        tiles   : [`${MARTIN_URL}/administrasi_ar_kecamatan/{z}/{x}/{y}`],
        minzoom : 0,
        maxzoom : 22,
        promoteId: 'gid'
    });

    // ── BATAS KECAMATAN — kuning solid, paling tebal & dominan ──────────────
    map.addLayer({
        id: 'kec-fill', type: 'fill', source: 'kecamatan',
        'source-layer': 'administrasi_ar_kecamatan',
        paint: { 'fill-color': '#fbbf24', 'fill-opacity': 0.05 }
    });
    // shadow/casing hitam
    map.addLayer({
        id: 'kec-line-casing', type: 'line', source: 'kecamatan',
        'source-layer': 'administrasi_ar_kecamatan',
        paint: {
            'line-color'  : '#000',
            'line-width'  : ['interpolate', ['linear'], ['zoom'], 8, 6, 12, 9, 16, 12],
            'line-opacity': 0.55,
            'line-blur'   : 2
        }
    });
    // garis kuning tebal solid
    map.addLayer({
        id: 'kec-line', type: 'line', source: 'kecamatan',
        'source-layer': 'administrasi_ar_kecamatan',
        paint: {
            'line-color' : '#fbbf24',
            'line-width' : ['interpolate', ['linear'], ['zoom'], 8, 2.5, 12, 4, 16, 5.5],
            'line-opacity': 1
        }
    });

    // ── BATAS KELURAHAN — putih dashed tipis, halus di dalam kecamatan ───────
    map.addSource('kelurahan', {
        type: 'vector',
        tiles: [`${MARTIN_URL}/administrasi_ar_desakel/{z}/{x}/{y}`],
        minzoom: 0, maxzoom: 22, promoteId: 'gid'
    });
    // highlight saat hover/klik
    map.addLayer({
        id: 'kel-fill', type: 'fill', source: 'kelurahan',
        'source-layer': 'administrasi_ar_desakel',
        paint: {
            'fill-color'  : '#ffffff',
            'fill-opacity': ['case', ['boolean', ['feature-state', 'hovered'], false], 0.12, 0]
        }
    });
    // shadow tipis
    map.addLayer({
        id: 'kel-line-casing', type: 'line', source: 'kelurahan',
        'source-layer': 'administrasi_ar_desakel',
        paint: {
            'line-color'  : '#000',
            'line-width'  : ['interpolate', ['linear'], ['zoom'], 10, 3, 14, 5, 18, 6],
            'line-opacity': 0.35,
            'line-blur'   : 1
        }
    });
    // garis putih dashed — jelas berbeda dari kecamatan
    map.addLayer({
        id: 'kel-line', type: 'line', source: 'kelurahan',
        'source-layer': 'administrasi_ar_desakel',
        paint: {
            'line-color'    : '#ffffff',
            'line-width'    : ['interpolate', ['linear'], ['zoom'], 10, 1.2, 14, 2, 18, 3],
            'line-opacity'  : 0.85,
            'line-dasharray': [5, 3]
        }
    });
    // label nama kelurahan (zoom 14+)
    map.addLayer({
        id: 'kel-label', type: 'symbol', source: 'kelurahan',
        'source-layer': 'administrasi_ar_desakel',
        minzoom: 14,
        layout: {
            'text-field'         : ['get', 'namobj'],
            'text-font'          : ['Open Sans Regular', 'Arial Unicode MS Regular'],
            'text-size'          : ['interpolate', ['linear'], ['zoom'], 14, 10, 17, 13],
            'text-anchor'        : 'center',
            'text-max-width'     : 8,
            'text-letter-spacing': 0.04,
            'symbol-placement'   : 'point'
        },
        paint: {
            'text-color'     : '#ffffff',
            'text-halo-color': 'rgba(0,0,0,0.85)',
            'text-halo-width': 1.5
        }
    });

    map.on('idle', updateStat);
});

// ── STAT ──────────────────────────────────────────────────────────────────────
function updateStat() {
    const feats  = map.queryRenderedFeatures({ layers: ['tanah-fill'] });
    const unique = new Set(feats.map(f => f.id ?? f.properties?.gid)).size;
    document.getElementById('stat').textContent =
        unique > 0 ? `${unique.toLocaleString('id-ID')} parsel` : 'Tidak ada data';
}

// ── HOVER ─────────────────────────────────────────────────────────────────────
let hoveredId = null;

map.on('mousemove', 'tanah-fill', (e) => {
    if (!e.features.length) return;
    map.getCanvas().style.cursor = 'pointer';

    if (hoveredId !== null) {
        map.setFeatureState({ source: 'tanah', sourceLayer: TABLE, id: hoveredId }, { hovered: false });
    }
    hoveredId = e.features[0].id;
    if (hoveredId != null) {
        map.setFeatureState({ source: 'tanah', sourceLayer: TABLE, id: hoveredId }, { hovered: true });
    }
});

map.on('mouseleave', 'tanah-fill', () => {
    map.getCanvas().style.cursor = '';
    if (hoveredId !== null) {
        map.setFeatureState({ source: 'tanah', sourceLayer: TABLE, id: hoveredId }, { hovered: false });
        hoveredId = null;
    }
});

// ── KLIK POPUP ────────────────────────────────────────────────────────────────
map.on('click', 'tanah-fill', (e) => {
    if (!e.features.length) return;

    const p   = e.features[0].properties;
    const st  = (p.status_pem ?? '').toString().trim().toUpperCase();

    // Badge class berdasarkan status
    let badgeClass = 'badge-default';
    if      (st === 'SUDAH BAYAR')              badgeClass = 'badge-lunas';
    else if (st.includes('BELUM'))              badgeClass = 'badge-belum';
    else if (st.includes('0 RUPIAH'))           badgeClass = 'badge-nol';

    function fmt(val, dec = 2) {
        if (val == null || val === '') return '—';
        const n = parseFloat(val);
        return isNaN(n) ? val : n.toLocaleString('id-ID', { maximumFractionDigits: dec });
    }

    const html = `
        <div class="pop-header">
            <div class="pop-title">Detail Parsel</div>
            <span class="pop-badge ${badgeClass}">${p.status_pem ?? '—'}</span>
        </div>
        <div class="pop-body">
            <div class="pop-row">
                <span class="pop-key">GID</span>
                <span class="pop-val">${p.gid ?? '—'}</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">ID Objek Pajak</span>
                <span class="pop-val">${p.idobjekpaj ?? '—'}</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">Luas Tanah</span>
                <span class="pop-val">${fmt(p.luas_tanah)} m²</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">Luas Bangunan</span>
                <span class="pop-val">${fmt(p.luas_bangu)} m²</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">RT / RW</span>
                <span class="pop-val">${p.rt ?? '—'} / ${p.rw ?? '—'}</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">Rasio</span>
                <span class="pop-val">${fmt(p.ratio, 4)}</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">Keliling (m)</span>
                <span class="pop-val">${fmt(p.shape_leng)}</span>
            </div>
            <div class="pop-row">
                <span class="pop-key">Luas Area</span>
                <span class="pop-val">${fmt(p.shape_area)} m²</span>
            </div>
        </div>
    `;

    new maplibregl.Popup({ offset: 8, maxWidth: '260px' })
        .setLngLat(e.lngLat)
        .setHTML(html)
        .addTo(map);
});

// ── TOGGLE LAYER BIDANG PBB-P2 ───────────────────────────────────────────────
document.getElementById('toggleBidang').addEventListener('change', (e) => {
    const vis = e.target.checked ? 'visible' : 'none';
    ['tanah-fill', 'tanah-line', 'tanah-hover'].forEach(id => {
        if (map.getLayer(id)) map.setLayoutProperty(id, 'visibility', vis);
    });
});

// ── TOGGLE LAYER BATAS KECAMATAN ─────────────────────────────────────────────
document.getElementById('toggleKecamatan').addEventListener('change', (e) => {
    const vis = e.target.checked ? 'visible' : 'none';
    ['kec-fill', 'kec-line-casing', 'kec-line'].forEach(id => {
        if (map.getLayer(id)) map.setLayoutProperty(id, 'visibility', vis);
    });
});

document.getElementById('toggleKelurahan').addEventListener('change', (e) => {
    const vis = e.target.checked ? 'visible' : 'none';
    ['kel-fill', 'kel-line-casing', 'kel-line', 'kel-label'].forEach(id => {
        if (map.getLayer(id)) map.setLayoutProperty(id, 'visibility', vis);
    });
});

// ── HOVER KELURAHAN ───────────────────────────────────────────────────────────
let hoveredKelId = null;

map.on('mousemove', 'kel-fill', (e) => {
    if (!e.features.length) return;
    map.getCanvas().style.cursor = 'pointer';
    if (hoveredKelId !== null)
        map.setFeatureState({ source:'kelurahan', sourceLayer:'administrasi_ar_desakel', id: hoveredKelId }, { hovered: false });
    hoveredKelId = e.features[0].id;
    if (hoveredKelId != null)
        map.setFeatureState({ source:'kelurahan', sourceLayer:'administrasi_ar_desakel', id: hoveredKelId }, { hovered: true });
});
map.on('mouseleave', 'kel-fill', () => {
    map.getCanvas().style.cursor = '';
    if (hoveredKelId !== null) {
        map.setFeatureState({ source:'kelurahan', sourceLayer:'administrasi_ar_desakel', id: hoveredKelId }, { hovered: false });
        hoveredKelId = null;
    }
});

// ── KLIK POPUP KELURAHAN ──────────────────────────────────────────────────────
map.on('click', 'kel-fill', (e) => {
    if (!e.features.length) return;
    // jangan tampil popup kelurahan jika klik pada parsel
    const parselHit = map.queryRenderedFeatures(e.point, { layers: ['tanah-fill'] });
    if (parselHit.length) return;

    const p = e.features[0].properties;
    new maplibregl.Popup({ offset: 6, maxWidth: '240px' })
        .setLngLat(e.lngLat)
        .setHTML(`
            <div class="pop-header">
                <div class="pop-title">Kelurahan</div>
                <span class="pop-badge" style="background:rgba(255,255,255,.1);color:#e2e8f0;border:1px solid rgba(255,255,255,.2);">
                    ${p.namobj ?? '—'}
                </span>
            </div>
            <div class="pop-body">
                <div class="pop-row"><span class="pop-key">Kecamatan</span><span class="pop-val">${p.wadmkc ?? '—'}</span></div>
                <div class="pop-row"><span class="pop-key">Kota/Kab</span><span class="pop-val">${p.wadmkk ?? '—'}</span></div>
                <div class="pop-row"><span class="pop-key">Provinsi</span><span class="pop-val">${p.wadmpr ?? '—'}</span></div>
                <div class="pop-row"><span class="pop-key">Luas</span><span class="pop-val">${p.luas != null ? parseFloat(p.luas).toLocaleString('id-ID',{maximumFractionDigits:2}) + ' km²' : '—'}</span></div>
            </div>
        `)
        .addTo(map);
});

// ── BASEMAP SWITCHER — hanya toggle visibility, TIDAK pakai setStyle() ────────
const BM_MAP = { dark: 'bm-dark', osm: 'bm-osm', satellite: 'bm-sat' };

function setBasemap(key) {
    // sembunyikan semua basemap layer, tampilkan yang dipilih
    Object.values(BM_MAP).forEach(id => map.setLayoutProperty(id, 'visibility', 'none'));
    map.setLayoutProperty(BM_MAP[key], 'visibility', 'visible');

    // update tampilan tombol aktif
    document.querySelectorAll('.bm-btn').forEach(b => {
        b.style.borderColor = 'rgba(255,255,255,0.12)';
        b.style.color = '#64748b';
    });
    const btn = document.getElementById('bm-' + key);
    if (btn) { btn.style.borderColor = 'rgba(34,211,238,.5)'; btn.style.color = '#22d3ee'; }
}
</script>

</body>
</html>
