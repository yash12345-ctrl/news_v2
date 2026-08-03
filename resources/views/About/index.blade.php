@extends('templates.base', ['title' => 'Akhbar-e-mashriq | About-us', 'ltr' => true])

@section('content')
<style>
/* ── ULTRA PREMIUM ABOUT US ARCHITECTURE ─────────────────── */
.am-about-universe { background: #0f172a; font-family: 'Inter', sans-serif; color: #f8fafc; overflow: hidden; }

/* Hero Section */
.am-about-hero { position: relative; padding: 140px 0 100px; background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.15) 0%, rgba(15, 23, 42, 1) 60%); border-bottom: 1px solid rgba(255,255,255,0.05); }
.am-hero-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 60px; align-items: center; position: relative; z-index: 2; }
.am-hero-badge { display: inline-flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); padding: 8px 20px; border-radius: 50px; font-size: 13px; text-transform: uppercase; letter-spacing: 3px; color: #38bdf8; margin-bottom: 30px; }
.am-hero-badge-dot { width: 6px; height: 6px; background: #38bdf8; border-radius: 50%; box-shadow: 0 0 10px #38bdf8; }
.am-hero-title { font-family: 'Playfair Display', serif; font-size: 72px; font-weight: 800; line-height: 1.05; letter-spacing: -2px; margin: 0 0 30px 0; background: linear-gradient(135deg, #ffffff 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.am-hero-subtitle { font-size: 20px; line-height: 1.7; color: #94a3b8; max-width: 600px; }
.am-stats-bento { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.am-stat-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px; padding: 40px 30px; backdrop-filter: blur(10px); transition: all 0.4s cubic-bezier(0.2, 1, 0.3, 1); }
.am-stat-card:hover { background: rgba(255,255,255,0.05); transform: translateY(-5px); border-color: rgba(56, 189, 248, 0.3); }
.am-stat-value { font-family: 'Playfair Display', serif; font-size: 56px; font-weight: 700; color: #ffffff; margin-bottom: 10px; line-height: 1; }
.am-stat-label { font-size: 14px; text-transform: uppercase; letter-spacing: 2px; color: #64748b; font-weight: 600; }

/* History Bento Grid */
.am-history-section { background: #f8fafc; color: #0f172a; padding: 140px 0; position: relative; }
.am-bento-grid { display: grid; grid-template-columns: repeat(12, 1fr); grid-auto-rows: minmax(100px, auto); gap: 30px; }
.am-bento-item { background: #ffffff; border-radius: 32px; padding: 50px; box-shadow: 0 20px 50px -10px rgba(15,23,42,0.05); border: 1px solid rgba(15,23,42,0.03); display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; transition: all 0.5s ease; }
.am-bento-item:hover { box-shadow: 0 30px 60px -15px rgba(15,23,42,0.1); transform: translateY(-5px); }
.am-bento-item.large { grid-column: span 8; }
.am-bento-item.small { grid-column: span 4; background: #0f172a; color: #fff; }
.am-bento-item.full { grid-column: span 12; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; }

.am-bento-year { position: absolute; top: -20px; right: -20px; font-family: 'Playfair Display', serif; font-size: 160px; font-weight: 900; color: rgba(15,23,42,0.03); line-height: 1; pointer-events: none; }
.am-bento-item.small .am-bento-year { color: rgba(255,255,255,0.03); }

.am-bento-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 800; margin: 0 0 20px 0; line-height: 1.2; }
.am-bento-text { font-size: 16px; line-height: 1.8; color: #475569; }
.am-bento-item.small .am-bento-text, 
.am-bento-item.full .am-bento-text { color: #94a3b8; }

.am-bento-quote { font-family: 'Playfair Display', serif; font-size: 36px; font-style: italic; font-weight: 600; color: #38bdf8; line-height: 1.4; }

.am-states-list { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 30px; }
.am-state-tag { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 10px 24px; border-radius: 40px; font-size: 14px; font-weight: 600; letter-spacing: 1px; }

/* Footer Section */
.am-about-signature-wrap { text-align: center; padding: 80px 0 0; margin-top: 80px; border-top: 1px solid rgba(15,23,42,0.1); }
.am-sig-name { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
.am-sig-title { font-size: 13px; text-transform: uppercase; letter-spacing: 3px; color: #64748b; font-weight: 700; }

@media (max-width: 1024px) {
    .am-hero-grid { grid-template-columns: 1fr; text-align: center; gap: 40px; }
    .am-hero-badge { margin: 0 auto 30px; }
    .am-hero-title { font-size: 56px; }
    .am-hero-subtitle { margin: 0 auto; }
    .am-bento-item.large, .am-bento-item.small { grid-column: span 12; }
    .am-bento-item.full { grid-template-columns: 1fr; gap: 30px; }
}
@media (max-width: 768px) {
    .am-about-hero { padding: 60px 0 60px; }
    .am-hero-title { font-size: 36px; }
    .am-hero-subtitle { font-size: 16px; }
    .am-stats-bento { grid-template-columns: 1fr 1fr; gap: 15px; }
    .am-stat-card { padding: 24px 20px; }
    .am-stat-value { font-size: 36px; }
    
    .am-history-section { padding: 80px 0; }
    .am-bento-item { padding: 30px 24px; }
    .am-bento-title { font-size: 24px; }
    .am-bento-text { font-size: 15px; }
    .am-bento-quote { font-size: 22px; }
    .am-bento-year { font-size: 90px; right: -10px; top: -10px; }
    
    .am-about-signature-wrap { margin-top: 40px; padding: 40px 16px 0; }
}
</style>

<div class="am-about-universe">
    
    <!-- Ultra Premium Hero -->
    <section class="am-about-hero">
        <div class="container">
            <div class="am-hero-grid">
                <div class="am-hero-content">
                    <div class="am-hero-badge">
                        <div class="am-hero-badge-dot"></div>
                        Our Legacy
                    </div>
                    <h1 class="am-hero-title">The Voice of the East. Since 1980.</h1>
                    <p class="am-hero-subtitle">Akhbar-e-Mashriq is more than a newspaper. It is a four-decade legacy of uncompromising journalism, technological innovation, and relentless dedication to our readers.</p>
                </div>
                
                <div class="am-stats-bento">
                    <div class="am-stat-card">
                        <div class="am-stat-value">1980</div>
                        <div class="am-stat-label">Founded</div>
                    </div>
                    <div class="am-stat-card">
                        <div class="am-stat-value">48+</div>
                        <div class="am-stat-label">Years of Trust</div>
                    </div>
                    <div class="am-stat-card">
                        <div class="am-stat-value">6</div>
                        <div class="am-stat-label">Major States</div>
                    </div>
                    <div class="am-stat-card">
                        <div class="am-stat-value">1st</div>
                        <div class="am-stat-label">Dual City Pub.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advanced Bento Grid History -->
    <section class="am-history-section">
        <div class="container">
            
            <div class="am-bento-grid">
                
                <!-- The Origin -->
                <div class="am-bento-item large">
                    <div class="am-bento-year">1980</div>
                    <h2 class="am-bento-title">The Dawn of Modern Urdu Journalism</h2>
                    <p class="am-bento-text">
                        A peep into our past offers memories of both bitter and sweet days, of trials and tribulations that pass before the eyes like a slow-motion picture. In an era when Urdu newspapers in eastern India were virtually in the stone age—containing only three or four pages, utilizing crude printing techniques, and lacking direct news sources—Akhbar-e-Mashriq stood radically unique. 
                        <br><br>
                        From day one, it was published using offset printing and fiercely held independent views, refusing to toe the line of any particular political party or group.
                    </p>
                </div>

                <!-- The Quote -->
                <div class="am-bento-item small" style="background: #2563eb;">
                    <div class="am-bento-quote">
                        "Fiercely independent views, refusing to toe the line of any political party."
                    </div>
                </div>

                <!-- The Tech Leap -->
                <div class="am-bento-item small">
                    <div class="am-bento-year">TECH</div>
                    <h2 class="am-bento-title">Technological Vanguard</h2>
                    <p class="am-bento-text">
                        Among all newspapers published from Kolkata across various languages, Akhbar-e-Mashriq was the second to embrace offset printing. What began on a sheetfed offset machine printing just two pages at a time has evolved into a massive, fully-automated web offset printing press.
                    </p>
                </div>

                <!-- The Expansion -->
                <div class="am-bento-item large">
                    <div class="am-bento-year">1996</div>
                    <h2 class="am-bento-title">Expanding the Horizon</h2>
                    <p class="am-bento-text">
                        In 1996, Akhbar-e-Mashriq shattered boundaries by launching an edition from Delhi, distinguishing itself as the only Urdu newspaper honored with simultaneous publication from both Kolkata and the capital. 
                        <br><br>
                        Our network rapidly expanded with offices in Ranchi and Asansol, supported by a robust network of correspondents spanning multiple regions.
                    </p>
                </div>

                <!-- Full Width Impact -->
                <div class="am-bento-item full">
                    <div>
                        <h2 class="am-bento-title" style="color: #fff;">A Pan-India Presence</h2>
                        <p class="am-bento-text" style="font-size: 18px;">
                            Today, the circulation of our paper transcends Kolkata, finding immense popularity and trust among readers across the eastern and northern belts of the nation.
                        </p>
                    </div>
                    <div>
                        <div class="am-states-list">
                            <span class="am-state-tag">West Bengal</span>
                            <span class="am-state-tag">Delhi</span>
                            <span class="am-state-tag">Bihar</span>
                            <span class="am-state-tag">Jharkhand</span>
                            <span class="am-state-tag">Uttar Pradesh</span>
                            <span class="am-state-tag">Orissa</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Editor Signature -->
            <div class="am-about-signature-wrap">
                <p class="am-bento-text" style="max-width: 600px; margin: 0 auto 30px;">
                    Ultimately, it must be acknowledged that the tireless efforts of our editor, his family, and the devoted workers of Akhbar-e-Mashriq have borne fruit. The seed sown all those years ago has blossomed into a towering tree of journalism.
                </p>
                <div class="am-sig-name">Mohammad Wasimul Haq</div>
                <div class="am-sig-title">Editor & Founder, 1980</div>
            </div>

        </div>
    </section>
</div>
@endsection


