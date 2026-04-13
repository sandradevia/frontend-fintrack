@extends('layouts.fullscreen-layout')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #0f172a;
    min-height: 100vh;
}

/* ── BACKGROUND ── */
.kp-outer {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 24px;
    position: relative;
    overflow: hidden;
}

.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    opacity: 0.22;
    animation: float 6s ease-in-out infinite;
    pointer-events: none;
}
.orb1 { width: 340px; height: 340px; background: #3b82f6; top: -100px; left: -100px; animation-delay: 0s; }
.orb2 { width: 260px; height: 260px; background: #f59e0b; bottom: -80px; right: -80px; animation-delay: 2s; }
.orb3 { width: 200px; height: 200px; background: #22c55e; bottom: 60px; left: 35%; animation-delay: 4s; }
.orb4 { width: 160px; height: 160px; background: #f97316; top: 30px; right: 28%; animation-delay: 1s; }

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50%       { transform: translateY(-22px) scale(1.06); }
}

/* ── PARTICLES ── */
.particles { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
.particle {
    position: absolute;
    width: 4px; height: 4px;
    border-radius: 50%;
    animation: rise linear infinite;
}
@keyframes rise {
    0%   { transform: translateY(100vh) translateX(0); opacity: 0.7; }
    100% { transform: translateY(-20px) translateX(30px); opacity: 0; }
}

/* ── CARD ── */
.kp-card {
    width: 100%;
    max-width: 880px;
    display: flex;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 40px 90px rgba(0,0,0,0.55);
    position: relative;
    z-index: 2;
}

/* ── LEFT PANEL ── */
.kp-left {
    flex: 1;
    background: rgba(15,23,42,0.88);
    border: 1px solid rgba(255,255,255,0.08);
    border-right: none;
    padding: 48px 44px;
    color: white;
    backdrop-filter: blur(24px);
}

/* ── STEPS ── */
.step-panel { display: none; }
.step-panel.active {
    display: block;
    animation: fadeUp 0.35s ease;
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── BADGE ── */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.6px;
    margin-bottom: 20px;
    text-transform: uppercase;
}
.badge-blue  { background: rgba(59,130,246,0.15);  color: #60a5fa;  border: 1px solid rgba(59,130,246,0.3);  }
.badge-green { background: rgba(34,197,94,0.15);   color: #4ade80;  border: 1px solid rgba(34,197,94,0.3);   }
.badge-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: currentColor;
    animation: blink 1.4s ease-in-out infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.25} }

/* ── TYPOGRAPHY ── */
.form-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 6px;
    background: linear-gradient(135deg, #ffffff 40%, #94a3b8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.form-sub { font-size: 13px; color: #64748b; margin-bottom: 30px; }

/* ── FORM ── */
.field-group { margin-bottom: 20px; }
.field-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.6px;
    color: #94a3b8;
    margin-bottom: 7px;
    text-transform: uppercase;
}
.field-input {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: white;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}
.field-input:focus {
    border-color: #3b82f6;
    background: rgba(59,130,246,0.08);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.18);
}
.field-input::placeholder { color: #475569; }

/* ── BUTTON ── */
.btn-login {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    font-family: inherit;
    color: white;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    transition: transform 0.2s, box-shadow 0.2s;
    margin-top: 6px;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(59,130,246,0.45);
}
.btn-login:active { transform: translateY(0); }
.btn-login::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
    transform: translateX(-100%);
    animation: shimmer 2.4s infinite;
}
@keyframes shimmer {
    0%      { transform: translateX(-100%); }
    60%,100%{ transform: translateX(100%); }
}

/* ── DIVIDER ── */
.divider { height: 1px; background: rgba(255,255,255,0.07); margin: 26px 0; }

/* ── DAPUR CARD ── */
.dapur-form { margin: 0; padding: 0; }
.dapur-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    margin-bottom: 10px;
    border-radius: 14px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    cursor: pointer;
    transition: background 0.25s, border-color 0.25s, transform 0.25s;
    width: 100%;
    text-align: left;
    color: white;
    font-family: inherit;
}
.dapur-card:hover {
    background: rgba(59,130,246,0.14);
    border-color: rgba(59,130,246,0.4);
    transform: translateX(7px);
}

.dapur-icon {
    width: 42px; height: 42px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    font-weight: 700;
    flex-shrink: 0;
}
.d-blue   { background: rgba(59,130,246,0.2);  color: #60a5fa; }
.d-green  { background: rgba(34,197,94,0.2);   color: #4ade80; }
.d-amber  { background: rgba(245,158,11,0.2);  color: #fbbf24; }
.d-orange { background: rgba(249,115,22,0.2);  color: #fb923c; }

.dapur-name { font-weight: 600; font-size: 13px; line-height: 1.3; }
.dapur-loc  { font-size: 11px; color: #64748b; margin-top: 2px; }

.dapur-arrow {
    margin-left: auto;
    width: 30px; height: 30px;
    border-radius: 8px;
    background: rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
    transition: background 0.2s;
}
.dapur-card:hover .dapur-arrow { background: rgba(59,130,246,0.3); }

.back-link {
    font-size: 12px;
    color: #475569;
    cursor: pointer;
    background: none;
    border: none;
    font-family: inherit;
    padding: 0;
    transition: color 0.2s;
    display: inline-block;
}
.back-link:hover { color: #94a3b8; }

/* ── RIGHT PANEL ── */
.kp-right {
    width: 300px;
    flex-shrink: 0;
    background: linear-gradient(160deg, #1e3a8a 0%, #1e40af 50%, #1d4ed8 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 44px 28px;
    position: relative;
    overflow: hidden;
}

.kp-right::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    border: 32px solid rgba(255,255,255,0.06);
    border-radius: 50%;
    top: -70px; right: -70px;
    animation: spin 20s linear infinite;
}
.kp-right::after {
    content: '';
    position: absolute;
    width: 160px; height: 160px;
    border: 22px solid rgba(255,255,255,0.04);
    border-radius: 50%;
    bottom: -50px; left: -50px;
    animation: spin 15s linear infinite reverse;
}
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }

.logo-box {
    width: 82px; height: 82px;
    border-radius: 22px;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; font-weight: 800;
    color: white;
    margin-bottom: 20px;
    position: relative; z-index: 1;
    animation: pulse-logo 3s ease-in-out infinite;
}
@keyframes pulse-logo {
    0%,100%{ box-shadow: 0 0 0 0 rgba(96,165,250,0); }
    50%    { box-shadow: 0 0 0 16px rgba(96,165,250,0.1); }
}

.logo-name {
    font-size: 24px; font-weight: 800;
    color: white; letter-spacing: 3px;
    margin-bottom: 8px;
    position: relative; z-index: 1;
}
.logo-sub {
    font-size: 12px;
    color: rgba(255,255,255,0.5);
    text-align: center; line-height: 1.6;
    position: relative; z-index: 1;
}

.pills-row {
    display: flex; flex-direction: column; gap: 9px;
    margin-top: 32px; width: 100%;
    position: relative; z-index: 1;
}
.pill {
    display: flex; align-items: center; gap: 9px;
    padding: 9px 13px;
    border-radius: 10px;
    font-size: 12px; font-weight: 500;
    color: rgba(255,255,255,0.9);
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    animation: slideIn 0.5s ease both;
}
.pill:nth-child(1){ animation-delay: 0.1s; }
.pill:nth-child(2){ animation-delay: 0.2s; }
.pill:nth-child(3){ animation-delay: 0.3s; }
@keyframes slideIn {
    from { opacity: 0; transform: translateX(20px); }
    to   { opacity: 1; transform: translateX(0); }
}
.pill-dot {
    width: 8px; height: 8px;
    border-radius: 50%; flex-shrink: 0;
}
.pd-green  { background: #22c55e; box-shadow: 0 0 6px #22c55e88; }
.pd-amber  { background: #f59e0b; box-shadow: 0 0 6px #f59e0b88; }
.pd-orange { background: #f97316; box-shadow: 0 0 6px #f9731688; }

/* ── ALERT ERROR ── */
.alert-error {
    padding: 12px 16px;
    border-radius: 12px;
    background: rgba(239,68,68,0.12);
    border: 1px solid rgba(239,68,68,0.3);
    color: #fca5a5;
    font-size: 13px;
    margin-bottom: 20px;
}

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
    .kp-right  { display: none; }
    .kp-left   { padding: 36px 28px; }
    .kp-card   { border-radius: 20px; }
}
</style>

<div class="kp-outer">

    {{-- Background orbs --}}
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>
    <div class="orb orb4"></div>

    {{-- Particles (rendered by JS) --}}
    <div class="particles" id="particles"></div>

    <div class="kp-card">

        {{-- ══ LEFT PANEL ══ --}}
        <div class="kp-left">

            {{-- ── STEP 1 : LOGIN ── --}}
            <div id="step-login" class="step-panel {{ session('step') ? '' : 'active' }}">

                <div class="badge badge-blue">
                    <span class="badge-dot"></span>
                    Sistem Aktif
                </div>

                <h1 class="form-title">Selamat Datang</h1>
                <p class="form-sub">Masuk untuk mengelola sistem keuangan gizi</p>

                @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="/signin">
                    @csrf

                    <div class="field-group">
                        <label class="field-label">Username</label>
                        <input
                            type="text"
                            name="username"
                            class="field-input"
                            placeholder="Masukkan username"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="field-input"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password">
                    </div>

                    <button type="submit" class="btn-login">
                        Masuk ke Sistem →
                    </button>
                </form>

                <div class="divider"></div>
                <p style="font-size:12px; color:#475569; text-align:center;">
                    KAPUAZ &copy; {{ date('Y') }} &mdash; Sistem Keuangan Gizi
                </p>
            </div>

            {{-- ── STEP 2 : PILIH DAPUR ── --}}
            <div id="step-dapur" class="step-panel {{ session('step') == 'dapur' ? 'active' : '' }}">

                <div class="badge badge-green">
                    <span class="badge-dot"></span>
                    Pilih Lokasi
                </div>

                <h1 class="form-title">Pilih Dapur</h1>
                <p class="form-sub">Pilih dapur yang akan dikelola sesi ini</p>

                @php
                    $iconColors = ['d-blue', 'd-green', 'd-amber', 'd-orange'];
                @endphp

                @foreach($dapur as $i => $d)
                <form class="dapur-form" method="POST" action="{{ url('/pilih-dapur/'.$d->id) }}">
                    @csrf
                    <button type="submit" class="dapur-card">
                        <div class="dapur-icon {{ $iconColors[$i % 4] }}">
                            {{ strtoupper(substr($d->nama_lembaga, 0, 1)) }}
                        </div>
                        <div>
                            <div class="dapur-name">{{ $d->nama_lembaga }}</div>
                            <div class="dapur-loc">{{ $d->alamat }}</div>
                        </div>
                        <div class="dapur-arrow">→</div>
                    </button>
                </form>
                @endforeach

                <div class="divider"></div>

                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit" class="back-link">← Kembali / Ganti Akun</button>
                </form>
            </div>

        </div>

        {{-- ══ RIGHT PANEL ══ --}}
        <div class="kp-right">

            <div class="logo-box">KP</div>
            <div class="logo-name">KAPUAZ</div>
            <div class="logo-sub">Sistem Keuangan Gizi<br>Terintegrasi</div>

            <div class="pills-row">
                <div class="pill">
                    <span class="pill-dot pd-green"></span>
                    Data Keuangan Real-time
                </div>
                <div class="pill">
                    <span class="pill-dot pd-amber"></span>
                    Multi-Dapur Terpusat
                </div>
                <div class="pill">
                    <span class="pill-dot pd-orange"></span>
                    Laporan Gizi Akurat
                </div>
            </div>

        </div>

    </div>
</div>

<script>
(function () {
    /* ── Particle generator ── */
    const container = document.getElementById('particles');
    const colors = ['#3b82f6', '#f59e0b', '#22c55e', '#f97316'];
    for (let i = 0; i < 20; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.cssText = [
            `left:${Math.random() * 100}%`,
            `bottom:0`,
            `background:${colors[i % 4]}`,
            `animation-duration:${4 + Math.random() * 6}s`,
            `animation-delay:${Math.random() * 6}s`,
            `opacity:${0.3 + Math.random() * 0.45}`,
        ].join(';');
        container.appendChild(p);
    }
})();
</script>

@endsection