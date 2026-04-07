@extends('layouts.fullscreen-layout')

@section('content')
<style>
    * { box-sizing: border-box; }

    .login-outer {
        min-height: 100vh;
        background: #f0f4fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        font-family: 'Inter', sans-serif;
    }

    /* FLOATING BLOBS */
    .bg-blobs span {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        animation: floatBlob 18s infinite ease-in-out;
    }

    .bg-blobs span:nth-child(1){
        width: 300px; height: 300px;
        left: 10%; top: 70%;
    }
    .bg-blobs span:nth-child(2){
        width: 200px; height: 200px;
        left: 70%; top: 80%;
        animation-delay: 4s;
    }
    .bg-blobs span:nth-child(3){
        width: 250px; height: 250px;
        left: 50%; top: 60%;
        animation-delay: 8s;
    }

    @keyframes floatBlob {
        0% { transform: translateY(0) scale(1);}
        50% { transform: translateY(-80px) scale(1.1);}
        100% { transform: translateY(0) scale(1);}
    }


    .dark .login-outer {
        background: #0f172a;
    }

    .login-card {
        display: flex;
        width: 100%;
        max-width: 860px;
        min-height: 520px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(12, 68, 124, 0.12);
        border: 0.5px solid rgba(55, 138, 221, 0.2);
    }

    /* LEFT */
    .left-panel {
        flex: 1;
        background: #fff;
        padding: 44px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dark .left-panel {
        background: #1e293b;
    }

    .back-link {
        font-size: 13px;
        color: #64748b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 28px;
        transition: color 0.2s;
    }

    .back-link:hover { color: #185FA5; }

    .step-dots {
        display: flex;
        gap: 6px;
        margin-bottom: 22px;
    }

    .step-dot {
        width: 6px;
        height: 6px;
        border-radius: 3px;
        background: #e2e8f0;
        transition: width 0.3s, background 0.3s;
    }

    .step-dot.active {
        width: 22px;
        background: #185FA5;
    }

    .badge-system {
        display: inline-flex;
        align-items: center;
        background: #EFF6FF;
        color: #185FA5;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 18px;
        font-weight: 500;
    }

    .badge-system .pulse {
        display: inline-block;
        width: 7px;
        height: 7px;
        background: #FAC775;
        border-radius: 50%;
        margin-right: 7px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.65); }
    }

    .form-title {
        font-size: 24px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .dark .form-title { color: #f1f5f9; }

    .form-sub {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 28px;
    }

    .field-group { margin-bottom: 16px; }

    .field-label {
        display: block;
        font-size: 13px;
        color: #475569;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .dark .field-label { color: #94a3b8; }

    .field-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #f8fafc;
        color: #0f172a;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .dark .field-input {
        background: #0f172a;
        border-color: #334155;
        color: #f1f5f9;
    }

    .field-input:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55, 138, 221, 0.12);
    }

    .btn-primary {
        width: 100%;
        padding: 11px;
        background: #185FA5;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 6px;
        transition: background 0.2s, transform 0.1s;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.2px;
    }

    .btn-primary:hover { background: #0C447C; }
    .btn-primary:active { transform: scale(0.98); }

    .btn-primary .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: scale(0);
        animation: ripple 0.55s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to { transform: scale(4); opacity: 0; }
    }

    /* DAPUR STEP */
    .dapur-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 13px 16px;
        cursor: pointer;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
        transition: border-color 0.2s, background 0.2s, transform 0.2s;
    }

    .dark .dapur-card {
        background: #1e293b;
        border-color: #334155;
    }

    .dapur-card:hover {
        border-color: #378ADD;
        background: #EFF6FF;
        transform: translateX(5px);
    }

    .dark .dapur-card:hover {
        background: #1e3a5f;
    }

    .dapur-icon {
        width: 40px;
        height: 40px;
        background: #EFF6FF;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dapur-name {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
    }

    .dark .dapur-name { color: #f1f5f9; }

    .dapur-loc {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .dapur-arrow {
        margin-left: auto;
        color: #378ADD;
        font-size: 18px;
        opacity: 0;
        transition: opacity 0.2s, transform 0.2s;
    }

    .dapur-card:hover .dapur-arrow {
        opacity: 1;
        transform: translateX(3px);
    }

    /* STEP TRANSITIONS */
    .step-panel { display: none; }

    .step-panel.active {
        display: flex;
        flex-direction: column;
        animation: slideIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(18px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .step-panel.back-anim {
        animation: slideInLeft 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-18px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* RIGHT */
    .right-panel {
        width: 280px;
        background: #0C447C;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 28px;
        position: relative;
        overflow: hidden;
    }

    .right-panel::before {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        top: -70px;
        right: -70px;
    }

    .right-panel::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(250, 199, 117, 0.12);
        bottom: -50px;
        left: -50px;
    }

    .logo-ring {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #FAC775;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        position: relative;
        z-index: 1;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .right-app-name {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        letter-spacing: 1.5px;
        position: relative;
        z-index: 1;
        margin-bottom: 10px;
    }

    .right-tagline {
        font-size: 13px;
        color: rgba(255,255,255,0.55);
        text-align: center;
        line-height: 1.6;
        position: relative;
        z-index: 1;
    }

    .dots-deco {
        display: flex;
        flex-direction: column;
        gap: 7px;
        position: absolute;
        bottom: 100px;
        right: 24px;
        z-index: 1;
    }

    .dots-deco span {
        display: block;
        width: 7px;
        height: 7px;
        background: rgba(250, 199, 117, 0.45);
        border-radius: 50%;
    }

    .dots-deco span:nth-child(1) { animation: pulse 2s 0s infinite; }
    .dots-deco span:nth-child(2) { animation: pulse 2s 0.3s infinite; }
    .dots-deco span:nth-child(3) { animation: pulse 2s 0.6s infinite; }

    .yellow-bar {
        width: 40px;
        height: 3px;
        background: #FAC775;
        border-radius: 2px;
        margin: 14px auto 0;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 640px) {
        .right-panel { display: none; }
        .login-card { max-width: 440px; }
    }

    [x-cloak] { display: none !important; }
</style>

<div class="login-outer dark:bg-gray-950">
    
    <div class="login-card">

        <!-- LEFT PANEL -->
        <div class="left-panel">
            {{-- <a href="/" class="back-link">← Kembali</a> --}}

            <!-- STEP: LOGIN -->
            <div id="step-login" class="step-panel active">
                <div class="step-dots">
                    <div class="step-dot active"></div>
                    <div class="step-dot"></div>
                </div>

                <div class="badge-system">
                    <span class="pulse"></span>
                    Sistem Keuangan Gizi
                </div>

                <h1 class="form-title">Masuk</h1>
                <p class="form-sub">Masuk untuk mengelola data keuangan</p>

                <form id="form-login">
                    <div class="field-group">
                        <label class="field-label">Username</label>
                        <input type="text" name="username" class="field-input" placeholder="Masukkan username">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password</label>
                        <input type="password" name="password" class="field-input" placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-primary">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- STEP: PILIH DAPUR -->
            <div id="step-dapur" class="step-panel">
                <div class="step-dots">
                    <div class="step-dot"></div>
                    <div class="step-dot active"></div>
                </div>

                <h1 class="form-title">Pilih Dapur</h1>
                <p class="form-sub">Pilih lokasi dapur untuk melanjutkan</p>

                @foreach($dapur as $d)
                <div class="dapur-card" onclick="selectDapur({{ $d->id }})">
                    <div class="dapur-icon">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                                      stroke="#185FA5" stroke-width="1.5"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="9 22 9 12 15 12 15 22"
                                          stroke="#185FA5" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                    </div>
                    <div>
                        <div class="dapur-name">{{ $d->nama_lembaga }}</div>
                        <div class="dapur-loc">{{ $d->alamat }}</div>
                    </div>
                    <div class="dapur-arrow">→</div>
                </div>
                @endforeach

                <button @click="backToLogin()"
                        class="back-link" style="margin-top: 14px;">
                    ← Kembali ke login
                </button>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="logo-ring">
                <svg width="34" height="34" fill="none" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" fill="#0C447C"/>
                    <path d="M8 12l3 3 5-5" stroke="#fff" stroke-width="1.8"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="right-app-name">KAPUAZ</div>
            <div class="right-tagline">Aplikasi Pelaporan<br>Keuangan Gizi</div>
            <div class="yellow-bar"></div>
            <div class="dots-deco">
                <span></span><span></span><span></span>
            </div>
        </div>

    </div>
</div>

<script>
const form = document.getElementById('form-login');
const stepLogin = document.getElementById('step-login');
const stepDapur = document.getElementById('step-dapur');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const username = form.querySelector('input[type=text]').value;
    const password = form.querySelector('input[type=password]').value;

    fetch('/signin', {
        method: 'POST',
        credentials: 'same-origin', // 🔥 tambahin ini juga biar konsisten
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ username, password })
    })
    .then(res => res.json())
    .then(res => {

        console.log(res);

        // 👑 SUPER ADMIN → tampil pilih dapur
        if (res.role === 'super_admin') {
            stepLogin.classList.remove('active');
            stepDapur.classList.add('active');
        }

        // 👤 ADMIN → langsung dashboard
        else if (res.role === 'admin') {
            window.location.href = res.redirect;
        }

    })
    .catch(err => {
        console.error(err);
        alert('Login gagal');
    });
});

function selectDapur(id) {
    fetch('/pilih-dapur/' + id, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => {
        console.log('STATUS:', res.status);
        if (!res.ok) throw new Error('Request gagal');
        return res.json();
    })
    .then(res => {
        if (res.status === 'success') {
            window.location.href = '/admin/dashboard';
        }
    })
    .catch(err => {
        console.error(err);
        alert('Gagal pilih dapur');
    });
}
</script>
@endsection