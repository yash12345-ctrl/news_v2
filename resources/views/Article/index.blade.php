@extends('templates.base', ['title' => 'Article | Akhbar-e-mashriq'])

@section('content')

{{-- ═══════════════════════════════════════
     PREMIUM ARTICLE INDEX STYLES
     ═══════════════════════════════════════ --}}
<style>
/* ── Google Font import ─────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap');

/* ── Page wrapper ───────────────────────── */
.am-articles-page {
    font-family: 'Poppins', sans-serif;
    background: #f3f4f7;
    background-image:
        radial-gradient(circle at 20% 0%, rgba(227,30,36,0.04) 0%, transparent 50%),
        radial-gradient(circle at 80% 100%, rgba(0,0,0,0.03) 0%, transparent 50%);
    min-height: 100vh;
    padding-top: 24px;
    padding-bottom: 80px;
}

/* ── Section header — Advanced Editorial Banner ── */
.am-page-header {
    margin-bottom: 44px;
    border-radius: 19px;
    padding: 2.5px; /* Thicker border */
    position: relative;
    overflow: hidden;
    box-shadow:
        0 8px 40px rgba(0,0,0,0.28),
        0 2px 8px rgba(0,0,0,0.18);
    background: rgba(255,255,255,0.03);
}

/* The spinning gradient border (sharp) */
.am-page-header::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%; width: 150%; height: 400%;
    background: conic-gradient(
        from 0deg,
        transparent 40%,
        #e31e24 80%,
        #ffffff 95%,
        transparent 100%
    );
    transform: translate(-50%, -50%) rotate(0deg);
    animation: am-border-spin 3.5s linear infinite;
    z-index: 0;
}

/* Strong glowing layer behind the sharp border */
.am-page-header::after {
    content: '';
    position: absolute;
    top: 50%; left: 50%; width: 150%; height: 400%;
    background: conic-gradient(
        from 0deg,
        transparent 40%,
        rgba(227,30,36,0.8) 80%,
        rgba(255,100,100,0.9) 95%,
        transparent 100%
    );
    transform: translate(-50%, -50%) rotate(0deg);
    animation: am-border-spin 3.5s linear infinite;
    z-index: 0;
    filter: blur(14px);
    opacity: 1;
}

@keyframes am-border-spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Inner content wrapper */
.am-page-header-inner {
    display: flex;
    flex-direction: column;
    gap: 0;
    background: #080808;
    border-radius: 17.5px;
    position: relative;
    z-index: 1;
    overflow: hidden;
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.06),
        inset 0 0 60px rgba(227,30,36,0.06);
}

/* ── Top zone: dark rich banner ── */
.am-header-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    padding: 28px 40px 24px;
    background: #0a0a0a;
    background-image:
        radial-gradient(ellipse at 0% 50%, rgba(227,30,36,0.12) 0%, transparent 55%),
        radial-gradient(ellipse at 100% 50%, rgba(100,0,0,0.08) 0%, transparent 55%),
        repeating-linear-gradient(
            -50deg,
            transparent,
            transparent 4px,
            rgba(255,255,255,0.012) 4px,
            rgba(255,255,255,0.012) 5px
        );
    position: relative;
    overflow: hidden;
}

/* animated shimmer sweep */
@keyframes am-shimmer {
    0%   { transform: translateX(-100%) skewX(-15deg); }
    100% { transform: translateX(400%) skewX(-15deg); }
}
.am-header-top::before {
    content: '';
    position: absolute;
    top: 0; bottom: 0;
    left: 0;
    width: 80px;
    background: linear-gradient(90deg,
        transparent,
        rgba(255,255,255,0.04),
        transparent
    );
    animation: am-shimmer 5s ease-in-out infinite;
    pointer-events: none;
}

/* glowing top border */
.am-header-top::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg,
        transparent 0%,
        #e31e24 15%,
        #ff5c5c 40%,
        #ff8080 50%,
        #ff5c5c 60%,
        #e31e24 85%,
        transparent 100%
    );
    box-shadow: 0 0 18px rgba(227,30,36,0.7), 0 0 4px rgba(255,100,100,0.4);
}

.am-accent-bar { display: none; }
.am-header-divider {
    width: 1px;
    height: 52px;
    background: linear-gradient(180deg,
        transparent 0%,
        rgba(255,255,255,0.14) 25%,
        rgba(255,255,255,0.14) 75%,
        transparent 100%
    );
    flex-shrink: 0;
}

