@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Trending Videos', 'ltr' => true])

@section('content')

<style>
/* ── Google Font import ─────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap');

/* ── Section header — Advanced Editorial Banner ── */
.am-page-header {
    margin-bottom: 44px;
    border-radius: 19px;
    padding: 2.5px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.28), 0 2px 8px rgba(0,0,0,0.18);
    background: rgba(255,255,255,0.03);
}
.am-page-header::before {
    content: ''; position: absolute; top: 50%; left: 50%; width: 150%; height: 400%;
    background: conic-gradient(from 0deg, transparent 40%, #e31e24 80%, #ffffff 95%, transparent 100%);
    transform: translate(-50%, -50%) rotate(0deg); animation: am-border-spin 3.5s linear infinite; z-index: 0;
}
.am-page-header::after {
    content: ''; position: absolute; top: 50%; left: 50%; width: 150%; height: 400%;
    background: conic-gradient(from 0deg, transparent 40%, rgba(227,30,36,0.8) 80%, rgba(255,100,100,0.9) 95%, transparent 100%);
    transform: translate(-50%, -50%) rotate(0deg); animation: am-border-spin 3.5s linear infinite; z-index: 0; filter: blur(14px); opacity: 1;
}
@keyframes am-border-spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); } 100% { transform: translate(-50%, -50%) rotate(360deg); }
}
.am-page-header-inner {
    display: flex; flex-direction: column; gap: 0; background: #080808; border-radius: 17.5px;
    position: relative; z-index: 1; overflow: hidden;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.06), inset 0 0 60px rgba(227,30,36,0.06);
}
.am-header-top {
    display: flex; align-items: center; justify-content: space-between; gap: 24px; padding: 28px 40px 24px;
    background: #0a0a0a;
    background-image: radial-gradient(ellipse at 0% 50%, rgba(227,30,36,0.12) 0%, transparent 55%), radial-gradient(ellipse at 100% 50%, rgba(100,0,0,0.08) 0%, transparent 55%), repeating-linear-gradient(-50deg, transparent, transparent 4px, rgba(255,255,255,0.012) 4px, rgba(255,255,255,0.012) 5px);
    position: relative; overflow: hidden;
}
@keyframes am-shimmer {
    0% { transform: translateX(-100%) skewX(-15deg); } 100% { transform: translateX(400%) skewX(-15deg); }
}
.am-header-top::before {
    content: ''; position: absolute; top: 0; bottom: 0; left: 0; width: 80px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.04), transparent);
    animation: am-shimmer 5s ease-in-out infinite; pointer-events: none;
}
.am-header-top::after {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent 0%, #e31e24 15%, #ff5c5c 40%, #ff8080 50%, #ff5c5c 60%, #e31e24 85%, transparent 100%);
    box-shadow: 0 0 18px rgba(227,30,36,0.7), 0 0 4px rgba(255,100,100,0.4);
}
.am-header-divider {
    width: 1px; height: 52px; background: linear-gradient(180deg, transparent 0%, rgba(255,255,255,0.14) 25%, rgba(255,255,255,0.14) 75%, transparent 100%); flex-shrink: 0;
}
.am-page-title-wrap {
    display: flex; flex-direction: column; gap: 8px; flex: 1; min-width: 0;
}
.am-page-eyebrow {
    font-family: 'Inter', sans-serif; font-size: 8.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 3.5px; color: rgba(227,30,36,0.85); display: flex; align-items: center; gap: 10px;
}
.am-page-eyebrow::before {
    content: ''; display: inline-block; width: 24px; height: 1.5px; background: linear-gradient(90deg, #e31e24, #ff5c5c); border-radius: 1px; box-shadow: 0 0 8px rgba(227,30,36,0.6);
}
.am-page-title {
    margin: 0; font-family: 'Poppins', sans-serif; font-size: 32px; font-weight: 800; color: #ffffff; letter-spacing: -1.2px; line-height: 1; display: flex; align-items: center; gap: 16px; text-shadow: 0 2px 20px rgba(0,0,0,0.5);
}
.am-header-watermark {
    position: absolute; right: 36px; top: 50%; transform: translateY(-50%); font-family: 'Poppins', sans-serif; font-size: 110px; font-weight: 900; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,0.04); line-height: 1; letter-spacing: -6px; pointer-events: none; user-select: none; white-space: nowrap;
}
.am-feed-badge {
    font-family: 'Inter', sans-serif; font-size: 8px; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 2px; padding: 5px 14px; background: linear-gradient(135deg, #e31e24 0%, #9e0d12 100%); border-radius: 50px; border: 1px solid rgba(255,100,100,0.25); box-shadow: 0 0 0 4px rgba(227,30,36,0.12), 0 0 0 1px rgba(227,30,36,0.4), 0 6px 18px rgba(227,30,36,0.45); display: inline-flex; align-items: center; gap: 7px; flex-shrink: 0;
}
.am-feed-badge::before {
    content: ''; display: inline-block; width: 6px; height: 6px; background: #fff; border-radius: 50%; animation: am-pulse 1.2s ease-in-out infinite; box-shadow: 0 0 8px rgba(255,255,255,0.8);
}
@keyframes am-pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.15; transform: scale(0.4); } }
.am-header-meta {
    display: flex; flex-direction: column; align-items: flex-end; gap: 5px; flex-shrink: 0;
}
.am-header-meta-date {
    font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 500; color: rgba(255,255,255,0.4); display: flex; align-items: center; gap: 6px; letter-spacing: 0.2px;
}
.am-header-meta-date svg { width: 12px; height: 12px; fill: rgba(255,255,255,0.22); }
.am-header-meta-tag {
    font-family: 'Inter', sans-serif; font-size: 8px; font-weight: 700; color: rgba(255,255,255,0.18); text-transform: uppercase; letter-spacing: 2px; padding: 2px 8px; border: 1px solid rgba(255,255,255,0.06); border-radius: 3px;
}
.am-header-stats {
    display: flex; align-items: center; gap: 0; background: rgba(255,255,255,0.025); border-top: 1px solid rgba(255,255,255,0.05); padding: 0 40px;
}
.am-header-stat {
    display: flex; align-items: center; gap: 8px; padding: 12px 20px 12px 0; margin-right: 20px; border-right: 1px solid rgba(255,255,255,0.05); flex-shrink: 0;
}
.am-header-stat:last-child { border-right: none; }
.am-header-stat-icon { width: 14px; height: 14px; fill: rgba(227,30,36,0.7); flex-shrink: 0; }
.am-header-stat-label { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 500; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1px; }
.am-header-stat-value { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.75); }
.am-header-stat-dot { width: 4px; height: 4px; border-radius: 50%; background: rgba(255,255,255,0.08); flex-shrink: 0; }

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

