@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Contact', 'ltr' => true])

@section('content')
<style>
/* ── ULTRA PREMIUM CONTACT ARCHITECTURE (AD THEME) ─────────────────── */
.am-contact-universe {
    background: #0a0a0a;
    font-family: 'Inter', sans-serif;
    color: #f8fafc;
    min-height: 100vh;
    padding: 120px 0 140px;
    position: relative;
    overflow: hidden;
}
/* Abstract Glowing Orbs in Background */
.am-contact-universe::before { content: ''; position: absolute; top: 0%; left: -10%; width: 50%; height: 60%; background: radial-gradient(circle, rgba(220, 38, 38, 0.15) 0%, rgba(10, 10, 10, 0) 70%); filter: blur(80px); z-index: 0; pointer-events: none; }
.am-contact-universe::after { content: ''; position: absolute; bottom: 0%; right: -10%; width: 50%; height: 60%; background: radial-gradient(circle, rgba(220, 38, 38, 0.1) 0%, rgba(10, 10, 10, 0) 70%); filter: blur(80px); z-index: 0; pointer-events: none; }

.am-contact-container {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

/* Header Section */
.am-contact-header {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 100px;
}
.am-contact-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(220, 38, 38, 0.1);
    border: 1px solid rgba(220, 38, 38, 0.2);
    padding: 8px 24px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    color: #ef4444;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 30px;
}
.am-contact-title {
    font-family: 'Playfair Display', serif;
    font-size: 72px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -2px;
    margin: 0 0 30px 0;
    background: linear-gradient(135deg, #ffffff 0%, #a3a3a3 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.am-contact-subtitle {
    font-size: 18px;
    line-height: 1.8;
    color: #a3a3a3;
}

/* Glassmorphic Grid */
.am-contact-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 60px;
}
.am-contact-card {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 32px;
    padding: 50px 40px;
    transition: all 0.4s cubic-bezier(0.2, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}
.am-contact-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 100%);
    pointer-events: none;
}
.am-contact-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.04);
    border-color: rgba(220, 38, 38, 0.4);
    box-shadow: 0 30px 60px -15px rgba(0,0,0,0.8);
}

