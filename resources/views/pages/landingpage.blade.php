<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAPUAZ — Sistem Informasi Keuangan Gizi Terintegrasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:   #2563eb;
            --blue-lt:#eff6ff;
            --green:  #16a34a;
            --green-lt:#f0fdf4;
            --amber:  #d97706;
            --amber-lt:#fffbeb;
            --orange: #ea580c;
            --orange-lt:#fff7ed;
            --purple: #7c3aed;
            --purple-lt:#f5f3ff;
            --teal:   #0d9488;
            --teal-lt:#f0fdfa;
            --text:   #0f172a;
            --muted:  #64748b;
            --border: #e2e8f0;
            --surface:#f8fafc;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: var(--text);
            overflow-x: hidden;
        }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }

        /* ─── NAVBAR ─── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 999;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 56px; height: 64px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow 0.3s;
        }
        .navbar.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,0.06); }
        .nav-logo { display: flex; align-items: center; gap: 10px; }
        .nav-logomark {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--blue); display: flex; align-items: center; justify-content: center;
            color: white; font-size: 12px; font-weight: 800; letter-spacing: 0.5px;
        }
        .nav-brand { font-size: 15px; font-weight: 800; letter-spacing: 1.5px; color: var(--text); }
        .nav-links { display: flex; gap: 32px; }
        .nav-links a { font-size: 13px; color: var(--muted); font-weight: 500; text-decoration: none; transition: color 0.2s; }
        .nav-links a:hover { color: var(--text); }
        .nav-right { display: flex; gap: 10px; align-items: center; }
        .btn-nav-ghost {
            padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 600;
            color: var(--muted); background: none; border: 1px solid var(--border);
            cursor: pointer; font-family: inherit; transition: all 0.2s;
        }
        .btn-nav-ghost:hover { border-color: #94a3b8; color: var(--text); }
        .btn-nav-main {
            padding: 8px 20px; border-radius: 8px; font-size: 13px; font-weight: 700;
            color: white; background: var(--blue); border: none;
            cursor: pointer; font-family: inherit; transition: all 0.2s;
        }
        .btn-nav-main:hover { background: #1d4ed8; box-shadow: 0 4px 14px rgba(37,99,235,0.35); }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 100px 56px 60px;
            position: relative; overflow: hidden;
            background: #ffffff;
        }

        /* Geometric BG shapes */
        .hero-bg {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }
        .geo {
            position: absolute;
            border-radius: 24px;
            opacity: 0;
            animation: geoIn 1s ease forwards;
        }
        .geo1 {
            width: 420px; height: 420px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            top: -80px; right: -80px;
            border-radius: 60px;
            transform: rotate(20deg);
            animation-delay: 0.1s;
        }
        .geo2 {
            width: 280px; height: 280px;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            bottom: 60px; left: -60px;
            border-radius: 50px;
            transform: rotate(-15deg);
            animation-delay: 0.25s;
        }
        .geo3 {
            width: 180px; height: 180px;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            top: 35%; right: 18%;
            border-radius: 40px;
            transform: rotate(30deg);
            animation-delay: 0.4s;
        }
        .geo4 {
            width: 120px; height: 120px;
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
            top: 20%; left: 12%;
            border-radius: 28px;
            transform: rotate(-8deg);
            animation-delay: 0.55s;
        }
        .geo5 {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            bottom: 22%; right: 32%;
            border-radius: 22px;
            transform: rotate(45deg);
            animation-delay: 0.7s;
        }
        @keyframes geoIn {
            from { opacity: 0; transform: scale(0.7) rotate(inherit); }
            to   { opacity: 1; }
        }

        /* floating dots */
        .dots-grid {
            position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, #cbd5e1 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.45;
            mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black, transparent);
        }

        .hero-inner {
            position: relative; z-index: 2;
            display: flex; align-items: center; gap: 72px;
            max-width: 1100px; width: 100%;
        }
        .hero-text { flex: 1; }
        .hero-visual { flex-shrink: 0; width: 420px; }

        /* Animated chip */
        .hero-chip {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 5px 14px 5px 6px;
            border-radius: 999px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            margin-bottom: 24px;
            animation: fadeUp 0.6s 0.2s ease both;
        }
        .chip-dot {
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--blue); color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 800;
        }
        .chip-text { font-size: 12px; font-weight: 600; color: var(--blue); }

        .hero-h1 {
            font-size: 54px; font-weight: 800; line-height: 1.1;
            color: var(--text);
            margin-bottom: 18px;
            animation: fadeUp 0.6s 0.35s ease both;
        }
        .hero-h1 .accent {
            color: var(--blue);
            position: relative; display: inline-block;
        }
        .hero-h1 .accent::after {
            content: '';
            position: absolute; left: 0; bottom: 2px; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--blue), #93c5fd);
            border-radius: 2px;
            animation: lineGrow 0.8s 0.9s ease both;
            transform-origin: left;
        }
        @keyframes lineGrow {
            from { transform: scaleX(0); }
            to   { transform: scaleX(1); }
        }

        .hero-p {
            font-size: 16px; color: var(--muted); line-height: 1.75;
            margin-bottom: 36px; max-width: 480px;
            animation: fadeUp 0.6s 0.5s ease both;
        }
        .hero-btns {
            display: flex; gap: 12px; flex-wrap: wrap;
            animation: fadeUp 0.6s 0.65s ease both;
        }
        .btn-hero-main {
            padding: 14px 28px; border-radius: 10px;
            background: var(--blue); color: white;
            font-size: 14px; font-weight: 700; font-family: inherit;
            border: none; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.25s;
        }
        .btn-hero-main:hover {
            background: #1d4ed8;
            box-shadow: 0 8px 24px rgba(37,99,235,0.35);
            transform: translateY(-2px);
        }
        .btn-hero-ghost {
            padding: 14px 24px; border-radius: 10px;
            background: none; color: var(--muted);
            font-size: 14px; font-weight: 600; font-family: inherit;
            border: 1.5px solid var(--border); cursor: pointer;
            transition: all 0.25s;
        }
        .btn-hero-ghost:hover { border-color: #94a3b8; color: var(--text); transform: translateY(-1px); }

        /* ─── HERO VISUAL ─── */
        .hv-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            animation: fadeUp 0.7s 0.4s ease both;
            position: relative;
        }
        .hv-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .hv-dot { width: 10px; height: 10px; border-radius: 50%; }
        .hv-title { font-size: 12px; font-weight: 700; color: var(--muted); letter-spacing: 0.5px; text-transform: uppercase; margin-left: 4px; }
        .hv-stat-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .hv-stat {
            padding: 14px; border-radius: 12px; background: var(--surface);
            border: 1px solid var(--border);
        }
        .hv-stat-val { font-size: 22px; font-weight: 800; color: var(--text); }
        .hv-stat-lbl { font-size: 10px; color: var(--muted); margin-top: 2px; font-weight: 500; }
        .hv-stat-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 999px; margin-top: 4px; }
        .hv-bar-row { margin-bottom: 10px; }
        .hv-bar-label { display: flex; justify-content: space-between; font-size: 11px; color: var(--muted); margin-bottom: 5px; }
        .hv-bar-track { height: 7px; background: var(--surface); border-radius: 99px; overflow: hidden; }
        .hv-bar-fill { height: 100%; border-radius: 99px; animation: barFill 1.2s ease both; }
        @keyframes barFill { from { width: 0 !important; } }
        .hv-chips { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 16px; }
        .hv-chip {
            font-size: 11px; font-weight: 600; padding: 4px 11px; border-radius: 999px;
            display: flex; align-items: center; gap: 5px;
        }
        .hv-chip-dot { width: 6px; height: 6px; border-radius: 50%; }

        /* Floating notification */
        .hv-notif {
            position: absolute; bottom: -18px; right: 20px;
            background: white; border: 1.5px solid var(--border);
            border-radius: 12px; padding: 10px 14px;
            display: flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            animation: notifIn 0.5s 1.1s ease both;
        }
        @keyframes notifIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hv-notif-icon {
            width: 32px; height: 32px; border-radius: 9px;
            background: #f0fdf4; display: flex; align-items: center; justify-content: center;
            font-size: 15px;
        }
        .hv-notif-text { font-size: 12px; }
        .hv-notif-title { font-weight: 700; color: var(--text); }
        .hv-notif-sub { color: var(--muted); margin-top: 1px; }

        /* ─── STATS BAR ─── */
        .stats-bar {
            background: var(--text); color: white;
            padding: 0 56px;
            display: flex; gap: 0;
            overflow: hidden;
        }
        .sbar-item {
            flex: 1; padding: 28px 24px; text-align: center;
            border-right: 1px solid rgba(255,255,255,0.08);
            position: relative; overflow: hidden;
        }
        .sbar-item:last-child { border-right: none; }
        .sbar-item::before {
            content: '';
            position: absolute; inset: 0;
            background: var(--blue);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .sbar-item:hover::before { opacity: 0.12; }
        .sbar-num {
            font-size: 28px; font-weight: 800; position: relative;
            display: flex; align-items: baseline; justify-content: center; gap: 4px;
        }
        .sbar-sup { font-size: 14px; font-weight: 600; color: #60a5fa; }
        .sbar-label { font-size: 12px; color: #94a3b8; margin-top: 4px; position: relative; }

        /* ─── SECTION BASE ─── */
        .section { padding: 96px 56px; }
        .section-alt { background: var(--surface); }

        .section-eyebrow {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 1px;
            text-transform: uppercase; margin-bottom: 12px;
        }
        .ey-line { width: 24px; height: 2px; border-radius: 1px; }
        .section-h2 { font-size: 38px; font-weight: 800; color: var(--text); line-height: 1.2; margin-bottom: 12px; }
        .section-p { font-size: 15px; color: var(--muted); line-height: 1.75; max-width: 500px; margin-bottom: 52px; }

        /* ─── FEATURE GRID ─── */
        .feat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feat-card {
            padding: 28px;
            border-radius: 16px;
            background: white;
            border: 1.5px solid var(--border);
            transition: all 0.3s;
            position: relative; overflow: hidden;
            cursor: default;
        }
        .feat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }
        .feat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.09);
            border-color: transparent;
        }
        .feat-card:hover::before { transform: scaleX(1); }

        .fc-blue::before  { background: var(--blue); }
        .fc-green::before { background: var(--green); }
        .fc-amber::before { background: var(--amber); }
        .fc-purple::before{ background: var(--purple); }
        .fc-orange::before{ background: var(--orange); }
        .fc-teal::before  { background: var(--teal); }

        .feat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 18px;
        }
        .fi-blue   { background: var(--blue-lt);   color: var(--blue);   }
        .fi-green  { background: var(--green-lt);  color: var(--green);  }
        .fi-amber  { background: var(--amber-lt);  color: var(--amber);  }
        .fi-purple { background: var(--purple-lt); color: var(--purple); }
        .fi-orange { background: var(--orange-lt); color: var(--orange); }
        .fi-teal   { background: var(--teal-lt);   color: var(--teal);   }

        .feat-name { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .feat-desc { font-size: 13px; color: var(--muted); line-height: 1.7; }

        /* ─── FLOW STEPS ─── */
        .flow-wrap {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .flow-card {
            padding: 28px 24px;
            border-radius: 16px;
            border: 1.5px solid var(--border);
            background: white;
            position: relative;
            transition: all 0.3s;
        }
        .flow-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.07);
        }
        .flow-card::after {
            content: '→';
            position: absolute; right: -18px; top: 50%; transform: translateY(-50%);
            font-size: 18px; color: #cbd5e1; font-weight: 700;
        }
        .flow-card:nth-child(3)::after,
        .flow-card:nth-child(6)::after { display: none; }

        .flow-step-num {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; margin-bottom: 16px;
        }
        .flow-step-name { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .flow-step-desc { font-size: 12px; color: var(--muted); line-height: 1.65; }

        /* ─── MODULE ─── */
        .mod-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .mod-card {
            padding: 24px;
            border-radius: 14px;
            background: white;
            border: 1.5px solid var(--border);
            display: flex; gap: 18px; align-items: flex-start;
            transition: all 0.3s; cursor: default;
        }
        .mod-card:hover {
            transform: translateX(6px);
            border-color: #bfdbfe;
            box-shadow: -4px 0 0 0 var(--blue), 0 8px 24px rgba(0,0,0,0.06);
        }
        .mod-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .mod-body {}
        .mod-name { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 5px; }
        .mod-desc { font-size: 12px; color: var(--muted); line-height: 1.65; margin-bottom: 10px; }
        .mod-tags { display: flex; gap: 6px; flex-wrap: wrap; }
        .mod-tag {
            font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 999px;
            letter-spacing: 0.3px;
        }

        /* ─── TESTIMONIAL / ABOUT ─── */
        .about-wrap { display: flex; align-items: center; gap: 72px; }
        .about-left { flex: 1; }
        .about-right { flex-shrink: 0; width: 420px; }
        .about-feature { display: flex; gap: 16px; margin-bottom: 28px; align-items: flex-start; }
        .about-feature-icon {
            width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 17px;
        }
        .about-feature-name { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
        .about-feature-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

        /* mini dashboard preview */
        .mini-dash {
            background: white; border: 1.5px solid var(--border);
            border-radius: 18px; overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.1);
        }
        .md-topbar {
            background: var(--text); padding: 12px 18px;
            display: flex; align-items: center; gap: 10px;
        }
        .md-dot { width: 10px; height: 10px; border-radius: 50%; }
        .md-title-bar { font-size: 11px; color: rgba(255,255,255,0.4); font-weight: 600; letter-spacing: 0.5px; margin-left: auto; text-transform: uppercase; }
        .md-body { padding: 20px; }
        .md-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .md-mini-stat {
            padding: 12px; border-radius: 10px; background: var(--surface);
            border: 1px solid var(--border);
        }
        .md-mini-val { font-size: 16px; font-weight: 800; color: var(--text); }
        .md-mini-lbl { font-size: 9px; color: var(--muted); margin-top: 2px; text-transform: uppercase; font-weight: 600; letter-spacing: 0.3px; }
        .md-chart-row { display: flex; align-items: flex-end; gap: 6px; height: 60px; margin-top: 12px; }
        .md-bar {
            flex: 1; border-radius: 4px 4px 0 0;
            animation: mdBarUp 1s ease both;
        }
        @keyframes mdBarUp { from { height: 0 !important; } }
        .md-chart-label { display: flex; gap: 6px; margin-top: 6px; }
        .md-chart-label span { flex: 1; text-align: center; font-size: 9px; color: var(--muted); }

        /* ─── CTA ─── */
        .cta-section {
            padding: 100px 56px; text-align: center;
            background: var(--text); color: white; position: relative; overflow: hidden;
        }
        .cta-geo {
            position: absolute; border-radius: 50%;
            opacity: 0.07; pointer-events: none;
        }
        .cg1 { width: 500px; height: 500px; background: var(--blue); top: -200px; left: -150px; }
        .cg2 { width: 400px; height: 400px; background: #22c55e; bottom: -180px; right: -120px; }
        .cta-label {
            display: inline-block; padding: 5px 16px; border-radius: 999px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.14);
            font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
            margin-bottom: 20px; color: #93c5fd; position: relative;
        }
        .cta-h2 {
            font-size: 44px; font-weight: 800; line-height: 1.15;
            margin-bottom: 14px; position: relative;
        }
        .cta-p { font-size: 15px; color: #94a3b8; margin-bottom: 36px; position: relative; }
        .cta-btns { display: flex; gap: 12px; justify-content: center; position: relative; }
        .btn-cta-main {
            padding: 14px 32px; border-radius: 10px;
            background: var(--blue); color: white;
            font-size: 14px; font-weight: 700; font-family: inherit;
            border: none; cursor: pointer; transition: all 0.25s;
        }
        .btn-cta-main:hover { background: #1d4ed8; box-shadow: 0 8px 24px rgba(37,99,235,0.4); transform: translateY(-2px); }
        .btn-cta-ghost {
            padding: 14px 28px; border-radius: 10px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            color: #94a3b8; font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all 0.25s;
        }
        .btn-cta-ghost:hover { background: rgba(255,255,255,0.12); color: white; }

        /* ─── FOOTER ─── */
        .footer {
            background: var(--text); border-top: 1px solid rgba(255,255,255,0.08);
            padding: 28px 56px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-logo { display: flex; align-items: center; gap: 10px; }
        .footer-brand { font-size: 13px; font-weight: 800; letter-spacing: 1.5px; color: white; }
        .footer-copy { font-size: 12px; color: #475569; }
        .footer-links { display: flex; gap: 24px; }
        .footer-links a { font-size: 12px; color: #475569; text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: #94a3b8; }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0; transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.08s; }
        .reveal-delay-2 { transition-delay: 0.16s; }
        .reveal-delay-3 { transition-delay: 0.24s; }
        .reveal-delay-4 { transition-delay: 0.32s; }
        .reveal-delay-5 { transition-delay: 0.40s; }
        .reveal-delay-6 { transition-delay: 0.48s; }

        /* Floating animation for geo shapes */
        .geo1 { animation: geoIn 1s 0.1s ease forwards, floatA 7s 1.1s ease-in-out infinite; }
        .geo2 { animation: geoIn 1s 0.25s ease forwards, floatB 9s 1.25s ease-in-out infinite; }
        .geo3 { animation: geoIn 1s 0.4s ease forwards, floatA 8s 1.4s ease-in-out infinite; }
        .geo4 { animation: geoIn 1s 0.55s ease forwards, floatB 6s 1.55s ease-in-out infinite; }
        .geo5 { animation: geoIn 1s 0.7s ease forwards, floatA 10s 1.7s ease-in-out infinite; }

        @keyframes floatA {
            0%,100% { transform: translateY(0px) rotate(20deg); }
            50%      { transform: translateY(-18px) rotate(22deg); }
        }
        @keyframes floatB {
            0%,100% { transform: translateY(0px) rotate(-15deg); }
            50%      { transform: translateY(-12px) rotate(-13deg); }
        }

        /* Counter animation */
        .counter { display: inline-block; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            .navbar { padding: 0 24px; }
            .nav-links { display: none; }
            .hero { padding: 90px 24px 60px; }
            .hero-inner { flex-direction: column; gap: 40px; }
            .hero-visual { width: 100%; }
            .hero-h1 { font-size: 36px; }
            .feat-grid { grid-template-columns: 1fr 1fr; }
            .flow-wrap { grid-template-columns: 1fr; }
            .flow-card::after { display: none; }
            .mod-grid { grid-template-columns: 1fr; }
            .about-wrap { flex-direction: column; gap: 40px; }
            .about-right { width: 100%; }
            .section { padding: 64px 24px; }
            .stats-bar { flex-direction: column; padding: 0; }
            .sbar-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); }
            .cta-section { padding: 64px 24px; }
            .cta-h2 { font-size: 32px; }
            .footer { flex-direction: column; gap: 12px; text-align: center; padding: 24px; }
        }
        @media (max-width: 640px) {
            .feat-grid { grid-template-columns: 1fr; }
            .md-row { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-logo">
            <div class="nav-logomark">KP</div>
            <span class="nav-brand">KAPUAZ</span>
        </div>
        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#alur">Alur Kerja</a>
            <a href="#modul">Modul</a>
            <a href="#tentang">Tentang</a>
        </div>
        <div class="nav-right">
            <button class="btn-nav-ghost">Bantuan</button>
            <button class="btn-nav-main" onclick="window.location.href='/login'">Masuk →</button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="hero">
        <div class="hero-bg">
            <div class="dots-grid"></div>
            <div class="geo geo1"></div>
            <div class="geo geo2"></div>
            <div class="geo geo3"></div>
            <div class="geo geo4"></div>
            <div class="geo geo5"></div>
        </div>

        <div class="hero-inner">
            <div class="hero-text">
                <div class="hero-chip">
                    <div class="chip-dot">✓</div>
                    <span class="chip-text">Sistem Aktif & Terintegrasi</span>
                </div>
                <h1 class="hero-h1">
                    Kelola Keuangan Gizi<br>
                    Lebih <span class="accent">Cerdas</span> &amp; Akurat
                </h1>
                <p class="hero-p">
                    KAPUAZ menghadirkan sistem informasi keuangan gizi terintegrasi untuk institusi dan yayasan — dari pencatatan transaksi harian, penerimaan barang, hingga laporan anggaran formal yang siap cetak.
                </p>
                <div class="hero-btns">
                    <button class="btn-hero-main" onclick="window.location.href='/login'">
                        <span>Mulai Sekarang</span>
                        <span>→</span>
                    </button>
                    <button class="btn-hero-ghost" onclick="document.getElementById('fitur').scrollIntoView({behavior:'smooth'})">
                        Lihat Fitur ↓
                    </button>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hv-card">
                    <div class="hv-header">
                        <div class="hv-dot" style="background:#ef4444"></div>
                        <div class="hv-dot" style="background:#f59e0b"></div>
                        <div class="hv-dot" style="background:#22c55e"></div>
                        <span class="hv-title">Dashboard Keuangan</span>
                    </div>

                    <div class="hv-stat-row">
                        <div class="hv-stat">
                            <div class="hv-stat-val">Rp 42,5jt</div>
                            <div class="hv-stat-lbl">Total Anggaran</div>
                            <div class="hv-stat-badge" style="background:#f0fdf4;color:#16a34a">↑ 8.3%</div>
                        </div>
                        <div class="hv-stat">
                            <div class="hv-stat-val">Rp 31,2jt</div>
                            <div class="hv-stat-lbl">Realisasi</div>
                            <div class="hv-stat-badge" style="background:#eff6ff;color:#2563eb">73.4%</div>
                        </div>
                    </div>

                    <div class="hv-bar-row">
                        <div class="hv-bar-label"><span>Dapur A — Utama</span><span style="font-weight:700;color:#0f172a">82%</span></div>
                        <div class="hv-bar-track"><div class="hv-bar-fill" style="width:82%;background:#2563eb;animation-delay:0.8s"></div></div>
                    </div>
                    <div class="hv-bar-row">
                        <div class="hv-bar-label"><span>Dapur B — Cabang</span><span style="font-weight:700;color:#0f172a">65%</span></div>
                        <div class="hv-bar-track"><div class="hv-bar-fill" style="width:65%;background:#16a34a;animation-delay:1s"></div></div>
                    </div>
                    <div class="hv-bar-row">
                        <div class="hv-bar-label"><span>Dapur C — Unit 3</span><span style="font-weight:700;color:#0f172a">48%</span></div>
                        <div class="hv-bar-track"><div class="hv-bar-fill" style="width:48%;background:#d97706;animation-delay:1.2s"></div></div>
                    </div>

                    <div class="hv-chips">
                        <div class="hv-chip" style="background:#eff6ff;color:#2563eb"><div class="hv-chip-dot" style="background:#2563eb"></div>3 Dapur Aktif</div>
                        <div class="hv-chip" style="background:#f0fdf4;color:#16a34a"><div class="hv-chip-dot" style="background:#16a34a"></div>Surplus</div>
                        <div class="hv-chip" style="background:#fff7ed;color:#ea580c"><div class="hv-chip-dot" style="background:#ea580c"></div>12 Transaksi Hari Ini</div>
                    </div>

                    <div class="hv-notif">
                        <div class="hv-notif-icon">✅</div>
                        <div class="hv-notif-text">
                            <div class="hv-notif-title">Laporan Disetujui</div>
                            <div class="hv-notif-sub" style="font-size:11px;color:#64748b">Penerimaan barang • 2 menit lalu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS BAR -->
    <div class="stats-bar">
        <div class="sbar-item">
            <div class="sbar-num"><span class="counter" data-target="100">0</span><span class="sbar-sup">%</span></div>
            <div class="sbar-label">Laporan Akurat</div>
        </div>
        <div class="sbar-item">
            <div class="sbar-num" style="font-size:20px;font-weight:700">Real-time</div>
            <div class="sbar-label">Data Keuangan Live</div>
        </div>
        <div class="sbar-item">
            <div class="sbar-num"><span class="sbar-sup" style="font-size:18px">∞</span>&nbsp;Multi</div>
            <div class="sbar-label">Dapur Terpusat</div>
        </div>
        <div class="sbar-item">
            <div class="sbar-num"><span class="counter" data-target="3">0</span><span class="sbar-sup">×</span></div>
            <div class="sbar-label">Tahap Approval</div>
        </div>
    </div>

    <!-- FITUR -->
    <section class="section" id="fitur">
        <div class="section-eyebrow" style="color:var(--blue)">
            <div class="ey-line" style="background:var(--blue)"></div>
            Fitur Unggulan
        </div>
        <h2 class="section-h2">Semua yang Dibutuhkan<br>dalam Satu Sistem</h2>
        <p class="section-p">Dari pencatatan harian hingga laporan formal siap tanda tangan — KAPUAZ menyederhanakan seluruh alur operasional keuangan gizi.</p>

        <div class="feat-grid">
            <div class="feat-card fc-blue reveal reveal-delay-1">
                <div class="feat-icon fi-blue">🏢</div>
                <div class="feat-name">Multi-Dapur Terpusat</div>
                <div class="feat-desc">Kelola beberapa unit dapur dari satu akun. Super admin memantau seluruh aktivitas secara real-time dari satu dashboard terpusat.</div>
            </div>
            <div class="feat-card fc-green reveal reveal-delay-2">
                <div class="feat-icon fi-green">📈</div>
                <div class="feat-name">Laporan Keuangan Live</div>
                <div class="feat-desc">Data transaksi, jurnal, dan realisasi anggaran tersaji langsung. Tidak perlu menunggu akhir periode untuk melihat kondisi keuangan.</div>
            </div>
            <div class="feat-card fc-amber reveal reveal-delay-3">
                <div class="feat-icon fi-amber">📦</div>
                <div class="feat-name">Penerimaan Barang Digital</div>
                <div class="feat-desc">Catat penerimaan barang dengan foto bukti, status persetujuan tiga tahap, dan preview lightbox — paperless dan tertelusur.</div>
            </div>
            <div class="feat-card fc-purple reveal reveal-delay-4">
                <div class="feat-icon fi-purple">📋</div>
                <div class="feat-name">Laporan LP Anggaran</div>
                <div class="feat-desc">Cetak laporan anggaran formal berformat institusional dengan indikator surplus/defisit dan filter periode yang fleksibel.</div>
            </div>
            <div class="feat-card fc-orange reveal reveal-delay-5">
                <div class="feat-icon fi-orange">🔐</div>
                <div class="feat-name">Manajemen Role & Akses</div>
                <div class="feat-desc">Sistem hak akses berbasis peran — Super Admin, Admin Dapur, Anggota — memastikan data aman dan wewenang terstruktur.</div>
            </div>
            <div class="feat-card fc-teal reveal reveal-delay-6">
                <div class="feat-icon fi-teal">🖨️</div>
                <div class="feat-name">Dokumen Cetak Formal</div>
                <div class="feat-desc">Hasilkan dokumen resmi bergaya yayasan lengkap dengan blok tanda tangan, kop, dan format sesuai standar institusi.</div>
            </div>
        </div>
    </section>

    <!-- ALUR KERJA -->
    <section class="section section-alt" id="alur">
        <div class="section-eyebrow" style="color:var(--green)">
            <div class="ey-line" style="background:var(--green)"></div>
            Alur Kerja
        </div>
        <h2 class="section-h2">Dari Input hingga Laporan<br>Dalam Hitungan Menit</h2>
        <p class="section-p">Proses keuangan yang biasanya memakan waktu kini dapat diselesaikan secara efisien dengan alur kerja terstruktur KAPUAZ.</p>

        <div class="flow-wrap">
            <div class="flow-card reveal reveal-delay-1">
                <div class="flow-step-num" style="background:var(--blue-lt);color:var(--blue)">1</div>
                <div class="flow-step-name">Login & Pilih Dapur</div>
                <div class="flow-step-desc">Masuk dengan akun terdaftar, lalu pilih unit dapur yang akan dikelola pada sesi ini.</div>
            </div>
            <div class="flow-card reveal reveal-delay-2">
                <div class="flow-step-num" style="background:var(--amber-lt);color:var(--amber)">2</div>
                <div class="flow-step-name">Input Transaksi Harian</div>
                <div class="flow-step-desc">Catat penerimaan barang, pengeluaran operasional, dan jurnal keuangan harian secara digital.</div>
            </div>
            <div class="flow-card reveal reveal-delay-3">
                <div class="flow-step-num" style="background:var(--orange-lt);color:var(--orange)">3</div>
                <div class="flow-step-name">Proses Persetujuan</div>
                <div class="flow-step-desc">Dokumen melewati tiga tahap approval: diajukan → diproses → disetujui oleh pejabat berwenang.</div>
            </div>
            <div class="flow-card reveal reveal-delay-1">
                <div class="flow-step-num" style="background:var(--purple-lt);color:var(--purple)">4</div>
                <div class="flow-step-name">Monitor Dashboard</div>
                <div class="flow-step-desc">Pantau ringkasan anggaran, realisasi, grafik tren, dan status keuangan dari dashboard interaktif.</div>
            </div>
            <div class="flow-card reveal reveal-delay-2">
                <div class="flow-step-num" style="background:var(--teal-lt);color:var(--teal)">5</div>
                <div class="flow-step-name">Cetak Laporan Formal</div>
                <div class="flow-step-desc">Ekspor laporan LP Anggaran resmi siap tanda tangan sesuai format dan kebutuhan institusi.</div>
            </div>
            <div class="flow-card reveal reveal-delay-3">
                <div class="flow-step-num" style="background:var(--green-lt);color:var(--green)">6</div>
                <div class="flow-step-name">Audit & Arsip Digital</div>
                <div class="flow-step-desc">Semua data tersimpan terstruktur, dapat ditelusuri kapan saja untuk kebutuhan audit dan evaluasi.</div>
            </div>
        </div>
    </section>

    <!-- MODUL -->
    <section class="section" id="modul">
        <div class="section-eyebrow" style="color:var(--amber)">
            <div class="ey-line" style="background:var(--amber)"></div>
            Modul Sistem
        </div>
        <h2 class="section-h2">Modul Lengkap untuk<br>Operasional Dapur Gizi</h2>
        <p class="section-p">Setiap modul dirancang khusus untuk kebutuhan manajemen keuangan institusional berbasis yayasan.</p>

        <div class="mod-grid">
            <div class="mod-card reveal reveal-delay-1">
                <div class="mod-icon fi-blue">🏠</div>
                <div class="mod-body">
                    <div class="mod-name">Manajemen Dapur</div>
                    <div class="mod-desc">Konfigurasi profil lembaga, alamat operasional, dan data anggota untuk setiap unit dapur secara independen.</div>
                    <div class="mod-tags">
                        <span class="mod-tag" style="background:var(--blue-lt);color:var(--blue)">Multi-Unit</span>
                        <span class="mod-tag" style="background:var(--blue-lt);color:var(--blue)">Profil Lembaga</span>
                    </div>
                </div>
            </div>
            <div class="mod-card reveal reveal-delay-2">
                <div class="mod-icon fi-green">💸</div>
                <div class="mod-body">
                    <div class="mod-name">Transaksi & Jurnal</div>
                    <div class="mod-desc">Pencatatan transaksi masuk/keluar dan jurnal keuangan harian yang otomatis terekap ke laporan periode.</div>
                    <div class="mod-tags">
                        <span class="mod-tag" style="background:var(--green-lt);color:var(--green)">Debit/Kredit</span>
                        <span class="mod-tag" style="background:var(--green-lt);color:var(--green)">Auto-Rekap</span>
                    </div>
                </div>
            </div>
            <div class="mod-card reveal reveal-delay-3">
                <div class="mod-icon fi-amber">📥</div>
                <div class="mod-body">
                    <div class="mod-name">Penerimaan Barang</div>
                    <div class="mod-desc">Input penerimaan dengan upload foto bukti, status persetujuan tiga tahap, dan fitur lightbox preview dokumen.</div>
                    <div class="mod-tags">
                        <span class="mod-tag" style="background:var(--amber-lt);color:var(--amber)">Upload Foto</span>
                        <span class="mod-tag" style="background:var(--amber-lt);color:var(--amber)">3 Tahap Approval</span>
                    </div>
                </div>
            </div>
            <div class="mod-card reveal reveal-delay-4">
                <div class="mod-icon fi-purple">📊</div>
                <div class="mod-body">
                    <div class="mod-name">Laporan LP Anggaran</div>
                    <div class="mod-desc">Laporan realisasi anggaran dengan indikator surplus/defisit, filter periode, dan format cetak formal yayasan.</div>
                    <div class="mod-tags">
                        <span class="mod-tag" style="background:var(--purple-lt);color:var(--purple)">Surplus/Defisit</span>
                        <span class="mod-tag" style="background:var(--purple-lt);color:var(--purple)">Cetak Formal</span>
                    </div>
                </div>
            </div>
            <div class="mod-card reveal reveal-delay-5">
                <div class="mod-icon fi-orange">👥</div>
                <div class="mod-body">
                    <div class="mod-name">Manajemen Anggota</div>
                    <div class="mod-desc">Kelola data pengguna beserta peran dan hak akses — Super Admin, Admin Dapur, hingga Anggota biasa.</div>
                    <div class="mod-tags">
                        <span class="mod-tag" style="background:var(--orange-lt);color:var(--orange)">Role-based</span>
                        <span class="mod-tag" style="background:var(--orange-lt);color:var(--orange)">Multi-User</span>
                    </div>
                </div>
            </div>
            <div class="mod-card reveal reveal-delay-6">
                <div class="mod-icon fi-teal">🖥️</div>
                <div class="mod-body">
                    <div class="mod-name">Dashboard Super Admin</div>
                    <div class="mod-desc">Monitoring terpusat seluruh dapur dengan grafik Chart.js, badge status dinamis, dan format nominal rupiah.</div>
                    <div class="mod-tags">
                        <span class="mod-tag" style="background:var(--teal-lt);color:var(--teal)">Chart.js</span>
                        <span class="mod-tag" style="background:var(--teal-lt);color:var(--teal)">Monitoring Global</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG / ABOUT -->
    <section class="section section-alt" id="tentang">
        <div class="about-wrap">
            <div class="about-left reveal">
                <div class="section-eyebrow" style="color:var(--purple)">
                    <div class="ey-line" style="background:var(--purple)"></div>
                    Mengapa KAPUAZ?
                </div>
                <h2 class="section-h2" style="margin-bottom:32px">Dibangun untuk Kebutuhan<br>Institusi Gizi Modern</h2>

                <div class="about-feature">
                    <div class="about-feature-icon fi-blue">🏛️</div>
                    <div>
                        <div class="about-feature-name">Standar Yayasan & Institusi</div>
                        <div class="about-feature-desc">Format laporan, blok tanda tangan, dan alur persetujuan dirancang mengikuti standar dokumen resmi yayasan di Indonesia.</div>
                    </div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon fi-green">🔒</div>
                    <div>
                        <div class="about-feature-name">Keamanan Berbasis Peran</div>
                        <div class="about-feature-desc">Setiap pengguna hanya mengakses data sesuai wewenangnya. Tidak ada kebocoran data lintas unit dapur.</div>
                    </div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon fi-amber">⚡</div>
                    <div>
                        <div class="about-feature-name">Efisiensi Operasional</div>
                        <div class="about-feature-desc">Proses yang biasanya memerlukan berjam-jam kini diselesaikan dalam menit. Dari input hingga laporan tercetak.</div>
                    </div>
                </div>
            </div>

            <div class="about-right reveal reveal-delay-2">
                <div class="mini-dash">
                    <div class="md-topbar">
                        <div class="md-dot" style="background:#ef4444"></div>
                        <div class="md-dot" style="background:#f59e0b;margin-left:5px"></div>
                        <div class="md-dot" style="background:#22c55e;margin-left:5px"></div>
                        <span class="md-title-bar">Superadmin Dashboard</span>
                    </div>
                    <div class="md-body">
                        <div class="md-row">
                            <div class="md-mini-stat">
                                <div class="md-mini-val" style="color:var(--blue)">3</div>
                                <div class="md-mini-lbl">Dapur Aktif</div>
                            </div>
                            <div class="md-mini-stat">
                                <div class="md-mini-val" style="color:var(--green)">47</div>
                                <div class="md-mini-lbl">Transaksi</div>
                            </div>
                            <div class="md-mini-stat">
                                <div class="md-mini-val" style="color:var(--amber)">12</div>
                                <div class="md-mini-lbl">Pending</div>
                            </div>
                        </div>
                        <div style="font-size:11px;font-weight:700;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px">Realisasi per Bulan</div>
                        <div class="md-chart-row">
                            <div class="md-bar" style="height:35%;background:#dbeafe;animation-delay:0.8s"></div>
                            <div class="md-bar" style="height:50%;background:#dbeafe;animation-delay:0.9s"></div>
                            <div class="md-bar" style="height:65%;background:#bfdbfe;animation-delay:1s"></div>
                            <div class="md-bar" style="height:55%;background:#bfdbfe;animation-delay:1.1s"></div>
                            <div class="md-bar" style="height:80%;background:#93c5fd;animation-delay:1.2s"></div>
                            <div class="md-bar" style="height:90%;background:#60a5fa;animation-delay:1.3s"></div>
                            <div class="md-bar" style="height:75%;background:#3b82f6;animation-delay:1.4s"></div>
                        </div>
                        <div class="md-chart-label">
                            <span>Jun</span><span>Jul</span><span>Ags</span><span>Sep</span><span>Okt</span><span>Nov</span><span>Des</span>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:14px;flex-wrap:wrap">
                            <span style="font-size:10px;padding:3px 10px;border-radius:999px;background:#f0fdf4;color:#16a34a;font-weight:700">✓ Surplus Rp 11,3jt</span>
                            <span style="font-size:10px;padding:3px 10px;border-radius:999px;background:#eff6ff;color:#2563eb;font-weight:700">↑ Naik 8.3%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-geo cg1"></div>
        <div class="cta-geo cg2"></div>
        <div class="cta-label">Siap Memulai?</div>
        <h2 class="cta-h2">Kelola Keuangan Dapur Gizi<br>Lebih Efisien Mulai Hari Ini</h2>
        <p class="cta-p">Masuk ke sistem KAPUAZ dan kendalikan seluruh operasional keuangan dapur gizi institusi Anda.</p>
        <div class="cta-btns">
            <button class="btn-cta-main" onclick="window.location.href='/login'">Masuk ke Sistem →</button>
            <button class="btn-cta-ghost">Hubungi Administrator</button>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-logo">
            <div class="nav-logomark">KP</div>
            <span class="footer-brand">KAPUAZ</span>
        </div>
        <div class="footer-copy">© {{ date('Y') }} KAPUAZ — Sistem Keuangan Gizi Terintegrasi</div>
        <div class="footer-links">
            <a href="#">Panduan</a>
            <a href="#">Kebijakan</a>
            <a href="#">Kontak</a>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Intersection Observer for reveal animations
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(el => observer.observe(el));

        // Counter animation
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    const el = e.target;
                    const target = parseInt(el.dataset.target);
                    let current = 0;
                    const step = target / 40;
                    const timer = setInterval(() => {
                        current = Math.min(current + step, target);
                        el.textContent = Math.round(current);
                        if (current >= target) clearInterval(timer);
                    }, 30);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(el => counterObserver.observe(el));

        // Smooth scroll for nav links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>
</html>