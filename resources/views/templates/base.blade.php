<!doctype html>
<html lang="{{ lang_urdu() ? 'ur' : 'en' }}">
<head>
<title>{{ $title }}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Akhbar-E-Mashriq is a news application and website that curates the most recent and noteworthy stories from a variety of local, national, and worldwide sources, summarises them, and presents them to you in  both Urdu and Hindustani English.">
<meta name="keywords" content="News, Akhbar, Urdu News Paper, Paper, Local News, Kolkata Urdu News Paper, Akhbar-e-Mashriq">

<meta name="google-site-verification" content="wL2DFo3NDViJyOlNZI_626hWAnYu-XnFZmURA4br3cc" />
<meta name="facebook-domain-verification" content="2cv2b4thia75eq6jcy5xs4u89wzm3m" />

<link rel="icon" type="image/png" sizes="192x192" href="/favicon.png">
<link rel="stylesheet" href="/assets/css/styles.css?v=1.2.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;900&family=Inter:wght@400;600;700;900&family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9409984276673694" crossorigin="anonymous"></script>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '2034710906924811');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" alt="Meta Pixel"
src="https://www.facebook.com/tr?id=2034710906924811&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-83QRJ8EKZL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-83QRJ8EKZL');
</script>
</head>
<body class="{{!isset($ltr) && lang_urdu() ? 'layout-rtl' : ''}}">
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,400&display=swap');

/* Prevent horizontal scroll on all screen sizes */
html, body {
    overflow-x: clip;
    max-width: 100%;
}

