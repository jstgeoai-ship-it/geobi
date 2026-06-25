<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang — Geoportal Jakarta SmartTax</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        .hero-glow {
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
        }

        .divider-accent {
            display: inline-block;
            width: 40px; height: 3px;
            background: linear-gradient(90deg, #f97316, #22d3ee);
            border-radius: 2px;
            margin-bottom: 16px;
        }

        .law-card {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 16px 18px;
            transition: border-color .2s, background .2s;
        }
        .law-card:hover {
            border-color: rgba(34, 211, 238, 0.2);
            background: rgba(34, 211, 238, 0.03);
        }

        .law-num {
            width: 28px; height: 28px;
            min-width: 28px;
            border-radius: 50%;
            background: rgba(34, 211, 238, 0.08);
            border: 1px solid rgba(34, 211, 238, 0.2);
            color: #22d3ee;
            font-size: 11px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin-top: 1px;
        }

        .stat-card {
            background: rgba(15,23,42,0.6);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            padding: 28px 24px;
            text-align: center;
        }

        .footer-link {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #64748b;
            text-decoration: none;
            transition: color .15s;
            padding: 4px 0;
        }
        .footer-link:hover { color: #22d3ee; }
    </style>
</head>
<body style="background:#0a0f1e;color:#e2e8f0;margin:0;">

@include('partials.navbar')

<!-- ── HERO ── -->
<section style="position:relative;overflow:hidden;padding:120px 0 80px;">

    <!-- GLOW BG -->
    <div class="hero-glow" style="background:rgba(34,211,238,0.04);top:-200px;left:-100px;"></div>
    <div class="hero-glow" style="background:rgba(249,115,22,0.04);bottom:-200px;right:-100px;"></div>

    <div style="max-width:800px;margin:0 auto;padding:0 32px;position:relative;z-index:1;">

        <!-- BREADCRUMB -->
        <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#475569;margin-bottom:40px;">
            <a href="{{ url('/home') }}" style="color:#475569;text-decoration:none;transition:color .15s;"
               onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#475569'">
                Beranda
            </a>
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span style="color:#f97316;font-weight:500;">Tentang</span>
        </div>

        <!-- LABEL -->
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <span style="width:32px;height:2px;background:linear-gradient(90deg,#f97316,#22d3ee);border-radius:2px;display:inline-block;"></span>
            <span style="font-size:11px;font-weight:700;color:#f97316;letter-spacing:.12em;text-transform:uppercase;">Tentang Kami</span>
        </div>

        <!-- JUDUL -->
        <h1 style="font-size:clamp(2.2rem,5vw,3.5rem);font-weight:800;line-height:1.1;margin-bottom:24px;letter-spacing:-.02em;">
            Geoportal <span style="color:#22d3ee;">Jakarta SmartTax</span>
        </h1>

        <!-- DESKRIPSI -->
        <p style="font-size:17px;line-height:1.8;color:#94a3b8;max-width:680px;">
            Geoportal Jakarta SmartTax merupakan portal informasi geospasial perpajakan daerah yang
            dikelola oleh Bapenda Provinsi DKI Jakarta. Portal ini menyediakan visualisasi data pajak
            daerah berbasis spasial yang terintegrasi untuk mendukung monitoring, analisis, dan
            pemutakhiran basis data pajak secara akurat, handal, dan mutakhir guna mendukung
            pengambilan kebijakan berbasis data.
        </p>

    </div>
</section>

<!-- ── STATISTIK ── -->
<section style="padding:0 0 72px;">
    <div style="max-width:800px;margin:0 auto;padding:0 32px;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            <div class="stat-card">
                <div style="font-size:2rem;font-weight:800;color:#22d3ee;margin-bottom:6px;">5 & 1</div>
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Wilayah Kota / Kabupaten</div>
            </div>
            <div class="stat-card">
                <div style="font-size:2rem;font-weight:800;color:#f97316;margin-bottom:6px;">44</div>
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Kecamatan</div>
            </div>
            <div class="stat-card">
                <div style="font-size:2rem;font-weight:800;color:#a855f7;margin-bottom:6px;">267</div>
                <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Kelurahan</div>
            </div>
        </div>
    </div>
</section>

<!-- ── LANDASAN HUKUM ── -->
<section style="padding:0 0 80px;">
    <div style="max-width:800px;margin:0 auto;padding:0 32px;">

        <!-- SECTION HEADER -->
        <div style="margin-bottom:36px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <span style="width:32px;height:2px;background:linear-gradient(90deg,#f97316,#22d3ee);border-radius:2px;display:inline-block;"></span>
                <span style="font-size:11px;font-weight:700;color:#f97316;letter-spacing:.12em;text-transform:uppercase;">Regulasi</span>
            </div>
            <h2 style="font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;letter-spacing:-.02em;margin-bottom:10px;">
                Landasan Hukum
            </h2>
            <p style="font-size:14px;color:#64748b;line-height:1.7;max-width:560px;">
                Peraturan perundang-undangan dan ketetapan resmi yang melandasi pelaksanaan
                program penataan data geospasial pajak daerah.
            </p>
        </div>

        <!-- GRID ITEMS -->
        @php
        $items = [
            'Undang-Undang Nomor 4 Tahun 2011 tentang Informasi Geospasial sebagaimana telah diubah terakhir dengan Undang-Undang Nomor 6 Tahun 2023;',
            'Peraturan Pemerintah Nomor 45 Tahun 2021 tentang Penyelenggaraan Informasi Geospasial;',
            'Peraturan Pemerintah Nomor 35 Tahun 2023 tentang Ketentuan Umum Pajak Daerah dan Retribusi Daerah;',
            'Peraturan Daerah Provinsi DKI Jakarta Nomor 7 Tahun 2022 tentang Pengelolaan Keuangan Daerah;',
            'Peraturan Daerah Nomor 1 Tahun 2024 tentang Pajak Daerah dan Retribusi Daerah;',
            'Peraturan Gubernur Provinsi DKI Jakarta Nomor 142 Tahun 2013 sebagaimana telah diubah dengan Peraturan Gubernur Nomor 161 Tahun 2014 tentang Sistem dan Prosedur Pengelolaan Keuangan Daerah;',
            'Peraturan Gubernur Provinsi DKI Jakarta Nomor 21 Tahun 2023 tentang Pembentukan dan Pemeliharaan Basis Data Pajak Daerah Melalui Sistem Informasi Geospasial;',
            'Instruksi Gubernur Provinsi DKI Jakarta Nomor 10 Tahun 2018 tentang Pemanfaatan Data Kependudukan oleh Organisasi Perangkat Daerah (OPD);',
            'Keputusan Gubernur Nomor 277 Tahun 2023 tentang Perubahan Ketigabelas Atas Keputusan Gubernur Nomor 129 Tahun 2020 tentang Kuasa Pengguna Anggaran pada Satuan Kerja Perangkat Daerah;',
            'Keputusan Kepala Badan Pendapatan Daerah Provinsi DKI Jakarta Nomor 356 Tahun 2024 tentang Pembentukan Tim Kerja Kegiatan Pemeliharaan dan Peningkatan Kualitas Data Pajak Daerah;',
            'Keputusan Kepala Badan Pendapatan Daerah Provinsi DKI Jakarta Nomor 362 Tahun 2024 tentang Petunjuk Pelaksanaan Kegiatan Matching dan Cleansing Data Pajak Bumi dan Bangunan Perdesaan dan Perkotaan Melalui Kegiatan Jakarta SmartTax;',
            'Keputusan Kepala Badan Pendapatan Daerah Provinsi DKI Jakarta Nomor 647 Tahun 2024 tentang Petunjuk Pelaksanaan Pendataan dalam rangka Penilaian Individual Pajak Bumi dan Bangunan Perdesaan dan Perkotaan;',
            'Keputusan Kepala Badan Pendapatan Daerah Provinsi DKI Jakarta Nomor 893 Tahun 2024 tentang Penunjukan dan Pengangkatan Pejabat Pembuat Komitmen di Lingkungan Badan Pendapatan Daerah Provinsi DKI Jakarta; dan',
            'Keputusan Kepala Badan Pendapatan Daerah Provinsi DKI Jakarta Nomor 4 Tahun 2025 tentang Penetapan Pejabat Penatausahaan Keuangan dan Pejabat Pelaksana Teknis Kegiatan Badan Pendapatan Daerah Provinsi DKI Jakarta Tahun Anggaran 2025.',
        ];
        @endphp

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            @foreach($items as $i => $item)
            <div class="law-card">
                <div class="law-num">{{ $i + 1 }}</div>
                <p style="font-size:13px;color:#94a3b8;line-height:1.65;margin:0;">{{ $item }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ── FOOTER ── -->
<footer style="border-top:1px solid rgba(255,255,255,0.05);background:rgba(2,6,23,0.6);">
    <div style="max-width:800px;margin:0 auto;padding:48px 32px 32px;">

        <div style="display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:40px;margin-bottom:40px;">

            <!-- BRAND -->
            <div>
                <img src="{{ asset('img/logo.png') }}" alt="Bapenda" style="height:40px;width:auto;margin-bottom:16px;display:block;">
                <p style="font-size:13px;color:#475569;line-height:1.7;">
                    Geoportal Pajak Daerah untuk repositori dan visualisasi data
                    geospasial perpajakan daerah Provinsi DKI Jakarta.
                </p>
            </div>

            <!-- KONTAK -->
            <div>
                <p style="font-size:11px;font-weight:700;color:#e2e8f0;text-transform:uppercase;letter-spacing:.08em;margin-bottom:16px;">Informasi Kontak</p>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <span style="width:26px;height:26px;min-width:26px;border-radius:50%;background:rgba(249,115,22,.12);display:flex;align-items:center;justify-content:center;margin-top:1px;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#f97316" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </span>
                        <span style="font-size:13px;color:#64748b;line-height:1.5;">Jl. Abdul Muis No. 66,<br>Jakarta Pusat</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="width:26px;height:26px;min-width:26px;border-radius:50%;background:rgba(34,197,94,.12);display:flex;align-items:center;justify-content:center;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#22c55e" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                        </span>
                        <span style="font-size:13px;color:#64748b;">(021) 3865656</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="width:26px;height:26px;min-width:26px;border-radius:50%;background:rgba(34,211,238,.12);display:flex;align-items:center;justify-content:center;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#22d3ee" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </span>
                        <span style="font-size:13px;color:#64748b;">bapenda@jakarta.go.id</span>
                    </div>
                </div>
            </div>

            <!-- TAUTAN -->
            <div>
                <p style="font-size:11px;font-weight:700;color:#e2e8f0;text-transform:uppercase;letter-spacing:.08em;margin-bottom:16px;">Tautan Terkait</p>
                <div style="display:flex;flex-direction:column;gap:4px;">
                    @foreach(['Bapenda DKI Jakarta','Data Jakarta','Portal DKI Jakarta'] as $link)
                    <a href="#" class="footer-link">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="opacity:.5;flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                        </svg>
                        {{ $link }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- COPYRIGHT -->
        <div style="border-top:1px solid rgba(255,255,255,0.05);padding-top:20px;text-align:center;font-size:12px;color:#1e293b;">
            © {{ date('Y') }} Badan Pendapatan Daerah Provinsi DKI Jakarta. All rights reserved.
        </div>

    </div>
</footer>

</body>
</html>
