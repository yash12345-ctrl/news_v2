@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Social', 'ltr' => true])

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,400&family=Inter:wght@300;400;500;600;700;900&display=swap');

.soc-page {
    background: #090909;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    overflow: hidden;
    padding: 0 0 100px 0;
}

/* Ambient glows */
.soc-page::before {
    content:'';
    position:absolute;
    top:-200px; left:-200px;
    width:700px; height:700px;
    background: radial-gradient(circle, rgba(227,30,36,0.12) 0%, transparent 65%);
    border-radius:50%;
    pointer-events:none;
    z-index:0;
}
.soc-page::after {
    content:'';
    position:absolute;
    bottom:-300px; right:-200px;
    width:800px; height:800px;
    background: radial-gradient(circle, rgba(227,30,36,0.06) 0%, transparent 65%);
    border-radius:50%;
    pointer-events:none;
    z-index:0;
}

/* Grid noise texture overlay */
.soc-noise {
    position:absolute;
    inset:0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events:none;
    z-index:0;
    opacity:0.5;
}

/* ─── Hero Banner ─── */
.soc-hero {
    position:relative; z-index:1;
    padding: 90px 40px 80px;
    text-align:center;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}
.soc-eyebrow {
    display:inline-flex;
    align-items:center;
    gap:12px;
    color: #e31e24;
    font-size:11px;
    font-weight:700;
    letter-spacing:3px;
    text-transform:uppercase;
    margin-bottom:24px;
}
.soc-eyebrow span { width:30px; height:1px; background:#e31e24; display:block; }
.soc-hero-title {
    font-family:'Playfair Display', serif;
    font-size: clamp(48px, 8vw, 96px);
    font-weight:900;
    color:#ffffff;
    line-height:1;
    letter-spacing:-2px;
    margin:0 0 8px;
}
.soc-hero-title em {
    font-style:italic;
    color: transparent;
    -webkit-text-stroke: 1px rgba(255,255,255,0.4);
}
.soc-hero-desc {
    color: rgba(255,255,255,0.35);
    font-size:15px;
    font-weight:400;
    line-height:1.7;
    max-width:420px;
    margin: 20px auto 0;
    letter-spacing:0.2px;
}

/* ─── Decorative Line ─── */
.soc-divider {
    position:relative; z-index:1;
    display:flex; align-items:center; gap:20px;
    max-width:900px; margin: 0 auto;
    padding: 0 40px;
}
.soc-divider-line { flex:1; height:1px; background: linear-gradient(90deg,transparent,rgba(255,255,255,0.06),transparent); }
.soc-divider-diamond {
    width:8px; height:8px; background:#e31e24;
    transform:rotate(45deg); flex-shrink:0;
}

/* ─── Cards Grid ─── */
.soc-grid {
    position:relative; z-index:1;
    max-width:1100px;
    margin: 70px auto 0;
    padding: 0 40px;
    display:grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}
@media(max-width:768px){ .soc-grid{ grid-template-columns:1fr; padding:0 20px; } }
@media(min-width:769px){
    .soc-card:last-child:nth-child(odd) {
        grid-column: 1 / -1;
        justify-self: center;
        width: calc(50% - 12px);
    }
}

.soc-card {
    position:relative;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 24px;
    padding: 50px 44px;
    text-decoration:none;
    display:flex;
    align-items:center;
    gap: 32px;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    overflow:hidden;
    transition: all 0.55s cubic-bezier(0.16,1,0.3,1);
    cursor: pointer;
    z-index: 1;
}

/* Animated Gradient Border setup */
@keyframes rotateBorder {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.soc-card::after {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    width: 200%; height: 300%;
    background: conic-gradient(from 0deg, transparent 40%, var(--bc, #e31e24) 80%, var(--bc, #e31e24) 95%, transparent 100%);
    transform: translate(-50%, -50%) rotate(0deg);
    animation: rotateBorder 3.5s linear infinite;
    opacity: 1;
    transition: opacity 0.5s ease;
    z-index: -2;
    pointer-events: none;
}

/* The dark background inside the card to cover the animated border except at the edge */
.soc-card-bg {
    position: absolute;
    inset: 2px;
    background: #111111;
    border-radius: 22.5px;
    z-index: -1;
    transition: background 0.5s ease;
    pointer-events: none;
}

/* Sheen overlay */
.soc-card::before {
    content:'';
    position:absolute;
    inset:0;
    background: linear-gradient(135deg, rgba(255,255,255,0.04) 0%, transparent 60%);
    border-radius:24px;
    opacity:0;
    transition: opacity 0.5s ease;
    pointer-events:none;
    z-index: 0;
}
.soc-card:hover::before { opacity:1; }

/* Reveal the animated border on hover */
.soc-card:hover::after { opacity: 1; }
.soc-card:hover .soc-card-bg { background: #161616; }

/* Brand glow blob */
.soc-card-glow {
    position:absolute;
    bottom:-80px; right:-80px;
    width:220px; height:220px;
    border-radius:50%;
    background: var(--bc, #e31e24);
    opacity:0;
    filter: blur(70px);
    transition: opacity 0.6s ease;
    pointer-events:none;
    z-index: 0;
}
.soc-card:hover .soc-card-glow { opacity:0.12; }

/* Top border accent */
.soc-card-accent {
    position:absolute;
    top:0; left:0; right:0;
    height:2px;
    background: linear-gradient(90deg, transparent, var(--bc, #e31e24), transparent);
    opacity:0;
    transition: opacity 0.5s ease;
    z-index: 0;
}
.soc-card:hover .soc-card-accent { opacity:1; }

.soc-card:hover {
    border-color: transparent;
    transform: translateY(-6px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.02);
}

/* Icon circle */
.soc-icon-ring {
    position:relative;
    width: 72px; height:72px;
    flex-shrink:0;
    border-radius:50%;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    display:flex;
    align-items:center;
    justify-content:center;
    color: rgba(255,255,255,0.6);
    transition: all 0.55s cubic-bezier(0.16,1,0.3,1);
    z-index: 1;
}
.soc-icon-ring svg { width:26px; height:26px; fill:currentColor; transition: transform 0.4s ease; }
.soc-card:hover .soc-icon-ring {
    background: var(--bc, #e31e24);
    border-color: var(--bc, #e31e24);
    color: var(--ic-hover, #fff);
    box-shadow: 0 12px 30px color-mix(in srgb, var(--bc, #e31e24) 40%, transparent);
    transform: scale(1.08) rotate(-5deg);
}
.soc-card:hover .soc-icon-ring svg { transform: rotate(5deg); }

/* Text */
.soc-card-body { flex:1; min-width:0; }
.soc-card-label {
    font-size:11px;
    font-weight:700;
    letter-spacing:2px;
    text-transform:uppercase;
    color: rgba(255,255,255,0.25);
    margin-bottom:6px;
}
.soc-card-name {
    font-family:'Playfair Display', serif;
    font-size:28px;
    font-weight:900;
    color:#fff;
    margin:0 0 6px;
    line-height:1;
    transition: color 0.3s ease;
}
.soc-card:hover .soc-card-name { color: var(--bc, #e31e24); }
.soc-card-handle {
    font-size:13px;
    color: rgba(255,255,255,0.3);
    font-weight:500;
    transition: color 0.3s ease;
}
.soc-card:hover .soc-card-handle { color: rgba(255,255,255,0.5); }

/* Arrow button */
.soc-arrow {
    flex-shrink:0;
    width:44px; height:44px;
    border-radius:50%;
    border:1px solid rgba(255,255,255,0.1);
    display:flex;
    align-items:center;
    justify-content:center;
    color: rgba(255,255,255,0.25);
    transition: all 0.45s cubic-bezier(0.16,1,0.3,1);
}
.soc-arrow svg { width:18px; height:18px; fill:currentColor; }
.soc-card:hover .soc-arrow {
    background: var(--bc, #e31e24);
    border-color: var(--bc, #e31e24);
    color: var(--ic-hover, #fff);
    transform:translateX(4px);
}

/* ─── Platform colors ─── */
.soc-twitter  { --bc: #ffffff; --ic-hover: #000000; }
.soc-youtube  { --bc: #FF0000; }
.soc-instagram{ --bc: #E1306C; }
.soc-facebook { --bc: #1877F2; }
.soc-linkedin { --bc: #0A66C2; }

/* ─── Bottom tagline ─── */
.soc-tagline {
    position:relative; z-index:1;
    text-align:center;
    margin-top:70px;
    padding:0 20px;
    color: rgba(255,255,255,0.12);
    font-size:13px;
    letter-spacing:1px;
}

/* ─── Floating counter badges ─── */
.soc-badge {
    position:absolute;
    top:22px; right:22px;
    font-size:10px;
    font-weight:700;
    letter-spacing:1.5px;
    text-transform:uppercase;
    color: rgba(255,255,255,0.2);
    border:1px solid rgba(255,255,255,0.07);
    padding:4px 10px;
    border-radius:30px;
    transition: all 0.4s ease;
}
.soc-card:hover .soc-badge {
    color: var(--bc, #e31e24);
    border-color: var(--bc, #e31e24);
    background: rgba(255,255,255,0.04);
}

/* ─── Animated scanline ─── */
@keyframes scanline {
    0%   { transform: translateY(-100%); }
    100% { transform: translateY(400%); }
}
.soc-scanline {
    position:absolute;
    top:0; left:0; right:0;
    height:40%;
    background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.015), transparent);
    animation: scanline 6s ease-in-out infinite;
    pointer-events:none;
    z-index:0;
}
</style>

<div class="soc-page">
    <div class="soc-noise"></div>
    <div class="soc-scanline"></div>

    {{-- Hero --}}
    <div class="soc-hero">
        <div class="soc-eyebrow">
            <span></span> Connect With Us <span></span>
        </div>
        <h1 class="soc-hero-title">Follow Our <em>Network</em></h1>
        <p class="soc-hero-desc">Stay ahead with breaking news, exclusive editorials, and live updates across every platform.</p>
    </div>

    <div class="soc-divider">
        <div class="soc-divider-line"></div>
        <div class="soc-divider-diamond"></div>
        <div class="soc-divider-line"></div>
    </div>

    {{-- Cards Grid --}}
    <div class="soc-grid">

        {{-- Instagram --}}
        <a href="https://www.instagram.com/akhbarmashriqin" target="_blank" class="soc-card soc-instagram">
            <div class="soc-card-bg"></div>
            <div class="soc-card-glow"></div>
            <div class="soc-card-accent"></div>
            <span class="soc-badge">Follow</span>
            <div class="soc-icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.0281 2.00073C14.1535 2.00259 14.7238 2.00855 15.2166 2.02322L15.4107 2.02956C15.6349 2.03753 15.8561 2.04753 16.1228 2.06003C17.1869 2.1092 17.9128 2.27753 18.5503 2.52503C19.2094 2.7792 19.7661 3.12253 20.3219 3.67837C20.8769 4.2342 21.2203 4.79253 21.4753 5.45003C21.7219 6.0867 21.8903 6.81337 21.9403 7.87753C21.9522 8.1442 21.9618 8.3654 21.9697 8.58964L21.976 8.78373C21.9906 9.27647 21.9973 9.84686 21.9994 10.9723L22.0002 11.7179C22.0003 11.809 22.0003 11.903 22.0003 12L22.0002 12.2821L21.9996 13.0278C21.9977 14.1532 21.9918 14.7236 21.9771 15.2163L21.9707 15.4104C21.9628 15.6347 21.9528 15.8559 21.9403 16.1225C21.8911 17.1867 21.7219 17.9125 21.4753 18.55C21.2211 19.2092 20.8769 19.7659 20.3219 20.3217C19.7661 20.8767 19.2069 21.22 18.5503 21.475C17.9128 21.7217 17.1869 21.89 16.1228 21.94C15.8561 21.9519 15.6349 21.9616 15.4107 21.9694L15.2166 21.9757C14.7238 21.9904 14.1535 21.997 13.0281 21.9992L12.2824 22L12.0003 22L11.7182 22L10.9725 21.9993C9.8471 21.9975 9.27672 21.9915 8.78397 21.9768L8.58989 21.9705C8.36564 21.9625 8.14444 21.9525 7.87778 21.94C6.81361 21.8909 6.08861 21.7217 5.45028 21.475C4.79194 21.2209 4.23444 20.8767 3.67861 20.3217C3.12278 19.7659 2.78028 19.2067 2.52528 18.55C2.27778 17.9125 2.11028 17.1867 2.06028 16.1225C2.0484 15.8559 2.03871 15.6347 2.03086 15.4104L2.02457 15.2163C2.00994 14.7236 2.00327 14.1532 2.00111 13.0278L2.00098 10.9723C2.00284 9.84686 2.00879 9.27647 2.02346 8.78373L2.02981 8.58964C2.03778 8.3654 2.04778 8.1442 2.06028 7.87753C2.10944 6.81253 2.27778 6.08753 2.52528 5.45003C2.77944 4.7917 3.12278 4.2342 3.67861 3.67837C4.23444 3.12253 4.79278 2.78003 5.45028 2.52503C6.08778 2.27753 6.81278 2.11003 7.87778 2.06003C8.14444 2.04816 8.36564 2.03847 8.58989 2.03062L8.78397 2.02433C9.27672 2.00969 9.8471 2.00302 10.9725 2.00086L13.0281 2.00073ZM12.0003 7.00003C9.23738 7.00003 7.00028 9.23956 7.00028 12C7.00028 14.7629 9.23981 17 12.0003 17C14.7632 17 17.0003 14.7605 17.0003 12C17.0003 9.23713 14.7607 7.00003 12.0003 7.00003ZM12.0003 9.00003C13.6572 9.00003 15.0003 10.3427 15.0003 12C15.0003 13.6569 13.6576 15 12.0003 15C10.3434 15 9.00028 13.6574 9.00028 12C9.00028 10.3431 10.3429 9.00003 12.0003 9.00003ZM17.2503 5.50003C16.561 5.50003 16.0003 6.05994 16.0003 6.74918C16.0003 7.43843 16.5602 7.9992 17.2503 7.9992C17.9395 7.9992 18.5003 7.4393 18.5003 6.74918C18.5003 6.05994 17.9386 5.49917 17.2503 5.50003Z"/></svg>
            </div>
            <div class="soc-card-body">
                <div class="soc-card-label">Photo & Stories</div>
                <h2 class="soc-card-name">Instagram</h2>
                <div class="soc-card-handle">@akhbarmashriqin</div>
            </div>
            <div class="soc-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"/></svg>
            </div>
        </a>

        {{-- Facebook --}}
        <a href="https://www.facebook.com/AkhbarMashriqIN" target="_blank" class="soc-card soc-facebook">
            <div class="soc-card-bg"></div>
            <div class="soc-card-glow"></div>
            <div class="soc-card-accent"></div>
            <span class="soc-badge">Like & Follow</span>
            <div class="soc-icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z"/></svg>
            </div>
            <div class="soc-card-body">
                <div class="soc-card-label">Community</div>
                <h2 class="soc-card-name">Facebook</h2>
                <div class="soc-card-handle">@AkhbarMashriqIN</div>
            </div>
            <div class="soc-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"/></svg>
            </div>
        </a>

        {{-- YouTube --}}
        <a href="https://www.youtube.com/@akhbarmashriqin" target="_blank" class="soc-card soc-youtube">
            <div class="soc-card-bg"></div>
            <div class="soc-card-glow"></div>
            <div class="soc-card-accent"></div>
            <span class="soc-badge">Subscribe</span>
            <div class="soc-icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.2439 4C12.778 4.00294 14.1143 4.01586 15.5341 4.07273L16.0375 4.09468C17.467 4.16236 18.8953 4.27798 19.6037 4.4755C20.5486 4.74095 21.2913 5.5155 21.5423 6.49732C21.942 8.05641 21.992 11.0994 21.9982 11.8358L21.9991 11.9884L21.9991 11.9991C21.9991 11.9991 21.9991 12.0028 21.9991 12.0099L21.9982 12.1625C21.992 12.8989 21.942 15.9419 21.5423 17.501C21.2878 18.4864 20.5451 19.261 19.6037 19.5228C18.8953 19.7203 17.467 19.8359 16.0375 19.9036L15.5341 19.9255C14.1143 19.9824 12.778 19.9953 12.2439 19.9983L12.0095 19.9991L11.9991 19.9991L11.7545 19.9983C10.6241 19.9921 5.89772 19.941 4.39451 19.5228C3.4496 19.2573 2.70692 18.4828 2.45587 17.501C2.0562 15.9419 2.00624 12.8989 2 12.1625V11.8358C2.00624 11.0994 2.0562 8.05641 2.45587 6.49732C2.7104 5.51186 3.45308 4.73732 4.39451 4.4755C5.89772 4.05723 10.6241 4.00622 11.7545 4H12.2439ZM9.99911 8.49914V15.4991L15.9991 11.9991L9.99911 8.49914Z"/></svg>
            </div>
            <div class="soc-card-body">
                <div class="soc-card-label">Video Channel</div>
                <h2 class="soc-card-name">YouTube</h2>
                <div class="soc-card-handle">@akhbarmashriqin</div>
            </div>
            <div class="soc-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"/></svg>
            </div>
        </a>

        {{-- X / Twitter --}}
        <a href="https://x.com/AkhbarMashriqIN" target="_blank" class="soc-card soc-twitter">
            <div class="soc-card-bg"></div>
            <div class="soc-card-glow"></div>
            <div class="soc-card-accent"></div>
            <span class="soc-badge">Follow</span>
            <div class="soc-icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.6874 3.0625L12.6907 8.77425L8.37045 3.0625H2.11328L9.58961 12.8387L2.50378 20.9375H5.53795L11.0068 14.6886L15.7863 20.9375H21.8885L14.095 10.6342L20.7198 3.0625H17.6874ZM16.6232 19.1225L5.65436 4.78217H7.45745L18.3034 19.1225H16.6232Z"/></svg>
            </div>
            <div class="soc-card-body">
                <div class="soc-card-label">Social Media</div>
                <h2 class="soc-card-name">X (Twitter)</h2>
                <div class="soc-card-handle">@AkhbarMashriqIN</div>
            </div>
            <div class="soc-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"/></svg>
            </div>
        </a>

        {{-- LinkedIn --}}
        <a href="https://www.linkedin.com/company/akhbar-e-mashriq/" target="_blank" class="soc-card soc-linkedin">
            <div class="soc-card-bg"></div>
            <div class="soc-card-glow"></div>
            <div class="soc-card-accent"></div>
            <span class="soc-badge">Connect</span>
            <div class="soc-icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.94 5.00002C6.93974 5.53046 6.72877 6.03906 6.35351 6.41394C5.97825 6.78883 5.46944 6.99947 4.939 6.99947C4.40857 6.99947 3.89976 6.78883 3.5245 6.41394C3.14924 6.03906 2.93827 5.53046 2.938 5.00002C2.93827 4.46958 3.14924 3.96098 3.5245 3.5861C3.89976 3.21121 4.40857 3.00057 4.939 3.00057C5.46944 3.00057 5.97825 3.21121 6.35351 3.5861C6.72877 3.96098 6.93974 4.46958 6.94 5.00002ZM7 8.48002H3V21.0001H7V8.48002ZM13.32 8.48002H9.34V21.0001H13.28V14.43C13.28 10.77 18.05 10.43 18.05 14.43V21.0001H22V13.07C22 6.90002 14.94 7.13002 13.28 10.16L13.32 8.48002Z"/></svg>
            </div>
            <div class="soc-card-body">
                <div class="soc-card-label">Professional</div>
                <h2 class="soc-card-name">LinkedIn</h2>
                <div class="soc-card-handle">@AkhbarMashriqIN</div>
            </div>
            <div class="soc-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"/></svg>
            </div>
        </a>

    </div>

    <div class="soc-tagline">AKHBAR-E-MASHRIQ &nbsp;·&nbsp; EST. KOLKATA &nbsp;·&nbsp; JOURNALISM OF RECORD</div>
</div>
@endsection