/* Navbar Premium Styles */
.navbar {
    background-color: #ffffff !important;
    border-bottom: 1px solid #f0f0f0;
    position: sticky;
    top: 0;
    z-index: 9999;
}
.navbar .navbar-menu .navbar-menu-item .navbar-menu-item-link {
    color: #666666 !important;
    font-weight: 500 !important;
    font-family: 'Inter', Helvetica, Arial, sans-serif !important;
    font-size: 13px !important;
    letter-spacing: 0.3px;
}
.navbar .navbar-menu .navbar-menu-item .navbar-menu-item-link.is-active {
    color: #111111 !important;
    font-weight: 700 !important;
}
.navbar .navbar-menu .navbar-menu-item.is-active::after,
.navbar .navbar-menu .navbar-menu-item.is-active-transparent .navbar-menu-item-link::after {
    background-color: #e31e24 !important;
    width: 100% !important;
    height: 2px !important;
    bottom: -19px !important;
}
.navbar .navbar-menu .navbar-menu-button {
    background-color: #ff0000 !important;
}
@keyframes pulseBlink { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.2); } 100% { opacity: 1; transform: scale(1); } }
.custom-top-banner {
    border-top: 3px solid #e31e24;
    background: #ffffff;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
    font-family: 'Inter', sans-serif;
}
.custom-banner-inner {
    max-width: 1440px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
}
.custom-banner-left {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
}
.custom-banner-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 2;
}
.custom-banner-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: center;
    gap: 8px;
    flex: 1;
}
.breaking-news-bar {
    border-bottom: 1px solid #eaeaea;
    border-top: 1px solid #f9f9f9;
    background: #ffffff;
    display: flex;
    align-items: stretch;
    height: 42px;
    position: relative;
    overflow: hidden;
}
.breaking-badge {
    background: #e31e24;
    color: white;
    padding: 0 30px 0 20px;
    font-weight: 700;
    font-size: 12px;
    display: flex;
    align-items: center;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    z-index: 10;
    clip-path: polygon(0 0, 100% 0, calc(100% - 15px) 100%, 0 100%);
}
@keyframes sharpBlink {
    0%, 49% { opacity: 1; }
    50%, 100% { opacity: 0; }
}
.breaking-dot {
    height: 6px;
    width: 6px;
    background: #ffffff;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
    animation: sharpBlink 1s infinite;
}
@keyframes scroll-marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.marquee-container {
    flex-grow: 1;
    overflow: hidden;
    display: flex;
    align-items: center;
    position: relative;
    z-index: 1;
    margin-left: -20px;
    padding-left: 30px;
}
.marquee-content {
    display: flex;
    white-space: nowrap;
    animation: scroll-marquee 50s linear infinite;
}
.marquee-content:hover {
    animation-play-state: paused;
}
.marquee-text {
    font-size: 13px;
    color: #222;
    font-weight: 500;
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    padding-right: 20px;
}
.marquee-separator {
    color: #e31e24;
    margin: 0 15px;
    font-size: 16px;
    vertical-align: middle;
}
@keyframes bannerBorderGlow {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
@media (max-width: 992px) {
    /* ====== ULTRA-PREMIUM MOBILE BANNER ====== */
    .custom-top-banner {
        padding: 20px 0 16px !important;
        background: #fff !important;
        border-top: none !important;
        position: relative !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
    }
    /* Animated glowing top accent line */
    .custom-top-banner::before {
        content: '' !important;
        display: block !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 3px !important;
        background: linear-gradient(90deg, #e31e24, #ff6b6b, #bd1217, #e31e24) !important;
        background-size: 300% 300% !important;
        animation: bannerBorderGlow 4s ease infinite !important;
        z-index: 10 !important;
    }
    .custom-banner-inner {
        flex-direction: row !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 10px 15px !important;
        gap: 0 !important;
    }
    /* === Hide Left Logo === */
    .custom-banner-left {
        display: none !important;
    }
    .custom-banner-left img {
        height: 68px !important;
        width: auto !important;
        object-fit: contain !important;
        border-radius: 6px !important;
        box-shadow: 0 4px 16px rgba(227, 30, 36, 0.18), 0 2px 6px rgba(0,0,0,0.07) !important;
    }
    /* === Center Block === */
    .custom-banner-center {
        display: contents !important;
    }
    /* Diamond dot — hide */
    .custom-banner-center > div:first-child {
        display: none !important;
    }
    /* === Title === */
    .custom-banner-center h1 {
        font-family: 'Playfair Display', Georgia, serif !important;
        font-size: 24px !important;
        font-weight: 900 !important;
        letter-spacing: -0.3px !important;
        margin: 0 0 0 12px !important;
        text-align: left !important;
        white-space: normal !important;
        line-height: 1.1 !important;
        color: #0a0a0a !important;
        transform: none !important;
        flex: 1 1 0% !important;
        order: 0 !important;
    }
    /* === Cities Block: inline-wrap — NO column flex === */
    .custom-banner-center > div:last-child {
        display: block !important;
        flex: 0 0 100% !important;
        order: 2 !important;
        white-space: normal !important;
        font-size: 9px !important;
        letter-spacing: 1px !important;
        line-height: 2 !important;
        text-align: center !important;
        margin: 12px auto 0 !important;
        color: #777 !important;
        width: 100% !important;
        max-width: 100% !important;
        position: relative !important;
        padding-top: 12px !important;
    }
    /* Ornamental divider above cities */
    .custom-banner-center > div:last-child::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 20% !important;
        right: 20% !important;
        height: 1px !important;
        background: linear-gradient(90deg, transparent 0%, #e31e24 50%, transparent 100%) !important;
        opacity: 0.4 !important;
    }
    /* "PUBLISHED FROM" label inline-block so cities follow on same/next line */
    .custom-banner-center > div:last-child > span:first-child {
        display: block !important;
        font-size: 7.5px !important;
        font-weight: 900 !important;
        letter-spacing: 3px !important;
        color: #bbb !important;
        margin: 0 0 3px 0 !important;
        text-align: center !important;
    }
    /* === Right logo — display on left === */
    .custom-banner-right {
        display: flex !important;
        order: -1 !important;
        flex: 0 0 auto !important;
    }
    .custom-banner-right > div {
        align-items: flex-start !important;
        margin: 0 !important;
    }
    .custom-banner-right img {
        max-height: 55px !important;
    }
    .custom-banner-right span {
        display: none !important;
    }
}


.premium-ad-button {
    background: linear-gradient(135deg, #e31e24 0%, #bd1217 100%);
    color: #ffffff !important;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 24px !important;
    border-radius: 30px;
    border: none;
    height: auto !important;
    box-shadow: 0 4px 12px rgba(227, 30, 36, 0.25);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.premium-ad-button:hover {
    background: linear-gradient(135deg, #f0252b 0%, #c81a20 100%);
    box-shadow: 0 6px 16px rgba(227, 30, 36, 0.35);
    transform: translateY(-1px);
    color: #ffffff !important;
}

@keyframes eyeCatchingGlow {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.8), 0 0 10px rgba(255, 0, 0, 0.5);
        background: linear-gradient(135deg, #e31e24 0%, #bd1217 100%);
        text-shadow: 0 0 0px rgba(255,255,255,0);
        transform: scale(1);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(255, 0, 0, 0), 0 0 25px rgba(255, 30, 30, 1), 0 0 45px rgba(255, 100, 0, 0.8);
        background: linear-gradient(135deg, #ff1a1a 0%, #e60000 100%);
        text-shadow: 0 0 8px rgba(255,255,255,0.9), 0 0 15px rgba(255,255,255,0.5);
        transform: scale(1.04);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 0), 0 0 10px rgba(255, 0, 0, 0.5);
        background: linear-gradient(135deg, #e31e24 0%, #bd1217 100%);
        text-shadow: 0 0 0px rgba(255,255,255,0);
        transform: scale(1);
    }
}

@keyframes rapidFireBlink {
    0%, 100% { opacity: 1; filter: drop-shadow(0 0 6px #ffffff); transform: scale(1.1); }
    50% { opacity: 0.1; filter: drop-shadow(0 0 0 transparent); transform: scale(0.9); }
}

@keyframes extremeShimmer {
    0% { transform: translateX(-150%) skewX(-30deg); }
    15% { transform: translateX(350%) skewX(-30deg); }
    100% { transform: translateX(350%) skewX(-30deg); }
}

.trending-glowing-btn {
    position: relative;
    overflow: hidden;
    animation: eyeCatchingGlow 1.2s infinite ease-in-out !important;
    border: 1px solid rgba(255, 200, 200, 0.4) !important;
}

.trending-glowing-btn::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
    animation: extremeShimmer 2.5s infinite ease-in-out;
    pointer-events: none;
    mix-blend-mode: overlay;
}

.trending-glowing-btn svg {
    animation: rapidFireBlink 0.6s infinite ease-in-out;
    color: #ffffff;
}
</style>

<div class="custom-top-banner">
    <div class="custom-banner-inner">
        <!-- Left Section -->
        <div class="custom-banner-left" style="justify-content: flex-start; align-items: center; gap: 12px;">
            <img src="/assets/img/a1.jpeg" alt="Logo" style="height: 75px; width: auto; object-fit: contain;">
        </div>

        <!-- Center Section -->
        <div class="custom-banner-center">
            <div style="width: 6px; height: 6px; background-color: #e31e24; transform: rotate(45deg); margin-bottom: 16px;"></div>
            <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 54px; font-weight: 900; color: #000; margin: 0; line-height: 1; letter-spacing: -1.5px; transform: scaleY(1.05);">Akhbar-e-Mashriq</h1>
            <div style="font-size: 12px; color: #222; margin-top: 18px; font-weight: 600; font-family: 'Inter', sans-serif; text-transform: uppercase; white-space: nowrap; letter-spacing: 1.5px;">
                <span style="font-weight: 800; color: #888; margin-right: 12px; letter-spacing: 2px;">PUBLISHED FROM</span>
                Kolkata <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Delhi <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Ranchi <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Lucknow <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Bhopal <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Srinagar <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Siliguri <span style="color: #e31e24; margin: 0 8px; font-size: 10px; position: relative; top: -1px;">♦</span> Asansol
            </div>
        </div>

        <!-- Right Section -->
        <div class="custom-banner-right" style="flex: 1; display: flex; justify-content: flex-end; align-items: center;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; margin-left: auto;">
                <img src="/assets/img/a2.jpeg" alt="Akhbar-e-Mashriq" style="max-height: 85px; width: auto; object-fit: contain; border-radius: 4px;">
                <span style="font-size: 12px; font-weight: 700; color: #000; letter-spacing: 1.5px; text-transform: uppercase; font-family: 'Inter', sans-serif;">Akhbar-e-Mashriq</span>
            </div>
        </div>
    </div>
</div>

<!-- Breaking News Ticker -->
@php
    // Fetch up to 10 English articles
    $englishAlerts = \App\Models\Article::where('status', \App\Models\Article::PUBLISHED)
                        ->whereIn('visible_in', [\App\Models\Article::HINDUSTANI, \App\Models\Article::BOTH])
                        ->whereNotNull('title_en')
                        ->where('title_en', '!=', '')
                        ->orderBy('id', 'DESC')
                        ->take(10)
                        ->get()
                        ->map(function($alert) {
                            $alert->display_title = $alert->title_en;
                            return $alert;
                        });

    $latestAlerts = collect($englishAlerts);

    // If we have less than 10 English articles, fill the rest with Urdu articles
    if ($latestAlerts->count() < 10) {
        $needed = 10 - $latestAlerts->count();
        $urduAlerts = \App\Models\Article::where('status', \App\Models\Article::PUBLISHED)
                            ->whereIn('visible_in', [\App\Models\Article::URDU, \App\Models\Article::BOTH])
                            ->whereNotIn('id', $latestAlerts->pluck('id')) // Avoid duplicates
                            ->whereNotNull('title_ur')
                            ->where('title_ur', '!=', '')
                            ->orderBy('id', 'DESC')
                            ->take($needed)
                            ->get()
                            ->map(function($alert) {
                                $alert->display_title = $alert->title_ur;
                                return $alert;
                            });
        $latestAlerts = $latestAlerts->concat($urduAlerts);
    }
@endphp
<div class="breaking-news-bar">
    <div class="breaking-badge">
        <span class="breaking-dot"></span> ALERTS
    </div>
    <div class="marquee-container">
        <div class="marquee-content">
            <!-- First Set -->
            <div class="marquee-text">
                @foreach($latestAlerts as $alert)
                    <a href="{{ $alert->article_url }}" style="color: inherit; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#e31e24'" onmouseout="this.style.color='inherit'" onfocus="this.style.color='#e31e24'" onblur="this.style.color='inherit'">{{ $alert->display_title }}</a> <span class="marquee-separator">•</span>
                @endforeach
            </div>
            <!-- Duplicated Set for Seamless Loop -->
            <div class="marquee-text">
                @foreach($latestAlerts as $alert)
                    <a href="{{ $alert->article_url }}" style="color: inherit; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#e31e24'" onmouseout="this.style.color='inherit'" onfocus="this.style.color='#e31e24'" onblur="this.style.color='inherit'">{{ $alert->display_title }}</a> <span class="marquee-separator">•</span>
                @endforeach
            </div>
        </div>
    </div>
</div>


<!-- Navigation Bar CSS -->
<style>
/* === Navbar Premium Styles === */
.premium-navbar {
    background-color: #ffffff;
    border-bottom: 1px solid #f0f0f0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    transition: all 0.3s ease;
}
.premium-navbar.scrolled {
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.premium-navbar-container {
    max-width: 1440px;
    width: 100%;
    margin: 0 auto;
    padding: 0 15px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
}


/* Sticky App Icon */
.sticky-app-icon {
    width: 0;
    opacity: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    margin-right: 0;
}
.sticky-app-icon img {
    height: 48px;
    width: 48px;
    object-fit: contain;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(227, 30, 36, 0.2);
    flex-shrink: 0;
}
.sticky-app-icon.visible {
    width: 48px;
    opacity: 1;
    margin-right: 15px;
}

/* Center: Nav Links */
.premium-navbar-links {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    padding: 0;
    list-style: none;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.premium-nav-item a {
    color: #333;
    font-family: 'Inter', sans-serif;
    font-size: 11.5px;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    position: relative;
    padding: 8px 0;
    transition: color 0.3s ease;
}

.premium-nav-item a:hover,
.premium-nav-item a.active {
    color: #e31e24;
}

.premium-nav-item a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: #e31e24;
    transition: width 0.3s ease;
}

.premium-nav-item a:hover::after,
.premium-nav-item a.active::after {
    width: 100%;
}

/* Right: Actions */
.premium-navbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-left: auto;
}

.premium-search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.premium-search-wrapper input {
    padding: 8px 16px 8px 36px;
    border: 1px solid #eaeaea;
    border-radius: 30px;
    font-size: 12px;
    outline: none;
    width: 160px;
    color: #111;
    background: #f9f9f9;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s ease;
}

.premium-search-wrapper input:focus {
    width: 200px;
    background: #ffffff;
    border-color: #d0d0d0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.premium-search-wrapper button {
    position: absolute;
    left: 12px;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    color: #888;
}

.premium-search-wrapper button svg {
    transition: stroke 0.3s ease;
}

.premium-search-wrapper input:focus + button svg {
    stroke: #e31e24;
}

.premium-btn-book {
    background: linear-gradient(135deg, #e31e24 0%, #bd1217 100%);
    color: #ffffff;
    font-family: 'Inter', sans-serif;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 8px 18px;
    border-radius: 30px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(227, 30, 36, 0.25);
    transition: all 0.3s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.premium-btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(227, 30, 36, 0.35);
    color: #ffffff;
}

/* Mobile Hamburger */
.premium-hamburger {
    display: none;
    background: linear-gradient(135deg, #e31e24 0%, #bd1217 100%);
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: #fff;
    box-shadow: 0 3px 12px rgba(227, 30, 36, 0.35);
    flex-shrink: 0;
}

.premium-hamburger:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(227, 30, 36, 0.5);
}

/* Mobile Sidebar (Premium Drawer) */
.mobile-sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.55);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 1001;
    opacity: 0;
    visibility: hidden;
    transition: all 0.35s ease;
}
.mobile-sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

.mobile-sidebar {
    position: fixed;
    top: 0;
    right: -100vw;
    width: 100vw;
    height: 100%;
    background: #ffffff;
    z-index: 1002;
    box-shadow: -8px 0 40px rgba(0,0,0,0.18);
    transition: right 0.42s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    overflow-x: hidden;
}
.mobile-sidebar.active {
    right: 0;
}

/* === Premium Dark Header === */
.mobile-sidebar-header {
    padding: 0;
    display: flex;
    flex-direction: column;
    background: linear-gradient(145deg, #1a0000 0%, #2d0404 60%, #1a0000 100%);
    position: sticky;
    top: 0;
    z-index: 10;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.mobile-sidebar-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(227,30,36,0.25) 0%, transparent 70%);
    pointer-events: none;
}
.mobile-sidebar-header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px 0 20px;
}
.mobile-sidebar-logo {
    height: 52px;
    width: auto;
    max-width: 160px;
    object-fit: contain;
    filter: drop-shadow(0 4px 10px rgba(0,0,0,0.5));
}
.mobile-sidebar-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 15px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 0.3px;
    margin: 0;
    opacity: 0.9;
}
.mobile-sidebar-close {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: rgba(255,255,255,0.85);
    flex-shrink: 0;
    backdrop-filter: blur(5px);
}
.mobile-sidebar-close:hover {
    background: linear-gradient(135deg, #e31e24 0%, #bd1217 100%);
    border-color: transparent;
    transform: rotate(90deg) scale(1.1);
    color: #fff;
    box-shadow: 0 4px 15px rgba(227,30,36,0.4);
}
.mobile-sidebar-header-tagline {
    font-family: 'Inter', sans-serif;
    font-size: 9.5px;
    font-weight: 600;
    letter-spacing: 3.5px;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    padding: 0 20px 16px 20px;
    text-align: right;
    margin-top: -4px;
}

/* === Content === */
.mobile-sidebar-content {
    padding: 20px 16px 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    flex: 1;
}

/* === Section label === */
.mobile-sidebar-section-label {
    font-family: 'Inter', sans-serif;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 2.5px;
    color: #bbb;
    text-transform: uppercase;
    padding: 0 4px;
    margin-bottom: -12px;
}

/* === Nav Links === */
.mobile-sidebar-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px; /* increased gap */
}

.mobile-sidebar-links a {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    text-decoration: none;
    color: #111827; /* sleek dark color */
    font-family: 'Inter', sans-serif;
    font-size: 14.5px;
    font-weight: 600;
    border-radius: 16px; /* softer rounded corners */
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03); /* subtle elevation */
    border: 1px solid rgba(0,0,0,0.04);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.mobile-sidebar-links a::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 0;
    background: linear-gradient(90deg, rgba(227,30,36,0.06), transparent);
    transition: width 0.3s ease;
}
.mobile-sidebar-links a:hover::before,
.mobile-sidebar-links a.active::before {
    width: 100%;
}
.mobile-sidebar-links a:hover,
.mobile-sidebar-links a.active {
    color: #e31e24;
    border-color: rgba(227,30,36,0.15);
    box-shadow: 0 6px 16px rgba(227,30,36,0.08); /* glowing shadow */
    transform: translateY(-2px); /* nice lift effect */
}

.mobile-sidebar-links a .nav-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #fdfdfd, #f1f3f5);
    border: 1px solid #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280; /* sleek gray for default SVG color */
    margin-right: 14px;
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.mobile-sidebar-links a:hover .nav-icon,
.mobile-sidebar-links a.active .nav-icon {
    background: linear-gradient(135deg, #ffffff, #ffecec);
    border-color: rgba(227,30,36,0.1);
    box-shadow: 0 4px 10px rgba(227,30,36,0.15);
    color: #e31e24; /* vibrant red for SVG on hover */
    transform: scale(1.08) rotate(-3deg);
}

/* === Search === */
.mobile-sidebar-search {
    position: relative;
    width: 100%;
}
.mobile-sidebar-search input {
    width: 100%;
    padding: 14px 16px 14px 46px;
    border: 1.5px solid #ebebeb;
    border-radius: 14px;
    font-size: 14px;
    background: #fafafa;
    outline: none;
    font-family: 'Inter', sans-serif;
    color: #111;
    transition: all 0.25s ease;
    box-sizing: border-box;
}
.mobile-sidebar-search input:focus {
    border-color: #e31e24;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(227,30,36,0.08);
}
.mobile-sidebar-search input::placeholder {
    color: #bbb;
    font-size: 13.5px;
}
.mobile-sidebar-search button {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #bbb;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: color 0.2s;
    padding: 0;
}
.mobile-sidebar-search input:focus ~ button,
.mobile-sidebar-search button:hover {
    color: #e31e24;
}
/* Premium Agent Tooltip */
.agent-tooltip {
    position: absolute;
    top: 70px;
    right: 15px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: #fff;
    padding: 12px 16px 12px 12px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2), 0 0 0 1px rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 1005;
    opacity: 0;
    transform: translateY(-10px) scale(0.95);
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    max-width: 280px;
    pointer-events: auto;
}
.agent-tooltip.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    visibility: visible;
    animation: bounceTooltip 2s ease-in-out infinite;
}
.agent-tooltip::before {
    content: '';
    position: absolute;
    top: -6px;
    right: 16px;
    width: 12px;
    height: 12px;
    background: #16213e;
    transform: rotate(45deg);
    border-top: 1px solid rgba(255,255,255,0.1);
    border-left: 1px solid rgba(255,255,255,0.1);
}
.agent-emoji {
    font-size: 24px;
    animation: waveEmoji 2s infinite;
    transform-origin: 70% 70%;
    display: inline-block;
}
.agent-tooltip-content div {
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    line-height: 1.4;
    color: #e2e8f0;
}
.agent-tooltip-content strong {
    font-size: 14px;
    color: #fff;
    font-weight: 700;
}
.agent-tooltip-close {
    background: rgba(255,255,255,0.1);
    border: none;
    color: #fff;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin-left: auto;
    font-size: 16px;
    line-height: 1;
    transition: background 0.2s;
    align-self: flex-start;
}
.agent-tooltip-close:hover {
    background: rgba(255,255,255,0.2);
}
@keyframes bounceTooltip {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}
@keyframes waveEmoji {
    0% { transform: rotate(0deg); }
    10% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
    30% { transform: rotate(14deg); }
    40% { transform: rotate(-4deg); }
    50% { transform: rotate(10deg); }
    60%, 100% { transform: rotate(0deg); }
}
@media (min-width: 993px) {
    .agent-tooltip {
        display: none !important;
    }
}

/* Mobile Sticky Title */
.mobile-sticky-title {
    display: none;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 900;
    color: #000;
    text-decoration: none;
    letter-spacing: -0.5px;
    opacity: 0;
    transition: opacity 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
    text-align: center;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .premium-navbar {
        position: fixed !important;
        background-color: transparent !important;
        border-bottom: none !important;
        box-shadow: none !important;
        pointer-events: none;
        width: 100% !important;
        left: 0 !important;
        right: 0 !important;
    }
    .premium-navbar.scrolled {
        background-color: #ffffff !important;
        border-bottom: 1px solid #f0f0f0 !important;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08) !important;
        pointer-events: auto;
    }
    .mobile-sticky-title {
        display: block;
    }
    .mobile-sticky-title.visible {
        opacity: 1;
    }
    .premium-navbar-links,
    .premium-navbar-actions {
        display: none;
    }
    .premium-hamburger {
        display: flex;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .premium-navbar.scrolled .premium-hamburger {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }
    .premium-navbar-container {
        padding: 0 16px;
        width: 100%;
        box-sizing: border-box;
    }
}
@media (max-width: 480px) {
    /* sidebar already 100vw from base style */
}
</style>

<!-- Main Navbar -->
<nav class="premium-navbar" id="premium-navbar">
    <div class="premium-navbar-container">
        


        <!-- Small Sticky Logo (Appears on Scroll) -->
        <a href="/" class="sticky-app-icon" id="sticky-app-icon">
            <img src="/assets/img/a2.jpeg" alt="Akhbar-e-Mashriq">
        </a>

        <!-- Mobile Sticky Title -->
        <a href="/" class="mobile-sticky-title" id="mobile-sticky-title">
            Akhbar-e-Mashriq
        </a>

        <!-- Desktop Links -->
        <?php $_selected_category = request()->route()->parameter('slug') ?? 0;
        if ($_selected_category == 0) {
            if (request()->is('social')) $_selected_category = 'social';
            elseif (request()->is('trending-videos')) $_selected_category = 'trending-videos';
            elseif (request('latest')) $_selected_category = 0;
            else $_selected_category = -1;
        }
        ?>
        <ul class="premium-navbar-links">
            <li class="premium-nav-item"><a href="/" class="{{ $_selected_category == -1 ? 'active' : '' }}">Home</a></li>
            <li class="premium-nav-item"><a href="/articles?latest=true" class="{{ $_selected_category == 0 ? 'active' : '' }}">Latest</a></li>
            @if($categories)
                @foreach($categories as $category)
                <li class="premium-nav-item"><a href="/articles/category/{{ strtolower($category->name_en) }}" class="{{ $category->name_en == $_selected_category ? 'active' : '' }}">{{ $category->name_en }}</a></li>
                @endforeach
            @endif
            <li class="premium-nav-item"><a href="/social" class="{{ $_selected_category == 'social' ? 'active' : '' }}">Socials</a></li>
            <li class="premium-nav-item"><a href="/trending-videos" class="{{ $_selected_category == 'trending-videos' ? 'active' : '' }}">Trending Videos</a></li>
        </ul>

        <!-- Desktop Actions -->
        <div class="premium-navbar-actions">
            <form action="/articles" class="premium-search-wrapper">
                <input type="search" name="search" placeholder="Search news..." value="{{ request('search', '') }}" required>
                <button type="submit" title="Search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </form>
            <a href="/advertisement-booking" class="premium-btn-book">
                Book Advertisement
            </a>
        </div>

        <!-- Mobile Hamburger Toggle -->
        <button class="premium-hamburger" id="mobile-menu-open" aria-label="Open Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <!-- Premium Agent Tooltip (Mobile Only) -->
        <div class="agent-tooltip" id="agent-tooltip">
            <div class="agent-tooltip-content">
                <span class="agent-emoji">👋</span>
                <div>
                    <strong>Welcome!</strong><br>
                    Tap here to explore news categories and e-paper.
                </div>
            </div>
            <button class="agent-tooltip-close" id="agent-tooltip-close" aria-label="Close tooltip">&times;</button>
        </div>

    </div>
</nav>

<!-- Mobile Sidebar (Drawer) -->
<div class="mobile-sidebar-overlay" id="mobile-sidebar-overlay"></div>
<aside class="mobile-sidebar" id="mobile-sidebar">

    <!-- Premium Dark Header -->
    <div class="mobile-sidebar-header">
        <div class="mobile-sidebar-header-top">
            <img src="/assets/img/a2-mobile.png" alt="Akhbar-e-Mashriq" class="mobile-sidebar-logo">
            <button type="button" class="mobile-sidebar-close" id="mobile-menu-close" aria-label="Close Menu" onclick="document.getElementById('mobile-sidebar').classList.remove('active'); document.getElementById('mobile-sidebar-overlay').classList.remove('active'); document.body.style.overflow = '';">
                <span style="font-size: 28px; line-height: 1; margin-top: -2px;">&times;</span>
            </button>
        </div>
        <div class="mobile-sidebar-header-tagline">Your trusted news source</div>
    </div>

    <div class="mobile-sidebar-content">

        <!-- Search -->
        <form action="/articles" class="mobile-sidebar-search">
            <input type="search" name="search" placeholder="Search articles..." value="{{ request('search', '') }}" required>
            <button type="submit">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </form>

        <!-- Book Ad Button -->
        <a href="/advertisement-booking" class="premium-btn-book" style="justify-content: center; padding: 14px 24px; font-size: 13.5px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Book Advertisement
        </a>

        <!-- Navigation -->
        <p class="mobile-sidebar-section-label">Navigation</p>
        <ul class="mobile-sidebar-links">
            <li><a href="/" class="{{ $_selected_category == -1 ? 'active' : '' }}"><span class="nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span> Home</a></li>
            <li><a href="/articles?latest=true" class="{{ $_selected_category == 0 ? 'active' : '' }}"><span class="nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span> Latest</a></li>
            @if(isset($categories))
                @foreach($categories as $category)
                <li><a href="/articles/category/{{ strtolower($category->name_en) }}" class="{{ $category->name_en == $_selected_category ? 'active' : '' }}"><span class="nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg></span> {{ $category->name_en }}</a></li>
                @endforeach
            @endif
            <li><a href="/social" class="{{ $_selected_category == 'social' ? 'active' : '' }}"><span class="nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg></span> Socials</a></li>
            <li><a href="/trending-videos" class="{{ $_selected_category == 'trending-videos' ? 'active' : '' }}"><span class="nav-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg></span> Trending Videos</a></li>
        </ul>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu drawer logic
    const menuOpen = document.getElementById('mobile-menu-open');
    const menuClose = document.getElementById('mobile-menu-close');
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-sidebar-overlay');

    function openMenu() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeMenu() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }

    if(menuOpen) menuOpen.addEventListener('click', openMenu);
    if(menuClose) menuClose.addEventListener('click', closeMenu);
    if(overlay) overlay.addEventListener('click', closeMenu);

    // Sticky navbar enhancement
    const navbar = document.getElementById('premium-navbar');
    const stickyIcon = document.getElementById('sticky-app-icon');
    const stickyTitle = document.getElementById('mobile-sticky-title');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 150) {
            navbar.classList.add('scrolled');
            if (stickyIcon) {
                stickyIcon.classList.add('visible');
            }
            if (stickyTitle) {
                stickyTitle.classList.add('visible');
            }
        } else {
            navbar.classList.remove('scrolled');
            if (stickyIcon) {
                stickyIcon.classList.remove('visible');
            }
            if (stickyTitle) {
                stickyTitle.classList.remove('visible');
            }
        }
    });

    // Agent Tooltip Logic
    const tooltip = document.getElementById('agent-tooltip');
    const tooltipClose = document.getElementById('agent-tooltip-close');
    
    if (tooltip && window.innerWidth <= 992) {
        // Show after 1.5 seconds
        setTimeout(() => {
            if (!localStorage.getItem('agentTooltipSeen')) {
                tooltip.classList.add('show');
            }
        }, 1500);

        const closeTooltip = () => {
            tooltip.classList.remove('show');
            localStorage.setItem('agentTooltipSeen', 'true');
        };

        if(tooltipClose) {
            tooltipClose.addEventListener('click', closeTooltip);
        }
        
        // Auto hide after 8 seconds
        setTimeout(() => {
            if (tooltip.classList.contains('show')) {
                closeTooltip();
            }
        }, 8000);
    }
});
</script>

 @yield('content')
