<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ImmoApp') }} — Gestion Immobilière Simplifiée</title>
    <meta name="description" content="ImmoApp est la solution complète pour propriétaires et gestionnaires immobiliers au Sénégal. Automatisez la gestion des loyers, locataires, incidents et maintenance.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --ink:     #0D1117;
            --sand:    #F5F0E8;
            --terra:   #C4622D;
            --terra-2: #E8845A;
            --gold:    #D4A853;
            --gold-lt: #F2D99B;
            --sage:    #4A7C59;
            --stone:   #8C7B6B;
            --white:   #FFFFFF;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
        }

        /* ── TYPOGRAPHY ── */
        .display { font-family: 'Cormorant Garamond', serif; }

        /* ── UTILS ── */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--terra);
            margin-bottom: 16px;
        }
        .section-label::before {
            content: '';
            display: block;
            width: 24px; height: 2px;
            background: var(--terra);
            border-radius: 2px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--terra);
            color: var(--white);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 14px 28px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.25s;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #A84E22;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(196,98,45,0.35);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: var(--ink);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            padding: 13px 28px;
            border-radius: 4px;
            text-decoration: none;
            border: 1.5px solid rgba(13,17,23,0.2);
            transition: all 0.25s;
        }
        .btn-outline:hover {
            border-color: var(--ink);
            background: var(--ink);
            color: var(--white);
        }

        /* ══════════════════════════════════
           NAVBAR
        ══════════════════════════════════ */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(13,17,23,0.06);
            transition: box-shadow 0.3s;
        }
        #navbar.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,0.08); }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nav-logo-mark {
            width: 40px; height: 40px;
            background: var(--ink);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-logo-mark svg { color: var(--gold); }
        .nav-logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }
        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--stone);
            text-decoration: none;
            transition: color 0.2s;
            white-space: nowrap;
        }
        .nav-links a:hover { color: var(--ink); }

        .nav-actions { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }

        .nav-login {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            text-decoration: none;
            padding: 8px 16px;
            transition: color 0.2s;
        }
        .nav-login:hover { color: var(--terra); }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-inner { padding: 0 20px; }
        }

        /* ══════════════════════════════════
           HERO
        ══════════════════════════════════ */
        .hero {
            min-height: 100vh;
            background: var(--sand);
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            overflow: hidden;
        }

        /* Texture overlay */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230D1117' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 120px 64px 80px;
            position: relative;
            z-index: 2;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(196,98,45,0.1);
            border: 1px solid rgba(196,98,45,0.2);
            color: var(--terra);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 2px;
            margin-bottom: 32px;
            width: fit-content;
        }
        .hero-eyebrow::before {
            content: '';
            width: 6px; height: 6px;
            background: var(--terra);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(48px, 5.5vw, 80px);
            font-weight: 600;
            line-height: 1.08;
            color: var(--ink);
            margin-bottom: 24px;
        }
        .hero-title em {
            font-style: normal;
            color: var(--terra);
        }

        .hero-sub {
            font-size: 17px;
            font-weight: 300;
            color: var(--stone);
            line-height: 1.7;
            max-width: 440px;
            margin-bottom: 40px;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 52px;
        }

        .hero-trust {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--stone);
        }
        .trust-item svg { color: var(--sage); flex-shrink: 0; }

        .hero-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 64px 80px 32px;
            position: relative;
            z-index: 2;
        }

        /* Dashboard mockup */
        .mockup-wrap {
            position: relative;
            width: 100%;
            max-width: 460px;
        }

        .mockup-card {
            background: var(--ink);
            border-radius: 16px;
            padding: 28px;
            color: var(--white);
            box-shadow: 0 40px 80px rgba(13,17,23,0.25), 0 0 0 1px rgba(255,255,255,0.05);
            transform: perspective(1000px) rotateY(-4deg) rotateX(2deg);
            transition: transform 0.5s ease;
        }
        .mockup-card:hover {
            transform: perspective(1000px) rotateY(-1deg) rotateX(0deg);
        }

        .mockup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .mockup-dots { display: flex; gap: 6px; }
        .mockup-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
        }
        .d1 { background: #FF5F57; }
        .d2 { background: #FFBD2E; }
        .d3 { background: #28C840; }

        .mockup-title { font-size: 12px; color: rgba(255,255,255,0.4); letter-spacing: 1px; }

        .mockup-property {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 16px;
        }
        .mockup-prop-name { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.9); margin-bottom: 4px; }
        .mockup-prop-loc { font-size: 11px; color: rgba(255,255,255,0.4); }

        .mockup-revenue {
            background: var(--terra);
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 16px;
        }
        .mockup-rev-label { font-size: 11px; color: rgba(255,255,255,0.7); margin-bottom: 6px; letter-spacing: 1px; text-transform: uppercase; }
        .mockup-rev-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--white);
        }
        .mockup-rev-sub { font-size: 11px; color: rgba(255,255,255,0.7); margin-top: 4px; }

        .mockup-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
        }
        .mockup-stat {
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }
        .mockup-stat-val { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 700; color: var(--gold); }
        .mockup-stat-lbl { font-size: 10px; color: rgba(255,255,255,0.4); margin-top: 2px; }

        .mockup-bar-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .mockup-bar-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mockup-bar-name { font-size: 11px; color: rgba(255,255,255,0.5); width: 50px; flex-shrink: 0; }
        .mockup-bar-track {
            flex: 1;
            height: 5px;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            overflow: hidden;
        }
        .mockup-bar-fill {
            height: 100%;
            border-radius: 10px;
            background: var(--gold);
        }
        .mockup-bar-pct { font-size: 10px; color: rgba(255,255,255,0.4); width: 28px; text-align: right; flex-shrink: 0; }

        /* Floating cards */
        .float-card {
            position: absolute;
            background: var(--white);
            border-radius: 10px;
            padding: 12px 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }
        .float-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .float-label { color: #8C8C8C; font-size: 10px; }
        .float-value { font-weight: 700; color: var(--ink); font-size: 13px; }

        .fc-payment {
            top: 40px; left: -40px;
            animation: floatUp 3s ease-in-out infinite;
        }
        .fc-alert {
            bottom: 60px; right: -30px;
            animation: floatUp 3s ease-in-out infinite 1.5s;
        }

        @keyframes floatUp {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; }
            .hero-right { display: none; }
            .hero-left { padding: 120px 24px 60px; }
        }

        /* ══════════════════════════════════
           STATS BAND
        ══════════════════════════════════ */
        .stats-band {
            background: var(--ink);
            padding: 56px 32px;
        }
        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }
        .stat-item { text-align: center; }
        .stat-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 52px;
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
            margin-bottom: 8px;
        }
        .stat-label { font-size: 13px; color: rgba(255,255,255,0.5); letter-spacing: 1px; }

        @media (max-width: 640px) {
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
        }

        /* ══════════════════════════════════
           PROBLEM/SOLUTION
        ══════════════════════════════════ */
        .ps-section {
            padding: 100px 32px;
            background: var(--white);
        }
        .ps-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: start;
        }

        .ps-col-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.2;
            margin-bottom: 32px;
        }

        .ps-list { list-style: none; display: flex; flex-direction: column; gap: 16px; }
        .ps-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        .ps-icon {
            width: 28px; height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .ps-icon.bad { background: #FEF2F2; }
        .ps-icon.good { background: #F0FDF4; }

        .ps-item-title { font-size: 14px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
        .ps-item-desc { font-size: 13px; color: var(--stone); line-height: 1.5; }

        .ps-solution {
            background: var(--sand);
            border-radius: 16px;
            padding: 40px;
            border: 1px solid rgba(13,17,23,0.06);
        }

        @media (max-width: 768px) {
            .ps-inner { grid-template-columns: 1fr; gap: 40px; }
        }

        /* ══════════════════════════════════
           HOW IT WORKS
        ══════════════════════════════════ */
        .how-section {
            padding: 100px 32px;
            background: var(--sand);
        }
        .section-center { text-align: center; max-width: 600px; margin: 0 auto 64px; }
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(36px, 4vw, 52px);
            font-weight: 600;
            color: var(--ink);
            line-height: 1.1;
            margin-bottom: 16px;
        }
        .section-sub { font-size: 16px; color: var(--stone); line-height: 1.6; }

        .steps-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(13,17,23,0.08);
            border-radius: 16px;
            overflow: hidden;
        }
        .step-card {
            background: var(--white);
            padding: 40px 32px;
            position: relative;
            transition: background 0.2s;
        }
        .step-card:hover { background: var(--sand); }

        .step-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 72px;
            font-weight: 700;
            color: rgba(13,17,23,0.06);
            line-height: 1;
            position: absolute;
            top: 20px; right: 24px;
        }

        .step-icon-wrap {
            width: 48px; height: 48px;
            background: var(--terra);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .step-icon-wrap svg { color: var(--white); }

        .step-title { font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
        .step-desc { font-size: 13px; color: var(--stone); line-height: 1.6; }

        @media (max-width: 768px) {
            .steps-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .steps-grid { grid-template-columns: 1fr; }
        }

        /* ══════════════════════════════════
           FEATURES
        ══════════════════════════════════ */
        .feat-section {
            padding: 100px 32px;
            background: var(--white);
        }
        .feat-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feat-card {
            background: var(--sand);
            border-radius: 16px;
            padding: 36px;
            border: 1px solid rgba(13,17,23,0.06);
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }
        .feat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            border: 1.5px solid var(--terra);
            opacity: 0;
            transition: opacity 0.25s;
        }
        .feat-card:hover::after { opacity: 1; }
        .feat-card:hover { background: #FAF5ED; transform: translateY(-2px); }

        .feat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            background: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .feat-icon svg { color: var(--gold); }

        .feat-title { font-size: 17px; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
        .feat-desc { font-size: 13px; color: var(--stone); line-height: 1.6; margin-bottom: 20px; }
        .feat-list { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .feat-list li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
            color: var(--stone);
        }
        .feat-list li::before {
            content: '—';
            color: var(--terra);
            flex-shrink: 0;
            font-weight: 700;
        }

        @media (max-width: 900px) { .feat-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 580px) { .feat-grid { grid-template-columns: 1fr; } }

        /* ══════════════════════════════════
           ADVANTAGES
        ══════════════════════════════════ */
        .adv-section {
            padding: 100px 32px;
            background: var(--ink);
        }
        .adv-section .section-title { color: var(--white); }
        .adv-section .section-sub { color: rgba(255,255,255,0.5); }
        .adv-section .section-label { color: var(--gold); }
        .adv-section .section-label::before { background: var(--gold); }

        .adv-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: rgba(255,255,255,0.06);
        }
        .adv-card {
            background: var(--ink);
            padding: 40px 36px;
            transition: background 0.2s;
        }
        .adv-card:hover { background: #161D27; }
        .adv-icon {
            width: 44px; height: 44px;
            background: rgba(212,168,83,0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .adv-icon svg { color: var(--gold); }
        .adv-title { font-size: 16px; font-weight: 700; color: var(--white); margin-bottom: 8px; }
        .adv-desc { font-size: 13px; color: rgba(255,255,255,0.45); line-height: 1.65; }

        @media (max-width: 768px) { .adv-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .adv-grid { grid-template-columns: 1fr; } }

        /* ══════════════════════════════════
           PRICING
        ══════════════════════════════════ */
        .price-section {
            padding: 100px 32px;
            background: var(--sand);
        }
        .price-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            align-items: start;
        }
        .price-card {
            background: var(--white);
            border-radius: 16px;
            padding: 32px 28px;
            border: 1.5px solid transparent;
            transition: all 0.25s;
        }
        .price-card:hover { border-color: rgba(13,17,23,0.15); transform: translateY(-3px); }
        .price-card.featured {
            background: var(--ink);
            border-color: var(--ink);
            transform: translateY(-8px);
            box-shadow: 0 32px 64px rgba(13,17,23,0.2);
        }
        .price-card.featured:hover { transform: translateY(-12px); }

        .price-badge {
            display: inline-block;
            background: var(--gold);
            color: var(--ink);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 2px;
            margin-bottom: 20px;
        }

        .price-plan-name { font-size: 13px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; }
        .price-plan-name.light { color: rgba(255,255,255,0.6); }
        .price-plan-name.dark { color: var(--stone); }

        .price-amount {
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }
        .price-amount.light { color: var(--white); }
        .price-amount.dark { color: var(--ink); }
        .price-amount.big { font-size: 30px; padding-top: 10px; }

        .price-period { font-size: 12px; margin-bottom: 4px; }
        .price-period.light { color: rgba(255,255,255,0.4); }
        .price-period.dark { color: var(--stone); }

        .price-desc { font-size: 13px; margin-bottom: 24px; padding-bottom: 24px; }
        .price-desc.light { color: rgba(255,255,255,0.5); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .price-desc.dark { color: var(--stone); border-bottom: 1px solid rgba(13,17,23,0.08); }

        .price-features { list-style: none; display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
        .price-features li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
        }
        .price-features li.light { color: rgba(255,255,255,0.7); }
        .price-features li.dark { color: #555; }

        .pf-check {
            width: 16px; height: 16px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .pf-check.gold { color: var(--gold); }
        .pf-check.terra { color: var(--terra); }

        .price-btn {
            display: block;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            padding: 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .price-btn.light { background: var(--terra); color: var(--white); }
        .price-btn.light:hover { background: #A84E22; }
        .price-btn.dark { background: var(--sand); color: var(--ink); border: 1.5px solid rgba(13,17,23,0.12); }
        .price-btn.dark:hover { background: var(--ink); color: var(--white); border-color: var(--ink); }
        .price-btn.dark-inv { background: var(--white); color: var(--ink); }
        .price-btn.dark-inv:hover { background: rgba(255,255,255,0.85); }

        @media (max-width: 900px) { .price-grid { grid-template-columns: 1fr 1fr; } .price-card.featured { transform: none; } }
        @media (max-width: 520px) { .price-grid { grid-template-columns: 1fr; } }

        /* ══════════════════════════════════
           FAQ
        ══════════════════════════════════ */
        .faq-section {
            padding: 100px 32px;
            background: var(--white);
        }
        .faq-inner { max-width: 720px; margin: 0 auto; }

        .faq-item {
            border-bottom: 1px solid rgba(13,17,23,0.08);
        }
        .faq-item summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            padding: 22px 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--ink);
            list-style: none;
            user-select: none;
            gap: 16px;
        }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-chevron {
            width: 20px; height: 20px;
            flex-shrink: 0;
            color: var(--stone);
            transition: transform 0.25s;
        }
        .faq-item[open] .faq-chevron { transform: rotate(180deg); }
        .faq-item[open] summary { color: var(--terra); }

        .faq-body {
            font-size: 14px;
            color: var(--stone);
            line-height: 1.7;
            padding-bottom: 20px;
        }

        /* ══════════════════════════════════
           PAYMENTS
        ══════════════════════════════════ */
        .pay-section {
            padding: 80px 32px;
            background: var(--sand);
            border-top: 1px solid rgba(13,17,23,0.06);
        }
        .pay-inner { max-width: 1200px; margin: 0 auto; }
        .pay-title { font-family: 'Cormorant Garamond', serif; font-size: 32px; font-weight: 600; color: var(--ink); margin-bottom: 8px; }
        .pay-sub { font-size: 14px; color: var(--stone); margin-bottom: 40px; }
        .pay-cards { display: flex; gap: 16px; flex-wrap: wrap; }

        .pay-card {
            flex: 1;
            min-width: 160px;
            background: var(--white);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(13,17,23,0.06);
            transition: all 0.2s;
        }
        .pay-card:hover { border-color: var(--terra); transform: translateY(-2px); }
        .pay-card-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pay-card-name { font-size: 14px; font-weight: 700; color: var(--ink); }

        /* ══════════════════════════════════
           CTA
        ══════════════════════════════════ */
        .cta-section {
            padding: 100px 32px;
            background: var(--terra);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .cta-inner { max-width: 600px; margin: 0 auto; position: relative; z-index: 1; }
        .cta-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(36px, 5vw, 60px);
            font-weight: 600;
            color: var(--white);
            line-height: 1.1;
            margin-bottom: 16px;
        }
        .cta-sub { font-size: 16px; color: rgba(255,255,255,0.75); margin-bottom: 36px; line-height: 1.6; }
        .cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-cta-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--terra);
            font-size: 14px;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-cta-white:hover { background: var(--sand); transform: translateY(-1px); }
        .btn-cta-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            font-weight: 600;
            padding: 13px 28px;
            border-radius: 4px;
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.3);
            transition: all 0.2s;
        }
        .btn-cta-ghost:hover { border-color: rgba(255,255,255,0.7); color: var(--white); }

        /* ══════════════════════════════════
           FOOTER
        ══════════════════════════════════ */
        footer {
            background: var(--ink);
            color: rgba(255,255,255,0.5);
            padding: 64px 32px 32px;
        }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }
        .footer-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; text-decoration: none; }
        .footer-logo-mark {
            width: 36px; height: 36px;
            background: var(--terra);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-logo-text { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 700; color: var(--white); }
        .footer-about { font-size: 13px; line-height: 1.7; max-width: 280px; margin-bottom: 20px; }
        .footer-socials { display: flex; gap: 8px; }
        .social-btn {
            width: 34px; height: 34px;
            background: rgba(255,255,255,0.06);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.5);
            transition: all 0.2s;
            text-decoration: none;
        }
        .social-btn:hover { background: var(--terra); color: var(--white); }

        .footer-col-title { font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.7); margin-bottom: 16px; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-links a { font-size: 13px; color: rgba(255,255,255,0.45); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: rgba(255,255,255,0.9); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; }
        }

        /* ══════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════ */
        .fade-in {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

<!-- ════════ NAVBAR ════════ -->
<nav id="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">
            <div class="nav-logo-mark">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/>
                </svg>
            </div>
            <span class="nav-logo-text">ImmoApp</span>
        </a>

        <ul class="nav-links" role="navigation" aria-label="Menu principal">
            <li><a href="#fonctionnalites">Fonctionnalités</a></li>
            <li><a href="#comment-ca-marche">Comment ça marche</a></li>
            <li><a href="#tarifs">Tarifs</a></li>
            <li><a href="#avantages">Avantages</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>

        <div class="nav-actions">
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="nav-login">Connexion</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<!-- ════════ HERO ════════ -->
<section class="hero">
    <div class="hero-left fade-in">
        <div class="hero-eyebrow">Plateforme SaaS — Sénégal</div>

        <h1 class="hero-title display">
            Gérez vos<br>
            <em>immeubles</em><br>
            avec intelligence
        </h1>

        <p class="hero-sub">
            La solution complète pour propriétaires et gestionnaires immobiliers. Automatisez loyers, locataires, incidents et maintenance — tout en un seul endroit.
        </p>

        <div class="hero-cta">
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary">
                    Démarrer gratuitement
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endif
            <a href="#comment-ca-marche" class="btn-outline">Voir comment ça marche</a>
        </div>

        <div class="hero-trust">
            <div class="trust-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Gratuit pour commencer
            </div>
            <div class="trust-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Sans engagement
            </div>
            <div class="trust-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                100% sécurisé
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="mockup-wrap fade-in" style="transition-delay:0.2s">
            <!-- Floating cards -->
            <div class="float-card fc-payment">
                <div class="float-icon" style="background:#F0FDF4;">
                    <svg width="16" height="16" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <div class="float-label">Loyer reçu</div>
                    <div class="float-value">+150 000 FCFA</div>
                </div>
            </div>

            <div class="float-card fc-alert">
                <div class="float-icon" style="background:#FEF3C7;">
                    <svg width="16" height="16" fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div>
                    <div class="float-label">Incident signalé</div>
                    <div class="float-value">Appt 205</div>
                </div>
            </div>

            <!-- Main card -->
            <div class="mockup-card">
                <div class="mockup-header">
                    <div class="mockup-dots">
                        <div class="mockup-dot d1"></div>
                        <div class="mockup-dot d2"></div>
                        <div class="mockup-dot d3"></div>
                    </div>
                    <div class="mockup-title">IMMOAPP DASHBOARD</div>
                </div>

                <div class="mockup-property">
                    <div class="mockup-prop-name">Résidence Les Almadies</div>
                    <div class="mockup-prop-loc">📍 Dakar, Almadies</div>
                </div>

                <div class="mockup-revenue">
                    <div class="mockup-rev-label">Revenus mensuels</div>
                    <div class="mockup-rev-value">2 500 000 FCFA</div>
                    <div class="mockup-rev-sub">↑ +12% vs mois dernier</div>
                </div>

                <div class="mockup-grid">
                    <div class="mockup-stat">
                        <div class="mockup-stat-val">15</div>
                        <div class="mockup-stat-lbl">Locataires</div>
                    </div>
                    <div class="mockup-stat">
                        <div class="mockup-stat-val">95%</div>
                        <div class="mockup-stat-lbl">Remplissage</div>
                    </div>
                    <div class="mockup-stat">
                        <div class="mockup-stat-val">2</div>
                        <div class="mockup-stat-lbl">Incidents</div>
                    </div>
                </div>

                <div class="mockup-bar-row">
                    <div class="mockup-bar-item">
                        <div class="mockup-bar-name">Janv.</div>
                        <div class="mockup-bar-track"><div class="mockup-bar-fill" style="width:88%"></div></div>
                        <div class="mockup-bar-pct">88%</div>
                    </div>
                    <div class="mockup-bar-item">
                        <div class="mockup-bar-name">Fév.</div>
                        <div class="mockup-bar-track"><div class="mockup-bar-fill" style="width:94%"></div></div>
                        <div class="mockup-bar-pct">94%</div>
                    </div>
                    <div class="mockup-bar-item">
                        <div class="mockup-bar-name">Mar.</div>
                        <div class="mockup-bar-track"><div class="mockup-bar-fill" style="width:95%"></div></div>
                        <div class="mockup-bar-pct">95%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════ STATS BAND ════════ -->
<div class="stats-band">
    <div class="stats-inner">
        <div class="stat-item fade-in">
            <div class="stat-value">100%</div>
            <div class="stat-label">Adapté au Sénégal</div>
        </div>
        <div class="stat-item fade-in" style="transition-delay:0.1s">
            <div class="stat-value">FCFA</div>
            <div class="stat-label">Devise locale</div>
        </div>
        <div class="stat-item fade-in" style="transition-delay:0.2s">
            <div class="stat-value">5+</div>
            <div class="stat-label">Moyens de paiement</div>
        </div>
        <div class="stat-item fade-in" style="transition-delay:0.3s">
            <div class="stat-value">24/7</div>
            <div class="stat-label">Disponibilité</div>
        </div>
    </div>
</div>

<!-- ════════ PROBLEM / SOLUTION ════════ -->
<section class="ps-section">
    <div class="ps-inner">
        <div class="fade-in">
            <div class="section-label">Le problème</div>
            <h2 class="ps-col-title display">Fini la gestion immobilière traditionnelle</h2>
            <ul class="ps-list">
                <li class="ps-item">
                    <div class="ps-icon bad"><svg width="14" height="14" fill="none" stroke="#DC2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></div>
                    <div>
                        <div class="ps-item-title">Registres et cahiers désorganisés</div>
                        <div class="ps-item-desc">Les traces papier se perdent ou se dégradent avec le temps</div>
                    </div>
                </li>
                <li class="ps-item">
                    <div class="ps-icon bad"><svg width="14" height="14" fill="none" stroke="#DC2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></div>
                    <div>
                        <div class="ps-item-title">Pertes d'informations locataires</div>
                        <div class="ps-item-desc">Difficile de retrouver l'historique complet d'un locataire</div>
                    </div>
                </li>
                <li class="ps-item">
                    <div class="ps-icon bad"><svg width="14" height="14" fill="none" stroke="#DC2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></div>
                    <div>
                        <div class="ps-item-title">Suivi manuel des paiements</div>
                        <div class="ps-item-desc">Sans système automatisé, les impayés passent inaperçus</div>
                    </div>
                </li>
                <li class="ps-item">
                    <div class="ps-icon bad"><svg width="14" height="14" fill="none" stroke="#DC2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></div>
                    <div>
                        <div class="ps-item-title">Incidents non résolus à temps</div>
                        <div class="ps-item-desc">Communication lente entre locataires et propriétaires</div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="ps-solution fade-in" style="transition-delay:0.15s">
            <div class="section-label">La solution</div>
            <h2 class="ps-col-title display">Avec ImmoApp, tout devient simple</h2>
            <ul class="ps-list">
                <li class="ps-item">
                    <div class="ps-icon good"><svg width="14" height="14" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div>
                        <div class="ps-item-title">Données centralisées</div>
                        <div class="ps-item-desc">Tous vos immeubles et locataires au même endroit</div>
                    </div>
                </li>
                <li class="ps-item">
                    <div class="ps-icon good"><svg width="14" height="14" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div>
                        <div class="ps-item-title">Profils locataires complets</div>
                        <div class="ps-item-desc">Historique, contacts, baux — tout est accessible en 1 clic</div>
                    </div>
                </li>
                <li class="ps-item">
                    <div class="ps-icon good"><svg width="14" height="14" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div>
                        <div class="ps-item-title">Paiements automatiques & tracés</div>
                        <div class="ps-item-desc">Wave, Orange Money — tout est enregistré et notifié</div>
                    </div>
                </li>
                <li class="ps-item">
                    <div class="ps-icon good"><svg width="14" height="14" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div>
                        <div class="ps-item-title">Incidents résolus rapidement</div>
                        <div class="ps-item-desc">Signalement en temps réel avec photos et suivi de statut</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- ════════ HOW IT WORKS ════════ -->
<section id="comment-ca-marche" class="how-section">
    <div class="section-center fade-in">
        <div class="section-label" style="margin:0 auto 16px;">Processus simple</div>
        <h2 class="section-title display">Comment ça marche</h2>
        <p class="section-sub">Commencez à gérer vos immeubles en 4 étapes simples</p>
    </div>

    <div class="steps-grid">
        <div class="step-card fade-in">
            <div class="step-num">1</div>
            <div class="step-icon-wrap">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div class="step-title">Inscription gratuite</div>
            <div class="step-desc">Créez votre compte en 2 minutes. Aucune carte bancaire requise.</div>
        </div>
        <div class="step-card fade-in" style="transition-delay:0.1s">
            <div class="step-num">2</div>
            <div class="step-icon-wrap">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div class="step-title">Ajoutez vos immeubles</div>
            <div class="step-desc">Enregistrez vos propriétés et appartements avec tous les détails.</div>
        </div>
        <div class="step-card fade-in" style="transition-delay:0.2s">
            <div class="step-num">3</div>
            <div class="step-icon-wrap">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="step-title">Gérez vos locataires</div>
            <div class="step-desc">Créez des profils complets pour chaque locataire et leurs baux.</div>
        </div>
        <div class="step-card fade-in" style="transition-delay:0.3s">
            <div class="step-num">4</div>
            <div class="step-icon-wrap">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="step-title">Automatisez tout</div>
            <div class="step-desc">Suivez les paiements, incidents et maintenance en temps réel.</div>
        </div>
    </div>
</section>

<!-- ════════ FEATURES ════════ -->
<section id="fonctionnalites" class="feat-section">
    <div class="section-center fade-in">
        <div class="section-label" style="margin:0 auto 16px;">Fonctionnalités</div>
        <h2 class="section-title display">Tout ce dont vous avez besoin</h2>
        <p class="section-sub">Une suite complète d'outils pour simplifier votre gestion immobilière</p>
    </div>

    <div class="feat-grid">
        <div class="feat-card fade-in">
            <div class="feat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
            <div class="feat-title">Gestion des Immeubles</div>
            <div class="feat-desc">Centralisez toutes vos propriétés au même endroit</div>
            <ul class="feat-list">
                <li>Informations détaillées par immeuble</li>
                <li>Gestion multi-appartements</li>
                <li>Photos et documents joints</li>
            </ul>
        </div>

        <div class="feat-card fade-in" style="transition-delay:0.05s">
            <div class="feat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
            <div class="feat-title">Profils Locataires</div>
            <div class="feat-desc">Toutes les informations essentielles sur vos locataires</div>
            <ul class="feat-list">
                <li>Contacts et pièces d'identité</li>
                <li>Historique complet des paiements</li>
                <li>Gestion des baux et renouvellements</li>
            </ul>
        </div>

        <div class="feat-card fade-in" style="transition-delay:0.1s">
            <div class="feat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <div class="feat-title">Suivi des Paiements</div>
            <div class="feat-desc">Ne perdez plus aucun loyer avec le suivi automatique</div>
            <ul class="feat-list">
                <li>Wave, Orange Money, virements</li>
                <li>Relances automatiques des impayés</li>
                <li>Reçus et quittances automatiques</li>
            </ul>
        </div>

        <div class="feat-card fade-in" style="transition-delay:0.15s">
            <div class="feat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
            <div class="feat-title">Gestion des Incidents</div>
            <div class="feat-desc">Résolvez les problèmes rapidement avec un suivi en temps réel</div>
            <ul class="feat-list">
                <li>Signalement avec photos</li>
                <li>Suivi du statut de résolution</li>
                <li>Notifications en temps réel</li>
            </ul>
        </div>

        <div class="feat-card fade-in" style="transition-delay:0.2s">
            <div class="feat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
            <div class="feat-title">Rapports & Statistiques</div>
            <div class="feat-desc">Prenez de meilleures décisions avec les bonnes données</div>
            <ul class="feat-list">
                <li>Tableaux de bord interactifs</li>
                <li>Export Excel et PDF</li>
                <li>Analyses de rentabilité</li>
            </ul>
        </div>

        <div class="feat-card fade-in" style="transition-delay:0.25s">
            <div class="feat-icon"><svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
            <div class="feat-title">Sécurité & Conformité</div>
            <div class="feat-desc">Vos données sont protégées et conformes aux normes</div>
            <ul class="feat-list">
                <li>Chiffrement SSL/TLS</li>
                <li>Sauvegardes automatiques</li>
                <li>Conformité RGPD</li>
            </ul>
        </div>
    </div>
</section>

<!-- ════════ ADVANTAGES ════════ -->
<section id="avantages" class="adv-section">
    <div class="section-center fade-in" style="max-width:600px;margin:0 auto 64px;">
        <div class="section-label" style="margin:0 auto 16px;">Pourquoi ImmoApp</div>
        <h2 class="section-title display">Les avantages qui font la différence</h2>
        <p class="section-sub" style="color:rgba(255,255,255,0.5)">Rejoignez les propriétaires qui ont simplifié leur gestion immobilière</p>
    </div>

    <div class="adv-grid" style="max-width:1200px;margin:0 auto;">
        <div class="adv-card fade-in">
            <div class="adv-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
            <div class="adv-title">Gain de temps considérable</div>
            <div class="adv-desc">Automatisez les tâches répétitives et concentrez-vous sur l'essentiel</div>
        </div>
        <div class="adv-card fade-in" style="transition-delay:0.05s">
            <div class="adv-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
            <div class="adv-title">Réduction des impayés</div>
            <div class="adv-desc">Le suivi automatique réduit drastiquement les retards de paiement</div>
        </div>
        <div class="adv-card fade-in" style="transition-delay:0.1s">
            <div class="adv-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg></div>
            <div class="adv-title">Accessible partout</div>
            <div class="adv-desc">Mobile, tablette ou ordinateur — vos données vous suivent partout</div>
        </div>
        <div class="adv-card fade-in" style="transition-delay:0.15s">
            <div class="adv-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
            <div class="adv-title">Augmentez vos revenus</div>
            <div class="adv-desc">Optimisez vos loyers et réduisez les périodes de vacance locative</div>
        </div>
        <div class="adv-card fade-in" style="transition-delay:0.2s">
            <div class="adv-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg></div>
            <div class="adv-title">Satisfaction locataire</div>
            <div class="adv-desc">Communication fluide et résolution rapide des problèmes</div>
        </div>
        <div class="adv-card fade-in" style="transition-delay:0.25s">
            <div class="adv-icon"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
            <div class="adv-title">Conformité légale</div>
            <div class="adv-desc">Tous vos documents et contrats en règle et sauvegardés</div>
        </div>
    </div>
</section>

<!-- ════════ PRICING ════════ -->
<section id="tarifs" class="price-section">
    <div class="section-center fade-in">
        <div class="section-label" style="margin:0 auto 16px;">Tarifs transparents</div>
        <h2 class="section-title display">Choisissez votre formule</h2>
        <p class="section-sub">Des tarifs adaptés à la taille de votre patrimoine immobilier</p>
    </div>

    <div class="price-grid">
        <!-- Gratuit -->
        <div class="price-card fade-in">
            <div class="price-plan-name dark">Gratuit</div>
            <div class="price-amount dark">0</div>
            <div class="price-period dark">FCFA / mois</div>
            <div class="price-desc dark">Pour découvrir ImmoApp</div>
            <ul class="price-features">
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>1 immeuble maximum</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>5 locataires max</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Gestion basique</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Support communautaire</li>
            </ul>
            <a href="{{ route('register') }}" class="price-btn dark">Commencer gratuitement</a>
        </div>

        <!-- Starter -->
        <div class="price-card fade-in" style="transition-delay:0.1s">
            <div class="price-plan-name dark">Starter</div>
            <div class="price-amount dark">9 999</div>
            <div class="price-period dark">FCFA / mois</div>
            <div class="price-desc dark">Pour petits propriétaires</div>
            <ul class="price-features">
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>3 immeubles max</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>20 locataires max</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Toutes les fonctionnalités</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Support email</li>
            </ul>
            <a href="{{ route('register') }}" class="price-btn dark">Choisir Starter</a>
        </div>

        <!-- Pro -->
        <div class="price-card featured fade-in" style="transition-delay:0.2s">
            <div class="price-badge">Populaire</div>
            <div class="price-plan-name light">Pro</div>
            <div class="price-amount light">24 999</div>
            <div class="price-period light">FCFA / mois</div>
            <div class="price-desc light">Pour professionnels</div>
            <ul class="price-features">
                <li class="light"><svg class="pf-check gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>10 immeubles max</li>
                <li class="light"><svg class="pf-check gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>100 locataires max</li>
                <li class="light"><svg class="pf-check gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Rapports avancés</li>
                <li class="light"><svg class="pf-check gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Support prioritaire</li>
            </ul>
            <a href="{{ route('register') }}" class="price-btn light">Choisir Pro</a>
        </div>

        <!-- Enterprise -->
        <div class="price-card fade-in" style="transition-delay:0.3s">
            <div class="price-plan-name dark">Entreprise</div>
            <div class="price-amount dark big">Sur mesure</div>
            <div class="price-period dark" style="margin-bottom:4px">&nbsp;</div>
            <div class="price-desc dark">Pour grandes structures</div>
            <ul class="price-features">
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Immeubles illimités</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Locataires illimités</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>API & intégrations</li>
                <li class="dark"><svg class="pf-check terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Support dédié 24/7</li>
            </ul>
            <a href="mailto:contact@immoapp.sn" class="price-btn dark">Nous contacter</a>
        </div>
    </div>
</section>

<!-- ════════ FAQ ════════ -->
<section id="faq" class="faq-section">
    <div class="section-center fade-in" style="max-width:720px;margin:0 auto 48px;">
        <div class="section-label" style="margin:0 auto 16px;">FAQ</div>
        <h2 class="section-title display">Vous avez des questions ?</h2>
    </div>

    <div class="faq-inner">
        <details class="faq-item fade-in">
            <summary>Comment fonctionne la période d'essai gratuite ?<svg class="faq-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></summary>
            <div class="faq-body">Le plan Gratuit est disponible sans limitation de durée. Vous pouvez gérer jusqu'à 1 immeuble et 5 locataires sans aucun engagement. Aucune carte bancaire n'est nécessaire pour commencer.</div>
        </details>
        <details class="faq-item fade-in">
            <summary>Puis-je changer de formule à tout moment ?<svg class="faq-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></summary>
            <div class="faq-body">Absolument ! Vous pouvez upgrader ou downgrader votre formule à tout moment depuis votre tableau de bord. Les changements sont effectifs immédiatement et la facturation est ajustée au prorata.</div>
        </details>
        <details class="faq-item fade-in">
            <summary>Mes données sont-elles sécurisées ?<svg class="faq-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></summary>
            <div class="faq-body">Oui, la sécurité est notre priorité. Toutes vos données sont chiffrées (SSL/TLS), stockées sur des serveurs sécurisés et sauvegardées quotidiennement. Nous sommes conformes aux normes RGPD.</div>
        </details>
        <details class="faq-item fade-in">
            <summary>Quels moyens de paiement acceptez-vous ?<svg class="faq-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></summary>
            <div class="faq-body">Nous acceptons Wave, Orange Money, les virements bancaires et les paiements en espèces. Pour vos locataires, ils peuvent payer par tous ces moyens et vous en êtes notifié automatiquement.</div>
        </details>
        <details class="faq-item fade-in">
            <summary>Proposez-vous une application mobile ?<svg class="faq-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></summary>
            <div class="faq-body">ImmoApp est une Progressive Web App (PWA) qui fonctionne parfaitement sur mobile, tablette et ordinateur. Vous pouvez l'installer sur votre écran d'accueil et l'utiliser comme une application native.</div>
        </details>
        <details class="faq-item fade-in">
            <summary>Comment fonctionne le support client ?<svg class="faq-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></summary>
            <div class="faq-body">Nos clients Gratuit bénéficient du support communautaire. Les plans Starter et Pro ont accès au support par email avec réponse sous 24h. Les clients Entreprise bénéficient d'un support dédié disponible 24/7.</div>
        </details>
    </div>
</section>

<!-- ════════ PAYMENT METHODS ════════ -->
<div class="pay-section">
    <div class="pay-inner fade-in">
        <div class="pay-title display">Moyens de paiement acceptés</div>
        <div class="pay-sub">Payez facilement avec vos méthodes préférées</div>
        <div class="pay-cards">
            <div class="pay-card">
                <div class="pay-card-icon" style="background:#FEF9C3;">
                    <svg width="24" height="24" fill="none" stroke="#CA8A04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="pay-card-name">Wave</div>
            </div>
            <div class="pay-card">
                <div class="pay-card-icon" style="background:#FEF3C7;">
                    <svg width="24" height="24" fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div class="pay-card-name">Orange Money</div>
            </div>
            <div class="pay-card">
                <div class="pay-card-icon" style="background:#EFF6FF;">
                    <svg width="24" height="24" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <div class="pay-card-name">Virement</div>
            </div>
            <div class="pay-card">
                <div class="pay-card-icon" style="background:#F0FDF4;">
                    <svg width="24" height="24" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="pay-card-name">Espèces</div>
            </div>
        </div>
    </div>
</div>

<!-- ════════ CTA ════════ -->
<section class="cta-section">
    <div class="cta-inner fade-in">
        <h2 class="cta-title display">Prêt à transformer votre gestion immobilière ?</h2>
        <p class="cta-sub">Rejoignez les propriétaires qui ont déjà simplifié leur quotidien au Sénégal</p>
        <div class="cta-btns">
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn-cta-white">
                    Commencer gratuitement
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endif
            <a href="#tarifs" class="btn-cta-ghost">Voir les tarifs</a>
        </div>
    </div>
</section>

<!-- ════════ FOOTER ════════ -->
<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <a href="/" class="footer-logo">
                    <div class="footer-logo-mark">
                        <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="footer-logo-text">ImmoApp</span>
                </a>
                <p class="footer-about">La solution complète pour simplifier votre gestion immobilière au Sénégal.</p>
                <div class="footer-socials">
                    <a href="#" class="social-btn"><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="social-btn"><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                    <a href="#" class="social-btn"><svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Produit</div>
                <ul class="footer-links">
                    <li><a href="#fonctionnalites">Fonctionnalités</a></li>
                    <li><a href="#tarifs">Tarifs</a></li>
                    <li><a href="#comment-ca-marche">Comment ça marche</a></li>
                    <li><a href="#avantages">Avantages</a></li>
                </ul>
            </div>

            <div>
                <div class="footer-col-title">Support</div>
                <ul class="footer-links">
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="mailto:contact@immoapp.sn">Contact</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Centre d'aide</a></li>
                </ul>
            </div>

            <div>
                <div class="footer-col-title">Légal</div>
                <ul class="footer-links">
                    <li><a href="#">Conditions d'utilisation</a></li>
                    <li><a href="#">Confidentialité</a></li>
                    <li><a href="#">Mentions légales</a></li>
                    <li><a href="#">RGPD</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} ImmoApp. Tous droits réservés. Made with ❤️ in Sénégal</span>
            <span>🇸🇳 Dakar — <a href="mailto:contact@immoapp.sn" style="color:rgba(255,255,255,0.45);text-decoration:none;transition:color 0.2s" onmouseover="this.style.color='rgba(255,255,255,0.9)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">contact@immoapp.sn</a></span>
        </div>
    </div>
</footer>

<script>
    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        });
    });

    // Scroll reveal
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
</script>

</body>
</html>