/* left: eyebrow + title block */
.am-page-title-wrap {
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
    min-width: 0;
}
.am-page-eyebrow {
    font-family: 'Inter', sans-serif;
    font-size: 8.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3.5px;
    color: rgba(227,30,36,0.85);
    display: flex;
    align-items: center;
    gap: 10px;
}
.am-page-eyebrow::before {
    content: '';
    display: inline-block;
    width: 24px;
    height: 1.5px;
    background: linear-gradient(90deg, #e31e24, #ff5c5c);
    border-radius: 1px;
    box-shadow: 0 0 8px rgba(227,30,36,0.6);
}
.am-page-title {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -1.2px;
    line-height: 1;
    display: flex;
    align-items: center;
    gap: 16px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.5);
}

/* large ghosted watermark */
.am-header-watermark {
    position: absolute;
    right: 36px;
    top: 50%;
    transform: translateY(-50%);
    font-family: 'Poppins', sans-serif;
    font-size: 110px;
    font-weight: 900;
    color: transparent;
    -webkit-text-stroke: 1px rgba(255,255,255,0.04);
    line-height: 1;
    letter-spacing: -6px;
    pointer-events: none;
    user-select: none;
    white-space: nowrap;
}

/* live feed badge */
.am-feed-badge {
    font-family: 'Inter', sans-serif;
    font-size: 8px;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 2px;
    padding: 5px 14px;
    background: linear-gradient(135deg, #e31e24 0%, #9e0d12 100%);
    border-radius: 50px;
    border: 1px solid rgba(255,100,100,0.25);
    box-shadow:
        0 0 0 4px rgba(227,30,36,0.12),
        0 0 0 1px rgba(227,30,36,0.4),
        0 6px 18px rgba(227,30,36,0.45);
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex-shrink: 0;
}
.am-feed-badge::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    background: #fff;
    border-radius: 50%;
    animation: am-pulse 1.2s ease-in-out infinite;
    box-shadow: 0 0 8px rgba(255,255,255,0.8);
}
@keyframes am-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.15; transform: scale(0.4); }
}

/* right meta block */
.am-header-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
    flex-shrink: 0;
}
.am-header-meta-date {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 500;
    color: rgba(255,255,255,0.4);
    display: flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 0.2px;
}
.am-header-meta-date svg {
    width: 12px;
    height: 12px;
    fill: rgba(255,255,255,0.22);
}
.am-header-meta-tag {
    font-family: 'Inter', sans-serif;
    font-size: 8px;
    font-weight: 700;
    color: rgba(255,255,255,0.18);
    text-transform: uppercase;
    letter-spacing: 2px;
    padding: 2px 8px;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 3px;
}

/* ── Bottom stats zone ── */
.am-header-stats {
    display: flex;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,0.025);
    border-top: 1px solid rgba(255,255,255,0.05);
    padding: 0 40px;
}
.am-header-stat {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px 12px 0;
    margin-right: 20px;
    border-right: 1px solid rgba(255,255,255,0.05);
    flex-shrink: 0;
}
.am-header-stat:last-child {
    border-right: none;
}
.am-header-stat-icon {
    width: 14px;
    height: 14px;
    fill: rgba(227,30,36,0.7);
    flex-shrink: 0;
}
.am-header-stat-label {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 500;
    color: rgba(255,255,255,0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
}
.am-header-stat-value {
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: rgba(255,255,255,0.75);
}
.am-header-stat-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    flex-shrink: 0;
}
.am-header-line { display: none; }

/* ── Layout wrapper ─────────────────────── */
.am-layout {
    display: flex;
    gap: 32px;
    align-items: flex-start;
}
@media (max-width: 900px) {
    .am-layout { flex-direction: column; }
}

@media (max-width: 768px) {
    /* Responsive advanced header */
    .am-header-top {
        flex-direction: column;
        align-items: flex-start;
        padding: 24px 20px 20px;
        gap: 16px;
    }
    .am-header-divider {
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.14) 50%, transparent);
    }
    .am-header-meta {
        align-items: flex-start;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }
    .am-header-stats {
        padding: 0 20px;
        flex-wrap: wrap;
    }
    .am-header-stat {
        padding: 10px 10px 10px 0;
        margin-right: 10px;
    }
    .am-page-title {
        font-size: 26px;
        flex-wrap: wrap;
        gap: 12px;
        line-height: 1.2;
    }
    .am-header-watermark {
        font-size: 72px;
        right: -10px;
        top: 10px;
        transform: none;
    }
}

