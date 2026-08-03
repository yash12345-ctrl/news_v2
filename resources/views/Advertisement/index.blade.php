@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Book Advertisement', 'ltr' => true])
@section('content')

<style>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Playfair+Display:wght@700;800;900&display=swap");

.ad-booking-section {
    background-color: #09090b;
    position: relative;
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

/* Background Ambient Glows for the whole section */
.ad-booking-section::before {
    content: '';
    position: absolute;
    top: -20%; left: -10%;
    width: 60%; height: 80%;
    background: radial-gradient(circle, rgba(227, 30, 36, 0.05) 0%, transparent 70%);
    z-index: 0; pointer-events: none;
}

.ad-booking-split {
    display: flex;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    align-items: center;
    gap: 80px;
    padding: 60px 24px;
    position: relative;
    z-index: 10;
}
@media(max-width: 1000px) {
    .ad-booking-split { flex-direction: column; gap: 40px; padding: 40px 20px; align-items: stretch; }
}

/* --- LEFT SIDE: GLOWING CONTENT --- */
.ad-booking-left {
    flex: 1;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding-top: 20px;
    animation: fadeRight 1s ease-out forwards;
}

/* Glowing Orbs */
.glow-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    z-index: 0;
    animation: floatOrb 10s ease-in-out infinite alternate;
}
.orb-1 {
    width: 500px; height: 500px;
    background: rgba(227, 30, 36, 0.15);
    top: -100px; left: -150px;
}
.orb-2 {
    width: 400px; height: 400px;
    background: rgba(255, 255, 255, 0.06);
    bottom: -150px; right: 0;
    animation-delay: -5s;
    animation-duration: 12s;
}

@keyframes floatOrb {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(60px, -40px) scale(1.1); }
}

