<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi — Geoportal Jakarta SmartTax</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background:#0a0f1e; color:#e2e8f0; margin:0; }

        /* ── ORG CHART ── */
        .org-wrap {
            background: linear-gradient(160deg, #0f1e35 0%, #0a1628 60%, #0d1f1a 100%);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            padding: 40px 32px 48px;
            position: relative;
            overflow: hidden;
        }
        .org-wrap::before {
            content:'';
            position:absolute;
            top:-120px; right:-120px;
            width:400px; height:400px;
            border-radius:50%;
            background: rgba(34,211,238,0.04);
            filter: blur(80px);
            pointer-events:none;
        }

        /* header row */
        .org-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:40px; }
        .org-title { font-size: clamp(1.6rem,3vw,2.6rem); font-weight:900; line-height:1.1; text-transform:uppercase; }
        .org-title span { color:#22d3ee; display:block; }
        .org-dots { display:flex; gap:6px; margin-top:14px; }
        .org-dots span { width:10px; height:10px; border-radius:50%; }
        .org-logos { display:flex; align-items:center; gap:16px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:12px 20px; }
        .org-logos img { height:36px; width:auto; }

        /* node */
        .node { display:flex; flex-direction:column; align-items:center; position:relative; }

        .avatar {
            width:100px; height:120px;
            border-radius:10px;
            object-fit:cover;
            background: linear-gradient(135deg,#1e293b,#0f172a);
            border: 2px solid rgba(255,255,255,0.1);
            display:flex; align-items:center; justify-content:center;
            overflow:hidden;
        }
        .avatar-sm {
            width:80px; height:96px;
            border-radius:8px;
        }
        .avatar-placeholder {
            width:100%; height:100%;
            display:flex; align-items:center; justify-content:center;
            font-size:1.8rem; color:#334155;
        }

        .node-name { font-size:13px; color:#22d3ee; font-weight:600; margin-top:8px; text-align:center; }
        .node-name-sm { font-size:11px; }
        .node-badge {
            font-size:8.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
            padding:4px 10px; border-radius:20px;
            background:rgba(34,211,238,0.12); color:#67e8f9;
            border:1px solid rgba(34,211,238,0.2);
            margin-top:5px; text-align:center; line-height:1.3;
            max-width:140px;
        }
        .badge-orange { background:rgba(249,115,22,.15); color:#fb923c; border-color:rgba(249,115,22,.25); }
        .badge-green  { background:rgba(34,197,94,.12);  color:#4ade80; border-color:rgba(34,197,94,.2); }
        .badge-purple { background:rgba(168,85,247,.12); color:#c084fc; border-color:rgba(168,85,247,.2); }
        .badge-dark   { background:rgba(30,41,59,.6);    color:#64748b; border-color:rgba(71,85,105,.3); }

        /* connectors */
        .v-line { width:2px; height:28px; background:rgba(34,211,238,0.3); margin:0 auto; }
        .h-connector { display:flex; align-items:flex-start; position:relative; gap:0; }
        .h-connector::before {
            content:''; position:absolute;
            top:0; left:50%; right:50%;
            height:2px; background:rgba(34,211,238,0.3);
            transform: translateX(-50%);
            width: calc(100% - 80px);
        }
        .h-connector > .node-col { flex:1; display:flex; flex-direction:column; align-items:center; }
        .h-connector > .node-col::before {
            content:''; display:block;
            width:2px; height:24px;
            background:rgba(34,211,238,0.3);
        }

        /* UPT row */
        .upt-card {
            background:rgba(15,23,42,0.7);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:10px;
            padding:8px 12px;
            display:flex; align-items:center; gap:8px;
            margin-bottom:10px;
        }
        .upt-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .upt-label { font-size:11px; font-weight:800; color:#e2e8f0; }

        .node-sub { font-size:10px; color:#475569; text-align:center; margin-top:4px; max-width:110px; line-height:1.3; }

        .footer-link { display:flex; align-items:center; gap:8px; font-size:13px; color:#64748b; text-decoration:none; transition:color .15s; padding:4px 0; }
        .footer-link:hover { color:#22d3ee; }
    </style>
</head>
<body>

@include('partials.navbar')

<!-- ── PAGE HEADER ── -->
<div style="max-width:1100px;margin:0 auto;padding:100px 32px 24px;">

    <!-- BREADCRUMB -->
    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#475569;margin-bottom:24px;">
        <a href="{{ url('/home') }}" style="color:#475569;text-decoration:none;" onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#475569'">Beranda</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span style="color:#f97316;font-weight:500;">Struktur Organisasi</span>
    </div>

    <h1 style="font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;margin-bottom:4px;">
        Struktur Organisasi <span style="color:#22d3ee;">Jakarta SmartTax</span>
    </h1>
    <p style="font-size:14px;color:#475569;margin-bottom:32px;">Bapenda DKI Jakarta</p>

</div>

<!-- ── ORG CHART PANEL ── -->
<div style="max-width:1100px;margin:0 auto;padding:0 32px 80px;">
<div class="org-wrap">

    <!-- PANEL HEADER -->
    <div class="org-header">
        <div>
            <div class="org-title">
                Struktur<br>
                <span>Organisasi</span>
                Tahun 2026
            </div>
            <div class="org-dots">
                <span style="background:#f97316;"></span>
                <span style="background:#22d3ee;"></span>
                <span style="background:#22d3ee;"></span>
            </div>
        </div>
        <div class="org-logos">
            <img src="{{ asset('img/logo-jakarta.png') }}" alt="Jakarta"
                 onerror="this.style.display='none'">
            <img src="{{ asset('img/logo.png') }}" alt="Bapenda">
            <img src="{{ asset('img/logo-smarttax.png') }}" alt="SmartTax"
                 onerror="this.style.display='none'">
        </div>
    </div>

    <!-- ORG TREE -->
    <div style="display:flex;flex-direction:column;align-items:center;">

        {{-- LEVEL 1: Kepala Badan --}}
        <div class="node">
            <div class="avatar" style="width:110px;height:130px;">
                <div class="avatar-placeholder">👤</div>
            </div>
            <div class="node-name">Lusiana Herawati</div>
            <div class="node-badge">Kepala Badan Pendapatan Daerah</div>
        </div>

        <div class="v-line"></div>

        {{-- LEVEL 2: Wakil Kepala --}}
        <div class="node">
            <div class="avatar">
                <div class="avatar-placeholder">👤</div>
            </div>
            <div class="node-name">Elvarinsa</div>
            <div class="node-badge">Wakil Kepala Badan Pendapatan Daerah</div>
        </div>

        <div class="v-line"></div>

        {{-- LEVEL 3: Kepala Bidang --}}
        <div class="node">
            <div class="avatar">
                <div class="avatar-placeholder">👤</div>
            </div>
            <div class="node-name">Mulyo Susongko</div>
            <div class="node-badge">Kepala Bidang Pendapatan Pajak I</div>
        </div>

        <div class="v-line"></div>

        {{-- LEVEL 4: Sub Bidang (3 kolom) --}}
        <div class="h-connector" style="width:100%;max-width:680px;">
            <div class="node-col">
                <div class="avatar avatar-sm"><div class="avatar-placeholder" style="font-size:1.4rem;">👤</div></div>
                <div class="node-name node-name-sm">Koko Karyono</div>
                <div class="node-badge badge-orange" style="font-size:8px;">Kepala Sub Bidang Pengendalian Pajak I</div>
            </div>
            <div class="node-col">
                <div class="avatar avatar-sm"><div class="avatar-placeholder" style="font-size:1.4rem;">👤</div></div>
                <div class="node-name node-name-sm">Sutan Imam</div>
                <div class="node-badge" style="font-size:7.5px;">Kepala Sub Bidang Potensi dan Ekstensifikasi Pajak I (Pejabat Pelaksana Teknis Kegiatan)</div>
            </div>
            <div class="node-col">
                <div class="avatar avatar-sm"><div class="avatar-placeholder" style="font-size:1.4rem;">👤</div></div>
                <div class="node-name node-name-sm">Heri Supriono</div>
                <div class="node-badge badge-green" style="font-size:8px;">Kepala Sub Bidang Pemeriksaan dan Penagihan Pajak I</div>
            </div>
        </div>

        <div class="v-line" style="margin-top:16px;"></div>

        {{-- UPT ROW --}}
        @php
        $upts = [
            ['code'=>'MDS FL','label'=>'UPT MDS FL','color'=>'#f97316','name'=>'Fifik Zulfikar','unit'=>'Unit Pelaksana Teknis Manajemen Data Spasial Frontline'],
            ['code'=>'STS','label'=>'UPT STS','color'=>'#22d3ee','name'=>'Firdaus','unit'=>'Unit Pelaksana Teknis Spasial Tax Survey'],
            ['code'=>'SSS','label'=>'UPT SSS','color'=>'#22c55e','name'=>'Asyari Adisaputra','unit'=>'Unit Pelaksana Teknis Spasial Support Survey'],
            ['code'=>'MDS BL','label'=>'UPT MDS BL','color'=>'#94a3b8','name'=>'Rachmat Dwinanto','unit'=>'Unit Pelaksana Teknis Manajemen Data Spasial Backline'],
            ['code'=>'AK','label'=>'UPT AK','color'=>'#a855f7','name'=>'Riky Hermansyah','unit'=>'Unit Pelaksana Teknis AK'],
        ];
        @endphp

        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;width:100%;position:relative;margin-top:8px;">

            {{-- horizontal line across UPT --}}
            <div style="position:absolute;top:0;left:10%;right:10%;height:2px;background:linear-gradient(90deg,rgba(34,211,238,0),rgba(34,211,238,0.3) 20%,rgba(34,211,238,0.3) 80%,rgba(34,211,238,0));"></div>

            @foreach($upts as $upt)
            <div style="display:flex;flex-direction:column;align-items:center;padding-top:24px;position:relative;">
                {{-- vertical drop --}}
                <div style="width:2px;height:24px;background:rgba(34,211,238,0.3);position:absolute;top:0;left:50%;transform:translateX(-50%);"></div>

                {{-- UPT card --}}
                <div class="upt-card" style="width:100%;justify-content:center;">
                    <div class="upt-icon" style="background:{{ $upt['color'] }}20;border:1px solid {{ $upt['color'] }}30;">
                        <span style="font-size:10px;font-weight:900;color:{{ $upt['color'] }};">{{ substr($upt['code'],0,2) }}</span>
                    </div>
                    <span class="upt-label" style="font-size:10px;">{{ $upt['label'] }}</span>
                </div>

                {{-- PM node --}}
                <div class="v-line" style="height:16px;"></div>
                <div class="avatar avatar-sm" style="width:72px;height:86px;">
                    <div class="avatar-placeholder" style="font-size:1.3rem;">👤</div>
                </div>
                <div class="node-name" style="font-size:11px;margin-top:6px;">{{ $upt['name'] }}</div>
                <div class="node-badge badge-orange" style="font-size:8px;">Project Manager</div>
                <div class="node-sub">{{ $upt['unit'] }}</div>

                {{-- Co-PM --}}
                <div class="v-line" style="height:16px;"></div>
                <div style="width:100%;border:1px solid rgba(255,255,255,0.07);border-radius:8px;padding:6px;text-align:center;">
                    <span style="font-size:9px;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.05em;">Co-Project Manager</span>
                </div>
            </div>
            @endforeach

        </div>

    </div>
</div>
</div>

<!-- ── FOOTER ── -->
<footer style="border-top:1px solid rgba(255,255,255,0.05);background:rgba(2,6,23,0.6);">
    <div style="max-width:900px;margin:0 auto;padding:48px 32px 32px;">

        <div style="display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:40px;margin-bottom:40px;">

            <div>
                <img src="{{ asset('img/logo.png') }}" alt="Bapenda" style="height:40px;width:auto;margin-bottom:16px;display:block;">
                <p style="font-size:13px;color:#475569;line-height:1.7;">
                    Geoportal Pajak Daerah untuk repositori dan visualisasi data geospasial
                    perpajakan daerah Provinsi DKI Jakarta yang terintegrasi dengan Portal Jakarta Satu.
                </p>
            </div>

            <div>
                <p style="font-size:11px;font-weight:700;color:#e2e8f0;text-transform:uppercase;letter-spacing:.08em;margin-bottom:16px;">Informasi Kontak</p>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <span style="width:26px;height:26px;min-width:26px;border-radius:50%;background:rgba(249,115,22,.12);display:flex;align-items:center;justify-content:center;margin-top:1px;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#f97316" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </span>
                        <span style="font-size:13px;color:#64748b;line-height:1.5;">Jl. Abdul Muis No. 66,<br>Jakarta Pusat</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="width:26px;height:26px;min-width:26px;border-radius:50%;background:rgba(34,197,94,.12);display:flex;align-items:center;justify-content:center;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#22c55e" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </span>
                        <span style="font-size:13px;color:#64748b;">(021) 3865656</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="width:26px;height:26px;min-width:26px;border-radius:50%;background:rgba(34,211,238,.12);display:flex;align-items:center;justify-content:center;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#22d3ee" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </span>
                        <span style="font-size:13px;color:#64748b;">bapenda@jakarta.go.id</span>
                    </div>
                </div>
            </div>

            <div>
                <p style="font-size:11px;font-weight:700;color:#e2e8f0;text-transform:uppercase;letter-spacing:.08em;margin-bottom:16px;">Tautan Terkait</p>
                <div style="display:flex;flex-direction:column;gap:4px;">
                    @foreach(['Bapenda DKI Jakarta','Data Jakarta','Portal DKI Jakarta'] as $link)
                    <a href="#" class="footer-link">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="opacity:.5;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        {{ $link }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.05);padding-top:20px;text-align:center;font-size:12px;color:#1e293b;">
            © {{ date('Y') }} Badan Pendapatan Daerah Provinsi DKI Jakarta. All rights reserved.
        </div>

    </div>
</footer>

</body>
</html>