/* ── Article grid ───────────────────────── */
.am-grid-area {
    flex: 1;
    min-width: 0;
}
.am-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    padding-bottom: 48px;
    align-items: start;
}
@media (max-width: 1200px) { .am-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .am-grid { grid-template-columns: 1fr; gap: 18px; } }

/* ── Article card ───────────────────────── */
.am-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
    height: 100%;
    position: relative;
}

/* Premium Hover Popup Styles */
.article-preview-popup { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.95); width: 340px; background: #fff; border-radius: 16px; box-shadow: 0 16px 48px rgba(0,0,0,0.3); border: 1px solid rgba(0,0,0,0.05); padding: 16px; opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); z-index: 100; }
.am-card-link:hover .article-preview-popup { opacity: 1; visibility: visible; transform: translate(-50%, -50%) scale(1.05); }
.article-preview-popup-img { width: 100%; height: 180px; object-fit: cover; border-radius: 12px; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
.article-preview-popup-content { padding: 0 4px; }
.article-preview-popup-title { font-family: "Poppins", "Noto Nastaliq Urdu", sans-serif; font-size: 16px; font-weight: 700; line-height: 2.2; color: #111; margin: 0 0 8px; text-align: right; unicode-bidi: plaintext; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.article-preview-popup-time { font-family: "Inter", sans-serif; font-size: 12px; color: #888; margin: 0; font-weight: 500; text-transform: uppercase; text-align: right; letter-spacing: 0.5px; }

.am-card {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.07);
    box-shadow: 0 1px 4px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.05);
    transition: transform 280ms cubic-bezier(.22,.68,0,1.2),
                box-shadow 280ms ease,
                border-color 280ms ease;
    height: 100%;
}
.am-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(0,0,0,0.12), 0 6px 16px rgba(0,0,0,0.07);
    border-color: rgba(227,30,36,0.15);
}

/* image wrapper */
.am-card-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #eef0f3;
    flex-shrink: 0;
}
.am-card-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 500ms cubic-bezier(.25,.8,.25,1);
}
.am-card:hover .am-card-img-wrap img {
    transform: scale(1.06);
}
/* category pill over image */
.am-card-cat-pill {
    position: absolute;
    top: 10px;
    left: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 9.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.8px;
    color: #ffffff;
    background: linear-gradient(135deg, #e31e24 0%, #b8151a 100%);
    padding: 4px 9px;
    border-radius: 5px;
    box-shadow: 0 3px 10px rgba(227,30,36,0.45);
    line-height: 1.4;
}
/* dark gradient scrim at bottom of image */
.am-card-img-wrap::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 80px;
    background: linear-gradient(to top, rgba(0,0,0,0.35) 0%, transparent 100%);
    pointer-events: none;
}

/* card body */
.am-card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 16px 18px 14px;
    gap: 7px;
    text-align: left;
}
.am-card-title {
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: #0f0f0f;
    line-height: 1.5;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 220ms ease;
    letter-spacing: -0.1px;
}
.am-card:hover .am-card-title { color: #c8141a; }

.am-card-excerpt {
    font-family: 'Inter', sans-serif;
    font-size: 12.5px;
    color: #777;
    line-height: 1.65;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
    text-align: left;
}

/* card footer */
.am-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 18px 12px;
    border-top: 1px solid rgba(0,0,0,0.06);
    background: #fafafa;
    gap: 8px;
    flex-wrap: wrap;
}
.am-card-meta {
    display: flex;
    align-items: center;
    gap: 12px;
}
.am-meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    color: #999;
    font-weight: 500;
    white-space: nowrap;
}
.am-meta-item svg {
    width: 12px;
    height: 12px;
    fill: #bbb;
    flex-shrink: 0;
}
/* READ CTA — pill style */
.am-read-cta {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 700;
    color: #e31e24;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border: 1px solid rgba(227,30,36,0.25);
    border-radius: 50px;
    background: rgba(227,30,36,0.04);
    transition: background 200ms ease, border-color 200ms ease, gap 180ms ease;
    white-space: nowrap;
}
.am-read-cta::after {
    content: '→';
    font-size: 11px;
    transition: transform 200ms ease;
}
.am-card:hover .am-read-cta {
    background: #e31e24;
    border-color: #e31e24;
    color: #fff;
    gap: 7px;
}
.am-card:hover .am-read-cta::after { transform: translateX(2px); }