.ad-left-content {
    position: relative;
    z-index: 10;
    margin-top: -170px;
}
@media(max-width: 1000px) {
    .ad-left-content { margin-top: 0; }
}
.ad-left-title {
    font-family: "Playfair Display", serif;
    font-size: 72px;
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    margin: 0 0 24px;
    letter-spacing: -2px;
}
@media(max-width: 600px) {
    .ad-left-title { font-size: 40px; }
}
.ad-left-title span {
    color: transparent;
    background: linear-gradient(135deg, #e31e24, #ff6b6b);
    -webkit-background-clip: text;
    background-clip: text;
    display: inline-block;
    filter: drop-shadow(0 10px 20px rgba(227,30,36,0.3));
}
.ad-left-subtitle {
    font-family: "Inter", sans-serif;
    font-size: 18px;
    color: rgba(255,255,255,0.6);
    line-height: 1.6;
    max-width: 480px;
    margin: 0 0 48px;
}

.ad-stats {
    display: flex;
    gap: 48px;
}
@media(max-width: 600px) {
    .ad-stats { gap: 24px; }
}
.ad-stat {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.ad-stat-number {
    font-family: "Inter", sans-serif;
    font-size: 42px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.ad-stat-label {
    font-family: "Inter", sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 1px;
}
.ad-stat-label span {
    color: #e31e24;
}

.ad-benefits {
    margin-top: 48px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.ad-benefit {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ad-benefit-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(227, 30, 36, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e31e24;
    flex-shrink: 0;
}
.ad-benefit-icon svg { width: 14px; height: 14px; fill: currentColor; }
.ad-benefit-text {
    font-family: "Inter", sans-serif;
    font-size: 15px;
    font-weight: 500;
    color: rgba(255,255,255,0.8);
}

/* --- RIGHT SIDE: FORM --- */
.ad-booking-right {
    flex: 1;
    max-width: 650px;
    width: 100%;
}
@media(max-width: 1000px) {
    .ad-booking-right { margin: 0 auto; max-width: 100%; }
}

/* Header Text (Hidden on desktop since left side has title, but visible on mobile if needed. Actually let's just keep the form clear) */
.ad-header-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 100px;
    font-family: "Inter", sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #e31e24;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 24px;
    animation: fadeUp 0.8s ease-out forwards;
}

/* Glassmorphism Card */
.ad-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 32px;
    padding: 48px;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 32px 64px rgba(0,0,0,0.4), inset 0 1px 1px rgba(255,255,255,0.1);
    animation: fadeUp 0.8s ease-out 0.2s forwards;
    opacity: 0;
}
@media(max-width: 600px) {
    .ad-card { padding: 32px 24px; border-radius: 24px; }
}

.ad-card-title {
    font-family: "Playfair Display", serif;
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 32px;
    line-height: 1.2;
}

/* Form Layout */
.ad-form-row {
    display: flex;
    gap: 24px;
    margin-bottom: 24px;
}
@media(max-width: 600px) {
    .ad-form-row { flex-direction: column; gap: 24px; }
}
.ad-form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.ad-form-group.full { width: 100%; margin-bottom: 24px; }

.ad-label {
    font-family: "Inter", sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255,255,255,0.8);
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ad-input {
    width: 100%;
    background: rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 18px 24px;
    font-family: "Inter", sans-serif;
    font-size: 15px;
    color: #fff;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    outline: none;
    box-sizing: border-box;
}
.ad-textarea {
    resize: vertical;
    min-height: 140px;
    line-height: 1.6;
}
.ad-input::placeholder { color: rgba(255,255,255,0.3); }
.ad-input:focus {
    background: rgba(0,0,0,0.4);
    border-color: #e31e24;
    box-shadow: 0 0 0 4px rgba(227, 30, 36, 0.15), inset 0 1px 1px rgba(255,255,255,0.05);
    transform: translateY(-2px);
}

/* Submit Button */
.ad-submit {
    width: 100%;
    background: linear-gradient(135deg, #e31e24 0%, #9e0d12 100%);
    color: #fff;
    border: none;
    padding: 20px;
    border-radius: 16px;
    font-family: "Inter", sans-serif;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 12px 28px rgba(227, 30, 36, 0.3), inset 0 2px 0 rgba(255,255,255,0.2);
    position: relative;
    overflow: hidden;
    margin-top: 12px;
}
.ad-submit::before {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s ease;
}
.ad-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 36px rgba(227, 30, 36, 0.4), inset 0 2px 0 rgba(255,255,255,0.2);
}
.ad-submit:hover::before { left: 100%; }

/* Phone Section */
.ad-phone-section {
    text-align: center;
    margin-top: 48px;
    animation: fadeUp 0.8s ease-out 0.4s forwards;
    opacity: 0;
}
.ad-phone-text {
    font-family: "Inter", sans-serif;
    font-size: 14px;
    color: rgba(255,255,255,0.5);
    margin-bottom: 12px;
}
.ad-phone-number {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-family: "Playfair Display", serif;
    font-size: 32px;
    font-weight: 800;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}
.ad-phone-number:hover {
    color: #e31e24;
    transform: scale(1.05);
}
.ad-phone-icon {
    width: 24px; height: 24px;
    fill: #e31e24;
}

/* Animations */
@keyframes fadeUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes fadeRight {
    0% { opacity: 0; transform: translateX(-30px); }
    100% { opacity: 1; transform: translateX(0); }
}

.alert {
    padding: 16px 24px;
    border-radius: 12px;
    font-family: "Inter", sans-serif;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.alert-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #4ade80;
}
.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #f87171;
}

.invalid-feedback {
    color: #f87171;
    font-family: "Inter", sans-serif;
    font-size: 12px;
    margin-top: 8px;
}

</style>

<section class="ad-booking-section">
    <div class="ad-booking-split">
        
        <!-- LEFT CONTENT -->
        <div class="ad-booking-left">
            <div class="glow-orb orb-1"></div>
            <div class="glow-orb orb-2"></div>
            
            <div class="ad-left-content">
                <div class="ad-header-badge">Advertising</div>
                <h1 class="ad-left-title">Amplify Your<br><span>Brand Impact</span></h1>
                <p class="ad-left-subtitle">Join thousands of businesses who trust Akhbar-e-Mashriq to deliver their message to a highly engaged audience across the nation.</p>
                
                <div class="ad-stats">
                    <div class="ad-stat">
                        <div class="ad-stat-number">1.3M+</div>
                        <div class="ad-stat-label">Monthly <span>Readers</span></div>
                    </div>
                    <div class="ad-stat">
                        <div class="ad-stat-number">45k+</div>
                        <div class="ad-stat-label">Daily <span>Reach</span></div>
                    </div>
                </div>
                
                <div class="ad-benefits">
                    <div class="ad-benefit">
                        <div class="ad-benefit-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg></div>
                        <div class="ad-benefit-text">Premium Editorial Environment</div>
                    </div>
                    <div class="ad-benefit">
                        <div class="ad-benefit-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg></div>
                        <div class="ad-benefit-text">Unmatched Regional Authority</div>
                    </div>
                    <div class="ad-benefit">
                        <div class="ad-benefit-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg></div>
                        <div class="ad-benefit-text">Highly Engaged & Loyal Audience</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="ad-booking-right">
            <div class="ad-card">
                <h3 class="ad-card-title">Book Ad Space</h3>

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-error">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <form class="ad-form" action="/contact" method="post">
                    @csrf
                    <input type="hidden" name="purpose" value="advertisement">
                    
                    <div class="ad-form-row">
                        <div class="ad-form-group">
                            <label class="ad-label">Full Name</label>
                            <input class="ad-input" type="text" name="full_name" placeholder="John Doe" value="{{ old('full_name') }}">
                            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="ad-form-group">
                            <label class="ad-label">Phone</label>
                            <input class="ad-input" type="text" name="phone" placeholder="e.g. 6290000000" maxlength="15" value="{{ old('phone') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="ad-form-group full">
                        <label class="ad-label">Email Address</label>
                        <input class="ad-input" type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="ad-form-group full">
                        <label class="ad-label">Message / Details</label>
                        <textarea class="ad-input ad-textarea" name="message" placeholder="Tell us about your advertisement needs...">{{ old('message') }}</textarea>
                        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <button type="submit" class="ad-submit">Submit Request</button>
                </form>
            </div>
            
            <div class="ad-phone-section">
                <p class="ad-phone-text">Prefer to speak with us directly? Call for instant booking.</p>
                <a class="ad-phone-number" href="tel:+919830637558">
                    <svg class="ad-phone-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.3837 15.4216C21.4939 15.5413 21.5645 15.6946 21.5855 15.859C21.6065 16.0234 21.5768 16.1897 21.5009 16.3323C20.6729 17.8893 19.4674 19.2319 17.9863 20.2443C16.9205 20.9705 15.6881 21.464 14.3986 21.68C12.5684 21.9904 10.6698 21.8499 8.91658 21.2721C7.30064 20.7383 5.82087 19.8669 4.60635 18.7233C3.4138 17.5647 2.49339 16.1479 1.91696 14.5807C1.30907 12.9234 1.0772 11.1444 1.24225 9.39054C1.35338 8.16901 1.70119 6.98586 2.26189 5.92212C2.79373 4.90806 3.48704 4.00445 4.30799 3.25672C4.54228 3.03373 4.88764 2.92271 5.21571 2.96472C6.72145 3.16104 8.08271 3.93172 9.06313 5.14371C9.69784 5.93291 10.1558 6.85244 10.3957 7.84439C10.4571 8.10629 10.4357 8.38466 10.3347 8.63464C10.2337 8.88463 10.0587 9.09176 9.83856 9.22234L8.14083 10.2295C7.9944 10.3164 7.89204 10.4583 7.86016 10.6214C7.82828 10.7845 7.86981 10.9543 7.97341 11.0903C8.75653 12.1157 9.70425 13.0031 10.7788 13.7196C11.6669 14.3023 12.6393 14.7578 13.6667 15.0722C13.8242 15.1189 13.9961 15.0934 14.1362 15.0028C14.2762 14.9122 14.3697 14.7656 14.3986 14.6025L14.7533 12.7214C14.793 12.5029 14.9223 12.3129 15.1128 12.193C15.3033 12.0731 15.5393 12.0331 15.7661 12.0811C16.8291 12.2987 17.8596 12.6566 18.8251 13.1434C19.866 13.6644 20.7602 14.4326 21.3837 15.4216Z"></path></svg>
                    +919830637558
                </a>
            </div>
        </div>
        
    </div>
</section>
@endsection