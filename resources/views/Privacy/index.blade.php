@extends('templates.base', ['title' => 'Akhbar-e-mashriq | Privacy Policy', 'ltr' => true])

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
    .am-legal-sidebar { display: none; }
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
            <h1 class="am-legal-title">Privacy Policy</h1>
            <div class="am-legal-meta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                Last updated: August 17, 2023
            </div>
        </div>

        <aside class="am-legal-sidebar">
            <div class="am-sidebar-title">Table of Contents</div>
            <ul class="am-sidebar-nav">
                <li><a href="#general" class="am-sidebar-link">1. General</a></li>
                <li><a href="#information" class="am-sidebar-link">2. Information Collected</a></li>
                <li><a href="#usage" class="am-sidebar-link">3. Usage of Personal Data</a></li>
                <li><a href="#disclosure" class="am-sidebar-link">4. Disclosure of Data</a></li>
                <li><a href="#security" class="am-sidebar-link">5. Security</a></li>
                <li><a href="#rights" class="am-sidebar-link">6. Your Rights</a></li>
                <li><a href="#updates" class="am-sidebar-link">7. Updates</a></li>
                <li><a href="#liability" class="am-sidebar-link">8. Restriction of Liability</a></li>
            </ul>
        </aside>

        <main class="am-legal-content">
            
            <div class="am-legal-intro">
                <p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p>
                <p>We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</p>
            </div>

            <div id="general" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">01</span> General</h2>
                <ul class="am-legal-list">
                    <li><strong>Akhbar-e-Mashriq Pvt.Ltd.</strong> (“Akhbar-e-Mashriq Pvt.Ltd.”, “We”, “Our”, “Us”) is committed to the protection of user (“You”, “Your”, “User”) provided information which personally identifies You (“Personal Information”). You agree that Your use of Our mobile App and website (“App and website”) implies Your consent to collecting, receiving, possessing, storing, dealing or handling of Your Personal Information in accordance with the terms of this Privacy Policy.</li>
                    <li>This Privacy Policy applies to all Users who access the App and website and are therefore required to read and understand the Privacy Policy before submitting any Personal Information.</li>
                    <li>We take the privacy of our Users seriously. We are committed to safeguarding the privacy of Our Users while providing a personalized and valuable service.</li>
                    <li>Access to the contents available through the App and website is conditional upon Your approval of this Privacy Policy which is in addition to the terms and conditions of use (“Terms”). You acknowledge that this Privacy Policy, together with our Terms, forms Our agreement with You in relation to Your use of the App and website.</li>
                </ul>
            </div>

            <div id="information" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">02</span> Information Collected</h2>
                <ul class="am-legal-list">
                    <li>
                        <p><strong>Traffic Data Collected:</strong> In order to provide the App and website, We automatically track and collect the following categories of information when You use the App and website:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">i) IP addresses;</span>
                            <span class="sub-list-item">ii) Domain servers; and</span>
                            <span class="sub-list-item">iii) Other information with respect to Your device, interaction of Your device with the App and website and applications (collectively "Traffic Data").</span>
                        </div>
                    </li>
                    <li>
                        <p><strong>Personal Information Collected:</strong> In order to provide the App and website, We may require You to provide Us with Personal Information, which includes the following categories:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">i) Contact data (such as Your email address, phone number and any details of Your contacts);</span>
                            <span class="sub-list-item">ii) Device data; and</span>
                            <span class="sub-list-item">iii) Demographic data (such as Your time zone and location details).</span>
                        </div>
                        <p>If You communicate with Us, by, for example, email or letter, any information provided in such communication may be collected and stored by Akhbar-e-Mashriq Pvt.Ltd. Our App and website may transmit your Personal Information to our internal servers which is situated inside India.</p>
                    </li>
                    <li>Our App and website may contain links to third party websites or applications. The inclusion or exclusion of the link does not imply any endorsement by Akhbar-e-Mashriq Pvt.Ltd. of the website, the website's provider, or the information on the website. You agree and understand that privacy policies of these websites are not under Our control. We encourage You to read the privacy policies of each such website.</li>
                </ul>
            </div>

            <div id="usage" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">03</span> Usage of Personal Information</h2>
                <ul class="am-legal-list">
                    <li>The information collected from You is used to ensure services with respect to the App and website are presented to You in the most effective manner, to carry out Our obligations to You, and to communicate with You. The said communication can either be by calls, text or emails and for purposes which include transactional, service, or promotional calls or messages.</li>
                    <li>
                        <p>In general, We use Our best efforts to use information in aggregate form (so that no individual user is identified). However, We may use Your Personal Information for the following purposes ("Permitted Use"):</p>
                        <div class="sub-list">
                            <span class="sub-list-item">i) To build up marketing profiles;</span>
                            <span class="sub-list-item">ii) To aid strategic development, data collection and business analytics;</span>
                            <span class="sub-list-item">iii) To manage our relationship with advertisers and partners;</span>
                            <span class="sub-list-item">iv) To enable us to provide the App and website through the use of appropriate technological services;</span>
                            <span class="sub-list-item">v) To audit usage of the App and website; and</span>
                            <span class="sub-list-item">vi) To enhance user experience in relation to the App and website.</span>
                        </div>
                    </li>
                </ul>
            </div>

            <div id="disclosure" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">04</span> Disclosure of Personal Information</h2>
                <ul class="am-legal-list">
                    <li>We do not disclose Your Personal Information to any third parties other than to Akhbar-e-Mashriq Pvt.Ltd.’ affiliates, third party service providers or other trusted business or persons, who may be situated outside India, pursuant to a lawful contract and in compliance with our Privacy Policy.</li>
                    <li>No User information is rented or sold to any third party.</li>
                    <li>In the event of a merger, reorganization, acquisition, joint venture, assignment, spin-off, transfer, asset sale, or sale or disposition of all or any portion of Our business, including in connection with any bankruptcy or similar proceedings, We may transfer any and all Personal Information to the relevant third party with the same rights of access and use. Please note that this may result in Your Personal Information being transferred outside India.</li>
                    <li>
                        <p>Except as otherwise provided in this Privacy Policy, We will keep Your Personal Information private and will not share it with third parties, unless We believe in good faith that disclosure of Your Personal Information or any other information We collect about You is necessary for Permitted Use or to:</p>
                        <div class="sub-list">
                            <span class="sub-list-item">i) Comply with a court order or other legal process;</span>
                            <span class="sub-list-item">ii) Protect the rights, property or safety of Akhbar-e-Mashriq Pvt.Ltd. or another party;</span>
                            <span class="sub-list-item">iii) Enforce the Privacy Policy, including Terms; or</span>
                            <span class="sub-list-item">iv) Respond to claims that any posting or other content violates the rights of third parties.</span>
                        </div>
                    </li>
                    <li>User data will only be accessible to Akhbar-e-Mashriq’s authorized staff or admin only. The user data will only be used anonymously for advertising purposes.</li>
                    <li>By agreeing to the Privacy Policy, You hereby grant Us Your consent for sharing Your information, including Your Personal Information, with third parties, including third parties situated outside India, for the Permitted Uses, and in all instances henceforth in pursuance of Clause 4 of this Privacy Policy.</li>
                </ul>
            </div>

            <div id="security" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">05</span> Security</h2>
                <ul class="am-legal-list">
                    <li>The security of Your Personal Information is important to Us. We take appropriate security measures as required under applicable laws and which is commercially reasonable which includes all physical, managerial, operational and technical security measures to protect the Personal Information against unauthorized access, alteration, disclosure, loss, misuse, or destruction of Your personal data that We collect and store.</li>
                    <li>Although We make best possible efforts to store Personal Information in a secure operating environment that is not open to the public, You should understand that there is no such thing as complete security, and We do not guarantee that there will be no unintended disclosures of Your Personal Information. If We become aware that Your Personal Information has been disclosed in a manner not in accordance with this Privacy Policy, We will use reasonable efforts to notify You of the nature and extent of such disclosure as soon as reasonably possible and as permitted by law. You should not share Your password with any third party, and if You believe Your password or account has been compromised, You should change it immediately and contact Us at <a href="mailto:digitalmashriq@gmail.com" class="am-legal-link">digitalmashriq@gmail.com</a>.</li>
                    <li>A high standard of security is maintained by Us for Our users. However, the transmission of information via the internet or telephone networks is not completely secure. While We do Our best to protect Your information, particularly with respect to protection of Your personal data, Akhbar-e-Mashriq Pvt.Ltd. cannot ensure the security of Your data transmitted via the internet, telephone or any other networks.</li>
                </ul>
            </div>

            <div id="rights" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">06</span> Your Rights</h2>
                <ul class="am-legal-list">
                    <li>You have a right to review your Personal Information and correct any errors in Your Personal Information available with Us by writing to us at <a href="mailto:digitalmashriq@gmail.com" class="am-legal-link">digitalmashriq@gmail.com</a>.</li>
                    <li>You may request Us in writing that We cease to use Your Personal Information and / or delete your existing Personal Information by writing to Us at <a href="mailto:digitalmashriq@gmail.com" class="am-legal-link">digitalmashriq@gmail.com</a>. In the event that you refuse to share any information, or withdraw consent to process information that you have previously given to us, we reserve the right to restrict or deny the provision of our services for which we consider such information to be necessary.</li>
                </ul>
            </div>

            <div id="updates" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">07</span> Updates and Changes to Privacy Policy</h2>
                <ul class="am-legal-list">
                    <li>We reserve the right, at any time, to add to, change, update, or modify this Privacy Policy. If We do, then We will post these changes on this page and will inform you of such changes. Your continued use of the services following the posting of changes to this Privacy Policy will constitute Your consent and acceptance of Our changes. In all cases, use of information We collect is subject to the Privacy Policy in effect at the time such information is collected.</li>
                </ul>
            </div>

            <div id="liability" class="am-legal-section">
                <h2 class="am-legal-h2"><span class="am-legal-h2-num">08</span> Restriction of Liability</h2>
                <ul class="am-legal-list">
                    <li><strong>Akhbar-e-Mashriq Pvt Ltd.</strong> makes no claims, promises or guarantees about the accuracy, completeness, or adequacy of the contents available through the App and website and expressly disclaims liability for errors and omissions in the contents available through the App and website.</li>
                    <li>No warranty of any kind, implied, expressed or statutory, including but not limited to the warranties of non-infringement of third-party rights, title, merchantability, fitness for a particular purpose and freedom from computer virus, is given with respect to the contents available through the App and website or its links to other internet resources as may be available to You through the App and website.</li>
                    <li>Reference in the App and website to any specific commercial products, processes, or services, or the use of any trade, firm or corporation name is for the information and convenience of the public, and does not constitute endorsement, recommendation, or favoring by Akhbar-e-Mashriq Pvt.Ltd. If you have questions or concerns, feel free to email at <a href="mailto:digitalmashriq@gmail.com" class="am-legal-link">digitalmashriq@gmail.com</a> and We will attempt to address Your concerns.</li>
                </ul>
            </div>

        </main>
    </div>
</div>
@endsection