.am-grid-area {
    flex: 1;
    min-width: 0;
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
    line-height: 2.2;
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

.am-video-card { background: #0f172a; border-radius: 24px; overflow: hidden; box-shadow: 0 15px 40px -10px rgba(0,0,0,0.2), 0 5px 15px rgba(0,0,0,0.1); transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1); display: flex; flex-direction: column; position: relative; min-height: 380px; }
.am-video-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 35px 60px -15px rgba(0,0,0,0.4), 0 20px 30px -10px rgba(0,0,0,0.3); }
.am-video-link { text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; position: relative; z-index: 2; }
.am-video-thumb-wrap { position: absolute; inset: 0; width: 100%; height: 100%; background-color: #0f172a; background-position: center; background-size: cover; background-repeat: no-repeat; z-index: 0; }
.am-video-thumb-wrap::before { content: ''; position: absolute; inset: 0; background: inherit; filter: blur(2px) scale(1.05); transition: transform 0.8s ease; z-index: 0; }
.am-video-card:hover .am-video-thumb-wrap::before { transform: scale(1.1); }
.am-video-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.6) 40%, rgba(15,23,42,0.1) 100%); transition: opacity 0.5s ease; z-index: 1; }
.am-video-card:hover .am-video-overlay { background: linear-gradient(to top, rgba(15,23,42,1) 0%, rgba(15,23,42,0.7) 50%, rgba(15,23,42,0.2) 100%); }
.am-video-play-btn { position: absolute; top: 35%; left: 50%; transform: translate(-50%, -50%); z-index: 2; width: 64px; height: 64px; background: rgba(255,255,255,0.2); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(0,0,0,0.3), inset 0 0 0 1px rgba(255,255,255,0.5); color: #fff; transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1); }
.am-video-play-btn::before { content: ''; position: absolute; inset: -4px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.4); opacity: 0; transform: scale(0.8); transition: all 0.5s ease; pointer-events: none; }
.am-video-card:hover .am-video-play-btn { background: #ffffff; color: #0f172a; transform: translate(-50%, -50%) scale(1.1); box-shadow: 0 15px 35px rgba(0,0,0,0.4), inset 0 0 0 1px rgba(255,255,255,1); }
.am-video-card:hover .am-video-play-btn::before { opacity: 1; transform: scale(1); animation: ping-play 2s cubic-bezier(0, 0, 0.2, 1) infinite; }
@keyframes ping-play { 75%, 100% { transform: scale(1.5); opacity: 0; } }
.am-video-play-btn svg { width: 28px; height: 28px; margin-left: 4px; fill: currentColor; }
.am-video-duration { position: absolute; top: 20px; right: 20px; z-index: 2; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: #fff; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; padding: 8px 16px; border-radius: 30px; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 15px rgba(0,0,0,0.2), inset 0 0 0 1px rgba(255,255,255,0.15); transition: all 0.3s ease; }
.am-video-card:hover .am-video-duration { background: #ffffff; color: #0f172a; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
.am-video-duration svg { width: 14px; height: 14px; fill: currentColor; }
.am-video-content { margin-top: auto; padding: 30px; text-align: left; display: flex; flex-direction: column; z-index: 2; position: relative; }
.am-video-title { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 800; color: #ffffff; line-height: 2.2; margin: 0 0 12px 0; letter-spacing: -0.2px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.4s ease; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
.am-video-card:hover .am-video-title { color: #38bdf8; }
.am-video-desc { font-family: 'Inter', sans-serif; font-size: 14.5px; color: #cbd5e1; margin: 0 0 24px 0; line-height: 2.2; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-weight: 400; }
.am-video-meta { display: flex; align-items: center; gap: 8px; }
.am-video-time { font-family: 'Inter', sans-serif; font-size: 12px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
.am-video-time::before { content: ''; width: 6px; height: 6px; background: #38bdf8; border-radius: 50%; display: block; box-shadow: 0 0 8px rgba(56,189,248,0.5); transition: all 0.4s ease; }
.am-video-card:hover .am-video-time::before { background: #7dd3fc; box-shadow: 0 0 12px rgba(125,211,252,0.8); }
</style>

<section class="section has-border-bottom" style="min-height: 60vh; padding: 60px 0; background: #f3f4f7;">
	<div class="container">
        
        {{-- ── Page Header — Advanced Editorial Banner ── --}}
        <div class="am-page-header">
            <div class="am-page-header-inner">
            <div class="am-header-top">
                <span class="am-header-watermark">AEM</span>
                <div class="am-page-title-wrap">
                    <span class="am-page-eyebrow">Akhbar-e-Mashriq</span>
                    <h2 class="am-page-title">
                        Trending Videos
                        <span class="am-feed-badge">Live Feed</span>
                    </h2>
                </div>
                <div class="am-header-divider"></div>
                <div class="am-header-meta">
                    <span class="am-header-meta-date">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM13 12V7H11V14H17V12H13Z"/></svg>
                        {{ date('d M Y') }}
                    </span>
                    <span class="am-header-meta-tag">Editorial</span>
                </div>
            </div>
            <div class="am-header-stats">
                <div class="am-header-stat">
                    <svg class="am-header-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C9.23858 13 7 10.7614 7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13Z"/></svg>
                    <span class="am-header-stat-label">Videos</span>
                    <span class="am-header-stat-value">{{ count($videos) }}</span>
                </div>
                <div class="am-header-stat-dot"></div>
                <div class="am-header-stat">
                    <svg class="am-header-stat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"/></svg>
                    <span class="am-header-stat-label">Category</span>
                    <span class="am-header-stat-value">Trending</span>
                </div>
            </div>
            </div>
        </div>

        <div class="am-layout">
            <div class="am-grid-area">
                <div class="section-text" style="text-align: center; margin: 0 auto; width: 100%;">
                    <div style="margin-top: 20px;">
                        <!-- Placeholder for video grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                            @forelse($videos as $video)
                            <div class="am-video-card">
                                <a href="{{ $video->video_url }}" onclick="openVideoModal('{{ $video->video_url }}', '{{ addslashes($video->title) }}', event)" class="am-video-link">
                                    <div class="am-video-thumb-wrap" style="background-image: url('{{ $video->thumbnail_url }}');">
                                        <div class="am-video-overlay"></div>
                                    </div>
                                    <div class="am-video-play-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 3L19 12L5 21V3Z" fill="currentColor"></path></svg>
                                    </div>
                                    <div class="am-video-duration">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 9.2L21 6V18L17 14.8V19C17 19.5523 16.5523 20 16 20H4C3.44772 20 3 19.5523 3 19V5C3 4.44772 3.44772 4 4 4H16C16.5523 4 17 4.44772 17 5V9.2ZM15 10.3243V6H5V18H15V13.6757L19 16.5514V7.44855L15 10.3243Z"></path></svg>
                                        Watch Now
                                    </div>
                                    <div class="am-video-content">
                                        <h3 class="am-video-title">{{ $video->title }}</h3>
                                        @if($video->description)
                                        <p class="am-video-desc">{{ Str::limit($video->description, 80) }}</p>
                                        @endif
                                        <div class="am-video-meta">
                                            <span class="am-video-time">{{ $video->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @empty
                            <!-- Video Skeleton Card 1 -->
                            <div class="am-video-card">
                                <div class="am-video-thumb-wrap" style="background: #334155;">
                                    <div class="am-video-overlay" style="background: linear-gradient(to top, rgba(15,23,42,0.95), rgba(15,23,42,0.2));"></div>
                                </div>
                                <div class="am-video-content">
                                    <div style="height: 20px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-bottom: 12px; width: 85%;"></div>
                                    <div style="height: 16px; background: rgba(255,255,255,0.1); border-radius: 4px; margin-bottom: 24px; width: 60%;"></div>
                                    <div class="am-video-meta"><div style="height: 14px; background: rgba(255,255,255,0.1); border-radius: 4px; width: 40%;"></div></div>
                                </div>
                            </div>
                            <!-- Video Skeleton Card 2 -->
                            <div class="am-video-card">
                                <div class="am-video-thumb-wrap" style="background: #334155;">
                                    <div class="am-video-overlay" style="background: linear-gradient(to top, rgba(15,23,42,0.95), rgba(15,23,42,0.2));"></div>
                                </div>
                                <div class="am-video-content">
                                    <div style="height: 20px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-bottom: 12px; width: 95%;"></div>
                                    <div style="height: 16px; background: rgba(255,255,255,0.1); border-radius: 4px; margin-bottom: 24px; width: 75%;"></div>
                                    <div class="am-video-meta"><div style="height: 14px; background: rgba(255,255,255,0.1); border-radius: 4px; width: 50%;"></div></div>
                                </div>
                            </div>
                            <!-- Video Skeleton Card 3 -->
                            <div class="am-video-card">
                                <div class="am-video-thumb-wrap" style="background: #334155;">
                                    <div class="am-video-overlay" style="background: linear-gradient(to top, rgba(15,23,42,0.95), rgba(15,23,42,0.2));"></div>
                                </div>
                                <div class="am-video-content">
                                    <div style="height: 20px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-bottom: 12px; width: 80%;"></div>
                                    <div style="height: 16px; background: rgba(255,255,255,0.1); border-radius: 4px; margin-bottom: 24px; width: 50%;"></div>
                                    <div class="am-video-meta"><div style="height: 14px; background: rgba(255,255,255,0.1); border-radius: 4px; width: 35%;"></div></div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <aside class="am-sidebar">
                <div class="am-sidebar-card">
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
        </div>

	</div>
</section>

<section class="section bg-primary pt-0" style="padding-bottom: 80px;">
	<div class="container">
		<div class="pop-header" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
			<h2 class="pop-title" style="font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 800; color: #111; margin: 0; letter-spacing: 0.5px; text-transform: uppercase;">Past Popular Articles</h2>
			<a class="section-header-cta-button" href="/articles?past_popular" style="text-decoration: none; display: flex; align-items: center; gap: 4px;">
				<span class="section-header-cta-text" style="font-family: 'Inter', sans-serif; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #111;">view more</span>
				<svg class="section-header-cta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: #111;"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
			</a>
		</div>
		<style>
			/* === PPA Split Panel === */
			.ppa-split { display: grid; grid-template-columns: 3fr 2fr; gap: 0; border-radius: 20px; overflow: hidden; background: #fff; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.04); margin-top: 24px; min-height: 520px; }
			@media (max-width: 768px) { 
                .ppa-split { grid-template-columns: 1fr; }
                .ppa-featured-body { padding: 20px; }
                .ppa-featured-title { font-size: 20px; }
                .ppa-list-panel { max-height: 400px; }
                .ppa-featured { min-height: 350px !important; }
            }
			/* Left: Featured panel */
			.ppa-featured { position: relative; overflow: hidden; }
			.ppa-featured-img-wrap { position: absolute; inset: 0; }
			.ppa-featured-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1); display: block; }
			.ppa-featured-gradient { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.05) 100%); }
			.ppa-featured-body { position: absolute; bottom: 0; left: 0; right: 0; padding: 40px 36px; text-align: right; }
			.ppa-featured-badge { display: inline-flex; align-items: center; gap: 6px; background: #e31e24; color: #fff; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 12px; border-radius: 4px; margin-bottom: 16px; }
			.ppa-featured-title { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 800; color: #fff; line-height: 2.2; margin: 0 0 12px 0; text-shadow: 0 2px 10px rgba(0,0,0,0.5); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: opacity 0.4s ease; }
			.ppa-featured-meta { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px; }
			.ppa-read-btn { display: inline-flex; align-items: center; gap: 8px; margin-top: 20px; padding: 10px 22px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; color: #fff; text-decoration: none; letter-spacing: 0.8px; text-transform: uppercase; transition: all 0.3s ease; }
			.ppa-read-btn:hover { background: rgba(255,255,255,0.3); }
			/* Right: Article list */
			.ppa-list-panel { position: relative; display: flex; flex-direction: column; overflow-y: auto; max-height: 520px; scrollbar-width: thin; scrollbar-color: #e5e5e5 transparent; }
			.ppa-list-panel::-webkit-scrollbar { width: 4px; }
			.ppa-list-panel::-webkit-scrollbar-thumb { background: #e5e5e5; border-radius: 4px; }
			.ppa-panel-item { display: flex; align-items: center; gap: 14px; padding: 16px 20px; border-bottom: 1px solid rgba(0,0,0,0.05); cursor: pointer; transition: all 0.25s ease; flex-direction: row-reverse; text-decoration: none; flex-shrink: 0; }
			.ppa-panel-item:last-child { border-bottom: none; }
			.ppa-panel-item:hover { background: rgba(0,0,0,0.02); }
			.ppa-panel-item.ppa-active { background: #fef2f2; border-right: 3px solid #e31e24; }
			.ppa-panel-thumb { width: 76px; height: 58px; border-radius: 8px; overflow: hidden; flex-shrink: 0; position: relative; }
			.ppa-panel-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
			.ppa-panel-item:hover .ppa-panel-thumb img { transform: scale(1.08); }
			.ppa-panel-content { flex: 1; text-align: right; }
			.ppa-panel-title { font-family: 'Playfair Display', serif; font-size: 13px; font-weight: 700; color: #111; line-height: 2.2; margin: 0 0 5px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s; }
			.ppa-panel-item.ppa-active .ppa-panel-title { color: #e31e24; }
			.ppa-panel-meta { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.8px; }
			.ppa-panel-num { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 800; color: #ccc; min-width: 18px; text-align: center; }
			.ppa-panel-item.ppa-active .ppa-panel-num { color: #e31e24; }
            .pop-header::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 60px; height: 2px; background: #e31e24; }
            .pop-header { position: relative; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 12px; }
		</style>

		{{-- Collect all articles as JSON for JS --}}
		@php
			$ppaArticles = $past_popular_articles->map(fn($a) => [
				'url' => $a->article_url,
				'title' => $a->title,
				'image' => $a->image_url,
				'time' => $a->created_at->diffForHumans(),
			]);
		@endphp

		<div class="ppa-split" id="ppaSplit">
			{{-- Left: featured panel --}}
			<a href="#" class="ppa-featured" id="ppaFeatured" style="min-height: 520px;">
				<div class="ppa-featured-img-wrap">
					<img src="{{ count($past_popular_articles) > 0 ? $past_popular_articles[0]->image_url : '' }}" id="ppaFeaturedImg" alt="">
				</div>
				<div class="ppa-featured-gradient"></div>
				<div class="ppa-featured-body">
					<div class="ppa-featured-badge">⭐ Popular</div>
					<h2 class="ppa-featured-title" id="ppaFeaturedTitle">{{ count($past_popular_articles) > 0 ? $past_popular_articles[0]->title : '' }}</h2>
					<div class="ppa-featured-meta" id="ppaFeaturedMeta">{{ count($past_popular_articles) > 0 ? $past_popular_articles[0]->created_at->diffForHumans() : '' }}</div>
					<span class="ppa-read-btn">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16.172 11l-4.95-4.95 1.414-1.414L20 12l-7.364 7.364-1.414-1.414L16.172 13H4v-2z"/></svg>
						<span>Read Article</span>
					</span>
				</div>
			</a>
			{{-- Right: article list --}}
			<div class="ppa-list-panel" id="ppaListPanel">
				@foreach($past_popular_articles as $idx => $article)
				<div class="ppa-panel-item {{ $idx === 0 ? 'ppa-active' : '' }}" onclick="ppaSelect({{ $idx }})" data-idx="{{ $idx }}">
					<div class="ppa-panel-num">{{ sprintf('%02d', $idx + 1) }}</div>
					<div class="ppa-panel-thumb">
						<img src="{{ $article->image_sm_url }}" alt="{{ $article->title }}" loading="lazy">
					</div>
					<div class="ppa-panel-content">
						<h4 class="ppa-panel-title">{{ $article->title }}</h4>
						<div class="ppa-panel-meta">{{ $article->created_at->diffForHumans() }}</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<script>
		(function() {
			const articles = @json($ppaArticles);
			const featured = document.getElementById('ppaFeatured');
			const featuredImg = document.getElementById('ppaFeaturedImg');
			const featuredTitle = document.getElementById('ppaFeaturedTitle');
			const featuredMeta = document.getElementById('ppaFeaturedMeta');
			const items = document.querySelectorAll('#ppaListPanel .ppa-panel-item');
			let current = 0, timer = null;

			window.ppaSelect = function(idx) {
				current = idx;
				const a = articles[idx];
				// Fade out
				featuredImg.style.opacity = '0';
				featuredTitle.style.opacity = '0';
				setTimeout(function() {
					featuredImg.src = a.image;
					featuredTitle.textContent = a.title;
					featuredMeta.textContent = a.time;
					featured.href = a.url;
					// Fade in
					featuredImg.style.opacity = '1';
					featuredTitle.style.opacity = '1';
				}, 350);
				items.forEach((el, i) => el.classList.toggle('ppa-active', i === idx));
				// Scroll item into view locally within the panel, not the whole window
				const panel = document.getElementById('ppaListPanel');
				const item = items[idx];
				const itemTop = item.offsetTop;
				const itemBottom = itemTop + item.offsetHeight;
				const panelTop = panel.scrollTop;
				const panelBottom = panelTop + panel.clientHeight;

				if (itemTop < panelTop) {
					panel.scrollTo({ top: itemTop, behavior: 'smooth' });
				} else if (itemBottom > panelBottom) {
					panel.scrollTo({ top: itemBottom - panel.clientHeight, behavior: 'smooth' });
				}
			};

			// Transition styles
			featuredImg.style.transition = 'opacity 0.35s ease';
			featuredTitle.style.transition = 'opacity 0.35s ease';

			// Auto-cycle every 6 seconds
			function autoNext() { ppaSelect((current + 1) % articles.length); }
			timer = setInterval(autoNext, 6000);
			// Pause on hover
			document.getElementById('ppaSplit').addEventListener('mouseenter', function() { clearInterval(timer); });
			document.getElementById('ppaSplit').addEventListener('mouseleave', function() { timer = setInterval(autoNext, 6000); });
		})();
		</script>
	</div>
</section>

<!-- Premium Video Modal -->
<div id="videoModal" class="video-modal-overlay">
    <div class="video-modal-container">
        <div class="video-modal-header">
            <h3 class="video-modal-title" id="videoModalTitle"></h3>
            <button class="video-modal-close" onclick="closeVideoModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="video-modal-content"></div>
    </div>
</div>

<style>
.video-modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.92); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
    z-index: 99999; display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
}
.video-modal-overlay.active {
    opacity: 1; visibility: visible;
}
.video-modal-container {
    position: relative; width: 92%; max-width: 1100px;
    background: #000; border-radius: 20px;
    box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.1), 0 0 150px rgba(227, 30, 36, 0.15);
    transform: scale(0.96) translateY(30px); opacity: 0;
    transition: all 0.6s cubic-bezier(0.2, 1, 0.3, 1);
    aspect-ratio: 16 / 9;
    overflow: hidden;
    display: flex; flex-direction: column;
}
.video-modal-overlay.active .video-modal-container {
    transform: scale(1) translateY(0); opacity: 1;
}
.video-modal-header {
    padding: 24px 32px;
    background: #000;
    display: flex; align-items: center; justify-content: space-between;
    z-index: 10;
    flex-shrink: 0;
}
.video-modal-title {
    font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 600; color: #fff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.8);
    display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    margin: 0;
}
.video-modal-close {
    pointer-events: auto;
    background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff; width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.3s ease;
}
.video-modal-close:hover {
    background: #e31e24; border-color: #e31e24; transform: rotate(90deg); box-shadow: 0 0 20px rgba(227,30,36,0.6);
}
.video-modal-close svg { width: 20px; height: 20px; }
.video-modal-content {
    flex: 1; width: 100%; border-radius: 0 0 20px 20px; overflow: hidden; position: relative;
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.05);
    -webkit-overflow-scrolling: touch;
}
@media (max-width: 768px) {
    .video-modal-header { padding: 16px; }
    .video-modal-title { font-size: 16px; }
    .video-modal-close { width: 36px; height: 36px; }
    .video-modal-close svg { width: 16px; height: 16px; }
}
</style>

<script>
function openVideoModal(url, title, e) {
    if(e) e.preventDefault();
    const modal = document.getElementById('videoModal');
    const content = document.querySelector('.video-modal-content');
    const titleEl = document.getElementById('videoModalTitle');
    
    titleEl.textContent = title;

    const container = document.querySelector('.video-modal-container');

    // Check if it's YouTube
    let isYouTube = false;
    let ytId = '';
    const ytMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
    if (ytMatch && ytMatch[1]) {
        isYouTube = true;
        ytId = ytMatch[1];
    }

    // Check if it's Instagram
    let isInstagram = false;
    let instaEmbedUrl = '';
    
    let instaMatch = null;
    try {
        // Strip query parameters and hashes to get a clean URL, and remove trailing slash
        const cleanUrl = url.split('?')[0].split('#')[0].replace(/\/$/, ""); 
        
        // Match instagr.am or any subdomain of instagram.com, capturing the type (p/reel/tv) and ID
        const instaRegex = /(?:https?:\/\/)?(?:[a-zA-Z0-9-]+\.)*(?:instagram\.com|instagr\.am)\/(?:[a-zA-Z0-9_\-\.]+\/)?(p|reel|tv)\/([a-zA-Z0-9_\-]+)/i;
        instaMatch = cleanUrl.match(instaRegex);
        
        if (instaMatch) {
            isInstagram = true;
            // Always force www.instagram.com for embeds to avoid mobile/CORS bugs
            instaEmbedUrl = `https://www.instagram.com/${instaMatch[1]}/${instaMatch[2]}/embed/captioned`;
        }
    } catch(err) {
        console.error("Error parsing Instagram URL", err);
    }

    if (isInstagram) {
        container.style.aspectRatio = 'auto';
        container.style.maxWidth = '500px';
        container.style.height = '85vh';
        content.innerHTML = `
        <div style="width:100%; height:100%; background:white; overflow-y:auto; -webkit-overflow-scrolling:touch; padding: 10px 0; display: flex; flex-direction: column; align-items: center;">
            <div style="margin-bottom: 10px; width: 100%; text-align: center; padding: 10px;">
                <a href="https://www.instagram.com/${instaMatch[1]}/${instaMatch[2]}/" target="_blank" style="background:#0095f6; color:white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0,149,246,0.3);">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    Open in Instagram App
                </a>
            </div>
            <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/${instaMatch[1]}/${instaMatch[2]}/?utm_source=ig_embed" data-instgrm-version="14" style="background:#FFF; border:0; margin: 0 auto; max-width:540px; min-width:326px; padding:0; width:99%;">
            </blockquote>
        </div>`;
        
        // Load official Instagram embed script
        if (window.instgrm) {
            window.instgrm.Embeds.process();
        } else {
            const script = document.createElement('script');
            script.src = "https://www.instagram.com/embed.js";
            script.async = true;
            document.body.appendChild(script);
        }
    } else if (isYouTube) {
        container.style.aspectRatio = '16 / 9';
        container.style.maxWidth = '1100px';
        container.style.height = 'auto';
        content.innerHTML = `<iframe src="https://www.youtube.com/embed/${ytId}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%; height:100%; border-radius: 0 0 20px 20px;"></iframe>`;
    } else {
        container.style.aspectRatio = '16 / 9';
        container.style.maxWidth = '1100px';
        container.style.height = 'auto';
        content.innerHTML = `<video controls autoplay style="width:100%; height:100%; background: #000; outline: none; border-radius: 0 0 20px 20px;" src="${url}"></video>`;
    }

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const content = document.querySelector('.video-modal-content');
    modal.classList.remove('active');
    setTimeout(() => {
        content.innerHTML = '';
    }, 400);
    document.body.style.overflow = '';
}

document.getElementById('videoModal').addEventListener('click', function(e) {
    if (e.target === this) closeVideoModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('videoModal').classList.contains('active')) {
        closeVideoModal();
    }
});
</script>

@endsection
