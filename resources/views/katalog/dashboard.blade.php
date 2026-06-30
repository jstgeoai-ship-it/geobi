<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PBB-P2 — GEO BI</title>

    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css"/>
    @vite(['resources/css/app.css'])
    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; background:#0a0f1e; color:#e2e8f0; height:100vh; overflow:hidden; display:flex; flex-direction:column; }

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
        #map-header { display:none; }
        #map { flex:1; }

        /* ── SEARCH FLOATING ── */
        #search-float {
            position:absolute; top:12px; right:12px; z-index:10;
        }

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

        /* ── HOVER TOOLTIP ── */
        #hover-tooltip {
            position:absolute; pointer-events:none; z-index:20;
            background:rgba(2,6,23,0.92); border:1px solid rgba(255,255,255,0.10);
            border-radius:8px; padding:8px 12px; font-size:11px; color:#e2e8f0;
            display:none; white-space:nowrap; box-shadow:0 4px 16px rgba(0,0,0,.5);
        }
        #hover-tooltip .tt-row { display:flex; gap:8px; justify-content:space-between; padding:2px 0; }
        #hover-tooltip .tt-key { color:#64748b; }
        #hover-tooltip .tt-val { font-weight:600; }

        /* ── SEARCH BAR ── */
        #search-bar {
            display:flex; gap:0; width:280px;
        }
        #search-input {
            flex:1; background:rgba(2,6,23,0.92); border:1px solid rgba(255,255,255,0.12);
            border-right:none; border-radius:8px 0 0 8px; color:#e2e8f0;
            font-size:12px; padding:6px 12px; outline:none;
        }
        #search-input::placeholder { color:#475569; }
        #search-input:focus { border-color:rgba(34,211,238,.4); }
        #search-btn {
            background:#22d3ee; border:1px solid #22d3ee;
            border-left:none; border-radius:0 8px 8px 0; color:#0a0f1e;
            font-size:12px; font-weight:600; padding:6px 12px; cursor:pointer;
            transition:background .15s; white-space:nowrap;
        }
        #search-btn:hover { background:rgba(34,211,238,.22); }
        #search-btn:disabled { opacity:.5; cursor:default; }
        #search-results {
            position:absolute; top:100%; right:0; margin-top:4px; width:280px;
            background:rgba(2,6,23,0.96); border:1px solid rgba(255,255,255,0.10);
            border-radius:8px; overflow:hidden; display:none;
            box-shadow:0 8px 24px rgba(0,0,0,.6); z-index:30;
        }
        .sr-item { padding:8px 12px; font-size:11px; color:#cbd5e1; cursor:pointer; border-bottom:1px solid rgba(255,255,255,0.05); transition:background .1s; }
        .sr-item:last-child { border-bottom:none; }
        .sr-item:hover { background:rgba(255,255,255,0.06); }
        .sr-item .sr-name { font-weight:600; margin-bottom:2px; }
        .sr-item .sr-detail { color:#475569; font-size:10px; }
        .sr-empty { padding:10px 12px; font-size:11px; color:#475569; text-align:center; }
    </style>
</head>
<body style="padding-top:64px;">

@include('partials.navbar')

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
        <div id="map"></div>
        <div id="search-float">
            <div style="position:relative;">
                <div id="search-bar">
                    <input id="search-input" type="text" placeholder="" autocomplete="off">
                    <button id="search-btn">Cari</button>
                </div>
                <div id="search-results"></div>
            </div>
        </div>
        <div id="stat-chip">Memuat…</div>
        <div id="hover-tooltip">
            <div class="tt-row"><span class="tt-key">ID Objek Pajak</span><span class="tt-val" id="tt-id">—</span></div>
            <div class="tt-row"><span class="tt-key">Luas Tanah</span><span class="tt-val" id="tt-lt">—</span></div>
            <div class="tt-row"><span class="tt-key">Luas Bangunan</span><span class="tt-val" id="tt-lb">—</span></div>
        </div>
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

// ── ATTRIBUTION TOGGLE ────────────────────────────────────────────────────────
const ATTR_TEXTS = { dark:'© CARTO © OpenStreetMap', osm:'© OpenStreetMap contributors', satellite:'© Google' };
class AttrControl {
    onAdd() {
        this._visible = false;
        this._el = document.createElement('div');
        this._el.className = 'maplibregl-ctrl';
        this._el.style.cssText = 'display:flex;align-items:center;gap:4px;padding:2px 0;justify-content:flex-end;';
        this._el.innerHTML = `
            <span id="attr-text" style="display:none;font-size:10px;color:#475569;background:rgba(2,6,23,.88);border:1px solid rgba(255,255,255,.09);border-radius:5px;padding:2px 8px;white-space:nowrap;"></span>
            <button id="attr-btn" title="Toggle attribution" style="width:22px;height:22px;border-radius:50%;border:1px solid rgba(255,255,255,.09);background:rgba(2,6,23,.88);color:#64748b;font-size:14px;cursor:pointer;line-height:1;display:flex;align-items:center;justify-content:center;">ⓘ</button>
        `;
        this._el.querySelector('#attr-btn').addEventListener('click', () => {
            this._visible = !this._visible;
            const t = this._el.querySelector('#attr-text');
            t.style.display = this._visible ? 'inline-block' : 'none';
            this._el.querySelector('#attr-btn').style.color = this._visible ? '#22d3ee' : '#64748b';
        });
        this.updateText('dark');
        return this._el;
    }
    onRemove() {}
    updateText(key) {
        const t = this._el?.querySelector('#attr-text');
        if (t) t.textContent = ATTR_TEXTS[key] ?? '';
    }
}
const attrCtrl = new AttrControl();
map.addControl(attrCtrl, 'bottom-right');

map.addControl(new maplibregl.NavigationControl({showCompass:true}), 'bottom-right');

// ── HOME BUTTON ───────────────────────────────────────────────────────────────
const navGroup = map.getContainer().querySelector('.maplibregl-ctrl-bottom-right .maplibregl-ctrl-group');
if (navGroup) {
    const homeBtn = document.createElement('button');
    homeBtn.title = 'Reset tampilan';
    homeBtn.style.cssText = 'display:flex;align-items:center;justify-content:center;color:#333;';
    homeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>`;
    const zoomIn = navGroup.querySelector('.maplibregl-ctrl-zoom-in');
    if (zoomIn) navGroup.insertBefore(homeBtn, zoomIn);
    homeBtn.addEventListener('click', () => {
        if (initialBounds) map.fitBounds(initialBounds, {padding:20, maxZoom:16, duration:800});
    });
}

map.addControl(new maplibregl.ScaleControl({unit:'metric'}), 'bottom-left');

// auto-fit ke bounds data
let initialBounds = null;
fetch(`${MARTIN}/data_tanah`).then(r=>r.json()).then(meta=>{
    if(meta.bounds){
        const[w,s,e,n]=meta.bounds;
        initialBounds = [[w,s],[e,n]];
        map.fitBounds(initialBounds,{padding:20,maxZoom:16,duration:800});
    }
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
        paint:{ 'fill-color':COLOR_EXPR, 'fill-opacity': 0 }
    });
    map.addLayer({ id:'tanah-line', type:'line', source:'tanah', 'source-layer':TABLE,
        paint:{ 'line-color':COLOR_EXPR, 'line-width':['interpolate',['linear'],['zoom'],10,.5,15,1.2,18,2] }
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

// hover + tooltip
let hId = null;
const tooltip = document.getElementById('hover-tooltip');
function fmtT(v,d=0){ if(v==null||v==='')return'—'; const n=parseFloat(v); return isNaN(n)?v:n.toLocaleString('id-ID',{maximumFractionDigits:d}); }

map.on('mousemove','tanah-fill', e => {
    if (!e.features.length) return;
    map.getCanvas().style.cursor = 'pointer';
    if (hId !== null) map.setFeatureState({source:'tanah',sourceLayer:TABLE,id:hId},{hovered:false});
    hId = e.features[0].id;
    if (hId != null) map.setFeatureState({source:'tanah',sourceLayer:TABLE,id:hId},{hovered:true});

    const p = e.features[0].properties;
    document.getElementById('tt-id').textContent = p.idobjekpaj ?? '—';
    document.getElementById('tt-lt').textContent = p.luas_tanah != null ? fmtT(p.luas_tanah)+' m²' : '—';
    document.getElementById('tt-lb').textContent = p.luas_bangu != null ? fmtT(p.luas_bangu)+' m²' : '—';

    const rect = map.getCanvas().getBoundingClientRect();
    tooltip.style.left = (e.originalEvent.clientX - rect.left + 14) + 'px';
    tooltip.style.top  = (e.originalEvent.clientY - rect.top  - 10) + 'px';
    tooltip.style.display = 'block';
});
map.on('mouseleave','tanah-fill', () => {
    map.getCanvas().style.cursor='';
    tooltip.style.display = 'none';
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

// ── SEARCH / GEOCODING ───────────────────────────────────────────────────────
const searchInput   = document.getElementById('search-input');
const searchBtn     = document.getElementById('search-btn');
const searchResults = document.getElementById('search-results');
let searchMarker    = null;

function closeResults() { searchResults.style.display = 'none'; }

async function doSearch() {
    const q = searchInput.value.trim();
    if (!q) return;
    searchBtn.disabled = true; searchBtn.textContent = '…';
    closeResults();
    try {
        const url = `https://nominatim.openstreetmap.org/search?format=json&limit=5&countrycodes=id&viewbox=106.68,-6.38,107.00,-6.10&bounded=0&q=${encodeURIComponent(q)}`;
        const data = await fetch(url, {headers:{'Accept-Language':'id'}}).then(r=>r.json());
        searchResults.innerHTML = '';
        if (!data.length) {
            searchResults.innerHTML = '<div class="sr-empty">Alamat tidak ditemukan</div>';
            searchResults.style.display = 'block'; return;
        }
        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'sr-item';
            const parts = item.display_name.split(',');
            div.innerHTML = `<div class="sr-name">${parts[0].trim()}</div><div class="sr-detail">${parts.slice(1,4).join(',').trim()}</div>`;
            div.addEventListener('click', () => {
                const lng = parseFloat(item.lon), lat = parseFloat(item.lat);
                map.flyTo({center:[lng,lat], zoom:17, duration:900});
                if (searchMarker) searchMarker.remove();
                searchMarker = new maplibregl.Marker({color:'#22d3ee'}).setLngLat([lng,lat]).addTo(map);
                searchInput.value = parts[0].trim();
                closeResults();
            });
            searchResults.appendChild(div);
        });
        searchResults.style.display = 'block';
    } catch { searchResults.innerHTML = '<div class="sr-empty">Gagal menghubungi layanan pencarian</div>'; searchResults.style.display='block'; }
    finally { searchBtn.disabled=false; searchBtn.textContent='Cari'; }
}

searchBtn.addEventListener('click', doSearch);
searchInput.addEventListener('keydown', e => { if(e.key==='Enter') doSearch(); });
document.addEventListener('click', e => { if(!document.getElementById('search-bar').contains(e.target)) closeResults(); });

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