/* empty state */
.am-empty {
    text-align: center;
    padding: 80px 24px;
    color: #888;
    font-family: 'Inter', sans-serif;
    font-size: 15px;
}

/* ── Sidebar ────────────────────────────── */
.am-sidebar {
    width: 300px;
    flex-shrink: 0;
    position: sticky;
    top: 80px;
}
@media (max-width: 900px) {
    .am-sidebar { width: 100%; position: static; }
}

.am-sidebar-card {
    background: #ffffff;
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04);
}
/* dark header with subtle pattern */
.am-sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 20px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    background: #111111;
    background-image:
        repeating-linear-gradient(
            45deg,
            rgba(255,255,255,0.015) 0px,
            rgba(255,255,255,0.015) 1px,
            transparent 1px,
            transparent 8px
        );
    position: relative;
    overflow: hidden;
}
.am-sidebar-header::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, #e31e24 0%, #ff6b6b 60%, transparent 100%);
}
.am-sidebar-accent {
    width: 3px;
    height: 18px;
    background: linear-gradient(180deg, #e31e24, #ff6b6b);
    border-radius: 2px;
    flex-shrink: 0;
    box-shadow: 0 0 8px rgba(227,30,36,0.6);
}
.am-sidebar-title {
    font-family: 'Inter', sans-serif;
    font-size: 10.5px;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0;
}
.am-sidebar-body {
    display: flex;
    flex-direction: column;
    padding: 4px 0 8px;
}
/* trending item */
.am-trending-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 18px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    text-decoration: none;
    color: inherit;
    transition: background 180ms ease, border-left-color 180ms ease;
    position: relative;
    border-left: 3px solid transparent;
}
.am-trending-item:last-child { border-bottom: none; }
.am-trending-item:hover {
    background: rgba(227,30,36,0.03);
    border-left-color: #e31e24;
}
.am-trending-item:hover .am-trending-headline { color: #c8141a; }

/* numbered badge */
.am-trending-rank {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 800;
    color: #ddd;
    line-height: 1.5;
    flex-shrink: 0;
    width: 22px;
    text-align: center;
    padding-top: 1px;
}
.am-trending-item:hover .am-trending-rank {
    color: #e31e24;
}
.am-trending-content {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
    min-width: 0;
}
.am-trending-headline {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.5;
    transition: color 180ms ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.am-trending-time {
    font-family: 'Inter', sans-serif;
    font-size: 10.5px;
    color: #bbb;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}
.am-trending-time::before {
    content: '';
    display: inline-block;
    width: 3px;
    height: 3px;
    background: #e31e24;
    border-radius: 50%;
    flex-shrink: 0;
}
</style>

<section id="app" class="section bg-primary has-border-bottom am-articles-page">
    <div class="container">

        {{-- ── Page Header — Advanced Editorial Banner ── --}}
        <div class="am-page-header">
            <div class="am-page-header-inner">

            {{-- Top zone --}}
            <div class="am-header-top">
                {{-- Ghosted watermark --}}
                <span class="am-header-watermark">AEM</span>

                {{-- Left: eyebrow + title --}}
                <div class="am-page-title-wrap">
                    <span class="am-page-eyebrow">Akhbar-e-Mashriq</span>
                    <h2 class="am-page-title">
                        {{ isset($selected_category) ? $selected_category->name_en : 'Latest Articles' }}
                        <span class="am-feed-badge">Live Feed</span>
                    </h2>
                </div>

                {{-- Divider --}}
                <div class="am-header-divider"></div>

                {{-- Right: date + tag --}}
                <div class="am-header-meta">
                    <span class="am-header-meta-date">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM13 12V7H11V14H17V12H13Z"/></svg>
                        @{{ currentDate || '...' }}
                    </span>
                    <span class="am-header-meta-tag">Editorial</span>
                </div>
            </div>

            {{-- Bottom stats bar --}}
            <div class="am-header-stats">
                <div class="am-header-stat">
                    <svg class="am-header-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C9.23858 13 7 10.7614 7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13Z"/></svg>
                    <span class="am-header-stat-label">Articles</span>
                    <span class="am-header-stat-value">{{ count($articles) }}+</span>
                </div>
                <div class="am-header-stat-dot"></div>
                <div class="am-header-stat">
                    <svg class="am-header-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"/></svg>
                    <span class="am-header-stat-label">Category</span>
                    <span class="am-header-stat-value">{{ isset($selected_category) ? $selected_category->name_en : 'All News' }}</span>
                </div>
            </div>

            </div>{{-- /.am-page-header-inner --}}
        </div>

        {{-- ── Two-column layout ───────────────────── --}}
        <div class="am-layout">

            {{-- ─── Main article grid ───────────────── --}}
            <div class="am-grid-area">

                @if (count($articles) > 0)
                    <div class="am-grid">

                        {{-- Server-rendered first batch --}}
                        @foreach ($articles as $a)
                            <a href="{{ $a->article_url }}" class="am-card-link">
                                <div class="article-preview-popup">
                                    <img class="article-preview-popup-img" src="{{$a->image_url}}" alt="{{$a->title}}" loading="lazy">
                                    <div class="article-preview-popup-content">
                                        <h4 class="article-preview-popup-title">{{$a->title}}</h4>
                                        <p class="article-preview-popup-time">{{$a->created_at->diffForHumans()}}</p>
                                    </div>
                                </div>
                                <article class="am-card">
                                    <div class="am-card-img-wrap">
                                        <img src="{{ $a->image_sm_url }}" alt="{{ $a->title }}" loading="lazy">
                                        <span class="am-card-cat-pill">{{ $a->category->name }}</span>
                                    </div>
                                    <div class="am-card-body">
                                        <p class="am-card-title">{{ $a->title }}</p>
                                        <p class="am-card-excerpt">{{ $a->content_short }}</p>
                                    </div>
                                    <div class="am-card-footer">
                                        <div class="am-card-meta">
                                            <span class="am-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"/></svg>
                                                {{ $a->views }}
                                            </span>
                                            <span class="am-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z"/></svg>
                                                {{ date("d M Y", strtotime($a->created_at)) }}
                                            </span>
                                        </div>
                                        <span class="am-read-cta">Read</span>
                                    </div>
                                </article>
                            </a>
                        @endforeach

                        {{-- Vue-rendered subsequent pages --}}
                        <template v-for="a in articles">
                            <a :href="a.article_url" class="am-card-link">
                                <div class="article-preview-popup">
                                    <img class="article-preview-popup-img" :src="a.image_url" :alt="a.title" loading="lazy">
                                    <div class="article-preview-popup-content">
                                        <h4 class="article-preview-popup-title">@{{a.title}}</h4>
                                        <p class="article-preview-popup-time">@{{showDate(a.created_at)}}</p>
                                    </div>
                                </div>
                                <article class="am-card">
                                    <div class="am-card-img-wrap">
                                        <img :src="a.image_sm_url" :alt="a.title" loading="lazy">
                                        <span class="am-card-cat-pill">@{{ a.category.name_en }}</span>
                                    </div>
                                    <div class="am-card-body">
                                        <p class="am-card-title">@{{ a.title }}</p>
                                        <p class="am-card-excerpt">@{{ a.content_short }}</p>
                                    </div>
                                    <div class="am-card-footer">
                                        <div class="am-card-meta">
                                            <span class="am-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"/></svg>
                                                @{{ a.views }}
                                            </span>
                                            <span class="am-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z"/></svg>
                                                @{{ showDate(a.created_at) }}
                                            </span>
                                        </div>
                                        <span class="am-read-cta">Read</span>
                                    </div>
                                </article>
                            </a>
                        </template>

                    </div>{{-- /.am-grid --}}
                @else
                    <div class="am-empty">
                        <p>No content found for the requested article(s).</p>
                    </div>
                @endif

            </div>{{-- /.am-grid-area --}}

            {{-- ─── Sticky Sidebar ──────────────────── --}}
            <aside class="am-sidebar">
            @php
                $show_ad = false;
                $ad_slot = '';
                if (!isset($selected_category)) {
                    $show_ad = true; // Latest Articles
                    $ad_slot = '9510848453';
                } else {
                    $cat_name = strtolower(trim($selected_category->name_en));
                    if ($cat_name === 'kolkata' || $cat_name === 'bengal') {
                        $show_ad = true;
                        $ad_slot = '9510848453';
                    } elseif ($cat_name === 'national' || $cat_name === 'international' || $cat_name === 'sports') {
                        $show_ad = true;
                        $ad_slot = '1632358432';
                    } elseif ($cat_name === 'activities' || $cat_name === 'entertainment') {
                        $show_ad = true;
                        $ad_slot = '8391685392';
                    }
                }
            @endphp
            
            @if($show_ad)
                {{-- Premium Ad Box --}}
                <div class="am-sidebar-card">
                    <div class="am-sidebar-header">
                        <div class="am-sidebar-accent"></div>
                        <h3 class="am-sidebar-title">Sponsorship</h3>
                    </div>
                    <div class="am-sidebar-body" style="padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 250px; background: #fafafa;">
                        <!-- dynamic ad slot -->
                        <ins class="adsbygoogle"
                             style="display:block; width:100%;"
                             data-ad-client="ca-pub-9409984276673694"
                             data-ad-slot="{{ $ad_slot }}"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                    </div>
                </div>
            @endif

            {{-- Trending Articles Box --}}
            <div class="am-sidebar-card" style="margin-top: {{ $show_ad ? '24px' : '0' }};">
                    <div class="am-sidebar-header">
                        <div class="am-sidebar-accent"></div>
                        <h3 class="am-sidebar-title">Trending Articles</h3>
                    </div>
                    <div class="am-sidebar-body">
                        @if (count($trending_articles) > 0)
                            @foreach ($trending_articles as $i => $ta)
                                <a href="{{ $ta->article_url }}" class="am-trending-item">
                                    <span class="am-trending-rank">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="am-trending-content">
                                        <p class="am-trending-headline">{{ $ta->title }}</p>
                                        <span class="am-trending-time">{{ $ta->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p style="padding: 20px; font-size: 13px; color: #aaa; font-family: Inter, sans-serif;">No articles trending today.</p>
                        @endif
                    </div>
                </div>
            </aside>

        </div>{{-- /.am-layout --}}

    </div>{{-- /.container --}}
</section>

@endsection

@section('vue_app')
<script>
    // Initialize Adsense
    (window.adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
const app = new Vue({
    el: "#app",
    data: {
        articles: [],
        page: 1,
        isProcessing: false,
        selectedCategoryId: "{{ isset($selected_category) ? $selected_category->id : null }}",
        currentDate: "",
    },

    created() {
        this.updateDateTime();
        setInterval(this.updateDateTime, 60000); // update every minute
    },

    methods: {
        updateDateTime() {
            const now = new Date();
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            this.currentDate = now.toLocaleDateString('en-GB', options);
        },
        fetchArticles(page = 1, callback) {
            let params = new URLSearchParams({
                latest: true,
                page: this.page,
                items: 20
            });

            if (this.selectedCategoryId) {
                params.append('category_id', this.selectedCategoryId);
            }
            const url = `/api/articles?${params.toString()}`;

            const options = {
                method: "GET",
                headers: {
                    "content-type": "application/json",
                    "accept": "application/json",
                },
            };
            this.isProcessing = true;
            fetch(url, options).then((res) => {
                return res.json();
            }).then((data) => {
                data.data.forEach((item) => {
                    this.articles.push(item);
                });
            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.isProcessing = false;
                callback();
            });
        },

        activateAutoFetchOnScrollToBottom() {
            document.addEventListener("scroll", (event) => {
                const totalPageHeight = document.body.clientHeight;
                const lastKnownScrollPosition = window.scrollY;

                if ((totalPageHeight - lastKnownScrollPosition) <= window.innerHeight) {
                    this.page += 1;
                    if (!this.isProcessing) {
                        this.fetchArticles(this.page, () => {
                            window.scrollTo({top: lastKnownScrollPosition});
                        });
                    }
                }
            });
        },

        showDate(timestampString) {
            const d = new Date(timestampString);
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        }
    },

    mounted() {
        this.activateAutoFetchOnScrollToBottom();
    },
});
</script>
@endsection