.am-contact-icon {
    width: 70px;
    height: 70px;
    background: rgba(220, 38, 38, 0.1);
    border: 1px solid rgba(220, 38, 38, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    margin-bottom: 30px;
    transition: all 0.4s ease;
}
.am-contact-card:hover .am-contact-icon {
    background: #dc2626;
    color: #ffffff;
    transform: scale(1.05) rotate(5deg);
}

.am-contact-method {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 16px 0;
}
.am-contact-desc {
    font-size: 15px;
    color: #a3a3a3;
    line-height: 1.6;
    margin: 0 0 30px 0;
    flex-grow: 1;
}
.am-contact-value {
    font-size: 17px;
    font-weight: 600;
    color: #ef4444;
    text-decoration: none;
    transition: color 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.am-contact-value:hover { color: #ffffff; }

/* Structured Contact Lists */
.am-contact-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
}
.am-contact-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
.am-contact-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.am-contact-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #737373;
    font-weight: 700;
    transition: color 0.3s ease;
}
.am-contact-item:hover .am-contact-label {
    color: #a3a3a3;
}
.am-contact-sublist {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* Large Editorial Banner */
.am-editorial-banner {
    grid-column: span 3;
    background: #171717;
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 32px;
    padding: 60px 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 60px;
    margin-top: 30px;
    position: relative;
    overflow: hidden;
}
.am-banner-glow {
    position: absolute;
    top: -50px; right: -50px;
    width: 300px; height: 300px;
    background: #dc2626;
    filter: blur(120px);
    opacity: 0.2;
}
.am-banner-content { position: relative; z-index: 2; max-width: 600px; }
.am-banner-title {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 20px 0;
    line-height: 1.2;
}
.am-banner-text {
    font-size: 16px;
    color: #a3a3a3;
    line-height: 1.8;
}
.am-banner-signature {
    position: relative;
    z-index: 2;
    text-align: right;
    border-left: 1px solid rgba(255,255,255,0.1);
    padding-left: 60px;
}
.am-banner-sig-text { font-family: 'Playfair Display', serif; font-size: 24px; font-style: italic; color: #ef4444; margin-bottom: 10px; }
.am-banner-sig-team { font-size: 13px; text-transform: uppercase; letter-spacing: 2px; color: #737373; font-weight: 700; }

@media (max-width: 1024px) {
    .am-contact-grid { grid-template-columns: repeat(2, 1fr); }
    .am-editorial-banner { grid-column: span 2; flex-direction: column; text-align: center; padding: 50px 40px; gap: 40px; }
    .am-banner-signature { border-left: none; border-top: 1px solid rgba(255,255,255,0.1); padding-left: 0; padding-top: 40px; text-align: center; }
}
@media (max-width: 768px) {
    .am-contact-universe { padding: 60px 0 80px; }
    .am-contact-header { margin-bottom: 50px; }
    .am-contact-title { font-size: 40px; }
    .am-contact-subtitle { font-size: 15px; }
    
    .am-contact-grid { grid-template-columns: 1fr; gap: 20px; }
    .am-contact-card { padding: 30px 24px; }
    
    .am-editorial-banner { grid-column: span 1; padding: 40px 24px; gap: 30px; }
    .am-banner-title { font-size: 28px; }
}
</style>

<div class="am-contact-universe">
  <div class="container am-contact-container">
    
    <header class="am-contact-header">
      <div class="am-contact-eyebrow">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        Get In Touch
      </div>
      <h1 class="am-contact-title">We’re Here for You.</h1>
      <p class="am-contact-subtitle">Akhbar-e-Mashriq is deeply dedicated to our readers and clients. Whether you have news tips, feedback, or business inquiries, our executive team is ready to listen.</p>
    </header>

    <div class="am-contact-grid">
      <!-- Email Card -->
      <div class="am-contact-card">
        <div class="am-contact-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        </div>
        <h3 class="am-contact-method">Email Us</h3>
        <p class="am-contact-desc">For general inquiries, editorial tips, press releases, and digital support.</p>
        <div class="am-contact-list">
          <div class="am-contact-item" style="border-bottom: none;">
            <span class="am-contact-label">Email Address</span>
            <a href="mailto:akhbaremashriq1@gmail.com" class="am-contact-value">
              akhbaremashriq1@gmail.com
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Phone Card -->
      <div class="am-contact-card">
        <div class="am-contact-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
        </div>
        <h3 class="am-contact-method">Call Us</h3>
        <p class="am-contact-desc">Speak directly with our executive customer relations team during business hours.</p>
        <div class="am-contact-list">
          <div class="am-contact-item">
            <span class="am-contact-label">Mobile</span>
            <a href="tel:+919830637558" class="am-contact-value">
              +91 98306 37558
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>
          <div class="am-contact-item" style="border-bottom: none;">
            <span class="am-contact-label">Landline Numbers</span>
            <div class="am-contact-sublist">
              <a href="tel:03322890093" class="am-contact-value">
                033-22890093
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
              <a href="tel:03322890053" class="am-contact-value">
                033-22890053
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Address Card -->
      <div class="am-contact-card">
        <div class="am-contact-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        </div>
        <h3 class="am-contact-method">Headquarters</h3>
        <p class="am-contact-desc">Drop by our main editorial headquarters for formal business discussions.</p>
        <span class="am-contact-value" style="cursor: default; display: block; line-height: 1.6;">
          12, Darga Road, 3rd Floor,<br>Kolkata - 700017
        </span>
      </div>

      <!-- Editorial Banner -->
      <div class="am-editorial-banner">
        <div class="am-banner-glow"></div>
        <div class="am-banner-content">
          <h2 class="am-banner-title">Uncompromising Editorial Integrity</h2>
          <p class="am-banner-text">
            At Akhbar-e-Mashriq, we hold ourselves to the highest standards of journalistic excellence. If you believe any content on our site requires clarification or correction, we are committed to absolute accuracy and will address it with urgency.
          </p>
        </div>
        <div class="am-banner-signature">
          <div class="am-banner-sig-text">Thank you,</div>
          <div class="am-banner-sig-team">The Executive Team</div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
