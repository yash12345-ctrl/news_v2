@extends('templates.base', ['title' => 'Article | Akhbar-e-mashriq'])

@section('content')
<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;900&family=Noto+Nastaliq+Urdu:wght@400;700&display=swap");

/* ═══════════════════════════════════════════
   NEWSPAPER 3-COLUMN ARTICLE LAYOUT
   ═══════════════════════════════════════════ */

.single-article-page {
    background: #f7f7f7;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}
.single-article-page > .container {
    padding-top: 32px;
    padding-bottom: 80px;
    max-width: 1260px;
}

/* ── 3-Column Grid: Left / Center / Right ── */
.np-layout {
    display: grid;
    grid-template-columns: 1.15fr 2fr 1fr;
    gap: 24px;
    align-items: start;
}

/* ── Shared White Box Style ── */
.np-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e8e8e8;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* ═══════════════════════
   LEFT BOX — Title & Meta
   ═══════════════════════ */
.np-left { padding: 28px 24px 24px; display: flex; flex-direction: column; gap: 0; }

.np-category {
    display: inline-flex;
    align-items: center;
    background: rgba(227, 30, 36, 0.08);
    color: #e31e24;
    font-family: "Inter", sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 6px 14px;
    border-radius: 50px;
    margin-bottom: 24px;
    border: 1px solid rgba(227, 30, 36, 0.12);
    box-shadow: 0 2px 8px rgba(227,30,36,0.03);
    align-self: flex-start;
}

.np-title {
    font-family: "Noto Nastaliq Urdu", serif !important;
    font-size: 34px !important;
    font-weight: 700 !important;
    line-height: 1.7 !important;
    color: #0a0a0a !important;
    margin: 0 0 24px !important;
    direction: rtl !important;
    text-align: right !important;
}

.np-author-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 0 0;
    border-top: 1px solid #f0f0f0;
    margin-top: 10px;
    margin-bottom: 24px;
}
.np-author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    flex-shrink: 0;
}
.np-author-info { display: flex; flex-direction: column; }
.np-author-name {
    font-family: "Inter", sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: #000;
}
.np-author-meta {
    font-family: "Inter", sans-serif;
    font-size: 12px;
    color: #777;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 3px;
}
.np-listen-btn {
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 50px;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #e31e24;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 700;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin-left: auto;
}
.np-listen-btn:hover {
    background: #e31e24;
    color: #fff;
    border-color: #e31e24;
    box-shadow: 0 6px 16px rgba(227,30,36,0.2);
}
@keyframes np-spin { 100% { transform: rotate(360deg); } }

.np-social-stack {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 4px;
}

