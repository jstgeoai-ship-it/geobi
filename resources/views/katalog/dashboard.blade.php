<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PBB-P2 — GEO BI</title>

    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css"/>
    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; background:#0a0f1e; color:#e2e8f0; height:100vh; overflow:hidden; display:flex; flex-direction:column; }

        /* ── TOPBAR ── */
        #topbar {
            height:52px; flex-shrink:0;
            background:rgba(2,6,23,0.92); backdrop-filter:blur(12px);
            border-bottom:1px solid rgba(255,255,255,0.06);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 20px; z-index:100;
        }
        #topbar .brand { display:flex; align-items:center; gap:10px; }
        #topbar .brand img { height:28px; }
        #topbar .brand span { font-size:13px; font-weight:700; color:#e2e8f0; }
        #topbar .brand sub { font-size:10px; color:#475569; font-weight:400; display:block; line-height:1; }
        #topbar nav a { font-size:12px; color:#64748b; text-decoration:none; padding:4px 10px; border-radius:6px; transition:color .15s; }
        #topbar nav a:hover { color:#e2e8f0; }
        #topbar nav a.active { color:#f97316; font-weight:600; }
        #topbar .badge-bi { background:rgba(249,115,22,.15); color:#fb923c; border:1px solid rgba(249,115,22,.25); font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; }

        /* ── LAYOUT ── */
        #workspace { flex:1; display:flex; overflow:hidden; }

        /* LEFT SIDEBAR */
        #sidebar {
            width:300px; flex-shrink:0;
            background:rgba(6,12,30,0.95);
            border-right:1px solid rgba(255,255,255,0.06);
            display:flex; flex-direction:column;
            overflow-y:auto; overflow-x:hidden;
        }
        #sidebar::-webkit-scrollbar { width:4px; }
        #sidebar::-webkit-scrollbar-track { background:transparent; }
        #sidebar::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.08); border-radius:2px; }

        .sidebar-section { padding:16px; border-bottom:1px solid rgba(255,255,255,0.04); }
        .sidebar-label { font-size:10px; font-weight:700; color:#334155; text-transform:uppercase; letter-spacing:.09em; margin-bottom:12px; }

        /* STAT CARDS */
        .stat-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
        .stat-card {
            background:rgba(15,23,42,0.7); border:1px solid rgba(255,255,255,0.06);
            border-radius:10px; padding:12px;
        }
        .stat-card .val { font-size:1.5rem; font-weight:800; line-height:1; margin-bottom:4px; }
        .stat-card .lbl { font-size:10px; color:#475569; }
        .stat-card .pct { font-size:11px; font-weight:600; margin-top:3px; }

        /* CHART CONTAINERS */
        .chart-box { background:rgba(15,23,42,0.7); border:1px solid rgba(255,255,255,0.06); border-radius:10px; padding:14px; margin-bottom:10px; }
        .chart-title { font-size:11px; font-weight:600; color:#94a3b8; margin-bottom:10px; text-transform:uppercase; letter-spacing:.06em; }

        /* LEGEND */
        .legend-item { display:flex; align-items:center; gap:8px; font-size:11px; color:#94a3b8; margin-bottom:6px; }
        .legend-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }

        /* LAYER TOGGLE */
        .layer-toggle { display:flex; align-items:center; justify-content:space-between; padding:8px 0; }
        .layer-toggle label { font-size:12px; color:#64748b; display:flex; align-items:center; gap:8px; cursor:pointer; }
        .layer-toggle input[type=checkbox] { accent-color:#22d3ee; width:14px; height:14px; }

        /* FILTER BADGE */
        .filter-row { display:flex; gap:6px; flex-wrap:wrap; }
        .filter-chip {
            font-size:10px; font-weight:600; padding:4px 10px; border-radius:20px; cursor:pointer;
            border:1px solid rgba(255,255,255,0.1); color:#64748b; background:transparent;
            transition:all .15s;
        }
        .filter-chip.active-sudah  { background:rgba(34,197,94,.15); color:#4ade80; border-color:rgba(34,197,94,.3); }
        .filter-chip.active-belum  { background:rgba(239,68,68,.15);  color:#f87171; border-color:rgba(239,68,68,.3); }
        .filter-chip.active-nol    { background:rgba(245,158,11,.15); color:#fbbf24; border-color:rgba(245,158,11,.3); }
        .filter-chip.active-all    { background:rgba(34,211,238,.1);  color:#22d3ee; border-color:rgba(34,211,238,.3); }

        /* MAIN MAP AREA */
        #main { flex:1; display:flex; flex-direction:column; overflow:hidden; }
        #map-header { padding:10px 16px; background:rgba(6,12,30,0.8); border-bottom:1px solid rgba(255,255,255,0.04); display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
        #map-header .title { font-size:12px; font-weight:600; color:#94a3b8; }
        #map-header .controls { display:flex; gap:8px; }
        #map-header .ctrl-btn { font-size:11px; padding:4px 10px; border-radius:6px; border:1px solid rgba(255,255,255,0.1); color:#64748b; background:transparent; cursor:pointer; transition:all .15s; }
        #map-header .ctrl-btn:hover { color:#e2e8f0; border-color:rgba(255,255,255,0.2); }
        #map { flex:1; }

        /* POPUP */
        .maplibregl-popup-content {
            background:#0f172a !important; border:1px solid rgba(255,255,255,0.1) !important;
            border-radius:10px !important; padding:0 !important; min-width:200px;
            box-shadow:0 8px 32px rgba(0,0,0,.6) !important;
        }
        .maplibregl-popup-close-button { color:#475569 !important; right:8px !important; top:6px !important; font-size:16px !important; }
        .maplibregl-popup-tip { border-top-color:#0f172a !important; }
        .pop-head { padding:10px 14px 8px; border-bottom:1px solid rgba(255,255,255,0.06); }
        .pop-badge { display:inline-block; font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; margin-top:4px; }
        .pop-body  { padding:8px 14px 12px; }
        .pop-row   { display:flex; justify-content:space-between; font-size:11px; padding:3px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
        .pop-row:last-child { border-bottom:none; }
        .pop-k { color:#475569; } .pop-v { color:#e2e8f0; font-weight:500; }

        /* STAT CHIP bottom */
        #stat-chip { position:absolute; bottom:32px; right:48px; background:rgba(6,12,30,.9); border:1px solid rgba(255,255,255,0.08); border-radius:8px; padding:5px 12px; font-size:11px; color:#64748b; z-index:10; pointer-events:none; }
    </style>
</head>
<body>

<!-- ── TOPBAR ── -->
<header id="topbar">
    <div class="brand">
        <img src="{{ asset('img/logo.png') }}" alt="Bapenda">
        <div>
            <span>Geoportal Jakarta SmartTax</span>
            <sub>Dashboard PBB-P2 · GEO BI</sub>
        </div>
    </div>

    <nav style="display:flex;gap:2px;">
        <a href="{{ url('/home') }}">Beranda</a>
        <a href="{{ url('/katalog/pbb-p2') }}">Peta</a>
        <a href="{{ url('/katalog/dashboard-pbb') }}" class="active">Dashboard</a>
        <a href="{{ url('/tentang') }}">Tentang</a>
    </nav>

    <div style="display:flex;align-items:center;gap:10px;">
        <span class="badge-bi">GEO BI</span>
        @auth
        <span style="font-size:12px;color:#475569;">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button style="font-size:12px;color:#f87171;background:none;border:none;cursor:pointer;">Logout</button>
        </form>
        @endauth
    </div>
</header>

<!-- ── WORKSPACE ── -->
<div id="workspace">

    <!-- ── LEFT SIDEBAR ── -->
    <aside id="sidebar">

        {{-- STATS --}}
        <div class="sidebar-section">
            <div class="sidebar-label">Ringkasan Data</div>
            @php
                $total      = $stats?->total      ?? 0;
                $sudah      = $stats?->sudah_bayar ?? 0;
                $belum      = $stats?->belum_bayar ?? 0;
                $nol        = $stats?->pbb_nol     ?? 0;
                $pctSudah   = $total > 0 ? round($sudah/$total*100,1) : 0;
                $pctBelum   = $total > 0 ? round($belum/$total*100,1) : 0;
                $pctNol     = $total > 0 ? round($nol/$total*100,1)   : 0;
            @endphp
            <div class="stat-grid">
                <div class="stat-card" style="grid-column:span 2;">
                    <div class="val" style="color:#22d3ee;">{{ number_format($total, 0, ',', '.') }}</div>
                    <div class="lbl">Total Parsel Terdaftar</div>
                </div>
                <div class="stat-card">
                    <div class="val" style="color:#22c55e;">{{ number_format($sudah, 0, ',', '.') }}</div>
                    <div class="lbl">Sudah Bayar</div>
                    <div class="pct" style="color:#22c55e;">{{ $pctSudah }}%</div>
                </div>
                <div class="stat-card">
                    <div class="val" style="color:#ef4444;">{{ number_format($belum, 0, ',', '.') }}</div>
                    <div class="lbl">Belum Bayar</div>
                    <div class="pct" style="color:#ef4444;">{{ $pctBelum }}%</div>
                </div>
                <div class="stat-card" style="grid-column:span 2;">
                    <div class="val" style="color:#f59e0b;">{{ number_format($nol, 0, ',', '.') }}</div>
                    <div class="lbl">PBB Bayar 0 Rupiah</div>
                    <div class="pct" style="color:#f59e0b;">{{ $pctNol }}%</div>
                </div>
            </div>
        </div>

        {{-- DONUT CHART --}}
        <div class="sidebar-section">
            <div class="sidebar-label">Distribusi Status</div>
            <div class="chart-box" style="padding:10px;">
                <canvas id="chartDonut" height="180"></canvas>
            </div>
            <div style="margin-top:4px;">
                <div class="legend-item"><span class="legend-dot" style="background:#22c55e;"></span>Sudah Bayar ({{ $pctSudah }}%)</div>
                <div class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>Belum Bayar ({{ $pctBelum }}%)</div>
                <div class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span>PBB 0 Rupiah ({{ $pctNol }}%)</div>
            </div>
        </div>

        {{-- COMPLIANCE BAR --}}
        <div class="sidebar-section">
            <div class="sidebar-label">Tingkat Kepatuhan</div>
            <div class="chart-box">
                <div style="margin-bottom:8px;">
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;">
                        <span>Sudah Bayar</span><span style="color:#22c55e;">{{ $pctSudah }}%</span>
                    </div>
                    <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:3px;">
                        <div style="height:100%;width:{{ $pctSudah }}%;background:#22c55e;border-radius:3px;transition:width .6s;"></div>
                    </div>
                </div>
                <div style="margin-bottom:8px;">
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;">
                        <span>Belum Bayar</span><span style="color:#ef4444;">{{ $pctBelum }}%</span>
                    </div>
                    <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:3px;">
                        <div style="height:100%;width:{{ $pctBelum }}%;background:#ef4444;border-radius:3px;"></div>
                    </div>
                </div>
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;">
                        <span>PBB 0 Rupiah</span><span style="color:#f59e0b;">{{ $pctNol }}%</span>
                    </div>
                    <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:3px;">
                        <div style="height:100%;width:{{ $pctNol }}%;background:#f59e0b;border-radius:3px;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAYER & FILTER --}}
        <div class="sidebar-section">
            <div class="sidebar-label">Filter Peta</div>
            <div class="filter-row" id="filterRow">
                <button class="filter-chip active-all" data-filter="all" onclick="setFilter('all')">Semua</button>
                <button class="filter-chip" data-filter="sudah" onclick="setFilter('sudah')">Sudah Bayar</button>
                <button class="filter-chip" data-filter="belum" onclick="setFilter('belum')">Belum Bayar</button>
                <button class="filter-chip" data-filter="nol" onclick="setFilter('nol')">0 Rupiah</button>
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Layer</div>
            <div class="layer-toggle">
                <label><input type="checkbox" id="toggleFill" checked> Parsel fill</label>
            </div>
            <div class="layer-toggle">
                <label><input type="checkbox" id="toggleLine" checked> Outline</label>
            </div>
        </div>

        @if(isset($error))
        <div class="sidebar-section">
            <div style="font-size:11px;color:#f87171;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;padding:10px;line-height:1.5;">
                ⚠ {{ $error }}
            </div>
        </div>
        @endif

    </aside>

    <!-- ── MAP PANEL ── -->
    <div id="main" style="position:relative;">
        <div id="map-header">
            <span class="title">Peta Sebaran PBB-P2 · Jakarta</span>
            <div class="controls">
                <button class="ctrl-btn" onclick="fetch(`${MARTIN}/data_tanah`).then(r=>r.json()).then(m=>{if(m.bounds){const[w,s,e,n]=m.bounds;map.fitBounds([[w,s],[e,n]],{padding:20,maxZoom:16});}})">Reset View</button>
                <button class="ctrl-btn" onclick="map.flyTo({center:[106.779,-6.276],zoom:16})">Zoom In</button>
            </div>
        </div>
        <div id="map"></div>
        <div id="stat-chip">Memuat…</div>
    </div>

</div>

<script>
const MARTIN = '{{ env("MARTIN_URL","http://localhost:3000") }}';
const TABLE  = 'data_tanah';

// ── DONUT CHART ───────────────────────────────────────────────────────────────
new Chart(document.getElementById('chartDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Sudah Bayar','Belum Bayar','PBB 0 Rupiah'],
        datasets: [{
            data: [{{ $sudah }}, {{ $belum }}, {{ $nol }}],
            backgroundColor: ['#22c55e','#ef4444','#f59e0b'],
            borderColor: '#0a0f1e',
            borderWidth: 3,
            hoverOffset: 6
        }]
    },
    options: {
        cutout: '65%',
        plugins: { legend: { display:false }, tooltip: {
            callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed.toLocaleString('id-ID')} parsel` }
        }},
        animation: { animateRotate: true, duration: 800 }
    }
});

// ── MAP ───────────────────────────────────────────────────────────────────────
const map = new maplibregl.Map({
    container: 'map',
    style: 'https://basemaps.cartocdn.com/gl/dark-matter-gl-style/style.json',
    center: [106.779, -6.276],
    zoom: 14,
    attributionControl: false
});

map.addControl(new maplibregl.NavigationControl({showCompass:true}), 'bottom-right');
map.addControl(new maplibregl.ScaleControl({unit:'metric'}), 'bottom-left');
map.addControl(new maplibregl.AttributionControl({compact:true}), 'bottom-right');

// auto-fit ke bounds data
fetch(`${MARTIN}/data_tanah`).then(r=>r.json()).then(meta=>{
    if(meta.bounds){const[w,s,e,n]=meta.bounds;map.fitBounds([[w,s],[e,n]],{padding:20,maxZoom:16,duration:800});}
}).catch(()=>{});

const COLOR_EXPR = [
    'match', ['coalesce',['get','status_pem'],''],
    'SUDAH BAYAR',              '#22c55e',
    'BELUM BAYAR / BELUM LUNAS','#ef4444',
    'PBB BAYAR 0 RUPIAH',       '#f59e0b',
    '#475569'
];

map.on('load', () => {
    map.addSource('tanah', {
        type:'vector', promoteId:'gid',
        tiles:[`${MARTIN}/${TABLE}/{z}/{x}/{y}`],
        minzoom:0, maxzoom:22
    });

    map.addLayer({ id:'tanah-fill', type:'fill', source:'tanah', 'source-layer':TABLE,
        paint:{ 'fill-color':COLOR_EXPR, 'fill-opacity':['interpolate',['linear'],['zoom'],10,.55,16,.75] }
    });
    map.addLayer({ id:'tanah-line', type:'line', source:'tanah', 'source-layer':TABLE,
        paint:{ 'line-color':'rgba(0,0,0,.35)', 'line-width':['interpolate',['linear'],['zoom'],10,.2,16,.9] }
    });
    map.addLayer({ id:'tanah-hover', type:'fill', source:'tanah', 'source-layer':TABLE,
        paint:{ 'fill-color':'#fff', 'fill-opacity':['case',['boolean',['feature-state','hovered'],false],.25,0] }
    });

    map.on('idle', updateStat);
});

// stat count
function updateStat() {
    const feats = map.queryRenderedFeatures({layers:['tanah-fill']});
    const n = new Set(feats.map(f=>f.id??f.properties?.gid)).size;
    document.getElementById('stat-chip').textContent = n > 0 ? `${n.toLocaleString('id-ID')} parsel tampil` : 'Tidak ada data';
}

// hover
let hId = null;
map.on('mousemove','tanah-fill', e => {
    if (!e.features.length) return;
    map.getCanvas().style.cursor = 'pointer';
    if (hId !== null) map.setFeatureState({source:'tanah',sourceLayer:TABLE,id:hId},{hovered:false});
    hId = e.features[0].id;
    if (hId != null) map.setFeatureState({source:'tanah',sourceLayer:TABLE,id:hId},{hovered:true});
});
map.on('mouseleave','tanah-fill', () => {
    map.getCanvas().style.cursor='';
    if (hId !== null) { map.setFeatureState({source:'tanah',sourceLayer:TABLE,id:hId},{hovered:false}); hId=null; }
});

// klik popup
map.on('click','tanah-fill', e => {
    if (!e.features.length) return;
    const p = e.features[0].properties;
    const st = (p.status_pem??'').trim().toUpperCase();
    let bc='background:rgba(71,85,105,.2);color:#94a3b8;border:1px solid rgba(71,85,105,.3);';
    if (st==='SUDAH BAYAR')               bc='background:rgba(34,197,94,.12);color:#4ade80;border:1px solid rgba(34,197,94,.25);';
    else if (st.includes('BELUM'))         bc='background:rgba(239,68,68,.12);color:#f87171;border:1px solid rgba(239,68,68,.25);';
    else if (st.includes('0 RUPIAH'))      bc='background:rgba(245,158,11,.12);color:#fbbf24;border:1px solid rgba(245,158,11,.25);';

    const fmt = (v,d=2) => v==null?'—':isNaN(parseFloat(v))?v:parseFloat(v).toLocaleString('id-ID',{maximumFractionDigits:d});

    new maplibregl.Popup({offset:6,maxWidth:'260px'})
        .setLngLat(e.lngLat)
        .setHTML(`
            <div class="pop-head">
                <div style="font-size:10px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Detail Parsel</div>
                <span class="pop-badge" style="${bc}">${p.status_pem??'—'}</span>
            </div>
            <div class="pop-body">
                <div class="pop-row"><span class="pop-k">GID</span><span class="pop-v">${p.gid??'—'}</span></div>
                <div class="pop-row"><span class="pop-k">ID Objek Pajak</span><span class="pop-v">${p.idobjekpaj??'—'}</span></div>
                <div class="pop-row"><span class="pop-k">Luas Tanah</span><span class="pop-v">${fmt(p.luas_tanah)} m²</span></div>
                <div class="pop-row"><span class="pop-k">Luas Bangunan</span><span class="pop-v">${fmt(p.luas_bangu)} m²</span></div>
                <div class="pop-row"><span class="pop-k">RT / RW</span><span class="pop-v">${p.rt??'—'} / ${p.rw??'—'}</span></div>
            </div>
        `)
        .addTo(map);
});

// ── FILTER ───────────────────────────────────────────────────────────────────
const FILTER_MAP = {
    all:   null,
    sudah: ['==',['get','status_pem'],'SUDAH BAYAR'],
    belum: ['==',['get','status_pem'],'BELUM BAYAR / BELUM LUNAS'],
    nol:   ['==',['get','status_pem'],'PBB BAYAR 0 RUPIAH'],
};
const CHIP_CLASS = { all:'active-all', sudah:'active-sudah', belum:'active-belum', nol:'active-nol' };

function setFilter(key) {
    document.querySelectorAll('.filter-chip').forEach(el => {
        el.className = 'filter-chip';
        if (el.dataset.filter === key) el.classList.add(CHIP_CLASS[key]);
    });
    const f = FILTER_MAP[key];
    ['tanah-fill','tanah-line','tanah-hover'].forEach(id => {
        if (map.getLayer(id)) map.setFilter(id, f);
    });
    map.once('idle', updateStat);
}

// ── LAYER TOGGLES ─────────────────────────────────────────────────────────────
document.getElementById('toggleFill').addEventListener('change', e => {
    if (map.getLayer('tanah-fill')) map.setLayoutProperty('tanah-fill','visibility', e.target.checked?'visible':'none');
});
document.getElementById('toggleLine').addEventListener('change', e => {
    if (map.getLayer('tanah-line')) map.setLayoutProperty('tanah-line','visibility', e.target.checked?'visible':'none');
});
</script>

</body>
</html>
