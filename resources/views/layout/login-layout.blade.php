<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — Akhbar-e-Mashriq</title>
    <meta name="description" content="Sign in to access Akhbar-e-Mashriq premium E-Paper and editorial content.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --red:        #c0392b;
            --red-deep:   #a93226;
            --red-light:  #fdf2f1;
            --red-mid:    #f5cac7;
            --ink:        #0f172a;
            --ink-2:      #1e293b;
            --slate:      #475569;
            --muted:      #94a3b8;
            --border:     #e2e8f0;
            --border-2:   #cbd5e1;
            --surface:    #f8fafc;
            --white:      #ffffff;
            --panel:      #f1f5f9;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        /* ── FULL-PAGE GRID ────────────────────────────────────────── */
        .am-login-root {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── LEFT PANEL  (Brand / Visual Side) ────────────────────── */
        .am-login-left {
            position: relative;
            overflow: hidden;
            background: var(--ink);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 56px;
        }

        /* Subtle mesh gradient overlay */
        .am-login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(192,57,43,0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 90% 80%, rgba(37,99,235,0.10) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Decorative horizontal rule lines */
        .am-left-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .am-left-lines span {
            position: absolute;
            left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.06) 50%, transparent 100%);
        }
        .am-left-lines span:nth-child(1) { top: 25%; }
        .am-left-lines span:nth-child(2) { top: 50%; }
        .am-left-lines span:nth-child(3) { top: 75%; }

        /* Floating dot grid */
        .am-dot-grid {
            position: absolute;
            right: -40px; bottom: 80px;
            width: 280px; height: 280px;
            background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1.5px, transparent 1.5px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* Brand mark on left */
        .am-left-brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }
        .am-left-logo {
            width: 46px; height: 46px;
            background: var(--red);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -1px;
            flex-shrink: 0;
            box-shadow: 0 8px 24px rgba(192,57,43,0.45);
        }
        .am-left-name-wrap span:first-child {
            display: block;
            font-size: 17px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
            line-height: 1.1;
        }
        .am-left-name-wrap span:last-child {
            display: block;
            font-size: 10.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1.8px;
        }

        /* Center editorial block */
        .am-left-center {
            position: relative;
            z-index: 2;
        }
        .am-left-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(192,57,43,0.18);
            border: 1px solid rgba(192,57,43,0.3);
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 700;
            color: #ff8a80;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 28px;
        }
        .am-left-tag::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #ff8a80;
            animation: blink 1.8s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }

        .am-left-headline {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 3.5vw, 46px);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .am-left-headline em {
            font-style: italic;
            color: rgba(255,255,255,0.55);
        }
        .am-left-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.45);
            line-height: 1.75;
            max-width: 360px;
        }

        /* Trust badges */
        .am-trust-badges {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .am-trust-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .am-trust-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .am-trust-icon svg {
            width: 16px; height: 16px;
            color: rgba(255,255,255,0.5);
        }
        .am-trust-text span:first-child {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.75);
        }
        .am-trust-text span:last-child {
            display: block;
            font-size: 12px;
            color: rgba(255,255,255,0.35);
        }


        /* ── RIGHT PANEL (Form Side) ───────────────────────────────── */
        .am-login-right {
            background: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 64px 48px;
            position: relative;
            overflow: hidden;
        }

        /* Subtle top-right accent */
        .am-login-right::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(192,57,43,0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .am-login-right::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .am-login-form-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Form header */
        .am-form-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--red);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 14px;
        }
        .am-form-eyebrow::before {
            content: '';
            width: 20px; height: 2px;
            background: var(--red);
            border-radius: 2px;
        }
        .am-form-title {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }
        .am-form-sub {
            font-size: 14.5px;
            color: var(--slate);
            line-height: 1.65;
            margin-bottom: 36px;
        }

        /* Error notice */
        .am-alert-error {
            background: var(--red-light);
            border: 1px solid var(--red-mid);
            border-radius: 12px;
            padding: 13px 16px;
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-bottom: 24px;
        }
        .am-alert-error svg {
            flex-shrink: 0;
            width: 17px; height: 17px;
            color: var(--red);
            margin-top: 1px;
        }
        .am-alert-error span {
            font-size: 13px;
            font-weight: 600;
            color: var(--red-deep);
            line-height: 1.5;
        }

        /* Fields */
        .am-field { margin-bottom: 18px; }
        .am-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--slate);
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .am-input-wrap { position: relative; }
        .am-input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px; height: 17px;
            color: var(--muted);
            pointer-events: none;
            transition: color 0.25s;
        }
        .am-input {
            width: 100%;
            height: 50px;
            background: var(--panel);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 0 16px 0 46px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: var(--ink);
            transition: all 0.25s ease;
            outline: none;
        }
        .am-input::placeholder { color: var(--muted); font-weight: 400; }
        .am-input:focus {
            background: var(--white);
            border-color: var(--red);
            box-shadow: 0 0 0 4px rgba(192,57,43,0.1);
        }
        .am-input:focus + .am-input-icon,
        .am-input-wrap:focus-within .am-input-icon { color: var(--red); }

        /* Password toggle */
        .am-pass-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--muted);
            transition: color 0.25s;
            display: flex;
            align-items: center;
        }
        .am-pass-toggle:hover { color: var(--slate); }
        .am-pass-toggle svg { width: 17px; height: 17px; }

        /* Forgot password row */
        .am-forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 6px;
        }
        .am-forgot-row a {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--slate);
            text-decoration: none;
            transition: color 0.25s;
        }
        .am-forgot-row a:hover { color: var(--red); }

        /* Submit */
        .am-btn-submit {
            width: 100%;
            height: 52px;
            background: var(--red);
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 15.5px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            margin-top: 28px;
            letter-spacing: 0.2px;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 16px rgba(192,57,43,0.25);
        }
        .am-btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.12) 0%, transparent 100%);
        }
        .am-btn-submit:hover {
            background: var(--red-deep);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(192,57,43,0.35);
        }
        .am-btn-submit:active { transform: translateY(0); box-shadow: 0 4px 12px rgba(192,57,43,0.2); }
        .am-btn-submit svg { width: 18px; height: 18px; z-index: 1; }
        .am-btn-submit span { z-index: 1; }

        /* Divider */
        .am-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0;
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .am-divider::before, .am-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Card links */
        .am-card-links {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            font-size: 13.5px;
            color: var(--muted);
        }
        .am-card-links a {
            color: var(--red);
            text-decoration: none;
            font-weight: 700;
            margin-left: 5px;
            transition: color 0.25s;
        }
        .am-card-links a:hover { color: var(--red-deep); }

        /* Protected notice */
        .am-secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
        }
        .am-secure-badge svg { width: 14px; height: 14px; color: var(--muted); }

        /* ── RESPONSIVE ────────────────────────────────────────────── */
        @media (max-width: 900px) {
            .am-login-root { grid-template-columns: 1fr; }
            .am-login-left { display: none; }
            .am-login-right { padding: 48px 28px; min-height: 100vh; }
        }
        @media (max-width: 480px) {
            .am-login-right { padding: 40px 20px; }
            .am-form-title { font-size: 28px; }
        }
    </style>