/* Language Toggles */
.np-lang-active { background: linear-gradient(135deg, #e31e24 0%, #ff4b4b 100%); color: #fff; border: none; padding: 10px 28px; border-radius: 50px; font-family: 'Inter', sans-serif; font-size: 14.5px; font-weight: 700; cursor: default; display: inline-flex; align-items: center; box-shadow: 0 6px 16px rgba(227,30,36,0.3); letter-spacing: 0.2px; }
.np-lang-inactive { background: #fff; color: #555; border: 1px solid #e0e0e0; padding: 9px 27px; border-radius: 50px; font-family: 'Inter', sans-serif; font-size: 14.5px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.04); letter-spacing: 0.2px; }
.np-lang-inactive:hover { background: #fafafa; color: #111; border-color: #ccc; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transform: translateY(-1px); }

.np-social-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #e8e8e8;
    background: #fafafa;
    font-family: "Inter", sans-serif;
    font-size: 12px;
    font-weight: 600;
    color: #555;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}
.np-social-btn svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }
.np-social-btn.facebook:hover { background: #1877f2; color: #fff; border-color: #1877f2; }
.np-social-btn.twitter:hover  { background: #1da1f2; color: #fff; border-color: #1da1f2; }
.np-social-btn.whatsapp:hover { background: #25d366; color: #fff; border-color: #25d366; }
.np-social-btn.linkedin:hover { background: #0a66c2; color: #fff; border-color: #0a66c2; }
.np-social-btn.email:hover    { background: #555;    color: #fff; border-color: #555; }

/* Tags section in left box */
.np-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #f0f0f0;
}
.np-tag {
    font-family: "Inter", sans-serif;
    font-size: 11px;
    font-weight: 600;
    color: #555;
    background: #f5f5f5;
    padding: 5px 12px;
    border-radius: 100px;
    text-decoration: none;
    border: 1px solid #e8e8e8;
    transition: all 0.2s ease;
}
.np-tag:hover { background: #e31e24; color: #fff; border-color: #e31e24; }

/* Reaction voting inside left box */
.np-vote {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #f0f0f0;
}
.np-vote-title {
    font-family: "Inter", sans-serif;
    font-size: 12px;
    font-weight: 800;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}
.np-vote-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}
.np-vote-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    background: #fafafa;
    padding: 10px 4px;
    border-radius: 10px;
    border: 1px solid #e8e8e8;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: "Inter", sans-serif;
    font-size: 10px;
    font-weight: 700;
    color: #666;
}
.np-vote-btn img { width: 28px; height: 28px; }
.np-vote-btn:hover { border-color: #e31e24; background: #fff5f5; color: #e31e24; transform: translateY(-2px); }

/* ═══════════════════════════════
   CENTER BOX — Image + Content
   ═══════════════════════════════ */
.np-center { padding: 0; }

.np-hero-img-wrap {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 14px 14px 0 0;
}
.np-hero-img {
    width: 100%;
    height: 340px;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}
.np-hero-img:hover { transform: scale(1.02); }
.np-hero-iframe {
    width: 100%;
    height: 340px;
    display: block;
    border: none;
}
.np-img-caption {
    background: #f7f7f7;
    border-top: 1px solid #ebebeb;
    padding: 10px 20px;
    font-family: "Inter", sans-serif;
    font-size: 12px;
    color: #888;
    line-height: 1.5;
    font-style: italic;
}

.np-content-body { padding: 24px 28px 28px; }

.np-article-text {
    font-family: "Noto Nastaliq Urdu", serif !important;
    font-size: 20px !important;
    line-height: 2.8 !important;
    color: #333 !important;
    direction: rtl !important;
    text-align: right !important;
    margin-bottom: 24px !important;
}
.np-article-text strong { color: #111; font-weight: 700; }

/* Pull Quote / Blockquote */
.np-pullquote {
    border-left: 4px solid #e31e24;
    background: #fff9f9;
    margin: 28px 0;
    padding: 20px 24px;
    border-radius: 0 8px 8px 0;
}
.np-pullquote p {
    font-family: "Poppins", sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: #222;
    margin: 0;
    line-height: 1.7;
    font-style: italic;
}
.np-pullquote::before {
    content: '\201C';
    display: block;
    font-size: 48px;
    color: #e31e24;
    line-height: 1;
    margin-bottom: -8px;
    font-family: Georgia, serif;
}

.np-source {
    font-family: "Inter", sans-serif;
    font-size: 12px;
    color: #aaa;
    padding-top: 16px;
    border-top: 1px solid #eee;
    margin-top: 24px;
    direction: rtl;
    text-align: right;
}

/* ═══════════════════════════════
   RIGHT BOX — Related + Trending
   ═══════════════════════════════ */
.np-right { padding: 24px; display: flex; flex-direction: column; gap: 0; }

.np-section-label {
    font-family: "Inter", sans-serif;
    font-size: 12px;
    font-weight: 900;
    color: #111;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding-bottom: 12px;
    border-bottom: 2px solid #111;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.np-section-label span {
    width: 6px;
    height: 6px;
    background: #e31e24;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}

/* Related Stories — thumbnail cards */
.np-related-list {
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-bottom: 28px;
}
.np-related-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #f2f2f2;
    text-decoration: none;
    transition: all 0.2s ease;
}
.np-related-item:last-child { border-bottom: none; }
.np-related-item:hover .np-related-title { color: #e31e24; }
.np-related-thumb {
    width: 72px;
    height: 54px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}
.np-related-item:hover .np-related-thumb { transform: scale(1.04); }
.np-related-info { flex: 1; min-width: 0; }
.np-related-title {
    font-family: "Noto Nastaliq Urdu", serif;
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.7;
    margin: 0 0 4px;
    direction: rtl;
    text-align: right;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
}
.np-related-date {
    font-family: "Inter", sans-serif;
    font-size: 10px;
    color: #bbb;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    text-align: right;
    direction: rtl;
}

/* Trending — numbered list */
.np-trending-list {
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-bottom: 28px;
    counter-reset: trend-counter;
}
.np-trending-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid #f2f2f2;
    text-decoration: none;
    counter-increment: trend-counter;
    transition: all 0.2s ease;
}
.np-trending-item:last-child { border-bottom: none; }
.np-trending-num {
    font-family: "Inter", sans-serif;
    font-size: 20px;
    font-weight: 900;
    color: #ddd;
    line-height: 1.2;
    flex-shrink: 0;
    width: 24px;
    text-align: center;
}
.np-trending-num::before { content: counter(trend-counter); }
.np-trending-item:hover .np-trending-num { color: #e31e24; }
.np-trending-title {
    font-family: "Noto Nastaliq Urdu", serif;
    font-size: 13px;
    font-weight: 600;
    color: #222;
    line-height: 1.8;
    margin: 0;
    direction: rtl;
    text-align: right;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
    flex: 1;
}
.np-trending-item:hover .np-trending-title { color: #e31e24; }

/* Ad card in right column */
.np-ad-block {
    border-top: 1px solid #f0f0f0;
    padding-top: 20px;
    margin-top: 4px;
}
.np-ad-img {
    width: 100%;
    border-radius: 10px;
    display: block;
    height: auto;
    margin-bottom: 10px;
}
.np-ad-label {
    font-family: "Inter", sans-serif;
    font-size: 10px;
    color: #bbb;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}
.np-ad-title {
    font-family: "Noto Nastaliq Urdu", serif;
    font-size: 14px;
    color: #111;
    direction: rtl;
    text-align: right;
    line-height: 2;
    margin: 0;
}

/* ── Responsive ── */
@media (max-width: 1100px) {
    .np-layout { grid-template-columns: 1fr 1.8fr; }
    .np-right-col { grid-column: span 2; }
}
@media (max-width: 768px) {
    .np-layout { grid-template-columns: 1fr; }
    .np-right-col { grid-column: span 1; }
    .single-article-page > .container { padding-top: 16px; padding-bottom: 40px; }
    .np-title { font-size: 24px !important; }
    .np-article-text { font-size: 17px !important; line-height: 2.4 !important; }
    .np-hero-img, .np-hero-iframe { height: 220px; }
}

/* ── Global: Comments & Contact Section ── */
.section.bg-primary { background: #f5f5f7 !important; padding: 48px 0; }
.section.bg-primary .content-header-title { font-size: 18px !important; font-weight: 700 !important; color: #111 !important; text-transform: none; letter-spacing: 0; }
.section.bg-primary .section-header-cta-button { font-family: "Inter", sans-serif; font-size: 12px; font-weight: 700; color: #e31e24; text-decoration: none; display: flex; align-items: center; gap: 4px; text-transform: uppercase; letter-spacing: 1px; }
.section.bg-primary .section-header-cta-icon { width: 16px; height: 16px; fill: #e31e24; }
.contact-section.bg-primary { background: #fafafa !important; padding: 80px 0; border-top: 1px solid rgba(0,0,0,0.05); }
.contact-section .container { margin: 0 auto; }

.comments-layout { display: flex; gap: 80px; align-items: stretch; width: 100%; max-width: 100%; margin: 0 auto; }
@media(max-width: 1000px) { .comments-layout { flex-direction: column; gap: 40px; } }
.comments-sidebar { width: 35%; min-width: 380px; max-width: 480px; flex-shrink: 0; }
@media(max-width: 1000px) { .comments-sidebar { width: 100%; min-width: 0; max-width: none; } }
.comments-main { flex: 1; min-width: 0; width: 100%; padding-bottom: 40px; }
.comments-sidebar-box { background: #09090b; padding: 60px 48px; border-radius: 32px; color: #fff; box-shadow: 0 32px 64px rgba(0,0,0,0.15), inset 0 1px 1px rgba(255,255,255,0.08); position: sticky; top: 40px; height: calc(100vh - 80px); min-height: 500px; max-height: 700px; display: flex; flex-direction: column; justify-content: center; text-align: left; border: 1px solid rgba(255,255,255,0.04); overflow: hidden; }
.comments-sidebar-box::before { content: ''; position: absolute; top: -30%; left: -30%; width: 160%; height: 160%; background: radial-gradient(circle at 50% 0%, rgba(227, 30, 36, 0.12) 0%, transparent 60%); z-index: 0; pointer-events: none; }
.comments-sidebar-box > * { position: relative; z-index: 1; }
.comments-sidebar-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 100px; font-family: "Inter", sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.8); margin-bottom: 24px; align-self: flex-start; }
.comments-sidebar-badge-dot { width: 6px; height: 6px; background: #e31e24; border-radius: 50%; box-shadow: 0 0 10px #e31e24; animation: pulse-glow 2s infinite; }
@keyframes pulse-glow { 0% { box-shadow: 0 0 0 0 rgba(227,30,36,0.4); } 70% { box-shadow: 0 0 0 6px rgba(227,30,36,0); } 100% { box-shadow: 0 0 0 0 rgba(227,30,36,0); } }
.comments-sidebar-box h3 { font-family: "Poppins", serif; font-size: 42px; font-weight: 800; margin: 0 0 20px; color: #fff; letter-spacing: -1.5px; line-height: 1.1; }
.comments-sidebar-box h3 span { color: transparent; background: linear-gradient(135deg, #e31e24, #ff6b6b); -webkit-background-clip: text; background-clip: text; }
.comments-sidebar-box p { font-family: "Inter", sans-serif; font-size: 15.5px; color: rgba(255,255,255,0.6); line-height: 1.8; margin: 0; }
.comments-sidebar-icon { display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: linear-gradient(135deg, rgba(227,30,36,0.15) 0%, rgba(227,30,36,0.02) 100%); color: #e31e24; border-radius: 20px; margin-bottom: 28px; box-shadow: inset 0 1px 1px rgba(255,255,255,0.1), 0 12px 32px rgba(227,30,36,0.1); border: 1px solid rgba(227,30,36,0.15); align-self: flex-start; }
.comments-sidebar-icon svg { width: 28px; height: 28px; fill: currentColor; filter: drop-shadow(0 4px 8px rgba(227,30,36,0.4)); }

.contact-section .article-section-details-vote-text { text-align: left !important; margin-bottom: 32px; }
.contact-section .article-section-details-vote-text-title { font-family: "Poppins", sans-serif; font-size: 32px; font-weight: 800; color: #111; margin-bottom: 8px; letter-spacing: -0.5px; position: relative; display: inline-block; }
.contact-section .article-section-details-vote-text-title::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 40px; height: 3px; background: #e31e24; border-radius: 2px; }
.contact-section .article-section-details-vote-text-subtitle { font-family: "Inter", sans-serif; font-size: 13px; color: #888; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-top: 16px; }

.contact-info { display: flex; gap: 24px; margin-bottom: 24px; }
@media(max-width: 600px) { .contact-info { flex-direction: column; gap: 16px; margin-bottom: 16px; } }
.contact-info-input { flex: 1; position: relative; }
.form-input, .text-input { width: 100%; border: 1px solid transparent; border-radius: 16px; font-family: "Inter", sans-serif; font-size: 15px; color: #111; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.04); outline: none; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-sizing: border-box; }
.form-input { padding: 18px 24px; }
.text-input { padding: 24px; resize: vertical; min-height: 160px; line-height: 1.6; }
.form-input::placeholder, .text-input::placeholder { color: #a0a0a0; font-weight: 400; }
.form-input:focus, .text-input:focus { background: #fff; border-color: rgba(227,30,36,0.3); box-shadow: 0 8px 32px rgba(227,30,36,0.08), 0 0 0 4px rgba(227,30,36,0.05); transform: translateY(-2px); }

.contact-cta { text-align: right; margin-top: 24px; }
.button-hero { background: linear-gradient(135deg, #e31e24 0%, #9e0d12 100%); color: #fff; border: none; padding: 16px 48px; border-radius: 50px; font-family: "Inter", sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 10px 24px rgba(227,30,36,0.3), inset 0 2px 0 rgba(255,255,255,0.2); text-transform: uppercase; letter-spacing: 1.5px; position: relative; overflow: hidden; display: inline-block; }
.button-hero::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.6s ease; }
.button-hero:hover { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(227,30,36,0.4), inset 0 2px 0 rgba(255,255,255,0.2); color: #fff; }
.button-hero:hover::before { left: 100%; }

.chats { display: flex; flex-direction: column; gap: 20px; margin-top: 32px; }
.chat { display: flex; gap: 16px; align-items: flex-start; padding: 20px 24px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.04); transition: transform 0.25s ease; }
.chat:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.07); }
.chat-avatar-img { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.chat-content { flex: 1; min-width: 0; }
.chat-content-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
.chat-content-text-user { font-family: "Poppins", sans-serif; font-weight: 700; color: #111; font-size: 14px; letter-spacing: -0.2px; }
.chat-content-text { font-family: "Inter", sans-serif; font-size: 14px; color: #555; line-height: 1.7; }

.alert-success { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #15803d; padding: 14px 18px; border-radius: 12px; font-family: "Inter", sans-serif; font-size: 14px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.alert-success::before { content: '✓'; display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; background: #16a34a; color: #fff; border-radius: 50%; font-size: 12px; }

</style>

<section id="app" class="single-article-page">

    <div class="container">
        <div class="np-layout">

            <!-- ═══ BOX 1 (LEFT): Category · Title · Author · Social ═══ -->
            <div>
                <div class="np-box np-left">

                    <!-- Category Badge -->
                    <span class="np-category">{{ $article->category ? $article->category->name : 'General' }}</span>

                    <!-- Title -->
                    <h1 class="np-title">{{ $article->title }}</h1>

                    <!-- Author Row -->
                    <div class="np-author-row">
                        <img class="np-author-avatar" src="{{ $article->admin ? $article->admin->photo : '/assets/img/default-image.jpg' }}" alt="{{ $article->admin ? $article->admin->first_name : 'Admin' }}">
                        <div class="np-author-info">
                            <span class="np-author-name">By {{ $article->admin ? $article->admin->first_name : 'Admin' }}</span>
                            <div class="np-author-meta">
                                <span>{{ date('M d, Y', strtotime($article->created_at)) }}</span>
                            </div>
                        </div>

                        <button @click="textToSpeech" class="np-listen-btn" title="Listen to Article">
                            <svg v-if="isProcessing" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: np-spin 1s linear infinite;"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                            <svg v-else-if="isPlaying" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                            
                            <span v-if="isProcessing">Loading...</span>
                            <span v-else-if="isPlaying">Playing</span>
                            <span v-else>Listen</span>
                        </button>
                    </div>

                    <!-- Vertical Social Share -->
                    <div class="np-social-stack">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $article->article_url }}" target="_blank" class="np-social-btn facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z"/></svg>
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ $article->title }}&url={{ $article->article_url }}" target="_blank" class="np-social-btn twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.69303 15.9418 3.69434C13.6326 3.69434 11.7597 5.56661 11.7597 7.87683C11.7597 8.20458 11.7973 8.52242 11.8676 8.82909C8.39047 8.65404 5.31007 6.99005 3.24678 4.45941C2.87529 5.09767 2.68005 5.82318 2.68104 6.56167C2.68104 8.01259 3.4196 9.29324 4.54149 10.043C3.87737 10.022 3.22788 9.84264 2.64718 9.51973C2.64654 9.5373 2.64654 9.55487 2.64654 9.57148C2.64654 11.5984 4.08819 13.2892 6.00199 13.6731C5.6428 13.7703 5.27232 13.8194 4.90022 13.8191C4.62997 13.8191 4.36771 13.7942 4.11279 13.7453C4.64531 15.4065 6.18886 16.6159 8.0196 16.6491C6.53813 17.8118 4.70869 18.4426 2.82543 18.4399C2.49212 18.4402 2.15909 18.4205 1.82812 18.3811C3.74004 19.6102 5.96552 20.2625 8.23842 20.2601C15.9316 20.2601 20.138 13.8875 20.138 8.36111C20.138 8.1803 20.1336 7.99886 20.1256 7.81997C20.9443 7.22845 21.651 6.49567 22.2125 5.65605Z"/></svg>
                            Twitter / X
                        </a>
                        <a href="https://wa.me/?text={{ $article->article_url }}" target="_blank" class="np-social-btn whatsapp">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22C10.1671 22 8.44851 21.5064 6.97086 20.6447L2.00516 22L3.35712 17.0315C2.49494 15.5536 2.00098 13.8345 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2Z"/></svg>
                            WhatsApp
                        </a>
                        <a href="mailto:?subject={{ $article->title }}&body={{ $article->article_url }}" class="np-social-btn email">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM12.0606 11.6829L5.64722 6.2377L4.35278 7.7623L12.0732 14.3171L19.6544 7.75616L18.3456 6.24384L12.0606 11.6829Z"/></svg>
                            Email
                        </a>
                    </div>

                    <!-- Tags -->
                    @if(count($category_map) > 0)
                    <div class="np-tags">
                        @foreach($category_map as $key => $c)
                            <a class="np-tag" href="/articles?category_id={{ $c }}">{{ ucwords($key) }}</a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Reaction Voting -->
                    <div class="np-vote">
                        <p class="np-vote-title">Your Reaction</p>
                        @if(session()->has('vote_message'))
                            <div class="alert-success" style="margin-bottom:12px; font-size:12px;">{{ session()->get('vote_message') }}</div>
                        @endif
                        <div v-if="voteMessage" class="alert-success" style="margin-bottom:12px; font-size:12px;" v-cloak>@{{ voteMessage }}</div>
                        <form ref="voteForm" action="/vote/store" @submit.prevent method="post">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <input type="hidden" name="vote_type" :value="articleVoteType">
                            <div class="np-vote-row">
                                <button type="submit" @click="postVote(1)" class="np-vote-btn"><img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f60d/512.webp" alt="Best" loading="lazy"><span>Best</span></button>
                                <button type="submit" @click="postVote(2)" class="np-vote-btn"><img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44d/512.webp" alt="Good" loading="lazy"><span>Good</span></button>
                                <button type="submit" @click="postVote(3)" class="np-vote-btn"><img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f610/512.webp" alt="Okay" loading="lazy"><span>Okay</span></button>
                                <button type="submit" @click="postVote(4)" class="np-vote-btn"><img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f44e/512.webp" alt="Bad" loading="lazy"><span>Bad</span></button>
                            </div>
                        </form>
                        <p style="font-family:'Inter',sans-serif; font-size:11px; color:#bbb; margin:8px 0 0; text-align:center;" v-cloak>@{{ currentVoteCount }} Responses</p>
                    </div>

                </div>

                @if(isset($trending_video) && $trending_video)
                <div class="np-box" style="margin-top: 24px; padding: 20px;">
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 800; color: #111; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 1px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e31e24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                        Trending Video
                    </h3>
                    <div style="border-radius: 12px; overflow: hidden; background: #000; aspect-ratio: 9/16; width: 100%; box-shadow: 0 6px 16px rgba(0,0,0,0.12); position: relative;">
                        <video id="trendingVideoPlayer" autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover; display: block; cursor: pointer;" poster="{{ asset($trending_video->thumbnail_url ?? '') }}" onclick="var v=document.getElementById('trendingVideoPlayer'); v.muted=!v.muted; document.getElementById('icon-muted').style.display=v.muted?'block':'none'; document.getElementById('icon-unmuted').style.display=v.muted?'none':'block';">
                            <source src="{{ asset($trending_video->video_url) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <!-- Custom Mute Button Overlay -->
                        <button onclick="var v=document.getElementById('trendingVideoPlayer'); v.muted=!v.muted; document.getElementById('icon-muted').style.display=v.muted?'block':'none'; document.getElementById('icon-unmuted').style.display=v.muted?'none':'block';" style="position: absolute; bottom: 16px; right: 16px; background: rgba(0,0,0,0.6); border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #fff; transition: background 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                            <!-- Muted Icon (Default) -->
                            <svg id="icon-muted" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
                            <!-- Unmuted Icon -->
                            <svg id="icon-unmuted" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>
                        </button>
                    </div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #333; margin: 12px 0 0; line-height: 1.4;">
                        {{ $trending_video->title }}
                    </p>
                </div>
                @endif

            </div>

            <!-- ═══ BOX 2 (CENTER): Image + Article Content ═══ -->
            <div>
                <div class="np-box np-center">

                    <!-- Hero Image / Video -->
                    <div class="np-hero-img-wrap">
                        @if ($article->isVideoArticle())
                            <img class="np-hero-img" src="{{ $article->image_url }}" alt="{{ $article->title }}" fetchpriority="high">
                        @else
                            <iframe class="np-hero-iframe" src="https://www.youtube.com/embed/{{ $article->extractVideoId($article->video_url) }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        @endif
                    </div>
                    <!-- Image Caption -->
                    <div class="np-img-caption">
                        {{ $article->title }} — <em>{{ date('F d, Y', strtotime($article->created_at)) }}</em>
                    </div>

                    <!-- Language Toggles -->
                    <div style="display: flex; gap: 10px; margin: 24px 24px 8px; border-bottom: 1px solid #f0f0f0; padding-bottom: 20px;" v-cloak>
                        <button @click="isEnglish ? translateContent() : null" :class="!isEnglish ? 'np-lang-active' : 'np-lang-inactive'">Urdu</button>
                        <button @click="!isEnglish ? translateContent() : null" :class="isEnglish ? 'np-lang-active' : 'np-lang-inactive'">
                            English
                            <svg v-if="isTranslating" style="animation: np-spin 1s linear infinite; margin-left: 6px;" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        </button>
                    </div>

                    <!-- Article Body -->
                    <div class="np-content-body">
                        <div class="np-article-text">{!! nl2br(e($article->content)) !!}</div>

                        <!-- Pull Quote -->
                        @php
                            $shortContent = strip_tags($article->content_short ?? $article->content ?? '');
                            $pullQuote = mb_substr($shortContent, 0, 180);
                        @endphp
                        @if(!empty(trim($pullQuote)))
                        <div class="np-pullquote">
                            <p>{{ $pullQuote }}...</p>
                        </div>
                        @endif

                        <!-- Source -->
                        @if($article->source)
                        <div class="np-source"><strong>Source:</strong> {{ $article->source }}</div>
                        @endif
                    </div>

                </div>
            </div>

            <!-- ═══ BOX 3 (RIGHT): Related Stories + Trending + Ad ═══ -->
            <div class="np-right-col">
                <div class="np-box np-right">

                    <!-- Related Stories -->
                    <div class="np-section-label"><span></span> Related Stories</div>
                    <div class="np-related-list">
                        @foreach($popular_articles->take(4) as $p)
                        <a href="{{ $p->article_url }}" class="np-related-item">
                            <img class="np-related-thumb" src="{{ $p->image_sm_url }}" alt="{{ $p->title }}" loading="lazy">
                            <div class="np-related-info">
                                <h4 class="np-related-title">{{ $p->title }}</h4>
                                <div class="np-related-date">{{ $p->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <!-- Trending Articles -->
                    <div class="np-section-label" style="margin-top: 8px;"><span></span> Trending Articles</div>
                    <div class="np-trending-list">
                        @foreach($popular_articles->take(5) as $p)
                        <a href="{{ $p->article_url }}" class="np-trending-item">
                            <div class="np-trending-num"></div>
                            <h4 class="np-trending-title">{{ $p->title }}</h4>
                        </a>
                        @endforeach
                    </div>

                    <!-- Sponsored Ad -->
                    @if(!is_null($digital_ad))
                    <div class="np-ad-block">
                        <div class="np-ad-label">Sponsored</div>
                        <a href="/ad-track/{{ $digital_ad->id }}" target="_blank" style="display:block; text-decoration:none;">
                            <img class="np-ad-img" src="{{ $digital_ad->media_url }}" alt="{{ $digital_ad->title }}" loading="lazy">
                            <p class="np-ad-title">{{ $digital_ad->title }}</p>
                        </a>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>

<style>
/* ── Related Articles Section ── */
.ra-section {
    background: linear-gradient(160deg, #f8f9fb 0%, #eef0f5 100%);
    padding: 60px 0;
}
.ra-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 36px;
}
.ra-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.ra-header-accent {
    width: 5px;
    height: 32px;
    background: linear-gradient(180deg, #e31e24, #ff6b6b);
    border-radius: 4px;
    flex-shrink: 0;
}
.ra-header-title {
    font-family: 'Inter', sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: #111;
    letter-spacing: -0.5px;
    margin: 0;
}
.ra-header-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #e31e24;
    text-decoration: none;
    letter-spacing: 0.3px;
    transition: gap 0.2s ease;
}
.ra-header-cta:hover { gap: 12px; }
.ra-header-cta svg { transition: transform 0.2s ease; }
.ra-header-cta:hover svg { transform: translateX(3px); }
.ra-columns {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 992px) { .ra-columns { grid-template-columns: 1fr; } }
.ra-column {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px 24px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.05), 0 1px 4px rgba(0,0,0,0.03);
    border: 1px solid rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    gap: 0;
}
.ra-item {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    text-decoration: none;
    padding: 20px 0;
    border-bottom: 1px solid rgba(0,0,0,0.055);
    transition: background 0.2s ease;
    border-radius: 0;
    position: relative;
    overflow: visible;
}
.ra-item:last-child { border-bottom: none; padding-bottom: 0; }
.ra-item:first-child { padding-top: 0; }
.ra-item:hover .ra-item-title { color: #e31e24; }
.ra-item:hover .ra-item-img { transform: scale(1.06); }
.ra-item-text { flex: 1; display: flex; flex-direction: column; justify-content: center; min-width: 0; }
.ra-item-title {
    font-family: 'Noto Nastaliq Urdu', 'Playfair Display', serif;
    font-size: 17px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.75;
    margin: 0 0 10px 0;
    text-align: right;
    direction: rtl;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
}
.ra-item-meta {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
    direction: rtl;
}
.ra-item-time {
    font-family: 'Inter', sans-serif;
    font-size: 10.5px;
    font-weight: 700;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.6px;
}
.ra-item-dot {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: #ddd;
    flex-shrink: 0;
}
.ra-item-img-wrap {
    width: 115px;
    height: 82px;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    background: #f0f0f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.ra-item-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    display: block;
}
</style>

<section class="ra-section">
    <div class="container">

        <div class="ra-header">
            <div class="ra-header-left">
                <div class="ra-header-accent"></div>
                <h2 class="ra-header-title">Related Articles</h2>
            </div>
            <a class="ra-header-cta" href="/articles">
                <span>مزید دیکھیں</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#e31e24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"/></svg>
            </a>
        </div>

        <div class="ra-columns">
            @for ($i = 0; $i < count($related_articles); ++$i)
            <div class="ra-column">
                @for (; $i < count($related_articles); $i++)
                <a href="{{ $related_articles[$i]->article_url }}" class="ra-item">
                    <div class="ra-item-text">
                        <h3 class="ra-item-title">{{ $related_articles[$i]->title }}</h3>
                        <div class="ra-item-meta">
                            <span class="ra-item-time">{{ $related_articles[$i]->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="ra-item-img-wrap">
                        <img class="ra-item-img" src="{{ $related_articles[$i]->image_sm_url }}" alt="{{ $related_articles[$i]->title }}" loading="lazy">
                    </div>
                </a>
                @if (($i + 1) % 4 == 0) @break @endif
                @endfor
            </div>
            @endfor
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
                                    <img class="chat-avatar-img" src="{{ $ac->user && $ac->user->photo ? $ac->user->photo: '/assets/img/default-image.jpg'}}" alt="Avatar" loading="lazy">
                                </div>
                                <div class="chat-content">
                                    <div class="chat-content-header">
                                        <span class="chat-content-text-user">{{ $ac->user ? $ac->user->first_name : 'Anonymous' }}</span>
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
        articleName: @json($article->title),
        articleId: {{ $article->id }},
        isTranslating: false,
        isEnglish: false,
        originalTitle: "",
        originalContent: "",
        voteMessage: "",
        currentVoteCount: {{ (int)$count_vote }},
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
                let titleEl = document.querySelector('.np-title');
                let descEl = document.querySelector('.np-article-text');
                
                if(titleEl && this.originalTitle) {
                    titleEl.innerText = this.originalTitle;
                    titleEl.style.removeProperty('direction');
                    titleEl.style.removeProperty('text-align');
                    titleEl.style.removeProperty('font-family');
                }
                if(descEl && this.originalContent) {
                    descEl.innerHTML = this.originalContent;
                    descEl.style.removeProperty('direction');
                    descEl.style.removeProperty('text-align');
                    descEl.style.removeProperty('font-family');
                }
                this.isEnglish = false;
                return;
            }

            this.isTranslating = true;
            fetch(`/api/articles/${this.articleId}/translate`)
                .then(res => res.json())
                .then(data => {
                    if (data.title && data.content) {
                        let titleEl = document.querySelector('.np-title');
                        let descEl = document.querySelector('.np-article-text');
                        
                        if (!this.originalTitle && titleEl) this.originalTitle = titleEl.innerText;
                        if (!this.originalContent && descEl) this.originalContent = descEl.innerHTML;

                        if(titleEl) {
                            titleEl.innerText = data.title;
                            titleEl.style.setProperty('direction', 'ltr', 'important');
                            titleEl.style.setProperty('text-align', 'left', 'important');
                            titleEl.style.setProperty('font-family', '"Inter", sans-serif', 'important');
                        }
                        if(descEl) {
                            descEl.innerHTML = data.content.replace(/\n/g, '<br>');
                            descEl.style.setProperty('direction', 'ltr', 'important');
                            descEl.style.setProperty('text-align', 'left', 'important');
                            descEl.style.setProperty('font-family', '"Inter", sans-serif', 'important');
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
