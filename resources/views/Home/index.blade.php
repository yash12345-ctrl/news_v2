@extends('templates.base', ['title' => 'Akhbar-e-mashriq', 'home_page' => true])

@section('content')

<section class="hero-section has-border-bottom">
    <div class="container">
        <div style="display: flex; flex-direction: column; gap: 48px; padding: 32px 0;">
            <!-- Featured Article & Ads Section -->
            @php
                $available_ads = collect($data['digital_ads'] ?? []);
                if (isset($data['random_ad']) && !$available_ads->contains('id', $data['random_ad']->id)) {
                    $available_ads->push($data['random_ad']);
                }

                // Filter out ads that are strictly assigned to Box 1 (3), Box 2 (4), or Box 3 (5)
                // so they don't get randomly used as fallbacks for the wrong box.
                $generic_ads = $available_ads->reject(function($ad) {
                    return in_array($ad->ad_kind, [3, 4, 5]);
                });

                // Assign the strict ad if available, otherwise fall back to a generic ad
                $box1_ad = $available_ads->firstWhere('ad_kind', 3);
                if (!$box1_ad) $box1_ad = $generic_ads->shift();

                $box2_ad = $available_ads->firstWhere('ad_kind', 4);
                if (!$box2_ad) $box2_ad = $generic_ads->shift();

                $box3_ad = $available_ads->firstWhere('ad_kind', 5);
                if (!$box3_ad) $box3_ad = $generic_ads->shift();
            @endphp
            <div class="hero-main-row" style="display: flex; gap: 24px; align-items: stretch; width: 100%;">
                <!-- Left Ad Block -->
                @if($box1_ad)
                    @php $ad = $box1_ad; @endphp
                    <a href="/ad-track/{{ $ad->id }}" target="_blank" class="hide-in-mobile hide-in-tab" style="flex: 0 0 200px; position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 30px rgba(0,0,0,0.08); text-decoration: none; display: flex; flex-direction: column; justify-content: flex-end; transition: transform 0.3s ease;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
                            <img src="{{ $ad->media_url }}" alt="{{ $ad->title }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                        </div>
                        @if(false)<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15,17,21,0) 0%, rgba(15,17,21,0.1) 40%, rgba(15,17,21,0.95) 100%); z-index: 1;"></div>@endif
                        <div style="position: absolute; top: 16px; left: 16px; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; z-index: 2; border: 1px solid rgba(255,255,255,0.1);">
                            Sponsored
                        </div>
                        <div style="position: relative; z-index: 2; padding: 24px 16px; display: flex; flex-direction: column; gap: 8px;">
                            @if(false)
                            <h4 style="margin: 0; font-size: 18px; font-weight: 800; color: #fff; font-family: 'Inter', sans-serif; line-height: 1.2; letter-spacing: -0.3px;">{{ $ad->title }}</h4>
                            @if($ad->description)
                            <p style="margin: 0; font-size: 12px; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; line-height: 1.5; font-weight: 400;">{{ Str::limit($ad->description, 50) }}</p>
                            @endif
                            @if($ad->cta_text)
                            <div style="margin-top: 8px; align-self: flex-start; display: inline-flex; align-items: center; gap: 6px; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; font-family: 'Inter', sans-serif; letter-spacing: 1px; border-bottom: 2px solid #e31e24; padding-bottom: 4px;">
                                {{ $ad->cta_text }}
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#e31e24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </div>
                            @endif
                            @endif
                        </div>
                    </a>
                @endif

                <!-- Main Featured Article -->
                <div style="flex: 1; min-width: 0; position: relative; display: flex; flex-direction: column;">
                @if ($data['last_article'])
                    <a href="{{$data['last_article']['article_url']}}" style="display: flex; flex-direction: column; flex: 1; position: relative; width: 100%; min-height: 410px; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            @if ($data['last_article']->isVideoArticle())
                                <img src="{{$data['last_article']['image_url']}}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" alt="{{$data['last_article']['title']}}">
                            @else
                                <iframe src="https://www.youtube.com/embed/{{ $data['last_article']->extractVideoId($data['last_article']->video_url) }}" style="width: 100%; height: 100%; object-fit: cover;" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            @endif
                        </div>

                        <!-- Dark Gradient Overlay for text readability -->
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(30,20,15,0.95) 0%, rgba(30,20,15,0.6) 40%, rgba(0,0,0,0) 100%); pointer-events: none;"></div>

                        <!-- Top Category Badge -->
                        <div style="position: absolute; top: 24px; left: 24px; background: rgba(0,0,0,0.6); color: #fff; padding: 6px 16px; border-radius: 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 500; letter-spacing: 0.5px;">
                            {{ $data['last_article']->category->name_en ?? 'Breaking News' }}
                        </div>

                        <!-- Content Overlay -->
                        <div style="position: relative; margin-top: auto; padding: 40px 32px 32px 32px; color: #ffffff; text-align: left; display: flex; flex-direction: column; align-items: flex-start; z-index: 1;">
                            <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 32px; font-weight: 700; line-height: 1.25; margin: 0 0 10px 0; max-width: 900px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3); text-align: left;">
                                {{$data['last_article']['title']}}
                            </h1>
                            <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #d0d0d0; max-width: 800px; margin: 0 0 20px 0; line-height: 1.5; text-shadow: 0 1px 2px rgba(0,0,0,0.5); text-align: left;">
                                {{ \Illuminate\Support\Str::limit($data['last_article']['content_short'] ?? '', 150) }}
                            </p>

                            <!-- Metadata -->
                            <div style="display: flex; align-items: center; gap: 24px; font-family: 'Inter', sans-serif; font-size: 12px; color: #bbb;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    {{date("d/m/Y", strtotime($data['last_article']['created_at']))}}
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
                </div>

                <!-- Right Ad Block -->
                <!-- Right Ad Block -->
                @if($box2_ad)
                    @php $ad = $box2_ad; @endphp
                    <a href="/ad-track/{{ $ad->id }}" target="_blank" class="hide-in-mobile hide-in-tab" style="flex: 0 0 200px; position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 30px rgba(0,0,0,0.08); text-decoration: none; display: flex; flex-direction: column; justify-content: flex-end; transition: transform 0.3s ease;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
                            <img src="{{ $ad->media_url }}" alt="{{ $ad->title }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                        </div>
                        @if(false)<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15,17,21,0) 0%, rgba(15,17,21,0.1) 40%, rgba(15,17,21,0.95) 100%); z-index: 1;"></div>@endif
                        <div style="position: absolute; top: 16px; left: 16px; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; z-index: 2; border: 1px solid rgba(255,255,255,0.1);">
                            Sponsored
                        </div>
                        <div style="position: relative; z-index: 2; padding: 24px 16px; display: flex; flex-direction: column; gap: 8px;">
                            @if(false)
                            <h4 style="margin: 0; font-size: 18px; font-weight: 800; color: #fff; font-family: 'Inter', sans-serif; line-height: 1.2; letter-spacing: -0.3px;">{{ $ad->title }}</h4>
                            @if($ad->description)
                            <p style="margin: 0; font-size: 12px; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; line-height: 1.5; font-weight: 400;">{{ Str::limit($ad->description, 50) }}</p>
                            @endif
                            @if($ad->cta_text)
                            <div style="margin-top: 8px; align-self: flex-start; display: inline-flex; align-items: center; gap: 6px; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; font-family: 'Inter', sans-serif; letter-spacing: 1px; border-bottom: 2px solid #e31e24; padding-bottom: 4px;">
                                {{ $ad->cta_text }}
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#e31e24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </div>
                            @endif
                            @endif
                        </div>
                    </a>
                @else
                    <div class="hide-in-mobile hide-in-tab" style="flex: 0 0 200px; position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 30px rgba(0,0,0,0.08); display: flex; flex-direction: column; justify-content: center; align-items: center; background: #fafafa; border: 1px solid rgba(0,0,0,0.04);">
                        <div style="position: absolute; top: 16px; right: 16px; background: rgba(0,0,0,0.1); color: #888; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; z-index: 2;">
                            Advertisement
                        </div>
                        <!-- Premium Ad Placeholder (Ad Slot Available) -->
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 20px; text-align: center; color: rgba(0,0,0,0.3); font-size: 13px; font-weight: 500;">
                            Premium Ad Space<br>Available
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>



