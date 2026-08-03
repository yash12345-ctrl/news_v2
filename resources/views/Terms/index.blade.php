@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Terms & Condition', 'ltr' => true])

@section('content')
<style>
/* ── ULTRA PREMIUM LEGAL ARCHITECTURE (SIDEBAR LAYOUT) ─────────────────── */
html { scroll-behavior: smooth; }

.am-legal-root {
    background: #f8fafc;
    min-height: 100vh;
    padding: 100px 0 160px;
    font-family: 'Inter', sans-serif;
    color: #334155;
    line-height: 1.8;
}

.am-legal-wrapper {
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 60px;
    padding: 0 40px;
}

/* Header Span Across Both Columns */
.am-legal-header-full {
    grid-column: 1 / -1;
    margin-bottom: 60px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.am-legal-title {
    font-family: 'Playfair Display', serif;
    font-size: 72px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    margin: 0 0 24px 0;
    letter-spacing: -2px;
}
.am-legal-meta {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: #ffffff;
    border: 1px solid rgba(15,23,42,0.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    color: #2563eb;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Sticky Sidebar */
.am-legal-sidebar {
    position: sticky;
    top: 120px;
    align-self: start;
    background: #ffffff;
    border: 1px solid rgba(15,23,42,0.04);
    box-shadow: 0 20px 40px -10px rgba(15,23,42,0.03);
    border-radius: 24px;
    padding: 30px;
}
.am-sidebar-title {
    font-size: 12px;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
}
.am-sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.am-sidebar-link {
    display: block;
    color: #64748b;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.am-sidebar-link:hover, .am-sidebar-link.active {
    background: #f1f5f9;
    color: #2563eb;
    transform: translateX(5px);
}

/* Main Content Area */
.am-legal-content {
    background: #ffffff;
    border: 1px solid rgba(15,23,42,0.04);
    box-shadow: 0 20px 40px -10px rgba(15,23,42,0.03);
    border-radius: 32px;
    padding: 80px 100px;
}

.am-legal-intro {
    font-size: 20px;
    color: #475569;
    line-height: 1.8;
    margin-bottom: 60px;
    padding-bottom: 40px;
    border-bottom: 2px solid #f1f5f9;
}

.am-legal-section {
    margin-bottom: 60px;
    scroll-margin-top: 140px;
}
.am-legal-h2 {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 30px 0;
    display: flex;
    align-items: baseline;
    gap: 15px;
}
.am-legal-h2-num {
    color: #2563eb;
    font-size: 40px;
    opacity: 0.2;
    font-weight: 900;
}

.am-legal-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.am-legal-list > li {
    position: relative;
    padding-left: 35px;
    margin-bottom: 30px;
    font-size: 16px;
}
.am-legal-list > li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 10px;
    width: 12px;
    height: 2px;
    background: #2563eb;
    border-radius: 2px;
}
.am-legal-list p { margin: 0 0 16px 0; }
.am-legal-list .sub-list {
    display: block;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    margin-top: 16px;
}
.am-legal-list .sub-list-item {
    display: block;
    margin-bottom: 12px;
    padding-left: 20px;
    position: relative;
}
.am-legal-list .sub-list-item:last-child { margin-bottom: 0; }
.am-legal-list .sub-list-item::before {
    content: '→';
    position: absolute;
    left: 0;
    color: #94a3b8;
    font-family: monospace;
}

.am-legal-highlight {
    background: linear-gradient(135deg, #fef2f2 0%, #fff 100%);
    padding: 40px;
    border-radius: 20px;
    border: 1px solid #fecaca;
    border-left: 6px solid #ef4444;
    margin: 40px 0;
    box-shadow: 0 10px 30px -10px rgba(239, 68, 68, 0.1);
}
.am-legal-highlight strong {
    color: #dc2626;
    display: block;
    font-size: 18px;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 16px;
}

.am-legal-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
    border-bottom: 1px solid transparent;
    transition: border-color 0.3s;
}
.am-legal-link:hover { border-color: #2563eb; }

@media (max-width: 1024px) {
    .am-legal-wrapper { grid-template-columns: 1fr; }
    .am-legal-sidebar { display: none; } /* Hide sidebar on mobile for simplicity */
    .am-legal-content { padding: 40px; border-radius: 24px; }
    .am-legal-title { font-size: 48px; }
}
@media (max-width: 768px) {
    .am-legal-root { padding: 60px 0 80px; }
    .am-legal-wrapper { padding: 0 16px; }
    .am-legal-header-full { margin-bottom: 40px; }
    .am-legal-title { font-size: 36px; }
    
    .am-legal-content { padding: 30px 20px; border-radius: 20px; }
    .am-legal-intro { font-size: 16px; margin-bottom: 30px; padding-bottom: 30px; }
    
    .am-legal-section { margin-bottom: 40px; }
    .am-legal-h2 { font-size: 24px; margin-bottom: 20px; }
    .am-legal-h2-num { font-size: 28px; }
    
    .am-legal-highlight { padding: 24px 20px; margin: 30px 0; }
}
</style>

<div class="am-legal-root">
    <div class="am-legal-wrapper">
        
        <div class="am-legal-header-full">
            <h1 class="am-legal-title">Terms & Conditions</h1>
            <div class="am-legal-meta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                Last updated: August 17, 2023
            </div>
        </div>

        <aside class="am-legal-sidebar">
            <div class="am-sidebar-title">Table of Contents</div>
            <ul class="am-sidebar-nav">
                <li><a href="#definitions" class="am-sidebar-link">1. Definitions</a></li>
                <li><a href="#approval" class="am-sidebar-link">2. Your Approval</a></li>
                <li><a href="#provision" class="am-sidebar-link">3. Provision of the App</a></li>
                <li><a href="#restrictions" class="am-sidebar-link">4. Restrictions On Use</a></li>
                <li><a href="#grievance" class="am-sidebar-link">5. Grievance Officer</a></li>
            </ul>
        </aside>

        <main class="am-legal-content">
            
            <div class="am-legal-intro">
                <p>These terms and conditions of use (“Terms”) along with the privacy policy (“Privacy Policy”) form a legally binding agreement (“Agreement”) between You and Us (“Akhbar-e-Mashriq Pvt. Ltd.”).</p>
                <p>Hence, We insist that You spend time reading these Terms and Privacy Policy. If you have any questions regarding the same, let us know at <a href="mailto:digitalmashriq@gmail.com" class="am-legal-link">digitalmashriq@gmail.com</a>. We will try our best to answer your queries.</p>
            </div>

            <div id="definitions" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">01</span> Definitions & Interpretation</h2>
                <ul class="am-legal-list">
                    <li>
                        <p>Capitalized terms, not defined elsewhere in this Agreement, shall mean as follows:</p>
                        <div class="sub-list">
                            <span class="sub-list-item"><strong>a) "App"</strong> means the Akhbar-e-Mashriq mobile platform downloadable from Google Play/AppStore, and owned by Us, including any updates thereof.</span>
                            <span class="sub-list-item"><strong>b) "AppStore"</strong> means the service provided by Apple Inc. and/or its affiliates, a third-party, through which You may download the App.</span>
                            <span class="sub-list-item"><strong>c) "Google Play"</strong> means the service provided by Google Ireland Limited, and/or its affiliates.</span>
                            <span class="sub-list-item"><strong>d) "Sponsored Content"</strong> means content distinct from other regular editorial content displayed on the App, in the form of audio, video, text and/or image media which supports a third party Person’s brand message.</span>
                            <span class="sub-list-item"><strong>e) "User", "You", or "Your"</strong> refers to a person who has accepted this Agreement in order to download and use the App.</span>
                        </div>
                    </li>
                    <li>Any reference to the singular includes a reference to the plural and vice versa, and any reference to one gender includes a reference to other gender(s), unless explicitly provided for.</li>
                    <li>Any reference to a natural person shall include his/her heirs, executors and permitted assignees and any reference to a juristic person shall include its affiliates, successors and permitted assignees, unless repugnant to the context.</li>
                </ul>
            </div>

            <div id="approval" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">02</span> Your Approval</h2>
                <ul class="am-legal-list">
                    <li>
                        <p>You approve of and accept the Agreement by:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">a) Downloading and/or installing the App on Your device; or</span>
                            <span class="sub-list-item">b) Accessing or using the App or any of the content available within the App from any device.</span>
                        </div>
                    </li>
                    <li>
                        <p>You can accept the Agreement only if:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">a) You are a natural person of the legal age to consent in your jurisdiction and of sound mind to form a binding contract.</span>
                            <span class="sub-list-item">b) You are a juristic Person, lawfully existing that has all the authorizations to enter into this Agreement.</span>
                            <span class="sub-list-item">c) You are not legally barred under applicable laws from using the App.</span>
                        </div>
                    </li>
                    <li>You understand that We want You to not use the App if You do not understand, approve of or accept the Agreement in its entirety.</li>
                </ul>
            </div>

            <div id="provision" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">03</span> Provision of the App</h2>
                <ul class="am-legal-list">
                    <li>The App is designed to provide You an in-app browsing experience through an embedded browser. The App summarizes third party content within one platform for easy access by You. When You read a summary, You will be provided with a link to one of the online sources. If You chose to access such link, You acknowledge that you are leaving the App.</li>
                    <li>The App may include links to other mobile applications and/or websites which may contain materials that are objectionable, unlawful, or inaccurate. We do not endorse or support these links.</li>
                    <li>In order to access the App, You have to register as a User by providing prescribed information which will be governed by our Privacy Policy.</li>
                    <li>You agree and acknowledge that certain Sponsored Content may be placed on, about, or in conjunction with the other content within the App.</li>
                    <li>
                        <p>You agree and acknowledge to the following representations at all times while using the App:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">a) Any information that You provide is true, accurate, complete and updated.</span>
                            <span class="sub-list-item">b) You will only use the content for non-commercial and personal purpose.</span>
                            <span class="sub-list-item">c) You will not use the App for any purpose that is illegal or prohibited by this Agreement.</span>
                            <span class="sub-list-item">d) You will not copy, reproduce, alter, modify, create derivative works of, or publicly display any content displayed on the App.</span>
                        </div>
                    </li>
                    <li>We may stop provision of the App (or any part of the App), permanently or temporarily, to You or to users generally or may modify or change the nature of the App at Our sole discretion, without any prior notice.</li>
                </ul>
            </div>

            <div id="restrictions" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">04</span> Restrictions On Your Use</h2>
                <ul class="am-legal-list">
                    <li>
                        <p>You agree and acknowledge that You will not host, display, upload, modify, publish, transmit, update or share any information that:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">a) Belongs to another person and to which the User does not have any right.</span>
                            <span class="sub-list-item">b) Is defamatory, obscene, pornographic, paedophilic, or invasive of another‘s privacy.</span>
                            <span class="sub-list-item">c) Is harmful to children or infringes any patent, trademark, copyright or other proprietary rights.</span>
                            <span class="sub-list-item">d) Deceives or misleads the addressee about the origin of the message or is patently false or misleading.</span>
                            <span class="sub-list-item">e) Contains software virus or any other computer code designed to interrupt or destroy the functionality of any computer resource.</span>
                        </div>
                    </li>
                    <li>You will not circumvent or disable any digital rights management, usage rules, or other security features of the App.</li>
                    <li>You will not impersonate another person or falsely state or otherwise misrepresent Your affiliation with any person or entity.</li>
                </ul>
            </div>

            <div class="am-legal-highlight">
                <strong>Important Legal Disclaimer</strong>
                <p style="margin: 0;">YOU EXPRESSLY REPRESENT AND WARRANT THAT YOU WILL NOT USE THE APP IF YOU DO NOT UNDERSTAND, AGREE TO BECOME A PARTY TO, AND ABIDE BY ALL THE TERMS SPECIFIED IN THIS AGREEMENT. ANY VIOLATION OF THIS AGREEMENT MAY RESULT IN LEGAL LIABILITY UPON YOU. NOTHING IN THE AGREEMENT SHOULD BE CONSTRUED TO CONFER ANY RIGHTS TO ANY THIRD PARTY.</p>
            </div>

            <div id="grievance" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">05</span> Grievance Officer</h2>
                <ul class="am-legal-list">
                    <li>For any concerns, queries or grievances relating to Your use of the App, please write to our team at <a href="mailto:digitalmashriq@gmail.com" class="am-legal-link">digitalmashriq@gmail.com</a> with the following details:</li>
                    <li>
                        <div class="sub-list">
                            <span class="sub-list-item"><strong>Name:</strong> Your full legal name</span>
                            <span class="sub-list-item"><strong>Email ID:</strong> Your registered email address</span>
                            <span class="sub-list-item"><strong>Contact Number:</strong> Your active mobile number</span>
                            <span class="sub-list-item"><strong>URL:</strong> Link to the alleged infringing post (if applicable)</span>
                        </div>
                    </li>
                </ul>
            </div>

        </main>
    </div>
</div>
@endsection