<style>
/* === Ultra-Premium Advanced Footer === */
.footer-advanced {
    background: radial-gradient(circle at 50% 0%, #111115 0%, #080808 100%);
    position: relative;
    border-top: 1px solid rgba(255, 255, 255, 0.03);
    padding: 80px 0 40px 0;
    font-family: 'Inter', sans-serif;
    direction: ltr;
    text-align: left;
    overflow: hidden;
}
.footer-advanced::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(227,30,36,0.6), transparent);
}
.footer-adv-watermark {
    position: absolute;
    bottom: 25px;
    right: -20px;
    font-family: 'Playfair Display', serif;
    font-size: 140px;
    font-weight: 900;
    color: rgba(255,255,255,0.012);
    line-height: 1;
    z-index: 1;
    pointer-events: none;
    letter-spacing: -4px;
    white-space: nowrap;
}
.footer-adv-wrapper { position: relative; z-index: 2; display: grid; grid-template-columns: 2.5fr 1fr 1fr 1fr 1.5fr; gap: 40px; }
@media (max-width: 992px) { .footer-adv-wrapper { grid-template-columns: 1fr 1fr; gap: 60px; } }
@media (max-width: 768px) {
    .footer-adv-wrapper { grid-template-columns: 1fr 1fr; text-align: center; gap: 40px 10px; }
    .footer-adv-wrapper > div:first-child { grid-column: 1 / -1; }
}

