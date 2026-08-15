@extends('templates.base', ['title' => 'Article | Akhbar-e-mashriq'])

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Poppins:wght@700;900&family=Noto+Nastaliq+Urdu:wght@400;700&display=swap");

.single-article-page { background: #f7f7f8; padding-top: 0 !important; padding-bottom: 0 !important; }
.single-article-page > .container { padding-top: 36px; padding-bottom: 60px; }
.hero-section-wrapper { display: flex !important; gap: 40px; align-items: flex-start; }
.hero-section-right { flex: 1 1 0; min-width: 0; }
.hero-section-right-wrapper { background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 32px rgba(0,0,0,0.07); }
.section-header { padding: 22px 28px 0; }
.content-header { display: flex; align-items: center; gap: 10px; }
.content-header-left-bar.large { width: 4px; height: 22px; background: #e31e24; border-radius: 3px; flex-shrink: 0; }
.content-header-title { font-family: "Inter", sans-serif !important; font-size: 13px !important; font-weight: 700 !important; color: #e31e24 !important; text-transform: uppercase; letter-spacing: 2px; margin: 0 !important; }
.hero-section-right-header { position: relative; overflow: hidden; background: #000; }
.hero-section-right-header-image { width: 100%; height: auto; aspect-ratio: 16/9; object-fit: cover; display: block; border: none; }
.hero-section-right-body { padding: 32px 36px 20px; }
.hero-section-right-body-title { font-family: "Noto Nastaliq Urdu", "Jameel Noori Nastaleeq", serif !important; font-size: 32px !important; font-weight: 700 !important; line-height: 75px !important; color: #080808; margin: 0; direction: rtl; text-align: right; padding-bottom: 20px; }
.hero-section-right-footer { border-top: 1px solid rgba(0,0,0,0.04); border-bottom: 1px solid rgba(0,0,0,0.04); background: #fafafa; margin: 0 16px; border-radius: 12px; }
.hero-section-right-footer-wrapper { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; flex-wrap: wrap; gap: 12px; }
.hero-section-right-footer-left { display: flex; align-items: center; gap: 12px; }
.hero-section-right-footer-left-avatar-image { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #f0f0f0; }
.hero-section-right-footer-left-detail { display: flex; flex-direction: column; }
.hero-section-right-footer-left-detail-title { font-family: "Inter", sans-serif; font-size: 13px; font-weight: 700; color: #111; }
.hero-section-right-footer-left-detail-text { font-family: "Inter", sans-serif; font-size: 11px; color: #e31e24; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
.hero-section-footer-views { display: flex; align-items: center; gap: 18px; }
.hero-section-footer-views-detail { display: flex; align-items: center; gap: 6px; }
.hero-section-footer-views-detail-icon { width: 16px; height: 16px; fill: #aaa; }
.hero-section-footer-views-detail-text { font-family: "Inter", sans-serif; font-size: 13px; color: #888; font-weight: 500; }
.play-button { width: 38px; height: 38px; border-radius: 50%; background: #e31e24; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(227,30,36,0.3); padding: 0; }
.play-button:hover { background: #c0151a; transform: scale(1.08); }
.play-button-icon { width: 16px; height: 16px; fill: #fff; }
.play-button-wave { display: none; width: 40px; }
.article-section-details { padding: 28px 36px 36px; }
.article-section-details-description-text { font-family: "Noto Nastaliq Urdu", serif; font-size: 21px; line-height: 2.5; color: #222; margin-bottom: 24px; direction: rtl; text-align: right; word-spacing: 2px; }
.article-section-details-description-text strong { color: #e31e24; font-weight: 700; }
.article-section-details-socials { display: flex; align-items: center; gap: 12px; margin: 32px 0 24px; flex-wrap: wrap; }
.article-section-details-social { display: flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.06); background: #fff; cursor: pointer; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 2px 10px rgba(0,0,0,0.02); text-decoration: none; position: relative; overflow: hidden; isolation: isolate; }
.article-section-details-social > * { position: relative; z-index: 10; }
.article-section-details-social::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; transform: scaleY(0); transform-origin: bottom; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
.article-section-details-social.twitter::before { background: #1a1a1a; }
.article-section-details-social.fb::before { background: #1877F2; }
.article-section-details-social.whatsapp::before { background: #25D366; }
.article-section-details-social:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-color: transparent; }
.article-section-details-social:hover::before { transform: scaleY(1); }

.article-section-details-social-icon { width: 18px; height: 18px; transition: fill 0.3s ease; }
.article-section-details-social-icon.twitter { fill: #1a1a1a; }
.article-section-details-social-icon.fb { fill: #1877F2; }
.article-section-details-social-icon.whatsapp { fill: #25D366; }
.article-section-details-socials .article-section-details-social:hover .article-section-details-social-icon { fill: #ffffff !important; }
.article-section-details-socials .article-section-details-social.whatsapp:hover .article-section-details-social-icon.whatsapp,
.article-section-details-socials .article-section-details-social.fb:hover .article-section-details-social-icon.fb,
.article-section-details-socials .article-section-details-social.twitter:hover .article-section-details-social-icon.twitter { fill: #ffffff !important; }

.article-section-details-social-text { font-size: 13px; font-weight: 700; font-family: "Inter", sans-serif; transition: color 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; }
.article-section-details-social-text.twitter { color: #1a1a1a; }
.article-section-details-social-text.fb { color: #1877F2; }
.article-section-details-social-text.whatsapp { color: #25D366; }
.article-section-details-socials .article-section-details-social:hover .article-section-details-social-text { color: #ffffff !important; }
.article-section-details-socials .article-section-details-social.whatsapp:hover .article-section-details-social-text.whatsapp,
.article-section-details-socials .article-section-details-social.fb:hover .article-section-details-social-text.fb,
.article-section-details-socials .article-section-details-social.twitter:hover .article-section-details-social-text.twitter { color: #ffffff !important; }

.line { display: none; }
.article-section-details-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
.article-section-details-button { font-family: "Inter", sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; padding: 10px 20px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.05) !important; color: #555 !important; text-decoration: none; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); background: #f8f9fa !important; display: inline-flex; align-items: center; justify-content: center; }
.article-section-details-button:hover { background: #e31e24 !important; color: #fff !important; border-color: #e31e24 !important; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(227,30,36,0.2); }
.article-section-details-vote { background: linear-gradient(145deg, #f8f9fa, #f1f2f4); border-radius: 18px; padding: 32px 28px; margin-bottom: 32px; box-shadow: inset 0 2px 6px rgba(255,255,255,0.8), 0 4px 16px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04); }
.article-section-details-vote-text { margin-bottom: 24px; text-align: center; }
.article-section-details-vote-text-title { font-family: "Poppins", sans-serif; font-size: 19px; font-weight: 700; color: #111; margin: 0 0 6px; letter-spacing: -0.3px; }
.article-section-details-vote-text-subtitle { font-family: "Inter", sans-serif; font-size: 14px; color: #666; font-weight: 500; }
.article-section-details-vote-cards { display: flex; gap: 16px; flex-wrap: wrap; border: none; margin: 0; padding: 0; justify-content: center; }
.article-section-details-vote-cards .article-section-details-vote-card::before { display: none !important; }
.article-section-details-vote-card { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; padding: 22px 16px; background: #fff !important; border-radius: 16px; cursor: pointer; border: 1px solid rgba(0,0,0,0.05); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); flex: 1; min-width: 80px; max-width: 120px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); position: relative; z-index: 1; }
.article-section-details-vote-card:hover { border-color: rgba(227,30,36,0.3); box-shadow: 0 10px 28px rgba(227,30,36,0.08); transform: translateY(-4px); }
.article-section-details-vote-card-icon { width: 56px; height: 56px; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); user-select: none; display: block; margin-bottom: 2px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.06)); }
.article-section-details-vote-card:hover .article-section-details-vote-card-icon { transform: scale(1.15) rotate(4deg); }
.article-section-details-vote-card-text { font-family: "Inter", sans-serif; font-size: 13px; font-weight: 700; color: #444; transition: color 0.3s ease; }
.article-section-details-vote-card:hover .article-section-details-vote-card-text { color: #e31e24; }
.width-45-p { width: 360px; flex-shrink: 0; }
.hero-section-left { background: #fff; border-radius: 20px; overflow: visible !important; box-shadow: 0 8px 32px rgba(0,0,0,0.04); margin-bottom: 24px; border: 1px solid rgba(0,0,0,0.03); }
.hero-section-left-wrapper, .hero-section-left-body, .grid > div, .grid, .section-wrapper { overflow: visible !important; }
.single-article-page-header { padding: 22px 24px 18px; border-bottom: 1px solid rgba(0,0,0,0.04); position: relative; z-index: 2; background: #fff; border-radius: 20px 20px 0 0; }
.hero-section-left-wrapper.has-border-left { border-left: none !important; margin: 0 !important; }
.hero-section-left-body { counter-reset: pop-counter; padding: 0 !important; }
.hero-section-left-body-detail { display: flex !important; gap: 18px; align-items: center; padding: 20px 24px !important; border-bottom: 1px solid rgba(0,0,0,0.03) !important; text-decoration: none !important; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden; background: #fff; z-index: 1; counter-increment: pop-counter; }
.hero-section-left-body-detail::before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: #e31e24; transform: scaleY(0); transform-origin: top; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); z-index: 3; }
.hero-section-left-body-detail::after { content: "0" counter(pop-counter); position: absolute; right: 10px; top: -10px; font-family: "Poppins", sans-serif; font-size: 72px; font-weight: 900; color: rgba(0,0,0,0.02); z-index: -1; transition: all 0.4s ease; pointer-events: none; }
.hero-section-left-body-detail:hover { background: #fafafa !important; padding-left: 32px !important; }
.hero-section-left-body-detail:hover::before { transform: scaleY(1); }
.hero-section-left-body-detail:hover::after { color: rgba(227,30,36,0.04); transform: translateX(-10px); }
.hero-section-left-body-detail:last-child { border-bottom: none !important; border-radius: 0 0 20px 20px; }
.hero-section-left-body-detail-poster { position: relative; z-index: 2; }
.hero-section-left-body-detail-poster-image { width: 92px; height: 70px; object-fit: cover; border-radius: 12px; flex-shrink: 0; box-shadow: 0 4px 14px rgba(0,0,0,0.08); transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease; }
.hero-section-left-body-detail:hover .hero-section-left-body-detail-poster-image { transform: scale(1.08) rotate(-1deg); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
.hero-section-left-body-detail-content { flex: 1; min-width: 0; position: relative; z-index: 2; }
.hero-section-left-body-detail-content-text { font-family: "Poppins", "Noto Nastaliq Urdu", sans-serif !important; font-size: 13.5px; font-weight: 600; color: #111; line-height: 1.5; margin: 0 0 6px; text-align: right; unicode-bidi: plaintext; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.3s ease; letter-spacing: -0.1px; }
.hero-section-left-body-detail:hover .hero-section-left-body-detail-content-text { color: #e31e24; }
.hero-section-left-body-detail-content-time { font-family: "Inter", sans-serif; font-size: 12px; color: #888; font-weight: 500; text-align: right; text-transform: uppercase; letter-spacing: 0.5px; }
.section.bg-primary { background: #f0f0f2 !important; padding: 48px 0; }
.section.bg-primary .content-header-title { font-size: 18px !important; font-weight: 700 !important; color: #111 !important; text-transform: none; letter-spacing: 0; }
.section.bg-primary .section-header-cta-button { font-family: "Inter", sans-serif; font-size: 12px; font-weight: 700; color: #e31e24; text-decoration: none; display: flex; align-items: center; gap: 4px; text-transform: uppercase; letter-spacing: 1px; }
.section.bg-primary .section-header-cta-icon { width: 16px; height: 16px; fill: #e31e24; }
.contact-section.bg-primary { background: #fafafa !important; padding: 80px 0; border-top: 1px solid rgba(0,0,0,0.03); }
.contact-section .container { margin: 0 auto; }

/* 2-Column Comments Layout */
.comments-layout { display: flex; gap: 80px; align-items: stretch; width: 100%; max-width: 100%; margin: 0 auto; }
@media(max-width: 1000px) { .comments-layout { flex-direction: column; gap: 40px; } }
.comments-sidebar { width: 35%; min-width: 380px; max-width: 480px; flex-shrink: 0; }
@media(max-width: 1000px) { .comments-sidebar { width: 100%; min-width: 0; max-width: none; } }
.comments-main { flex: 1; min-width: 0; width: 100%; padding-bottom: 40px; }
.comments-sidebar-box { background: #09090b; padding: 60px 48px; border-radius: 32px; color: #fff; box-shadow: 0 32px 64px rgba(0,0,0,0.15), inset 0 1px 1px rgba(255,255,255,0.08); position: sticky; top: 40px; height: calc(100vh - 80px); min-height: 500px; max-height: 700px; display: flex; flex-direction: column; justify-content: center; text-align: left; border: 1px solid rgba(255,255,255,0.04); overflow: hidden; }
.comments-sidebar-box::before { content: ''; position: absolute; top: -30%; left: -30%; width: 160%; height: 160%; background: radial-gradient(circle at 50% 0%, rgba(227, 30, 36, 0.12) 0%, transparent 60%); z-index: 0; pointer-events: none; }
.comments-sidebar-box > * { position: relative; z-index: 1; }
.comments-sidebar-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 100px; font-family: "Inter", sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255, 255, 255, 0.8); margin-bottom: 24px; align-self: flex-start; }
.comments-sidebar-badge-dot { width: 6px; height: 6px; background: #e31e24; border-radius: 50%; box-shadow: 0 0 10px #e31e24; animation: pulse-glow 2s infinite; }
@keyframes pulse-glow { 0% { box-shadow: 0 0 0 0 rgba(227,30,36,0.4); } 70% { box-shadow: 0 0 0 6px rgba(227,30,36,0); } 100% { box-shadow: 0 0 0 0 rgba(227,30,36,0); } }
.comments-sidebar-box h3 { font-family: "Playfair Display", serif; font-size: 42px; font-weight: 800; margin: 0 0 20px; color: #fff; letter-spacing: -1.5px; line-height: 1.1; }
.comments-sidebar-box h3 span { color: transparent; background: linear-gradient(135deg, #e31e24, #ff6b6b); -webkit-background-clip: text; background-clip: text; }
.comments-sidebar-box p { font-family: "Inter", sans-serif; font-size: 15.5px; color: rgba(255,255,255,0.6); line-height: 1.8; margin: 0; }
.comments-sidebar-icon { display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: linear-gradient(135deg, rgba(227,30,36,0.15) 0%, rgba(227,30,36,0.02) 100%); color: #e31e24; border-radius: 20px; margin-bottom: 28px; box-shadow: inset 0 1px 1px rgba(255,255,255,0.1), 0 12px 32px rgba(227,30,36,0.1); border: 1px solid rgba(227, 30, 36, 0.15); align-self: flex-start; }
.comments-sidebar-icon svg { width: 28px; height: 28px; fill: currentColor; filter: drop-shadow(0 4px 8px rgba(227,30,36,0.4)); }

.contact-section .article-section-details-vote-text { text-align: left !important; margin-bottom: 32px; }
.contact-section .article-section-details-vote-text-title { font-family: "Playfair Display", serif; font-size: 32px; font-weight: 800; color: #111; margin-bottom: 8px; letter-spacing: -0.5px; position: relative; display: inline-block; }
.contact-section .article-section-details-vote-text-title::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 40px; height: 3px; background: #e31e24; border-radius: 2px; }
.contact-section .article-section-details-vote-text-subtitle { font-family: "Inter", sans-serif; font-size: 13px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-top: 16px; }

.contact-info { display: flex; gap: 24px; margin-bottom: 24px; }
@media(max-width: 600px) { .contact-info { flex-direction: column; gap: 16px; margin-bottom: 16px; } }
.contact-info-input { flex: 1; position: relative; }
.form-input, .text-input { width: 100%; border: 1px solid transparent; border-radius: 16px; font-family: "Inter", sans-serif; font-size: 15px; color: #111; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.04); outline: none; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-sizing: border-box; }
.form-input { padding: 18px 24px; }
.text-input { padding: 24px; resize: vertical; min-height: 160px; line-height: 1.6; }
.form-input::placeholder, .text-input::placeholder { color: #a0a0a0; font-weight: 400; }
.form-input:focus, .text-input:focus { background: #fff; border-color: rgba(227, 30, 36, 0.3); box-shadow: 0 8px 32px rgba(227, 30, 36, 0.08), 0 0 0 4px rgba(227, 30, 36, 0.05); transform: translateY(-2px); }

.contact-cta { text-align: right; margin-top: 24px; }
.button-hero { background: linear-gradient(135deg, #e31e24 0%, #9e0d12 100%); color: #fff; border: none; padding: 16px 48px; border-radius: 50px; font-family: "Inter", sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 10px 24px rgba(227, 30, 36, 0.3), inset 0 2px 0 rgba(255,255,255,0.2); text-transform: uppercase; letter-spacing: 1.5px; position: relative; overflow: hidden; display: inline-block; }
.button-hero::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.6s ease; }
.button-hero:hover { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(227, 30, 36, 0.4), inset 0 2px 0 rgba(255,255,255,0.2); color: #fff; }
.button-hero:hover::before { left: 100%; }

.chats { display: flex; flex-direction: column; gap: 24px; margin-top: 32px; }
.chat { display: flex; gap: 20px; align-items: flex-start; padding: 24px; background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02); transition: transform 0.3s ease; }
.chat:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.06); }
.chat-avatar-img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.chat-content { flex: 1; min-width: 0; }
.chat-content-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
.chat-content-text-user { font-family: "Poppins", sans-serif; font-weight: 700; color: #111; font-size: 15px; letter-spacing: -0.2px; }
.chat-content-text { font-family: "Inter", sans-serif; font-size: 14.5px; color: #444; line-height: 1.7; background: transparent; padding: 0; border-radius: 0; }

.alert-success { background: rgba(34, 197, 94, 0.08); border: 1px solid rgba(34, 197, 94, 0.2); color: #15803d; padding: 16px 20px; border-radius: 12px; font-family: "Inter", sans-serif; font-size: 14px; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
.alert-success::before { content: '✓'; display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; background: #16a34a; color: #fff; border-radius: 50%; font-size: 12px; }

/* Article Preview Popup */
.popular-article-link { position: relative; display: block; }
.popular-article-link .article-preview-popup { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.95); width: 340px; background: #fff; border-radius: 16px; box-shadow: 0 16px 48px rgba(0,0,0,0.3); border: 1px solid rgba(0,0,0,0.05); padding: 16px; opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); z-index: 100; }
.popular-article-link:hover .article-preview-popup { opacity: 1; visibility: visible; transform: translate(-50%, -50%) scale(1.05); }
.article-preview-popup-img { width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.article-preview-popup-content { padding: 0 4px; }
.article-preview-popup-title { font-family: "Poppins", "Noto Nastaliq Urdu", sans-serif; font-size: 16px; font-weight: 700; line-height: 2.2; color: #111; margin: 0 0 8px; text-align: right; unicode-bidi: plaintext; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.article-preview-popup-time { font-family: "Inter", sans-serif; font-size: 12px; color: #888; margin: 0; font-weight: 500; text-transform: uppercase; text-align: right; letter-spacing: 0.5px; }

/* Related Article Popup */
.related-article-link { position: relative; display: block; }
.related-article-link .article-preview-popup { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.95); width: 340px; background: #fff; border-radius: 16px; box-shadow: 0 16px 48px rgba(0,0,0,0.3); border: 1px solid rgba(0,0,0,0.05); padding: 16px; opacity: 0; visibility: hidden; pointer-events: none; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); z-index: 100; }
.related-article-link:hover .article-preview-popup { opacity: 1; visibility: visible; transform: translate(-50%, -50%) scale(1.05); }

/* ============================================================
   MOBILE RESPONSIVE — ARTICLE PAGE (max-width: 992px)
   ============================================================ */
@media (max-width: 992px) {

    /* -- Page padding -- */
    .single-article-page > .container {
        padding-top: 16px !important;
        padding-bottom: 32px !important;
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    /* -- Stack layout vertically -- */
    .hero-section-wrapper {
        flex-direction: column !important;
        gap: 24px !important;
    }

    /* -- Right (main article) — full width -- */
    .hero-section-right {
        width: 100% !important;
        min-width: 0 !important;
    }
    .hero-section-right-wrapper {
        border-radius: 12px !important;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07) !important;
    }

    /* -- Section header -- */
    .section-header {
        padding: 16px 16px 0 !important;
    }

    /* -- Article image -- */
    .hero-section-right-header-image {
        aspect-ratio: 16/9 !important;
        width: 100% !important;
    }

    /* -- Title -- */
    .hero-section-right-body {
        padding: 30px 20px 14px !important; /* +12px top, equal 20px sides */
    }
    .hero-section-right-body-title {
        font-size: 22px !important;
        line-height: 50px !important;  /* reduced from 55px — tighter feel */
        padding-bottom: 12px !important;
        text-align: center !important; /* perfect horizontal centering */
        margin: 0 auto !important;
    }

    /* -- Author / meta footer -- */
    .hero-section-right-footer {
        margin: 0 10px !important;
    }
    .hero-section-right-footer-wrapper {
        padding: 12px 14px !important;
        gap: 10px !important;
        flex-wrap: wrap !important;
    }
    .hero-section-footer-views {
        gap: 12px !important;
        flex-wrap: wrap !important;
    }

    /* -- Article body text -- */
    .article-section-details {
        padding: 16px 16px 24px !important;
    }
    .article-section-details-description-text {
        font-size: 17px !important;
        line-height: 2.2 !important;
        margin-bottom: 16px !important;
    }

    /* -- Social share buttons — wrap cleanly -- */
    .article-section-details-socials {
        gap: 8px !important;
        margin: 20px 0 16px !important;
    }
    .article-section-details-social {
        padding: 8px 14px !important;
    }
    .article-section-details-social-text {
        font-size: 12px !important;
    }

    /* -- Tags / category buttons -- */
    .article-section-details-buttons {
        gap: 8px !important;
        margin-bottom: 20px !important;
    }
    .article-section-details-button {
        font-size: 10px !important;
        padding: 8px 14px !important;
    }

    /* -- Vote section -- */
    .article-section-details-vote {
        padding: 22px 16px !important;
        border-radius: 14px !important;
    }
    .article-section-details-vote-text-title {
        font-size: 16px !important;
    }
    .article-section-details-vote-cards {
        gap: 10px !important;
    }
    .article-section-details-vote-card {
        padding: 16px 10px !important;
        min-width: 64px !important;
        max-width: 90px !important;
    }
    .article-section-details-vote-card-icon {
        width: 42px !important;
        height: 42px !important;
    }

    /* -- Sidebar (popular articles + ad) — full width, below article -- */
    .width-45-p {
        width: 100% !important;
        flex-shrink: unset !important;
    }
    .hero-section-left {
        border-radius: 12px !important;
    }
    .single-article-page-header {
        padding: 14px 16px 12px !important;
        border-radius: 12px 12px 0 0 !important;
    }
    .hero-section-left-body-detail {
        padding: 14px 16px !important;
        gap: 12px !important;
    }
    .hero-section-left-body-detail-poster-image {
        width: 76px !important;
        height: 58px !important;
    }
    .hero-section-left-body-detail-content-text {
        font-size: 12.5px !important;
    }

    /* -- Hide hover popups on touch -- */
    .article-preview-popup {
        display: none !important;
    }

    /* -- Translate button -- */
    [style*="position: fixed; left: 24px"] {
        left: 12px !important;
        bottom: 80px !important;
    }
    [style*="position: fixed; left: 24px"] button {
        padding: 10px 16px !important;
        font-size: 12px !important;
    }

    /* -- Comments sidebar — full width on mobile -- */
    .comments-layout {
        flex-direction: column !important;
        gap: 24px !important;
    }
    .comments-sidebar {
        width: 100% !important;
        min-width: 0 !important;
        max-width: none !important;
    }
    .comments-sidebar-box {
        padding: 32px 24px !important;
        border-radius: 20px !important;
        height: auto !important;
        min-height: unset !important;
        max-height: unset !important;
        position: relative !important;
        top: auto !important;
    }
    .comments-sidebar-box h3 {
        font-size: 28px !important;
        letter-spacing: -0.5px !important;
    }
    .comments-main {
        padding-bottom: 20px !important;
    }
    .chat {
        padding: 16px !important;
        gap: 12px !important;
    }
    .chat-avatar-img {
        width: 38px !important;
        height: 38px !important;
    }

    /* -- Contact / comment form -- */
    .contact-section.bg-primary {
        padding: 40px 0 !important;
    }
    .contact-section .article-section-details-vote-text-title {
        font-size: 24px !important;
    }
    .contact-info {
        flex-direction: column !important;
        gap: 12px !important;
    }
    .button-hero {
        width: 100% !important;
        text-align: center !important;
        padding: 14px 24px !important;
    }
    .contact-cta {
        text-align: center !important;
    }
}
</style>

<section id="app" class="hero-section section has-border-bottom single-article-page">
    <div style="position: fixed; left: 24px; bottom: 40px; z-index: 1000;">
        <button @click="translateContent" :disabled="isTranslating" style="display: flex; align-items: center; gap: 8px; background: #e31e24; color: #fff; border: none; padding: 14px 24px; border-radius: 50px; font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 8px 24px rgba(227,30,36,0.3); transition: all 0.3s ease;">
            <svg v-if="!isTranslating" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/></svg>
            <span v-if="!isTranslating && !isEnglish">Translate to English</span>
            <span v-else-if="!isTranslating && isEnglish">Translate to Urdu</span>
            <span v-else>Translating...</span>
        </button>
    </div>
    <div class="container">
        <div class="hero-section-wrapper bg-transparent p-0 gap-20 t-gap-32">
            <div class="hero-section-right">
                <div class="hero-section-right-wrapper">
                    <div class="section-header">
                        <div class="content-header">
                            <div class="content-header-left-bar large"></div>
                            <h2 class="content-header-title text-black section-title">{{$article->category->name}}</h2>
                        </div>
                    </div>
                    <div class="hero-section-right-header">
                        @if ($article->isVideoArticle())
                            <img class="hero-section-right-header-image" src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy">
                        @else
                            <iframe class="hero-section-right-header-image" src="https://www.youtube.com/embed/{{ $article->extractVideoId($article->video_url) }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        @endif
                    </div>
                    <div class="hero-section-right-body">
                        <h1 class="hero-section-right-body-title">{{ $article->title }}</h1>
                    </div>
                    <div class="hero-section-right-footer width-full">
                        <div class="hero-section-right-footer-wrapper">
                            <div class="hero-section-right-footer-left">
                                <div class="hero-section-right-footer-left-avatar">
                                    <img class="hero-section-right-footer-left-avatar-image" src="{{ $article->admin->photo }}" alt="{ $article->admin->fullName() }}">
                                </div>
                                <div class="hero-section-right-footer-left-detail text-left">
                                    <span class="hero-section-right-footer-left-detail-title">{{ $article->admin->first_name }}</span>
                                    <span class="hero-section-right-footer-left-detail-text">{{ $article->admin->roleAsString() }}</span>
                                </div>
                            </div>
                            <div class="hero-section-footer-views">
                                <div class="hero-section-footer-views-detail">
                                    <span>
                                        <svg class="hero-section-footer-views-detail-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>
                                    </span>
                                    <span class="hero-section-footer-views-detail-text">{{ $article->views }}</span>
                                </div>
                                <div class="hero-section-footer-views-detail">
                                    <span>
                                        <svg class="hero-section-footer-views-detail-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 3H14C18.4183 3 22 6.58172 22 11C22 15.4183 18.4183 19 14 19V22.5C9 20.5 2 17.5 2 11C2 6.58172 5.58172 3 10 3ZM12 17H14C17.3137 17 20 14.3137 20 11C20 7.68629 17.3137 5 14 5H10C6.68629 5 4 7.68629 4 11C4 14.61 6.46208 16.9656 12 19.4798V17Z"></path></svg>
                                    </span>
                                    <span class="hero-section-footer-views-detail-text">{{$count_comment}}</span>
                                </div>
                                <div class="hero-section-footer-views-detail">
                                    <span>
                                        <svg class="hero-section-footer-views-detail-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z"></path></svg>
                                    </span>
                                    <span class="hero-section-footer-views-detail-text">{{ date("d/m/y", strtotime($article->created_at)) }}</span>
                                </div>
                                <button :class="{ 'is-loading': isProcessing, 'is-playing': isPlaying }" class="button play-button" title="Play Article" @click="textToSpeech">
                                    <svg class="play-button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6 20.1957V3.80421C6 3.01878 6.86395 2.53993 7.53 2.95621L20.6432 11.152C21.2699 11.5436 21.2699 12.4563 20.6432 12.848L7.53 21.0437C6.86395 21.46 6 20.9812 6 20.1957Z"></path>
                                    </svg>
                                    <svg class="play-button-icon pause" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.43263 3.5C5.96763 3.5 4.77563 4.692 4.77563 6.157V17.843C4.77563 19.308 5.96763 20.5 7.43263 20.5C8.89763 20.5 10.0896 19.308 10.0896 17.843V6.157C10.0896 4.692 8.89763 3.5 7.43263 3.5Z" fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5673 3.5C15.1023 3.5 13.9103 4.692 13.9103 6.157V17.843C13.9103 19.308 15.1023 20.5 16.5673 20.5C18.0323 20.5 19.2243 19.308 19.2243 17.843V6.157C19.2243 4.692 18.0323 3.5 16.5673 3.5Z" fill="currentColor"></path>
                                    </svg>
                                    <img class="play-button-wave" src="/assets/img/sound-wave.gif" alt="Sound Wave Animation">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="article-section-details">
                        <div class="article-section-details-wrapper">
                            <div class="article-section-details-description">
                                <p class="article-section-details-description-text">
                                    {!! nl2br(e($article->content)) !!}
                                </p>
                                <p class="article-section-details-description-text">
                                    <strong>Source:</strong> {{ $article->source }}
                                </p>
                            </div>
                            <div class="article-section-details-socials">
                                <a href="https://twitter.com/intent/tweet?text={{ $article->title }}&url={{ $article->article_url }}" target="_blank">
                                    <div class="article-section-details-social twitter">
                                    <span>
                                        <svg class="article-section-details-social-icon twitter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.69303 15.9418 3.69434C13.6326 3.69434 11.7597 5.56661 11.7597 7.87683C11.7597 8.20458 11.7973 8.52242 11.8676 8.82909C8.39047 8.65404 5.31007 6.99005 3.24678 4.45941C2.87529 5.09767 2.68005 5.82318 2.68104 6.56167C2.68104 8.01259 3.4196 9.29324 4.54149 10.043C3.87737 10.022 3.22788 9.84264 2.64718 9.51973C2.64654 9.5373 2.64654 9.55487 2.64654 9.57148C2.64654 11.5984 4.08819 13.2892 6.00199 13.6731C5.6428 13.7703 5.27232 13.8194 4.90022 13.8191C4.62997 13.8191 4.36771 13.7942 4.11279 13.7453C4.64531 15.4065 6.18886 16.6159 8.0196 16.6491C6.53813 17.8118 4.70869 18.4426 2.82543 18.4399C2.49212 18.4402 2.15909 18.4205 1.82812 18.3811C3.74004 19.6102 5.96552 20.2625 8.23842 20.2601C15.9316 20.2601 20.138 13.8875 20.138 8.36111C20.138 8.1803 20.1336 7.99886 20.1256 7.81997C20.9443 7.22845 21.651 6.49567 22.2125 5.65605Z"></path></svg>
                                    </span>
                                    <span class="article-section-details-social-text twitter">Tweet</span>
                                    </div>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $article->article_url }}" target="_blank">
                                    <div class="article-section-details-social fb">
                                    <span>
                                        <svg class="article-section-details-social-icon fb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z"></path></svg>
                                    </span>
                                    <span class="article-section-details-social-text fb">Post</span>
                                    </div>
                                </a>
                                <a href="https://wa.me/?text={{ $article->article_url}}" target="_blank">
                                    <div class="article-section-details-social whatsapp">
                                    <span>
                                        <svg class="article-section-details-social-icon whatsapp" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22C10.1671 22 8.44851 21.5064 6.97086 20.6447L2.00516 22L3.35712 17.0315C2.49494 15.5536 2.00098 13.8345 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2ZM8.59339 7.30019L8.39232 7.30833C8.26293 7.31742 8.13607 7.34902 8.02057 7.40811C7.93392 7.45244 7.85348 7.51651 7.72709 7.63586C7.60774 7.74855 7.53857 7.84697 7.46569 7.94186C7.09599 8.4232 6.89729 9.01405 6.90098 9.62098C6.90299 10.1116 7.03043 10.5884 7.23169 11.0336C7.63982 11.9364 8.31288 12.8908 9.20194 13.7759C9.4155 13.9885 9.62473 14.2034 9.85034 14.402C10.9538 15.3736 12.2688 16.0742 13.6907 16.4482C13.6907 16.4482 14.2507 16.5342 14.2589 16.5347C14.4444 16.5447 14.6296 16.5313 14.8153 16.5218C15.1066 16.5068 15.391 16.428 15.6484 16.2909C15.8139 16.2028 15.8922 16.159 16.0311 16.0714C16.0311 16.0714 16.0737 16.0426 16.1559 15.9814C16.2909 15.8808 16.3743 15.81 16.4866 15.6934C16.5694 15.6074 16.6406 15.5058 16.6956 15.3913C16.7738 15.2281 16.8525 14.9166 16.8838 14.6579C16.9077 14.4603 16.9005 14.3523 16.8979 14.2854C16.8936 14.1778 16.8047 14.0671 16.7073 14.0201L16.1258 13.7587C16.1258 13.7587 15.2563 13.3803 14.7245 13.1377C14.6691 13.1124 14.6085 13.1007 14.5476 13.097C14.4142 13.0888 14.2647 13.1236 14.1696 13.2238C14.1646 13.2218 14.0984 13.279 13.3749 14.1555C13.335 14.2032 13.2415 14.3069 13.0798 14.2972C13.0554 14.2955 13.0311 14.292 13.0074 14.2858C12.9419 14.2685 12.8781 14.2457 12.8157 14.2193C12.692 14.1668 12.6486 14.1469 12.5641 14.1105C11.9868 13.8583 11.457 13.5209 10.9887 13.108C10.8631 12.9974 10.7463 12.8783 10.6259 12.7616C10.2057 12.3543 9.86169 11.9211 9.60577 11.4938C9.5918 11.4705 9.57027 11.4368 9.54708 11.3991C9.50521 11.331 9.45903 11.25 9.44455 11.1944C9.40738 11.0473 9.50599 10.9291 9.50599 10.9291C9.50599 10.9291 9.74939 10.663 9.86248 10.5183C9.97128 10.379 10.0652 10.2428 10.125 10.1457C10.2428 9.95633 10.2801 9.76062 10.2182 9.60963C9.93764 8.92565 9.64818 8.24536 9.34986 7.56894C9.29098 7.43545 9.11585 7.33846 8.95659 7.32007C8.90265 7.31384 8.84875 7.30758 8.79459 7.30402C8.66053 7.29748 8.5262 7.29892 8.39232 7.30833L8.59339 7.30019Z"></path></svg>
                                    </span>
                                    <span class="article-section-details-social-text whatsapp">Send</span>
                                    </div>
                                </a>
                                <div class="line"></div>
                            </div>
                            <div class="article-section-details-buttons">
                                @foreach($category_map as $key => $c)
                                <a class="article-section-details-button" href="/articles?category_id={{ $c }}">{{ ucwords($key) }}</a>
                                @endforeach
                            </div>
                            <div class="article-section-details-vote">
                                <div class="article-section-details-vote-text text-left">
                                    <h2 class="article-section-details-vote-text-title">Please vote this article</h2>
                                    <span class="article-section-details-vote-text-subtitle" v-cloak>@{{ currentVoteCount }} Responses</span>
                                    @if(session()->has('vote_message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('vote_message') }}
                                        </div>
                                    @endif
                                    <div v-if="voteMessage" class="alert alert-success" style="margin-top: 10px;" v-cloak>
                                        @{{ voteMessage }}
                                    </div>
                                </div>
                                <form ref="voteForm" action="/vote/store" @submit.prevent method="post" class="article-section-details-vote-cards">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <input type="hidden" name="vote_type" :value="articleVoteType">
                                    <div @click="postVote(1)" class="article-section-details-vote-card">
                                        <img class="article-section-details-vote-card-icon" src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f60d/512.webp" alt="Best Rating" loading="lazy">
                                        <span class="article-section-details-vote-card-text">Best</span>
                                    </div>
                                    <div @click="postVote(2)" class="article-section-details-vote-card">
                                        <img class="article-section-details-vote-card-icon" src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44d/512.webp" alt="Good Rating" loading="lazy">
                                        <span class="article-section-details-vote-card-text">Good</span>
                                    </div>
                                    <div @click="postVote(3)" class="article-section-details-vote-card">
                                        <img class="article-section-details-vote-card-icon" src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f610/512.webp" alt="Okay Rating" loading="lazy">
                                        <span class="article-section-details-vote-card-text">Okay</span>
                                    </div>
                                    <div @click="postVote(4)" class="article-section-details-vote-card">
                                        <img class="article-section-details-vote-card-icon" src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44e/512.webp" alt="Bad Rating" loading="lazy">
                                        <span class="article-section-details-vote-card-text">Bad</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width-45-p">
                @if(!is_null($digital_ad))
                <div class="hero-section-left width-full">
                    <div class="content-header single-article-page-header">
                        <div class="content-header-left-bar large bg-transparent"></div>
                        <h2 class="content-header-title text-black section-title">&nbsp;</h2>
                    </div>
                    <div class="section-image width-full pl-32 mb-20">
                    <div class="section-image-body">
                            <div class="e-paper-wrapper flex-end">
                                <a href="/ad-track/{{ $digital_ad->id }}" target="_blank" style="display: block; position: relative; width: 100%; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 30px rgba(0,0,0,0.08); text-decoration: none; transition: transform 0.3s ease; background-color: #0f1115;">
                                    <div style="position: relative; width: 100%; z-index: 0;">
                                        <img alt="{{ $digital_ad->title }}" loading="lazy" src="{{ $digital_ad->media_url }}" style="display: block; width: 100%; height: auto;">
                                    </div>
                                    @if(false)<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15,17,21,0) 0%, rgba(15,17,21,0.2) 40%, rgba(15,17,21,0.95) 100%); z-index: 1;"></div>@endif
                                    
                                    <div style="position: absolute; top: 16px; left: 16px; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; z-index: 2; border: 1px solid rgba(255,255,255,0.1);">
                                        Sponsored
                                    </div>
                                    
                                    @if(false)
                                    <div style="position: relative; z-index: 2; padding: 32px 24px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 10px;">
                                        <h4 style="margin: 0; font-size: 24px; font-weight: 900; color: #fff; font-family: 'Inter', sans-serif; line-height: 1.2; letter-spacing: -0.5px;">{{ $digital_ad->title }}</h4>
                                        @if($digital_ad->description)
                                        <p style="margin: 0; font-size: 15px; color: rgba(255,255,255,0.8); font-family: 'Inter', sans-serif; line-height: 1.6; font-weight: 400; max-width: 450px;">{{ Str::limit($digital_ad->description, 100) }}</p>
                                        @endif
                                        @if($digital_ad->cta_text)
                                        <div style="margin-top: 12px; background: #e31e24; color: #fff; padding: 12px 24px; border-radius: 50px; font-size: 13px; font-weight: 800; text-transform: uppercase; font-family: 'Inter', sans-serif; letter-spacing: 0.5px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 24px rgba(227,30,36,0.3);">
                                            {{ $digital_ad->cta_text }}
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="hero-section-left width-full">
                    <div class="content-header single-article-page-header">
                        <div class="content-header-left-bar large"></div>
                        <h2 class="content-header-title text-black section-title">Popular in {{ $article->category->name }}</h2>
                    </div>
                    <div class="hero-section-left-wrapper has-border-left mt-20">
                        <div class="hero-section-left-body section-left-body pl-32">
                            @foreach($popular_articles as $p)
                            <a href="{{ $p->article_url }}" class="popular-article-link">
                                <div class="article-preview-popup">
                                    <img class="article-preview-popup-img" src="{{ $p->image_url }}" alt="{{ $p->title }}" loading="lazy">
                                    <div class="article-preview-popup-content">
                                        <h4 class="article-preview-popup-title">{{ $p->title }}</h4>
                                        <p class="article-preview-popup-time">{{ $p->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="hero-section-left-body-detail text-black-005 py-16 tab-pt-0 hover-none has-border-bottom">
                                    <div class="hero-section-left-body-detail-poster section-image">
                                        <img class="hero-section-left-body-detail-poster-image" src="{{ $p->image_sm_url }}" alt="{{ $p->title }}" loading="lazy">
                                    </div>
                                    <div class="hero-section-left-body-detail-content">

                                        <p class="hero-section-left-body-detail-content-text text-20-600">{{ $p->title }}</p>
                                        <div class="hero-section-left-body-detail-content-time">{{ $p->created_at->diffForHumans() }}</div>
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
        <div class="section-header">
            <div class="content-header">
                <div class="content-header-left-bar large"></div>
                <h2 class="content-header-title text-black section-title">Related Articles</h2>
            </div>
            <div class="section-header-cta">
                <a class="section-header-cta-button" href="/articles">
                    <span class="section-header-cta-text">مزید دیکھیں</span>
                    <span>
                        <svg class="section-header-cta-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                    </span>
                </a>
            </div>
        </div>
        <div class="section-wrapper">
            <div class="grid mt-20 gap-12">
                @for ($i = 0; $i < count($related_articles); ++$i)

                <div>
                    <div class="hero-section-left width-full">
                        <div class="hero-section-left-wrapper">
                            <div class="hero-section-left-body section-left-body grid-col-1">

                            @for (; $i < count($related_articles); $i++)
                                <a href="{{ $related_articles[$i]->article_url }}" class="min-width-400 related-article-link">
                                    <div class="article-preview-popup">
                                        <img class="article-preview-popup-img" src="{{ $related_articles[$i]->image_url }}" alt="{{ $related_articles[$i]->title }}" loading="lazy">
                                        <div class="article-preview-popup-content">
                                            <h4 class="article-preview-popup-title">{{ $related_articles[$i]->title }}</h4>
                                            <p class="article-preview-popup-time">{{ $related_articles[$i]->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="hero-section-left-body-detail text-black-005 py-16 pt-0 hover-none has-border-bottom">
                                        <div class="hero-section-left-body-detail-poster section-image">
                                            <img class="hero-section-left-body-detail-poster-image" src="{{ $related_articles[$i]->image_sm_url }}" alt="{{ $related_articles[$i]->title }}" loading="lazy">
                                        </div>
                                        <div class="hero-section-left-body-detail-content">

                                            <p class="hero-section-left-body-detail-content-text">
                                                {{ $related_articles[$i]->title }}
                                            </p>
                                            <div class="hero-section-left-body-detail-content-time">
                                                {{ $related_articles[$i]->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @if (($i + 1) % 4 == 0) @break @endif
                            @endfor

                            </div>
                        </div>
                    </div>
                </div>

            @endfor
            </div>
        </div>
    </div>
</section>

<section class="section contact-section bg-primary">
    <div class="container">
        <div class="comments-layout">
            <div class="comments-sidebar">
                <div class="comments-sidebar-box">
                    <div class="comments-sidebar-badge">
                        <span class="comments-sidebar-badge-dot"></span> Discussion
                    </div>
                    <div class="comments-sidebar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM7.12132 17H20V5H4V18.3851L7.12132 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z"></path></svg>
                    </div>
                    <h3>Comment<br><span>Your View</span></h3>
                    <p>We'd love to hear your perspective on this article. Join the conversation and share your thoughts below!</p>
                </div>
            </div>
            <div class="comments-main">
                <div class="section-wrapper flex-col">
            <div class="section-form">
                <div class="section-form-wrapper">
                    <div class="article-section-details-vote-text text-left">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <h2 class="article-section-details-vote-text-title">Post your comment</h2>
                        <span class="article-section-details-vote-text-subtitle">{{ $count_comment }} Comments</span>
                    </div>
                    <form class="contact-form" action="/comment/store" method="POST">
                        @csrf
                        <div class="contact-form-wrapper width-700 bg-transparent shadow-none pl-0">
                            <div class="contact-info">
                                <div class="contact-info-input">
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <label for="first_name_input" style="display:none;">Name</label>
                                    <input id="first_name_input" class="form-input bg-white" type="text" placeholder="Name" name="first_name">
                                    @error('first_name')
                                        <p style="color:red">{{  $message }}</p>
                                    @enderror
                                </div>
                                <div class="contact-info-input">
                                    <label for="email_input" style="display:none;">Email address</label>
                                    <input id="email_input" class="form-input bg-white" type="text" placeholder="Email address" name="email">
                                    @error('email')
                                        <p style="color:red">{{  $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="contact-description">
                                <label for="comment_input" style="display:none;">Write message</label>
                                <textarea id="comment_input" class="text-input bg-white" type="text" placeholder="Write message..." name="comment"></textarea>
                                @error('comment')
                                    <p style="color:red">{{  $message }}</p>
                                @enderror
                            </div>
                            <div class="contact-cta">
                                <button class="button-hero button-hover is-fill ">Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section-form">
                <div class="section-form-wrapper">
                    @if ( $count_comment>0 )
                    <div class="article-section-details-vote-text text-left">
                        <h2 class="article-section-details-vote-text-title">All comments</h2>
                    </div>
                    <div class="chats">
                        @foreach($article_comments as $ac)
                            <div class="chat">
                                <div class="chat-avatar">
                                    <img class="chat-avatar-img" src="{{ $ac->user->photo ? $ac->user->photo: '/assets/img/default-image.jpg'}}" alt="Avatar" loading="lazy">
                                </div>
                                <div class="chat-content">
                                    <div class="chat-content-header">
                                        <span class="chat-content-text-user">{{ $ac->user->first_name }}</span>
                                    </div>
                                    <div class="chat-content-text">
                                        {{ $ac->comment }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="article-section-details-vote-text text-left">
                        <h2 class="article-section-details-vote-text-title">No comments</h2>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('vue_app')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="{{ asset('assets/js/soundTrack.js') }}"></script>
<script>

const app = new Vue({
    el: "#app",
    data: {
        vote: {
            article_id: {{ $article->id }},
            vote_type: 0,
            first_name: "",
            last_name: "",
            email: "",
            _token: "{{ csrf_token() }}",
        },
        articleVoteType: 0,
        isProcessing: false,
        isPlaying: false,
        track: null,
        articleName: "{{ $article->name }}",
        articleId: {{ $article->id }},
        isTranslating: false,
        isEnglish: false,
        originalTitle: "",
        originalContent: "",
        voteMessage: "",
        currentVoteCount: {{ $count_vote }},
    },

    methods: {
        postVote(voteType) {
            this.articleVoteType = voteType;

            this.$nextTick(() => {
                const form = this.$refs.voteForm;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => {
                    this.voteMessage = "Thank you! Your vote has been recorded.";
                    this.currentVoteCount++;
                })
                .catch(error => {
                    console.error("Error submitting vote:", error);
                });
            });
        },

        textToSpeech() {
            if (this.track) {
                if (this.isPlaying) {
                    this.track.pause();
                    this.isPlaying = false;
                } else {
                    this.track.play(false);
                    this.isPlaying = true;
                }
                return;
            }

            const url = `/api/articles/${this.articleId}/text-to-speech?device=web`;
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
            }).then(async (data) => {
                this.isProcessing = false;
                this.track = new SoundTrack(this.articleName, data.url);
                this.track.onEnded(() => this.isPlaying = false);
                await this.track.load();
                this.isPlaying = true;
                this.track.play(false);
            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.isProcessing = false;
            });
        },
        translateContent() {
            if (this.isEnglish) {
                let titleEl = document.querySelector('.hero-section-right-body-title');
                let descEl = document.querySelector('.article-section-details-description-text');
                
                if(titleEl && this.originalTitle) {
                    titleEl.innerText = this.originalTitle;
                    titleEl.style.direction = '';
                    titleEl.style.textAlign = '';
                    titleEl.style.fontFamily = '';
                }
                if(descEl && this.originalContent) {
                    descEl.innerText = this.originalContent;
                    descEl.style.direction = '';
                    descEl.style.textAlign = '';
                    descEl.style.fontFamily = '';
                }
                this.isEnglish = false;
                return;
            }

            this.isTranslating = true;
            fetch(`/api/articles/${this.articleId}/translate`)
                .then(res => res.json())
                .then(data => {
                    if (data.title && data.content) {
                        let titleEl = document.querySelector('.hero-section-right-body-title');
                        let descEl = document.querySelector('.article-section-details-description-text');
                        
                        if (!this.originalTitle && titleEl) this.originalTitle = titleEl.innerText;
                        if (!this.originalContent && descEl) this.originalContent = descEl.innerText;

                        if(titleEl) {
                            titleEl.innerText = data.title;
                            titleEl.style.direction = 'ltr';
                            titleEl.style.textAlign = 'left';
                            titleEl.style.fontFamily = '"Inter", sans-serif';
                        }
                        if(descEl) {
                            descEl.innerText = data.content;
                            descEl.style.direction = 'ltr';
                            descEl.style.textAlign = 'left';
                            descEl.style.fontFamily = '"Inter", sans-serif';
                        }
                        this.isEnglish = true;
                    } else {
                        alert('Translation failed or API key missing in .env.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred during translation. Check your console and API key.');
                })
                .finally(() => {
                    this.isTranslating = false;
                });
        },
    }
});
</script>
@endsection