<section class="section e-paper-section bg-primary pt-0">
    <div class="container">
        <div class="premium-mag-section">
                <style>
                    .premium-mag-section { display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px; align-items: start; padding-top: 20px; padding-bottom: 0; }

                    .premium-mag-card { text-decoration: none; color: inherit; display: flex; flex-direction: column; position: relative; }

                    .premium-mag-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 12px; position: relative; }
                    .premium-mag-header::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 60px; height: 2px; background: #e31e24; }

                    .premium-mag-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 800; color: #111; margin: 0; display: flex; align-items: center; letter-spacing: 0.5px; text-transform: uppercase; }

                    .premium-mag-title.ad-title { color: #888; font-size: 13px; font-family: 'Inter', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 2.5px; }
                    .premium-ad-container .premium-mag-header::after { background: #888; width: 40px; }

                    .premium-mag-date { font-family: 'Inter', sans-serif; font-size: 10px; color: #888; font-weight: 600; letter-spacing: 1.5px; display: flex; align-items: center; gap: 4px; text-transform: uppercase; }
                    .premium-mag-date svg { width: 12px; height: 12px; stroke-width: 2.5; }

                    /* Stacked Image Effect */
                    .premium-mag-stack { position: relative; width: 100%; aspect-ratio: 3 / 4; perspective: 1000px; }
                    .premium-mag-stack img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 12px 32px rgba(0,0,0,0.08); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); background: #fff; border: 1px solid rgba(0,0,0,0.04); }

                    .premium-mag-stack img.layer-1 { z-index: 3; transform: translateY(0) scale(1); }
                    .premium-mag-stack img.layer-2 { z-index: 2; transform: translateY(-16px) scale(0.95); opacity: 0.8; }
                    .premium-mag-stack img.layer-3 { z-index: 1; transform: translateY(-32px) scale(0.9); opacity: 0.5; }

                    .premium-mag-card:hover .premium-mag-stack img.layer-1 { transform: translateY(-12px) scale(1.02); box-shadow: 0 20px 48px rgba(0,0,0,0.12); }
                    .premium-mag-card:hover .premium-mag-stack img.layer-2 { transform: translateY(-24px) scale(0.98); opacity: 0.9; }
                    .premium-mag-card:hover .premium-mag-stack img.layer-3 { transform: translateY(-36px) scale(0.94); opacity: 0.7; }

                    /* Pill Button Overlay */
                    .premium-read-btn { position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%) translateY(20px); background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); color: #111; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; padding: 12px 24px; border-radius: 30px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); opacity: 0; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); z-index: 4; display: flex; align-items: center; gap: 8px; white-space: nowrap; pointer-events: none; }
                    .premium-mag-card:hover .premium-read-btn { transform: translateX(-50%) translateY(0); opacity: 1; }
                    .premium-read-btn svg { transition: transform 0.3s ease; }
                    .premium-mag-card:hover .premium-read-btn svg { transform: translateX(4px); }

                    /* Unified Ad Card */
                    .premium-ad-container { display: flex; flex-direction: column; height: 100%; }
                    .premium-ad-card { background: linear-gradient(145deg, #ffffff 0%, #f3f4f6 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; width: 100%; aspect-ratio: 3 / 4; position: relative; text-decoration: none; overflow: hidden; box-shadow: 0 12px 32px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.03); }
                    .premium-ad-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
                    .premium-ad-card:hover img { transform: scale(1.03); }
                    .premium-ad-label { position: absolute; top: 16px; right: 16px; background: rgba(0,0,0,0.8); color: #fff; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: 700; padding: 4px 10px; border-radius: 4px; letter-spacing: 1.5px; text-transform: uppercase; z-index: 2; }
                    .premium-mobile-read-btn { display: none; }

                    @media (max-width: 992px) {
                        .e-paper-section { display: none !important; }
                    }
                </style>

                <!-- Ad Block Container (First Ad) -->
                <div class="premium-ad-container hide-in-mobile">
                    <div class="premium-mag-header">
                        <h2 class="premium-mag-title ad-title">Premium Ad</h2>
                        <div class="premium-mag-date" style="visibility: hidden;">Hidden</div>
                    </div>
                    @if($box3_ad)
                        @php $ad = $box3_ad; @endphp
                        <a href="/ad-track/{{ $ad->id }}" target="_blank" class="premium-ad-card" style="display: flex; flex-direction: column; justify-content: flex-end; position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 12px 32px rgba(0,0,0,0.08); text-decoration: none;">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
                                <img src="{{ $ad->media_url }}" alt="{{ $ad->title }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            @if(false)<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15,17,21,0) 0%, rgba(15,17,21,0.2) 40%, rgba(15,17,21,0.95) 100%); z-index: 1;"></div>@endif
                            <div style="position: absolute; top: 16px; right: 16px; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; z-index: 2; border: 1px solid rgba(255,255,255,0.1);">Advertisement</div>

                            <!-- Spacing element to push text down -->
                            <div style="flex: 1; z-index: 2; pointer-events: none;"></div>

                            <div style="position: relative; z-index: 2; padding: 32px 24px; display: flex; flex-direction: column; gap: 10px;">
                                @if(false)
                                <h4 style="margin: 0; font-size: 24px; font-weight: 900; color: #fff; font-family: 'Inter', sans-serif; letter-spacing: -0.5px; line-height: 1.15;">{{ $ad->title }}</h4>
                                @if($ad->description)
                                <p style="margin: 0; font-size: 14px; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; line-height: 1.5; font-weight: 400;">{{ Str::limit($ad->description, 100) }}</p>
                                @endif
                                @if($ad->cta_text)
                                <div style="margin-top: 12px; align-self: flex-start; background: #e31e24; color: #fff; padding: 12px 24px; border-radius: 50px; font-size: 12px; font-weight: 800; text-transform: uppercase; font-family: 'Inter', sans-serif; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; box-shadow: 0 8px 24px rgba(227,30,36,0.3);">
                                    {{ $ad->cta_text }}
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </div>
                                @endif
                                @endif
                            </div>
                        </a>
                    @else
                        <div class="premium-ad-card">
                            <span class="premium-ad-placeholder">Premium<br>Ad Space</span>
                            <span class="premium-ad-label">Ad</span>
                        </div>
                    @endif
                </div>

                <!-- E-Paper Card -->
                <a href="/epaper/{{ $data['enews'] ? $data['enews']->id : '404-not-found' }}" class="premium-mag-card">
                    <div class="premium-mag-header">
                        <h2 class="premium-mag-title">E-Paper</h2>
                        <div class="premium-mag-date">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            {{ date("d/m/y") }}
                        </div>
                    </div>
                    <div class="premium-mag-stack">
                        <!-- Main Image -->
                        <img class="layer-1" src="{{ $data['enews'] && $data['enews']['image_url'] ? $data['enews']['image_url'] : '/assets/img/default-image.jpg' }}" alt="E-Paper Main">

                        <!-- Side Images layered behind -->
                        @if(isset($data['enews_paper_page']) && is_array($data['enews_paper_page']))
                            @foreach($data['enews_paper_page'] as $index => $val)
                                @if($index == 0)
                                    <img class="layer-2" src="{{$val['page_sm_url']}}" alt="Page 1">
                                @elseif($index == 1)
                                    <img class="layer-3" src="{{$val['page_sm_url']}}" alt="Page 2">
                                @endif
                                @if($index == 1) @break @endif
                            @endforeach
                        @endif

                        <div class="premium-read-btn">
                            Read Edition
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </div>
                    </div>

                </a>

                <!-- Ad Block Container -->
                <div class="premium-ad-container hide-in-mobile">
                    <div class="premium-mag-header">
                        <h2 class="premium-mag-title ad-title">Sponsorship</h2>
                        <div class="premium-mag-date" style="visibility: hidden;">Hidden</div>
                    </div>
                    <div class="premium-ad-card" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px;">
                        <!-- Google AdSense Placeholder -->
                        <ins class="adsbygoogle"
                             style="display:block; width: 100%; height: 100%; text-align:center;"
                             data-ad-client="ca-pub-9409984276673694"
                             data-ad-slot="7082473157"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>
                             if (window.innerWidth > 768) {
                                 (adsbygoogle = window.adsbygoogle || []).push({});
                             }
                        </script>
                        <span class="premium-ad-label">Advertisement</span>
                    </div>
                </div>
        </div>
    </div>
</section>
<section class="section bg-primary has-border-bottom pt-0">
    <div class="container">
        <div style="padding-bottom: 32px;">


            <!-- Popular Today Split Section -->
            <div style="width: 100%;">
                <!-- Premium Header -->
                <div class="pop-header premium-trending-header-mobile" style="margin-bottom: 24px; direction: ltr; display: flex !important; flex-direction: row !important; justify-content: space-between; align-items: flex-start !important;">
                    <h2 class="pop-title premium-trending-title-mobile" style="margin: 0;">
                        <span class="tt-main" style="font-size: 24px !important; line-height: 1.1;">Popular</span>
                        <span class="tt-sub" style="font-size: 32px !important;">Today</span>
                    </h2>
                    <div class="trending-supertitle">Most Read</div>
                </div>

                <style>
                    /* HEADER */
                    .pop-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 12px; position: relative; }
                    .pop-header::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 60px; height: 2px; background: #e31e24; }
                    .pop-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 800; color: #111; margin: 0; letter-spacing: 0.5px; text-transform: uppercase; }
                    /* LEFT PANEL */
                    .pop-split { display: flex; gap: 32px; align-items: stretch; height: 420px; }
                    .pop-left-panel { flex: 0 0 46%; position: relative; border-radius: 22px; overflow: hidden; box-shadow: 0 24px 60px rgba(0,0,0,0.18); background: #111; text-decoration: none; color: inherit; display: block; }
                    .pop-left-panel img { width: 100%; height: 100%; min-height: 420px; object-fit: cover; display: block; transition: transform 0.8s cubic-bezier(0.16,1,0.3,1); opacity: 0.88; }
                    .pop-left-panel:hover img { transform: scale(1.05); }
                    .pop-left-panel .pop-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(5,5,5,0.96) 0%, rgba(5,5,5,0.4) 50%, transparent 100%); pointer-events: none; }
                    .pop-left-panel .pop-info { position: absolute; bottom: 0; left: 0; right: 0; padding: 28px 28px; direction: ltr; text-align: left; }
                    .pop-left-panel .pop-badge { display: inline-flex; align-items: center; gap: 6px; background: #e31e24; color: #fff; font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 12px; border-radius: 6px; margin-bottom: 12px; }
                    .pop-left-panel h3 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; line-height: 1.35; color: #fff; margin: 0 0 8px 0; }
                    .pop-left-panel .pop-meta { font-family: 'Inter', sans-serif; font-size: 11px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1.2px; font-weight: 600; }
                    /* RIGHT PANEL */
                    .pop-right-panel { flex: 1; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; }
                    .pop-right-list { display: flex; flex-direction: column; flex: 1; overflow-y: auto; padding-right: 8px; margin-bottom: 10px; }
                    .pop-right-list::-webkit-scrollbar { width: 4px; }
                    .pop-right-list::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 4px; }
                    .pop-right-item { display: flex; gap: 12px; align-items: center; padding: 10px 10px; border-bottom: 1px solid rgba(0,0,0,0.06); text-decoration: none; color: inherit; cursor: pointer; border-radius: 12px; transition: background 0.2s ease; flex-shrink: 0; }
                    .pop-right-item:last-of-type { border-bottom: none; }
                    .pop-right-item:hover { background: rgba(0,0,0,0.03); }
                    .pop-right-item.pop-active { background: rgba(227,30,36,0.06); }
                    .pop-right-item .pop-rank { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: rgba(0,0,0,0.07); line-height: 1; flex-shrink: 0; width: 28px; text-align: center; }
                    .pop-right-item.pop-active .pop-rank { color: #e31e24; }
                    .pop-right-item .pop-thumb { border-radius: 10px; overflow: hidden; flex-shrink: 0; }
                    .pop-right-item .pop-thumb img { width: 72px; height: 72px; object-fit: cover; display: block; transition: transform 0.4s ease; }
                    .pop-right-item:hover .pop-thumb img { transform: scale(1.07); }
                    .pop-right-item .pop-text { flex: 1; direction: ltr; text-align: left; }
                    .pop-right-item h4 { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 600; line-height: 1.35; color: #111; margin: 0 0 4px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
                    .pop-right-item .pop-date { font-family: 'Inter', sans-serif; font-size: 10px; color: #999; text-transform: uppercase; letter-spacing: 0.9px; font-weight: 600; }
                    /* NEXT BUTTON */
                    .pop-next-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; margin-top: 20px; padding: 12px 28px; background: #111; color: #fff; border: none; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 0.6px; cursor: pointer; text-transform: uppercase; transition: background 0.25s ease, transform 0.2s ease, box-shadow 0.2s ease; align-self: flex-start; box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
                    .pop-next-btn:hover { background: #e31e24; transform: translateY(-2px); box-shadow: 0 12px 28px rgba(227,30,36,0.3); }
                    .pop-next-btn svg { transition: transform 0.3s ease; }
                    .pop-next-btn:hover svg { transform: translateX(5px); }
                    
                    /* --- MOBILE RESPONSIVE --- */
                    @media (max-width: 992px) {
                        .pop-split { flex-direction: column; height: auto; }
                        .pop-left-panel { flex: 0 0 auto; height: 350px; }
                        .pop-left-panel img { min-height: 350px; }
                        .pop-right-panel { flex: 0 0 auto; overflow: visible; }
                        .pop-right-list { max-height: 400px; padding-right: 0; }
                    }
                </style>

                @php $popularArticles = $data['popular_articles']; @endphp

                @if(count($popularArticles) > 0)
                <div class="pop-split">
                    <!-- LEFT: Big Featured Image -->
                    <a href="{{ $popularArticles[0]['article_url'] }}" class="pop-left-panel" id="popFeaturedLink">
                        <img src="{{ $popularArticles[0]['image_url'] }}" alt="{{ $popularArticles[0]['title'] }}" id="popFeaturedImg">
                        <div class="pop-overlay"></div>
                        <div class="pop-info">
                            <span class="pop-badge">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Popular
                            </span>
                            <h3 id="popFeaturedTitle">
                                {{$popularArticles[0]['title']}}
                            </h3>
                            <div class="pop-meta" id="popFeaturedDate">{{date("M d, Y", strtotime($popularArticles[0]['created_at']))}}</div>
                        </div>
                    </a>

                    <!-- RIGHT: Article List + Next Button -->
                    <div class="pop-right-panel">
                        <div class="pop-right-list">
                            @foreach($popularArticles as $i => $pa)
                            <a href="{{ $pa['article_url'] }}"
                               class="pop-right-item {{ $i === 0 ? 'pop-active' : '' }}"
                               data-img="{{ $pa['image_url'] }}"
                               data-url="{{ $pa['article_url'] }}"
                               onclick="popSelectItem(event, this)">
                                <span class="pop-rank">{{ $i + 1 }}</span>
                                <div class="pop-thumb"><img src="{{ $pa['image_sm_url'] }}" alt="{{ $pa['title'] }}"></div>
                                <div class="pop-text">
                                    <h4>
                                        {{$pa['title']}}
                                    </h4>
                                    <span class="pop-date">{{date("M d, Y", strtotime($pa['created_at']))}}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        <button class="pop-next-btn" onclick="popGoNext()" type="button">
                            Next Article
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <script>
                    (function() {
                        var popIdx = 0;
                        var popItems = document.querySelectorAll('.pop-right-item');

                        function applySelection(el) {
                            popItems.forEach(function(i) { i.classList.remove('pop-active'); });
                            el.classList.add('pop-active');
                            popIdx = Array.from(popItems).indexOf(el);
                            var img = document.getElementById('popFeaturedImg');
                            var title = document.getElementById('popFeaturedTitle');
                            var date = document.getElementById('popFeaturedDate');
                            var link = document.getElementById('popFeaturedLink');
                            img.style.opacity = '0';
                            img.style.transition = 'opacity 0.3s ease';
                            setTimeout(function() {
                                img.src = el.dataset.img;
                                img.onload = function() { img.style.opacity = '0.88'; };
                            }, 150);
                            title.textContent = el.querySelector('h4').textContent.trim();
                            date.textContent = el.querySelector('.pop-date').textContent.trim();
                            link.href = el.dataset.url;
                        }

                        window.popSelectItem = function(e, el) {
                            e.preventDefault();
                            applySelection(el);
                        };

                        window.popGoNext = function() {
                            popIdx = (popIdx + 1) % popItems.length;
                            applySelection(popItems[popIdx]);
                            popItems[popIdx].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        };
                    })();
                </script>
                @endif
            </div>
        </div>
    </div>
</section>



<section class="section bg-primary trending-article-section has-border-bottom pt-0">
    <div class="container">
        <!-- Premium Header -->
        <div class="pop-header premium-trending-header-mobile" style="margin-bottom: 24px; padding-top: 40px; direction: ltr; display: flex !important; flex-direction: row !important; justify-content: space-between; align-items: flex-start !important;">
            <h2 class="pop-title premium-trending-title-mobile" style="margin: 0;">
                <span class="tt-main" style="font-size: 24px !important; line-height: 1.1;">Latest</span>
                <span class="tt-sub" style="font-size: 32px !important;">Articles</span>
            </h2>
            <div class="trending-supertitle" style="margin-top: 8px;">Just In</div>
        </div>
        <div class="section-wrapper" style="gap: 48px;">
            <div class="trending-article-cards" style="flex: 1; min-width: 0;">
                <style>
                    .premium-news-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 12px 30px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); border: 1px solid rgba(0,0,0,0.03); display: flex; flex-direction: column; height: 100%; position: relative; }
                    .premium-news-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                    .premium-news-image-wrapper { position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; border-bottom: 1px solid rgba(0,0,0,0.03); }
                    .premium-news-image-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
                    .premium-news-card:hover .premium-news-image-wrapper img { transform: scale(1.05); }
                    .premium-news-badge { position: absolute; top: 12px; right: 12px; background: rgba(227, 30, 36, 0.95); color: #fff; padding: 4px 12px; border-radius: 4px; font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; box-shadow: 0 4px 12px rgba(227,30,36,0.2); backdrop-filter: blur(4px); z-index: 2; }
                    .premium-news-content { padding: 20px; display: flex; flex-direction: column; flex: 1; }
                    .premium-news-title { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 800; color: #111; line-height: 1.4; margin: 0 0 10px 0; text-align: right; direction: rtl; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
                    .premium-news-excerpt { font-family: 'Inter', sans-serif; font-size: 13px; color: #666; line-height: 1.6; margin: 0 0 20px 0; text-align: right; direction: rtl; flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
                    .premium-news-meta { display: flex; align-items: center; justify-content: flex-end; gap: 16px; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.06); direction: rtl; }
                    .premium-news-meta-item { display: flex; align-items: center; gap: 6px; color: #888; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; }
                    .premium-news-meta-item svg { width: 14px; height: 14px; fill: #aaa; }
                    .trending-article-cards-wrapper { gap: 24px; }
                    .premium-cta-button { display: inline-flex; align-items: center; gap: 12px; padding: 14px 36px; background: #111; color: #fff; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; border-radius: 50px; text-decoration: none; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
                    .premium-cta-button:hover { background: #e31e24; transform: translateY(-3px); box-shadow: 0 12px 24px rgba(227,30,36,0.3); color: #fff; }
                    .premium-cta-button svg { width: 16px; height: 16px; fill: currentColor; transition: transform 0.3s ease; }
                    .premium-cta-button:hover svg { transform: translateX(4px); }
                    .premium-cta-button:hover svg { transform: translateX(4px); }

                    /* Premium Hover Popup Styles */
                    .home-latest-article-link { position: relative; display: block; text-decoration: none; }
                    .article-preview-popup { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.95); width: 340px; background: #fff; border-radius: 16px; box-shadow: 0 16px 48px rgba(0,0,0,0.3); border: 1px solid rgba(0,0,0,0.05); padding: 16px; opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); z-index: 100; }
                    .home-latest-article-link:hover .article-preview-popup { opacity: 1; visibility: visible; transform: translate(-50%, -50%) scale(1.05); }
                    .article-preview-popup-img { width: 100%; height: 180px; object-fit: cover; border-radius: 12px; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
                    .article-preview-popup-content { padding: 0 4px; }
                    .article-preview-popup-title { font-family: "Poppins", "Noto Nastaliq Urdu", sans-serif; font-size: 16px; font-weight: 700; line-height: 2.2; color: #111; margin: 0 0 8px; text-align: right; unicode-bidi: plaintext; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
                    .article-preview-popup-time { font-family: "Inter", sans-serif; font-size: 12px; color: #888; margin: 0; font-weight: 500; text-transform: uppercase; text-align: right; letter-spacing: 0.5px; }
                    .trending-article-cards-wrapper, .trending-article-cards, .section-wrapper { overflow: visible !important; }

                    /* --- MOBILE RESPONSIVE PREMIUM DESIGN --- */
                    @media (max-width: 992px) {
                        .trending-article-section .section-wrapper { display: flex; flex-direction: column !important; gap: 40px !important; }
                        .trending-article-cards, .home-latest-sidebar { flex: 1 1 100% !important; max-width: 100% !important; width: 100% !important; }
                        
                        /* Layout fixes for mobile */
                        .trending-article-section .pop-header { padding-top: 20px; }
                        .trending-article-section .pop-title { font-size: 24px; text-align: center; width: 100%; }
                        .trending-article-section .pop-header::after { left: 50%; transform: translateX(-50%); width: 80px; }

                        .trending-article-cards-wrapper { display: flex; flex-direction: column; gap: 24px; }

                        /* Premium Mobile Card */
                        .premium-news-card {
                            flex-direction: row; /* Horizontal layout for compactness on mobile */
                            align-items: center;
                            border-radius: 16px;
                            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
                            border: 1px solid rgba(0,0,0,0.04);
                            padding: 12px;
                            gap: 16px;
                            background: #ffffff;
                            min-height: 140px;
                        }
                        
                        .premium-news-image-wrapper {
                            width: 110px;
                            height: 110px;
                            flex-shrink: 0;
                            border-radius: 12px;
                            border-bottom: none;
                        }
                        
                        .premium-news-badge {
                            top: 8px;
                            right: 8px;
                            font-size: 9px;
                            padding: 3px 8px;
                            border-radius: 6px;
                            box-shadow: 0 2px 8px rgba(227,30,36,0.3);
                        }
                        
                        .premium-news-content {
                            padding: 0;
                            justify-content: center;
                        }
                        
                        .premium-news-title {
                            font-size: 15px;
                            line-height: 1.5;
                            margin: 0 0 8px 0;
                            -webkit-line-clamp: 3;
                            font-weight: 700;
                        }
                        
                        .premium-news-excerpt {
                            display: none; /* Hide excerpt on mobile to keep it clean */
                        }
                        
                        .premium-news-meta {
                            padding-top: 0;
                            border-top: none;
                            gap: 12px;
                            justify-content: flex-start; /* Align meta to the right for RTL */
                            flex-direction: row-reverse;
                        }
                        
                        .premium-news-meta-item {
                            font-size: 10px;
                        }
                        .premium-news-meta-item svg { width: 12px; height: 12px; }

                        .section-header-cta-button {
                            width: 100%;
                            justify-content: center;
                            padding: 16px;
                        }
                    }
                    
                    @media (max-width: 576px) {
                        /* For very small screens, switch back to stacked card for better visual impact */
                        .premium-news-card {
                            flex-direction: column;
                            padding: 0;
                            min-height: auto;
                            border-radius: 20px;
                        }
                        .premium-news-image-wrapper {
                            width: 100%;
                            height: 200px;
                            border-radius: 20px 20px 0 0;
                        }
                        .premium-news-content {
                            padding: 20px;
                        }
                        .premium-news-title {
                            font-size: 18px;
                            -webkit-line-clamp: 3;
                        }
                        .premium-news-meta {
                            padding-top: 16px;
                            border-top: 1px solid rgba(0,0,0,0.04);
                            justify-content: space-between;
                            flex-direction: row;
                        }
                        .premium-news-excerpt {
                            display: -webkit-box;
                            margin-bottom: 16px;
                        }
                    }
                </style>
                <div class="trending-article-cards-wrapper">
                    @foreach($data['latest_article'] as $d)
                    <a href="{{$d->article_url}}" class="home-latest-article-link">
                        <div class="article-preview-popup">
                            <img class="article-preview-popup-img" src="{{$d->image_url}}" alt="{{$d->title}}" loading="lazy">
                            <div class="article-preview-popup-content">
                                <h4 class="article-preview-popup-title">{{$d->title}}</h4>
                                <p class="article-preview-popup-time">{{$d->created_at->diffForHumans()}}</p>
                            </div>
                        </div>
                        <div class="premium-news-card">
                            <div class="premium-news-image-wrapper">
                                <img src="{{$d->image_sm_url}}" alt="{{$d->title}}" loading="lazy">
                                <span class="premium-news-badge">{{$d->category->name_ur}}</span>
                            </div>
                            <div class="premium-news-content">
                                <h3 class="premium-news-title">{{$d->title}}</h3>
                                <p class="premium-news-excerpt">{{$d->content_short}}</p>
                                <div class="premium-news-meta">
                                    <div class="premium-news-meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>
                                        <span>{{$d->views}}</span>
                                    </div>
                                    <div class="premium-news-meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 3H14C18.4183 3 22 6.58172 22 11C22 15.4183 18.4183 19 14 19V22.5C9 20.5 2 17.5 2 11C2 6.58172 5.58172 3 10 3ZM12 17H14C17.3137 17 20 14.3137 20 11C20 7.68629 17.3137 5 14 5H10C6.68629 5 4 7.68629 4 11C4 14.61 6.46208 16.9656 12 19.4798V17Z"></path></svg>
                                        <span>0</span>
                                    </div>
                                    <div class="premium-news-meta-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z"></path></svg>
                                        <span style="direction: ltr; display: inline-block;">{{date("d/m/Y", strtotime($d->created_at))}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="section-header" style="padding: 16px 0; justify-content: center;">
                    <a href="/articles?latest=true" class="premium-cta-button">
                        <span>View all articles</span>
                        <span>
                            <svg class="section-header-cta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                        </span>
                    </a>
                </div>
            </div>
            <div class="trending-article-contents home-latest-sidebar" style="flex: 0 0 450px; max-width: 450px; width: 100%; border-left: none;">
                <div class="trending-article-contents-wrapper" style="padding: 0;">
                    <style>
                        .premium-trending-list { display: flex; flex-direction: column; }
                        .premium-trending-item { display: flex; align-items: center; padding: 20px 0; border-bottom: 1px solid rgba(0,0,0,0.06); transition: all 0.3s ease; gap: 24px; flex-direction: row-reverse; }
                        .premium-trending-item:last-child { border-bottom: none; }
                        .premium-trending-item:hover { transform: translateX(-6px); }
                        .premium-trending-number { font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 800; color: transparent; -webkit-text-stroke: 1px #e31e24; opacity: 0.3; transition: all 0.3s ease; min-width: 45px; text-align: center; }
                        .premium-trending-item:hover .premium-trending-number { opacity: 1; color: #e31e24; -webkit-text-stroke: 1px transparent; }
                        .premium-trending-content { flex: 1; display: flex; flex-direction: column; gap: 8px; text-align: right; }
                        .premium-trending-title { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 700; color: #111; line-height: 1.5; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
                        .premium-trending-meta { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
                        .premium-trending-box { background: #fff; border-radius: 12px; padding: 0 24px; box-shadow: 0 12px 30px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.03); }
                        
                        /* Premium Trending Header (All Devices) */
                            .premium-trending-header-mobile {
                                padding-top: 32px !important;
                                margin-bottom: 32px !important;
                                border-bottom: none !important;
                                display: flex !important;
                                flex-direction: row !important;
                                justify-content: space-between;
                                align-items: flex-start !important;
                                text-align: left !important;
                                direction: ltr !important;
                                width: 100%;
                            }
                            .premium-trending-header-mobile::after { display: none !important; }
                            
                            .trending-supertitle {
                                font-family: 'Inter', sans-serif;
                                font-size: 9px;
                                font-weight: 800;
                                color: #e31e24;
                                text-transform: uppercase;
                                letter-spacing: 2px;
                                margin: 0;
                                display: inline-flex;
                                align-items: center;
                                padding: 6px 12px;
                                border-radius: 50px;
                                background: rgba(227,30,36,0.06);
                                border: 1px solid rgba(227,30,36,0.12);
                                gap: 6px;
                                flex-shrink: 0;
                                margin-top: 8px; /* slight push down to balance */
                            }
                            .trending-supertitle::before {
                                content: '';
                                display: block;
                                width: 5px;
                                height: 5px;
                                border-radius: 50%;
                                background: #e31e24;
                                box-shadow: 0 0 0 2px rgba(227,30,36,0.2);
                                animation: pulse-trending 2s infinite;
                            }
                            @keyframes pulse-trending {
                                0% { box-shadow: 0 0 0 0 rgba(227,30,36,0.6); }
                                70% { box-shadow: 0 0 0 6px rgba(227,30,36,0); }
                                100% { box-shadow: 0 0 0 0 rgba(227,30,36,0); }
                            }
                            
                            .premium-trending-title-mobile {
                                margin: 0;
                                line-height: 1;
                                display: flex;
                                flex-direction: column;
                                align-items: flex-start !important;
                                text-align: left !important;
                            }
                            .premium-trending-title-mobile .tt-main {
                                font-family: 'Inter', sans-serif !important;
                                font-size: 32px !important;
                                font-weight: 900 !important;
                                color: #111 !important;
                                text-transform: uppercase !important;
                                letter-spacing: -1px !important;
                            }
                            .premium-trending-title-mobile .tt-sub {
                                font-family: 'Playfair Display', serif !important;
                                font-size: 36px !important;
                                font-style: italic !important;
                                font-weight: 400 !important;
                                margin-top: -4px;
                                background: linear-gradient(135deg, #e31e24 0%, #ff5e62 100%);
                                -webkit-background-clip: text;
                                -webkit-text-fill-color: transparent;
                                padding-right: 10px; /* prevent italic clipping */
                            }
                    </style>
                    <div class="pop-header premium-trending-header-mobile" style="margin-bottom: 24px; padding-top: 40px;">
                        <h2 class="pop-title premium-trending-title-mobile">
                            <span class="tt-main">Trending</span>
                            <span class="tt-sub">Articles</span>
                        </h2>
                        <div class="trending-supertitle">Live Updates</div>
                    </div>
                    <div class="premium-trending-box">
                    <div class="premium-trending-list">
                        @foreach($data['trending_articles'] as $t)
                            @if($loop->iteration > 13)
                                @break
                            @endif
                        <a href="{{$t['article_url']}}" style="text-decoration: none;">
                            <div class="premium-trending-item">
                                <div class="premium-trending-number">{{ sprintf('%02d', $loop->iteration) }}</div>
                                <div class="premium-trending-content">
                                    <h3 class="premium-trending-title">{{$t['title']}}</h3>
                                    <div class="premium-trending-meta">{{$t->created_at->diffForHumans()}}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-primary">
    <div class="container">
        <!-- Premium Header -->
        <div class="pop-header" style="margin-bottom: 24px; padding-top: 32px; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 16px; direction: ltr;">
            <h2 class="pop-title premium-trending-title-mobile" style="margin: 0;">
                <span class="tt-main" style="font-size: 24px !important; line-height: 1.1;">Past Popular</span>
                <span class="tt-sub" style="font-size: 32px !important;">Articles</span>
            </h2>
            <a class="section-header-cta-button" href="/articles?past_popular" style="text-decoration: none; display: flex; align-items: center; gap: 4px; flex-shrink: 0; margin-left: auto; padding-bottom: 4px;">
                <span class="section-header-cta-text" style="font-family: 'Inter', sans-serif; font-weight: 800; text-transform: uppercase; font-size: 10px; letter-spacing: 2px; color: #111;">view more</span>
                <svg class="section-header-cta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
            </a>
        </div>
        <style>
            /* === PPA Split Panel === */
            .ppa-split { display: grid; grid-template-columns: 3fr 2fr; gap: 0; border-radius: 20px; overflow: hidden; background: #fff; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.04); margin-top: 24px; min-height: 520px; }
            @media (max-width: 768px) { .ppa-split { grid-template-columns: 1fr; } }
            /* Left: Featured panel */
            .ppa-featured { position: relative; overflow: hidden; }
            .ppa-featured-img-wrap { position: absolute; inset: 0; }
            .ppa-featured-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1); display: block; }
            .ppa-featured-gradient { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.05) 100%); }
            .ppa-featured-body { position: absolute; bottom: 0; left: 0; right: 0; padding: 40px 36px; text-align: right; }
            .ppa-featured-badge { display: inline-flex; align-items: center; gap: 6px; background: #e31e24; color: #fff; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 12px; border-radius: 4px; margin-bottom: 16px; }
            .ppa-featured-title { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 800; color: #fff; line-height: 1.35; margin: 0 0 12px 0; text-shadow: 0 2px 10px rgba(0,0,0,0.5); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; transition: opacity 0.4s ease; }
            .ppa-featured-meta { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px; }
            .ppa-read-btn { display: inline-flex; align-items: center; gap: 8px; margin-top: 20px; padding: 10px 22px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; color: #fff; text-decoration: none; letter-spacing: 0.8px; text-transform: uppercase; transition: all 0.3s ease; }
            .ppa-read-btn:hover { background: rgba(255,255,255,0.3); }
            /* Right: Article list */
            .ppa-list-panel { position: relative; display: flex; flex-direction: column; overflow-y: auto; max-height: 520px; scrollbar-width: thin; scrollbar-color: #e5e5e5 transparent; }
            .ppa-list-panel::-webkit-scrollbar { width: 4px; }
            .ppa-list-panel::-webkit-scrollbar-thumb { background: #e5e5e5; border-radius: 4px; }
            .ppa-panel-item { appearance: none; background: transparent; width: 100%; text-align: right; font-family: inherit; display: flex; align-items: center; gap: 14px; padding: 16px 20px; border: none; border-bottom: 1px solid rgba(0,0,0,0.05); cursor: pointer; transition: all 0.25s ease; flex-direction: row-reverse; text-decoration: none; flex-shrink: 0; }
            .ppa-panel-item:last-child { border-bottom: none; }
            .ppa-panel-item:hover { background: rgba(0,0,0,0.02); }
            .ppa-panel-item.ppa-active { background: #fef2f2; border-right: 3px solid #e31e24; }
            .ppa-panel-thumb { width: 76px; height: 58px; border-radius: 8px; overflow: hidden; flex-shrink: 0; position: relative; }
            .ppa-panel-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
            .ppa-panel-item:hover .ppa-panel-thumb img { transform: scale(1.08); }
            .ppa-panel-content { flex: 1; text-align: right; }
            .ppa-panel-title { font-family: 'Playfair Display', serif; font-size: 13px; font-weight: 700; color: #111; line-height: 1.45; margin: 0 0 5px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s; }
            .ppa-panel-item.ppa-active .ppa-panel-title { color: #e31e24; }
            .ppa-panel-meta { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.8px; }
            .ppa-panel-num { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 800; color: #ccc; min-width: 18px; text-align: center; }
            .ppa-panel-item.ppa-active .ppa-panel-num { color: #e31e24; }
        </style>

        {{-- Collect all articles as JSON for JS --}}
        @php
            $ppaArticles = $data['past_popular_articles']->map(fn($a) => [
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
                    <img src="{{ $data['past_popular_articles'][0]->image_url }}" id="ppaFeaturedImg" alt="">
                </div>
                <div class="ppa-featured-gradient"></div>
                <div class="ppa-featured-body">
                    <div class="ppa-featured-badge">⭐ Popular</div>
                    <h2 class="ppa-featured-title" id="ppaFeaturedTitle">{{ $data['past_popular_articles'][0]->title }}</h2>
                    <div class="ppa-featured-meta" id="ppaFeaturedMeta">{{ $data['past_popular_articles'][0]->created_at->diffForHumans() }}</div>
                    <span class="ppa-read-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16.172 11l-4.95-4.95 1.414-1.414L20 12l-7.364 7.364-1.414-1.414L16.172 13H4v-2z"/></svg>
                        <span>Read Article</span>
                    </span>
                </div>
            </a>
            {{-- Right: article list --}}
            <div class="ppa-list-panel" id="ppaListPanel">
                @foreach($data['past_popular_articles'] as $idx => $article)
                <button class="ppa-panel-item {{ $idx === 0 ? 'ppa-active' : '' }}" onclick="ppaSelect({{ $idx }})" data-idx="{{ $idx }}">
                    <div class="ppa-panel-num">{{ sprintf('%02d', $idx + 1) }}</div>
                    <div class="ppa-panel-thumb">
                        <img src="{{ $article->image_sm_url }}" alt="{{ $article->title }}" loading="lazy">
                    </div>
                    <div class="ppa-panel-content">
                        <h4 class="ppa-panel-title">{{ $article->title }}</h4>
                        <div class="ppa-panel-meta">{{ $article->created_at->diffForHumans() }}</div>
                    </div>
                </button>
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
    </div>
</section>
<style>
/* === Premium App Promo Section === */
.app-promo-section { padding: 80px 0; background: #130a0d; position: relative; overflow: hidden; }
/* Subtle background grid */
.app-promo-section::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 40px 40px; pointer-events: none; }

.app-promo-card { max-width: 940px; margin: 0 auto; background: radial-gradient(ellipse at 0% 0%, #2a0e14 0%, #151515 50%, #111 100%); border-radius: 24px; padding: 40px 50px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: center; position: relative; border: 1px solid rgba(255,255,255,0.06); box-shadow: 0 40px 100px rgba(0,0,0,0.5); z-index: 1; direction: ltr; text-align: left; }
@media(max-width: 992px) { .app-promo-card { grid-template-columns: 1fr; padding: 40px; text-align: center; } }

.app-promo-badge { display: inline-block; border: 1px solid rgba(227, 30, 36, 0.3); background: rgba(227, 30, 36, 0.08); color: #e31e24; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 14px; border-radius: 50px; margin-bottom: 24px; }
.app-promo-title { font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 800; color: #fff; line-height: 1.15; margin: 0 0 16px 0; }
.app-promo-desc { font-family: 'Inter', sans-serif; font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.6; max-width: 440px; margin: 0 0 32px 0; }
@media(max-width: 992px) { .app-promo-desc { margin: 0 auto 40px auto; } }

.app-promo-btns { display: flex; gap: 16px; flex-wrap: wrap; }
@media(max-width: 992px) { .app-promo-btns { justify-content: center; } }
.app-btn-custom { display: flex; align-items: center; gap: 12px; background: #000; border: 1px solid rgba(255,255,255,0.08); padding: 12px 24px; border-radius: 14px; text-decoration: none; transition: all 0.3s; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
.app-btn-custom:hover { background: #111; border-color: rgba(255,255,255,0.2); transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,0.4); }
.app-btn-icon svg { width: 22px; height: 22px; fill: #fff; }
.app-btn-text { display: flex; flex-direction: column; text-align: left; }
.app-btn-sub { font-family: 'Inter', sans-serif; font-size: 9px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
.app-btn-main { font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 700; color: #fff; line-height: 1; }

/* Right Visual - 3D Phone Mockup */
.app-promo-visual { position: relative; display: flex; justify-content: center; align-items: center; perspective: 1000px; }
.css-phone { width: 220px; height: 460px; background: #fff; border-radius: 36px; border: 8px solid #1c1c1e; box-shadow: 0 40px 80px rgba(0,0,0,0.6), inset 0 0 0 3px #000, inset 0 0 20px rgba(0,0,0,0.1); position: relative; overflow: hidden; transform: rotateY(-12deg) rotateX(4deg); transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1); transform-style: preserve-3d; }
.app-promo-visual:hover .css-phone { transform: rotateY(0deg) rotateX(0deg); }
.css-phone::after { content: ''; position: absolute; top: -20%; left: -50%; width: 200%; height: 200%; background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0) 100%); transform: rotate(30deg); pointer-events: none; z-index: 50; }
.css-phone-notch { position: absolute; top: 12px; left: 50%; transform: translateX(-50%); width: 70px; height: 20px; background: #000; border-radius: 20px; z-index: 10; box-shadow: inset 0 0 4px rgba(255,255,255,0.2); }

/* Phone internals styling */
.phone-header { background: #fff; padding: 46px 16px 12px 16px; border-bottom: 1px solid #f0f0f0; }
.phone-logo { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 800; color: #111; margin-bottom: 12px; }
.phone-nav { display: flex; gap: 14px; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: 700; color: #888; text-transform: uppercase; border-bottom: 1px solid #f5f5f5; padding-bottom: 6px; }
.phone-nav span.active { color: #e31e24; border-bottom: 2px solid #e31e24; padding-bottom: 4px; margin-bottom: -7px; }
.phone-body { padding: 12px; background: #fafafa; height: calc(100% - 90px); overflow-y: hidden; display: flex; flex-direction: column; gap: 10px; }
.phone-article { display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.02); }
.phone-article img { width: 56px; height: 42px; border-radius: 4px; object-fit: cover; flex-shrink: 0; }
.phone-article-title { font-family: 'Playfair Display', serif; font-size: 10px; font-weight: 700; color: #222; line-height: 1.35; margin: 0 0 4px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.phone-article-meta { font-family: 'Inter', sans-serif; font-size: 7px; color: #999; text-transform: uppercase; font-weight: 600; }

/* Floating badges */
.float-badge { position: absolute; backdrop-filter: blur(8px); border-radius: 50px; padding: 10px 18px; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 8px; box-shadow: 0 16px 32px rgba(0,0,0,0.4); z-index: 20; transition: transform 0.4s; }
.badge-live { top: 15%; right: -30px; background: rgba(60,60,65,0.85); border: 1px solid rgba(255,255,255,0.1); transform: translateZ(40px); }
.badge-live .dot { width: 8px; height: 8px; background: #ff3b3b; border-radius: 50%; box-shadow: 0 0 8px rgba(255,59,59,0.8); }
.badge-premium { bottom: 25%; left: -40px; background: rgba(30,30,32,0.85); border: 1px solid rgba(255,255,255,0.08); transform: translateZ(60px); color: #eee; font-size: 11px; padding: 12px 20px;}
.app-promo-visual:hover .badge-live { transform: translateZ(60px) translateX(-10px); }
.app-promo-visual:hover .badge-premium { transform: translateZ(80px) translateX(10px); }
</style>

<section class="section app-promo-section">
    <div class="container">
        <div class="app-promo-card">
            {{-- Left Content --}}
            <div class="app-promo-content">
                <span class="app-promo-badge">Akhbar-E-Mashriq App</span>
                <h2 class="app-promo-title">News in your<br>pocket, instantly.</h2>
                <p class="app-promo-desc">Experience lightning-fast updates, personalized feeds, and premium journalism directly on your device.</p>
                <div class="app-promo-btns">
                    <a href="https://play.google.com/store/apps/details?id=com.akhbarmashriq" class="app-btn-custom">
                        <div class="app-btn-icon">
                            <svg viewBox="0 0 24 24"><path d="M3.60972 1.81396L13.793 12L3.61082 22.1864C3.41776 22.1048 3.24866 21.962 3.13555 21.7667C3.0474 21.6144 3.00098 21.4416 3.00098 21.2656V2.73453C3.00098 2.32109 3.25188 1.96625 3.60972 1.81396ZM14.5 12.707L16.802 15.009L5.86498 21.342L14.5 12.707ZM17.699 9.50896L20.5061 11.1347C20.9841 11.4114 21.1473 12.0232 20.8705 12.5011C20.783 12.6523 20.6574 12.778 20.5061 12.8655L17.698 14.491L15.207 12L17.699 9.50896ZM5.86498 2.65796L16.803 8.98996L14.5 11.293L5.86498 2.65796Z"></path></svg>
                        </div>
                        <div class="app-btn-text">
                            <span class="app-btn-sub">Get it on</span>
                            <span class="app-btn-main">Google Play</span>
                        </div>
                    </a>
                    <a href="https://apps.apple.com/in/app/akhbar-e-mashriq/id6468312807" class="app-btn-custom">
                        <div class="app-btn-icon">
                            <svg viewBox="0 0 24 24"><path d="M11.6734 7.2221C10.7974 7.2221 9.44138 6.2261 8.01338 6.2621C6.12938 6.2861 4.40138 7.3541 3.42938 9.0461C1.47338 12.4421 2.92538 17.4581 4.83338 20.2181C5.76938 21.5621 6.87338 23.0741 8.33738 23.0261C9.74138 22.9661 10.2694 22.1141 11.9734 22.1141C13.6654 22.1141 14.1454 23.0261 15.6334 22.9901C17.1454 22.9661 18.1054 21.6221 19.0294 20.2661C20.0974 18.7061 20.5414 17.1941 20.5654 17.1101C20.5294 17.0981 17.6254 15.9821 17.5894 12.6221C17.5654 9.8141 19.8814 8.4701 19.9894 8.4101C18.6694 6.4781 16.6414 6.2621 15.9334 6.2141C14.0854 6.0701 12.5374 7.2221 11.6734 7.2221ZM14.7934 4.3901C15.5734 3.4541 16.0894 2.1461 15.9454 0.850098C14.8294 0.898098 13.4854 1.5941 12.6814 2.5301C11.9614 3.3581 11.3374 4.6901 11.5054 5.9621C12.7414 6.0581 14.0134 5.3261 14.7934 4.3901Z"></path></svg>
                        </div>
                        <div class="app-btn-text">
                            <span class="app-btn-sub">Download on the</span>
                            <span class="app-btn-main">App Store</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Right Content: 3D CSS Phone Mockup --}}
            <div class="app-promo-visual">
                <div class="css-phone">
                    <div class="css-phone-notch"></div>
                    <img src="/assets/img/app1.jpeg" alt="App Screenshot" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                </div>
                {{-- Floating Badges --}}
                <div class="float-badge badge-live">
                    <span class="dot"></span> Live Updates
                </div>
                <div class="float-badge badge-premium">
                    Premium Content
                </div>
            </div>
        </div>
    </div>
</section>
@if (isset($promotion))
<section class="section popup-section" id="popupSection" style="background: rgba(15,17,21,0.85); backdrop-filter: blur(16px); z-index: 999999; position: fixed;">
    <div class="container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="section-wrapper" style="width: 100%; max-width: 900px; display: flex; justify-content: center; align-items: center;">
            <div class="popup-card" style="position: relative; width: 100%; display: flex; justify-content: center; align-items: center;">

                <div id="closeButton" style="position: absolute; top: -20px; right: -20px; background: #fff; width: 44px; height: 44px; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2); cursor: pointer; z-index: 100; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: stroke 0.3s ease;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </div>

                <a href="{{ $promotion->link }}" target="_blank" style="display: block; width: 100%; border-radius: 24px; overflow: hidden; box-shadow: 0 40px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.1); transform: scale(0.95) translateY(20px); opacity: 0; animation: premiumPopup 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
                    <img src="{{ $promotion->image_url }}" alt="Promotion" style="width: 100%; height: auto; max-height: 85vh; object-fit: contain; display: block; background: #0f1115; border-radius: 24px;">
                </a>

                <style>
                    @keyframes premiumPopup {
                        to { transform: scale(1) translateY(0); opacity: 1; }
                    }
                    #closeButton:hover { transform: scale(1.1) rotate(90deg); background: #e31e24; }
                    #closeButton:hover svg { stroke: #fff !important; }
                </style>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     HOMEPAGE MOBILE RESPONSIVENESS — Consolidated Media Queries
     ============================================================ --}}
<style>

/* ---------------------------------------------------------------
   1. HERO SECTION — Featured Article row
--------------------------------------------------------------- */
@media (max-width: 768px) {
    .hero-main-row {
        flex-direction: column !important;
        gap: 16px !important;
    }

    /* Reduce hero article height and text on mobile */
    .hero-main-row > div[style*="flex: 1"] a,
    .hero-main-row > div > a {
        min-height: 280px !important;
        border-radius: 16px !important;
    }

    /* Reduce h1 font size inside hero */
    .hero-main-row h1 {
        font-size: 20px !important;
        line-height: 1.3 !important;
        margin-bottom: 8px !important;
    }

    /* Reduce excerpt text */
    .hero-main-row p {
        font-size: 12px !important;
        margin-bottom: 12px !important;
    }

    /* Tighten content overlay padding */
    .hero-main-row div[style*="padding: 40px 32px"] {
        padding: 20px 16px 16px 16px !important;
    }

    /* Reduce overall hero section top padding */
    .hero-section .container > div {
        padding: 16px 0 !important;
        gap: 24px !important;
    }
}

/* ---------------------------------------------------------------
   2. E-PAPER SECTION — premium-mag-section
   (already has 992px breakpoint; only minor mobile tweaks needed)
--------------------------------------------------------------- */
@media (max-width: 600px) {
    .premium-mag-section {
        gap: 32px !important;
        padding-bottom: 48px !important;
    }

    .premium-mag-stack {
        height: 300px !important;
    }

    .premium-ad-card {
        height: 220px !important;
    }

    .premium-mag-title {
        font-size: 16px !important;
    }
}

/* ---------------------------------------------------------------
   3. POPULAR TODAY — pop-split
--------------------------------------------------------------- */
@media (max-width: 768px) {
    .pop-split {
        flex-direction: column !important;
        height: auto !important;
        gap: 16px !important;
    }

    .pop-left-panel {
        flex: none !important;
        width: 100% !important;
        min-height: 260px !important;
        height: 260px !important;
        border-radius: 16px !important;
    }

    .pop-left-panel img {
        min-height: 260px !important;
        height: 260px !important;
    }

    .pop-left-panel h3 {
        font-size: 18px !important;
        line-height: 1.3 !important;
    }

    .pop-left-panel .pop-info {
        padding: 16px !important;
    }

    .pop-right-panel {
        flex: none !important;
        width: 100% !important;
        max-height: 320px !important;
        overflow-y: auto !important;
    }

    .pop-right-item {
        padding: 8px !important;
    }

    .pop-right-item .pop-rank {
        font-size: 18px !important;
        width: 22px !important;
    }

    .pop-right-item .pop-thumb img {
        width: 60px !important;
        height: 60px !important;
    }

    .pop-next-btn {
        width: 100% !important;
        justify-content: center !important;
        margin-top: 12px !important;
    }

    .pop-title {
        font-size: 16px !important;
    }
}

/* ---------------------------------------------------------------
   4. LATEST ARTICLES SECTION
   — cards grid already responsive via styles.css
   — fix the hardcoded 450px right sidebar
--------------------------------------------------------------- */
@media (max-width: 775px) {
    .home-latest-sidebar {
        flex: none !important;
        max-width: 100% !important;
        width: 100% !important;
    }

    /* Hide hover popup on touch screens — causes layout issues */
    .article-preview-popup {
        display: none !important;
    }

    .premium-trending-item:hover {
        transform: none !important;
    }

    .premium-trending-number {
        font-size: 28px !important;
        min-width: 34px !important;
    }

    .premium-trending-title {
        font-size: 14px !important;
    }

    .premium-trending-box {
        padding: 0 12px !important;
    }
}

/* ---------------------------------------------------------------
   5. PAST POPULAR ARTICLES — ppa-split
   (grid already collapses to 1fr at 768px)
--------------------------------------------------------------- */
@media (max-width: 768px) {
    .ppa-featured {
        min-height: 280px !important;
    }

    .ppa-featured-body {
        padding: 20px 20px !important;
    }

    .ppa-featured-title {
        font-size: 18px !important;
        -webkit-line-clamp: 2 !important;
    }

    .ppa-list-panel {
        max-height: 300px !important;
    }

    .ppa-panel-thumb {
        width: 60px !important;
        height: 46px !important;
    }

    .ppa-panel-title {
        font-size: 12px !important;
    }
}

/* ---------------------------------------------------------------
   6. APP PROMO SECTION — css-phone + badges
--------------------------------------------------------------- */
@media (max-width: 600px) {
    .css-phone {
        width: 170px !important;
        height: 360px !important;
        border-radius: 28px !important;
    }

    .app-promo-title {
        font-size: 28px !important;
    }

    .badge-live {
        right: 0 !important;
        font-size: 10px !important;
        padding: 7px 12px !important;
    }

    .badge-premium {
        left: 0 !important;
        font-size: 10px !important;
        padding: 8px 14px !important;
    }

    .app-btn-custom {
        padding: 10px 16px !important;
    }

    .app-promo-card {
        padding: 28px 24px !important;
    }
}

/* ---------------------------------------------------------------
   GLOBAL — prevent horizontal overflow on mobile
--------------------------------------------------------------- */
@media (max-width: 768px) {
    .hero-section,
    .e-paper-section,
    .trending-article-section,
    .app-promo-section {
        overflow-x: hidden;
    }

    /* Ensure container doesn't cause overflow */
    .container {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }
}

</style>
@endsection


@section('vue_app')

<script>
    const promotion = @json($promotion ?? null);

    // Only run popup logic if a promotion exists
    if (promotion) {
        const closeButton = document.getElementById("closeButton");
        const popupSection = document.getElementById("popupSection");
        const saved = localStorage.getItem(`show_promotion_${promotion.id}`);

        if (!saved && popupSection) {
            popupSection.classList.add('is-open');
        }
        if (closeButton) {
            closeButton.addEventListener("click", () => {
                popupSection.classList.remove("is-open");
                popupSection.classList.add("is-close");
                setTimeout(() => {
                    popupSection.classList.remove("is-close");
                }, 300);

                if (promotion.irritating_visitor == 2) {
                    localStorage.setItem(`show_promotion_${promotion.id}`, JSON.stringify(promotion));
                }
            });
        }
    }

    document.querySelector('#navMenuToggler') && document.querySelector('#navMenuToggler').addEventListener('click', (e) => {
        // Handled by base.blade.php — no-op here to avoid double-binding
    });

</script>

<!-- Mobile Scroll E-Paper Popup -->
<div class="mobile-epaper-popup" id="mobileEpaperPopup">
    <button class="mobile-epaper-popup-close" id="mobileEpaperPopupClose">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <a href="/epaper/{{ $data['enews'] ? $data['enews']->id : '404-not-found' }}" class="mobile-epaper-popup-content" style="text-decoration: none;">
        <div class="mep-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16l-3 2z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 12h8"/><path d="M10 16h8"/>
            </svg>
        </div>
        <div class="mep-text">
            <h4>Today's E-Paper</h4>
            <p>Digital edition available</p>
        </div>
        <div class="mep-btn">Open</div>
    </a>
</div>

<style>
    .mobile-epaper-popup {
        display: none;
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(150%);
        width: calc(100% - 32px);
        max-width: 400px;
        background: rgba(20, 20, 20, 0.95);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), inset 0 1px 1px rgba(255,255,255,0.1);
        z-index: 9999;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease;
        opacity: 0;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .mobile-epaper-popup.is-visible {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
    .mobile-epaper-popup-content {
        display: flex;
        align-items: center;
        padding: 12px;
        gap: 12px;
        position: relative;
        cursor: pointer;
    }
    .mobile-epaper-popup-close {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #333;
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: rgba(255,255,255,0.8);
        padding: 0;
        transition: background 0.2s;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }
    .mobile-epaper-popup-close:active { background: #555; }
    .mobile-epaper-popup-close svg { width: 12px; height: 12px; }
    
    .mep-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ff3b3f 0%, #e31e24 100%);
        color: #fff;
        border-radius: 12px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(227,30,36,0.3);
    }
    .mep-icon svg { width: 20px; height: 20px; }
    
    .mep-text {
        display: flex;
        flex-direction: column;
        flex: 1;
        text-align: left;
    }
    .mep-text h4 {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 700;
        margin: 0 0 2px 0;
        color: #fff;
        line-height: 1.1;
        letter-spacing: 0.2px;
    }
    .mep-text p {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 500;
        margin: 0;
        color: rgba(255,255,255,0.7);
        letter-spacing: 0.1px;
        line-height: 1.2;
    }
    .mep-btn {
        background: rgba(255,255,255,0.1);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 50px;
        text-decoration: none;
        white-space: nowrap;
        border: 1px solid rgba(255,255,255,0.05);
        transition: background 0.2s;
        margin-right: 4px;
    }
    .mep-btn:active { background: rgba(255,255,255,0.2); }
    
    @media (max-width: 992px) {
        .mobile-epaper-popup { display: block; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('mobileEpaperPopup');
        const closeBtn = document.getElementById('mobileEpaperPopupClose');
        
        // Remove sessionStorage so it appears fresh on every page load
        let isClosed = false; 
        
        if (popup) {
            window.addEventListener('scroll', function() {
                if (isClosed) return; // Don't show if user explicitly closed it
                
                // Show after 500px, hide if scrolled back up
                if (window.scrollY > 500) {
                    popup.classList.add('is-visible');
                } else {
                    popup.classList.remove('is-visible');
                }
            });
            
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                popup.classList.remove('is-visible');
                isClosed = true; // Stay closed for the rest of this page view
            });
        }
    });
</script>
@endsection