.footer-adv-brand { display: inline-block; margin-bottom: 24px; position: relative; }
.footer-adv-brand img { height: 50px; border-radius: 6px; padding: 3px; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.5); transition: transform 0.3s ease, box-shadow 0.3s ease; }
.footer-adv-brand:hover img { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(227, 30, 36, 0.25); }
.footer-adv-desc { color: #a1a1aa; font-size: 14.5px; line-height: 1.8; margin-bottom: 32px; max-width: 320px; font-weight: 400; letter-spacing: 0.2px; }
@media (max-width: 768px) { .footer-adv-desc { margin: 0 auto 32px auto; } }

.footer-adv-socials { display: flex; gap: 14px; }
@media (max-width: 768px) { .footer-adv-socials { justify-content: center; } }
.footer-adv-social-icon { display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.12); color: #d1d1d6; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.3); }
.footer-adv-social-icon svg { width: 18px; height: 18px; fill: currentColor; }
.footer-adv-social-icon:hover { background: #e31e24; color: #fff; border-color: #e31e24; transform: translateY(-4px) scale(1.05); box-shadow: 0 10px 24px rgba(227, 30, 36, 0.3); }

.footer-adv-col-title { color: #55555c; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 28px; }
.footer-adv-links { display: flex; flex-direction: column; gap: 16px; }
.footer-adv-link { color: #a1a1aa; font-size: 14px; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; position: relative; width: fit-content; }
.footer-adv-link::before { content: ''; position: absolute; left: -12px; top: 50%; transform: translateY(-50%); width: 0; height: 2px; background: #e31e24; transition: all 0.3s ease; opacity: 0; }
.footer-adv-link:hover { color: #fff; transform: translateX(12px); }
.footer-adv-link:hover::before { width: 6px; opacity: 1; }
@media (max-width: 768px) {
    .footer-adv-link { width: auto; justify-content: center; margin: 0 auto; }
    .footer-adv-link:hover { transform: none; color: #cca953; }
    .footer-adv-link::before { display: none; }

    /* 2-column vertical list layout like screenshot */
    .footer-adv-links {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 16px !important;
    }
    .footer-adv-link {
        font-size: 14px !important;
        color: #a1a1aa !important;
        padding: 0 !important;
        background: transparent !important;
        border: none !important;
    }
    .footer-adv-col-title {
        position: relative;
        display: inline-block;
        padding-bottom: 12px;
        margin-bottom: 24px !important;
        font-size: 13px !important;
        letter-spacing: 1px !important;
        color: #e2e8f0;
    }
    .footer-adv-col-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 2px;
        background: #cca953; /* Gold accent line */
    }
}

.footer-adv-contact-text { color: #888892; font-size: 14px; line-height: 1.8; margin: 0; }

.footer-adv-bottom { position: relative; z-index: 2; margin-top: 80px; padding-top: 32px; border-top: 1px solid rgba(255, 255, 255, 0.04); display: flex; justify-content: space-between; align-items: center; color: #66666e; font-size: 13px; letter-spacing: 0.5px; }
@media (max-width: 768px) { .footer-adv-bottom { flex-direction: column; gap: 16px; text-align: center; } }
</style>

<footer class="footer-advanced">
    <div class="footer-adv-watermark">Akhbar-e-Mashriq</div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="footer-adv-wrapper">
            {{-- Brand & Socials --}}
            <div>
                <a href="/" class="footer-adv-brand" style="display: inline-block;">
                    <img src="/assets/img/a1.jpeg" alt="AKHBAR-E-MASHRIQ">
                </a>
                <p class="footer-adv-desc">Your trusted source for the latest news, personalized feeds, and premium journalism delivered directly to your screen.</p>
                <div class="footer-adv-socials">
                    <a href="https://www.facebook.com/AkhbarMashriqIN" target="_blank" class="footer-adv-social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z"></path></svg>
                    </a>
                    <a href="https://www.instagram.com/akhbarmashriqin" target="_blank" class="footer-adv-social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.0281 2.00098C14.1535 2.00284 14.7238 2.00879 15.2166 2.02346L15.4107 2.02981C15.6349 2.03778 15.8561 2.04778 16.1228 2.06028C17.1869 2.10944 17.9128 2.27778 18.5503 2.52528C19.2094 2.77944 19.7661 3.12278 20.3219 3.67861C20.8769 4.23444 21.2203 4.79278 21.4753 5.45028C21.7219 6.08694 21.8903 6.81361 21.9403 7.87778C21.9522 8.14444 21.9618 8.36564 21.9697 8.58989L21.976 8.78397C21.9906 9.27672 21.9973 9.8471 21.9994 10.9725L22.0002 11.7182C22.0003 11.8093 22.0003 11.9033 22.0003 12.0003L22.0002 12.2824L21.9996 13.0281C21.9977 14.1535 21.9918 14.7238 21.9771 15.2166L21.9707 15.4107C21.9628 15.6349 21.9528 15.8561 21.9403 16.1228C21.8911 17.1869 21.7219 17.9128 21.4753 18.5503C21.2211 19.2094 20.8769 19.7661 20.3219 20.3219C19.7661 20.8769 19.2069 21.2203 18.5503 21.4753C17.9128 21.7219 17.1869 21.8903 16.1228 21.9403C15.8561 21.9522 15.6349 21.9618 15.4107 21.9697L15.2166 21.976C14.7238 21.9906 14.1535 21.9973 13.0281 21.9994L12.2824 22.0002C12.1913 22.0003 12.0973 22.0003 12.0003 22.0003L11.7182 22.0002L10.9725 21.9996C9.8471 21.9977 9.27672 21.9918 8.78397 21.9771L8.58989 21.9707C8.36564 21.9628 8.14444 21.9528 7.87778 21.9403C6.81361 21.8911 6.08861 21.7219 5.45028 21.4753C4.79194 21.2211 4.23444 20.8769 3.67861 20.3219C3.12278 19.7661 2.78028 19.2069 2.52528 18.5503C2.27778 17.9128 2.11028 17.1869 2.06028 16.1228C2.0484 15.8561 2.03871 15.6349 2.03086 15.4107L2.02457 15.2166C2.00994 14.7238 2.00327 14.1535 2.00111 13.0281L2.00098 10.9725C2.00284 9.8471 2.00879 9.27672 2.02346 8.78397L2.02981 8.58989C2.03778 8.36564 2.04778 8.14444 2.06028 7.87778C2.10944 6.81278 2.27778 6.08778 2.52528 5.45028C2.77944 4.79194 3.12278 4.23444 3.67861 3.67861C4.23444 3.12278 4.79278 2.78028 5.45028 2.52528C6.08778 2.27778 6.81278 2.11028 7.87778 2.06028C8.14444 2.0484 8.36564 2.03871 8.58989 2.03086L8.78397 2.02457C9.27672 2.00994 9.8471 2.00327 10.9725 2.00111L13.0281 2.00098ZM12.0003 7.00028C9.23738 7.00028 7.00028 9.23981 7.00028 12.0003C7.00028 14.7632 9.23981 17.0003 12.0003 17.0003C14.7632 17.0003 17.0003 14.7607 17.0003 12.0003C17.0003 9.23738 14.7607 7.00028 12.0003 7.00028ZM12.0003 9.00028C13.6572 9.00028 15.0003 10.3429 15.0003 12.0003C15.0003 13.6572 13.6576 15.0003 12.0003 15.0003C10.3434 15.0003 9.00028 13.6576 9.00028 12.0003C9.00028 10.3434 10.3429 9.00028 12.0003 9.00028ZM17.2503 5.50028C16.561 5.50028 16.0003 6.06018 16.0003 6.74943C16.0003 7.43867 16.5602 7.99944 17.2503 7.99944C17.9395 7.99944 18.5003 7.43954 18.5003 6.74943C18.5003 6.06018 17.9386 5.49941 17.2503 5.50028Z"></path></svg>
                    </a>
                    <a href="https://x.com/AkhbarMashriqIN" target="_blank" class="footer-adv-social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17.6874 3.0625L12.6907 8.77425L8.37045 3.0625H2.11328L9.58961 12.8387L2.50378 20.9375H5.53795L11.0068 14.6886L15.7863 20.9375H21.8885L14.095 10.6342L20.7198 3.0625H17.6874ZM16.6232 19.1225L5.65436 4.78217H7.45745L18.3034 19.1225H16.6232Z"></path></svg>
                    </a>
                    <a href="https://www.youtube.com/@akhbarmashriqin" target="_blank" class="footer-adv-social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.2439 4C12.778 4.00294 14.1143 4.01586 15.5341 4.07273L16.0375 4.09468C17.467 4.16236 18.8953 4.27798 19.6037 4.4755C20.5486 4.74095 21.2913 5.5155 21.5423 6.49732C21.942 8.05641 21.992 11.0994 21.9982 11.8358L21.9991 11.9884L21.9991 11.9991C21.9991 11.9991 21.9991 12.0028 21.9991 12.0099L21.9982 12.1625C21.992 12.8989 21.942 15.9419 21.5423 17.501C21.2878 18.4864 20.5451 19.261 19.6037 19.5228C18.8953 19.7203 17.467 19.8359 16.0375 19.9036L15.5341 19.9255C14.1143 19.9824 12.778 19.9953 12.2439 19.9983L12.0095 19.9991L11.9991 19.9991C11.9991 19.9991 11.9956 19.9991 11.9887 19.9991L11.7545 19.9983C10.6241 19.9921 5.89772 19.941 4.39451 19.5228C3.4496 19.2573 2.70692 18.4828 2.45587 17.501C2.0562 15.9419 2.00624 12.8989 2 12.1625V11.8358C2.00624 11.0994 2.0562 8.05641 2.45587 6.49732C2.7104 5.51186 3.45308 4.73732 4.39451 4.4755C5.89772 4.05723 10.6241 4.00622 11.7545 4H12.2439ZM9.99911 8.49914V15.4991L15.9991 11.9991L9.99911 8.49914Z"></path></svg>
                    </a>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h3 class="footer-adv-col-title">Links</h3>
                <div class="footer-adv-links">
                    <a class="footer-adv-link" href="/about">About Us</a>
                    <a class="footer-adv-link" href="/contact">Contact Us</a>
                    <a class="footer-adv-link" href="/terms">Terms &amp; Condition</a>
                    <a class="footer-adv-link" href="/privacy">Privacy Policy</a>
                </div>
            </div>

            {{-- News --}}
            <div>
                <h3 class="footer-adv-col-title">News</h3>
                <div class="footer-adv-links">
                    @foreach ($categories ?? \App\Models\Category::all() as $index => $c)
                        <a class="footer-adv-link" href="/articles/category/{{ strtolower($c->name_en) }}">{{ $c->name_en }}</a>
                        @if ($index + 1 === 4) @break; @endif
                    @endforeach
                </div>
            </div>

            {{-- Business --}}
            <div>
                <h3 class="footer-adv-col-title">Business</h3>
                <div class="footer-adv-links">
                    <a class="footer-adv-link" href="/advertisement-booking">Learn</a>
                    <a class="footer-adv-link" href="/advertisement-booking">Advertise</a>
                    <a class="footer-adv-link" href="/contact">Get Quote</a>
                </div>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="footer-adv-col-title">Contact Us</h3>
                <div class="footer-adv-links">
                    <a class="footer-adv-link" href="tel:+919830637558" style="color: #fff; font-weight: 600; text-shadow: 0 0 12px rgba(255,255,255,0.2);">+91 98306 37558</a>
                    <a class="footer-adv-link" href="mailto:akhbaremashriq1@gmail.com">akhbaremashriq1@gmail.com</a>
                    <p class="footer-adv-contact-text mt-2">12 Dargah Road,<br>Kolkata - 700017<br> West Bengal</p>
                </div>
            </div>
        </div>

        <div class="footer-adv-bottom">
            <div>Copyright &copy; {{date("Y")}} Akhbar-E-Mashriq. All rights reserved.</div>
            <div>Designed for modern journalism.</div>
        </div>
    </div>
</footer>

@yield('vue_app')

<style>
    /* Old CSS removal or overrides if needed */
</style>


    <!-- Floating Sidebar -->
    <div class="floating-sidebar">
        <!-- Trending Videos -->
        <a href="/trending-videos" class="floating-btn trending" title="Watch Trending Videos">
            <div class="floating-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/>
                </svg>
            </div>
            <span class="floating-text">Trending Videos</span>
        </a>

        <!-- Instagram -->
        <a href="https://www.instagram.com/akhbarmashriqin" target="_blank" class="floating-btn instagram" title="Instagram">
            <div class="floating-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M13.0281 2.00073C14.1535 2.00259 14.7238 2.00855 15.2166 2.02322L15.4107 2.02956C15.6349 2.03753 15.8561 2.04753 16.1228 2.06003C17.1869 2.1092 17.9128 2.27753 18.5503 2.52503C19.2094 2.7792 19.7661 3.12253 20.3219 3.67837C20.8769 4.2342 21.2203 4.79253 21.4753 5.45003C21.7219 6.0867 21.8903 6.81337 21.9403 7.87753C21.9522 8.1442 21.9618 8.3654 21.9697 8.58964L21.976 8.78373C21.9906 9.27647 21.9973 9.84686 21.9994 10.9723L22.0002 11.7179C22.0003 11.809 22.0003 11.903 22.0003 12L22.0002 12.2821L21.9996 13.0278C21.9977 14.1532 21.9918 14.7236 21.9771 15.2163L21.9707 15.4104C21.9628 15.6347 21.9528 15.8559 21.9403 16.1225C21.8911 17.1867 21.7219 17.9125 21.4753 18.55C21.2211 19.2092 20.8769 19.7659 20.3219 20.3217C19.7661 20.8767 19.2069 21.22 18.5503 21.475C17.9128 21.7217 17.1869 21.89 16.1228 21.94C15.8561 21.9519 15.6349 21.9616 15.4107 21.9694L15.2166 21.9757C14.7238 21.9904 14.1535 21.997 13.0281 21.9992L12.2824 22L12.0003 22L11.7182 22L10.9725 21.9993C9.8471 21.9975 9.27672 21.9915 8.78397 21.9768L8.58989 21.9705C8.36564 21.9625 8.14444 21.9525 7.87778 21.94C6.81361 21.8909 6.08861 21.7217 5.45028 21.475C4.79194 21.2209 4.23444 20.8767 3.67861 20.3217C3.12278 19.7659 2.78028 19.2067 2.52528 18.55C2.27778 17.9125 2.11028 17.1867 2.06028 16.1225C2.0484 15.8559 2.03871 15.6347 2.03086 15.4104L2.02457 15.2163C2.00994 14.7236 2.00327 14.1532 2.00111 13.0278L2.00098 10.9723C2.00284 9.84686 2.00879 9.27647 2.02346 8.78373L2.02981 8.58964C2.03778 8.3654 2.04778 8.1442 2.06028 7.87753C2.10944 6.81253 2.27778 6.08753 2.52528 5.45003C2.77944 4.7917 3.12278 4.2342 3.67861 3.67837C4.23444 3.12253 4.79278 2.78003 5.45028 2.52503C6.08778 2.27753 6.81278 2.11003 7.87778 2.06003C8.14444 2.04816 8.36564 2.03847 8.58989 2.03062L8.78397 2.02433C9.27672 2.00969 9.8471 2.00302 10.9725 2.00086L13.0281 2.00073ZM12.0003 7.00003C9.23738 7.00003 7.00028 9.23956 7.00028 12C7.00028 14.7629 9.23981 17 12.0003 17C14.7632 17 17.0003 14.7605 17.0003 12C17.0003 9.23713 14.7607 7.00003 12.0003 7.00003ZM12.0003 9.00003C13.6572 9.00003 15.0003 10.3427 15.0003 12C15.0003 13.6569 13.6576 15 12.0003 15C10.3434 15 9.00028 13.6574 9.00028 12C9.00028 10.3431 10.3429 9.00003 12.0003 9.00003ZM17.2503 5.50003C16.561 5.50003 16.0003 6.05994 16.0003 6.74918C16.0003 7.43843 16.5602 7.9992 17.2503 7.9992C17.9395 7.9992 18.5003 7.4393 18.5003 6.74918C18.5003 6.05994 17.9386 5.49917 17.2503 5.50003Z"/></svg>
            </div>
            <span class="floating-text">Instagram</span>
        </a>

        <!-- Twitter (X) -->
        <a href="https://x.com/AkhbarMashriqIN" target="_blank" class="floating-btn twitter" title="X (Twitter)">
            <div class="floating-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.6874 3.0625L12.6907 8.77425L8.37045 3.0625H2.11328L9.58961 12.8387L2.50378 20.9375H5.53795L11.0068 14.6886L15.7863 20.9375H21.8885L14.095 10.6342L20.7198 3.0625H17.6874ZM16.6232 19.1225L5.65436 4.78217H7.45745L18.3034 19.1225H16.6232Z"/></svg>
            </div>
            <span class="floating-text">X (Twitter)</span>
        </a>

        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/company/akhbar-e-mashriq/" target="_blank" class="floating-btn linkedin" title="LinkedIn">
            <div class="floating-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6.94 5.00002C6.93974 5.53046 6.72877 6.03906 6.35351 6.41394C5.97825 6.78883 5.46944 6.99947 4.939 6.99947C4.40857 6.99947 3.89976 6.78883 3.5245 6.41394C3.14924 6.03906 2.93827 5.53046 2.938 5.00002C2.93827 4.46958 3.14924 3.96098 3.5245 3.5861C3.89976 3.21121 4.40857 3.00057 4.939 3.00057C5.46944 3.00057 5.97825 3.21121 6.35351 3.5861C6.72877 3.96098 6.93974 4.46958 6.94 5.00002ZM7 8.48002H3V21.0001H7V8.48002ZM13.32 8.48002H9.34V21.0001H13.28V14.43C13.28 10.77 18.05 10.43 18.05 14.43V21.0001H22V13.07C22 6.90002 14.94 7.13002 13.28 10.16L13.32 8.48002Z"/></svg>
            </div>
            <span class="floating-text">LinkedIn</span>
        </a>
    </div>

    <style>
    /* Ultra-Premium Floating Sidebar */
    .floating-sidebar {
        position: fixed;
        right: 0;
        top: 65%;
        transform: translateY(-50%);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .floating-btn {
        transform: translateX(calc(100% - 60px));
        display: flex;
        align-items: center;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: white;
        padding: 8px 20px 8px 12px;
        border-radius: 30px 0 0 30px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-right: none;
        text-decoration: none;
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        overflow: hidden;
        position: relative;
    }

    .floating-btn:hover {
        transform: translateX(0);
    }

    /* Colors and gradients */
    .floating-btn.trending {
        background: linear-gradient(135deg, rgba(227, 30, 36, 0.95) 0%, rgba(160, 15, 20, 0.95) 100%);
        box-shadow: -5px 5px 20px rgba(227, 30, 36, 0.3);
    }
    .floating-btn.trending:hover {
        background: linear-gradient(135deg, rgba(240, 40, 45, 1) 0%, rgba(180, 20, 25, 1) 100%);
        box-shadow: -8px 8px 25px rgba(227, 30, 36, 0.5);
    }

    .floating-btn.instagram {
        background: linear-gradient(135deg, rgba(225, 48, 108, 0.95) 0%, rgba(193, 53, 132, 0.95) 100%);
        box-shadow: -5px 5px 20px rgba(225, 48, 108, 0.3);
    }
    .floating-btn.instagram:hover {
        background: linear-gradient(135deg, rgba(253, 29, 29, 1) 0%, rgba(131, 58, 180, 1) 100%);
        box-shadow: -8px 8px 25px rgba(225, 48, 108, 0.5);
    }

    .floating-btn.twitter {
        background: linear-gradient(135deg, rgba(20, 20, 20, 0.95) 0%, rgba(0, 0, 0, 0.95) 100%);
        box-shadow: -5px 5px 20px rgba(0, 0, 0, 0.3);
    }
    .floating-btn.twitter:hover {
        background: linear-gradient(135deg, rgba(40, 40, 40, 1) 0%, rgba(10, 10, 10, 1) 100%);
        box-shadow: -8px 8px 25px rgba(0, 0, 0, 0.5);
    }

    .floating-btn.linkedin {
        background: linear-gradient(135deg, rgba(10, 102, 194, 0.95) 0%, rgba(0, 65, 130, 0.95) 100%);
        box-shadow: -5px 5px 20px rgba(10, 102, 194, 0.3);
    }
    .floating-btn.linkedin:hover {
        background: linear-gradient(135deg, rgba(10, 102, 194, 1) 0%, rgba(0, 65, 130, 1) 100%);
        box-shadow: -8px 8px 25px rgba(10, 102, 194, 0.5);
    }

    /* Icon styles */
    .floating-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        margin-right: 12px;
        backdrop-filter: blur(4px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        flex-shrink: 0;
        position: relative;
    }

    .floating-btn:hover .floating-icon {
        transform: rotate(360deg);
        background: white;
    }

    .floating-btn.trending:hover .floating-icon { color: #e31e24; box-shadow: 0 0 15px rgba(255, 255, 255, 0.6); }
    .floating-btn.instagram:hover .floating-icon { color: #E1306C; box-shadow: 0 0 15px rgba(255, 255, 255, 0.6); }
    .floating-btn.twitter:hover .floating-icon { color: #000000; box-shadow: 0 0 15px rgba(255, 255, 255, 0.6); }
    .floating-btn.linkedin:hover .floating-icon { color: #0A66C2; box-shadow: 0 0 15px rgba(255, 255, 255, 0.6); }

    .floating-text {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.8px;
        white-space: nowrap;
        text-transform: uppercase;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        padding-right: 10px;
    }

    /* Light sweep effect on the main trending button to make it stand out slightly */
    .floating-btn.trending::after {
        content: '';
        position: absolute;
        top: 0; left: -100%; width: 50%; height: 100%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
        transform: skewX(-25deg);
        animation: shine 5s infinite 2s;
    }

    @keyframes shine {
        0% { left: -100%; }
        20% { left: 200%; }
        100% { left: 200%; }
    }

    @media (max-width: 768px) {
        /* On mobile: convert to compact icon-only row at bottom-right */
        .floating-sidebar {
            top: auto !important;
            bottom: 140px;
            transform: none;
            flex-direction: column;
            gap: 6px;
        }
        /* Only show icon circle, hide text — pill stays peekable from right */
        .floating-btn {
            transform: translateX(calc(100% - 44px)) !important;
            padding: 5px 12px 5px 8px !important;
        }
        .floating-btn:hover,
        .floating-btn:active {
            transform: translateX(0) !important;
        }
        .floating-icon {
            width: 28px !important;
            height: 28px !important;
            margin-right: 8px !important;
        }
        .floating-text {
            font-size: 11px !important;
        }
    }

    </style>
</body>
</html>