</head>

<body>
    <div class="am-login-root">

        <!-- ══ LEFT BRAND PANEL ═══════════════════════════════════════ -->
        <div class="am-login-left">
            <div class="am-left-lines">
                <span></span><span></span><span></span>
            </div>
            <div class="am-dot-grid"></div>

            <!-- Brand -->
            <a href="/" class="am-left-brand">
                <div class="am-left-logo">ا م</div>
                <div class="am-left-name-wrap">
                    <span>Akhbar-e-Mashriq</span>
                    <span>Digital Publishing</span>
                </div>
            </a>

            <!-- Headline -->
            <div class="am-left-center">
                <div class="am-left-tag">Premium Access</div>
                <h2 class="am-left-headline">
                    Your trusted<br>
                    <em>source of news,</em><br>
                    reimagined.
                </h2>
                <p class="am-left-desc">
                    Access decades of editorial archives, daily E-Papers, and exclusive
                    multimedia content — all in one secure portal.
                </p>
            </div>

            <!-- Trust items -->
            <div class="am-trust-badges">
                <div class="am-trust-item">
                    <div class="am-trust-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div class="am-trust-text">
                        <span>Enterprise-Grade Security</span>
                        <span>SSL encrypted · Zero data sharing</span>
                    </div>
                </div>
                <div class="am-trust-item">
                    <div class="am-trust-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                        </svg>
                    </div>
                    <div class="am-trust-text">
                        <span>Full E-Paper Archive</span>
                        <span>Decades of issues, one click away</span>
                    </div>
                </div>
                <div class="am-trust-item">
                    <div class="am-trust-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="am-trust-text">
                        <span>Real-Time Updates</span>
                        <span>Breaking news · Live editorial feed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══ RIGHT FORM PANEL ═══════════════════════════════════════ -->
        <div class="am-login-right">
            <div class="am-login-form-wrap">

                @yield('container')

            </div>
        </div>

    </div>

    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.am-pass-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var input = btn.closest('.am-input-wrap').querySelector('input');
                    var isText = input.type === 'text';
                    input.type = isText ? 'password' : 'text';
                    btn.querySelector('.eye-open').style.display = isText ? 'block' : 'none';
                    btn.querySelector('.eye-closed').style.display = isText ? 'none' : 'block';
                });
            });
        });
    </script>
</body>
</html>