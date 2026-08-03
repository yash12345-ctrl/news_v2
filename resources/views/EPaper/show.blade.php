@extends('templates.base', ['title' => 'Akhbar-e-mashriq | EPaper', 'ltr' => true])

@section('content')
<style>
/* ── ULTRA PREMIUM E-PAPER DASHBOARD ─────────────────── */
.am-epaper-root {
    background: #f8fafc;
    min-height: 100vh;
    padding: 60px 0 100px;
    font-family: 'Inter', sans-serif;
}

/* Filter & Share Bar */
.am-epaper-header {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px 40px;
    box-shadow: 0 20px 40px -10px rgba(15,23,42,0.05);
    border: 1px solid rgba(15,23,42,0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 50px;
}
.am-epaper-form {
    display: flex;
    align-items: flex-end;
    gap: 24px;
    flex-wrap: wrap;
}
.am-epaper-input-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.am-epaper-label {
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.am-epaper-input, .am-epaper-select {
    height: 48px;
    background: #f1f5f9;
    border: 1px solid transparent;
    border-radius: 12px;
    padding: 0 16px;
    font-family: inherit;
    font-size: 15px;
    color: #334155;
    font-weight: 500;
    transition: all 0.3s ease;
    min-width: 200px;
}
.am-epaper-input:focus, .am-epaper-select:focus {
    outline: none;
    background: #ffffff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}
.am-epaper-btn {
    height: 48px;
    background: #0f172a;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 0 32px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.am-epaper-btn:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px -10px rgba(37,99,235,0.4);
}

/* Sharing Section */
.am-epaper-share {
    display: flex;
    align-items: center;
    gap: 16px;
}
.am-share-title {
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.am-share-buttons {
    display: flex;
    gap: 10px;
}
.am-share-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    height: 40px;
    padding: 0 16px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}
.am-share-btn svg { width: 16px; height: 16px; fill: currentColor; }
.am-share-btn.twitter { background: rgba(29, 155, 240, 0.1); color: #1d9bf0; }
.am-share-btn.twitter:hover { background: #1d9bf0; color: #fff; }
.am-share-btn.fb { background: rgba(24, 119, 242, 0.1); color: #1877f2; }
.am-share-btn.fb:hover { background: #1877f2; color: #fff; }
.am-share-btn.whatsapp { background: rgba(37, 211, 102, 0.1); color: #25d366; }
.am-share-btn.whatsapp:hover { background: #25d366; color: #fff; }

/* Thumbnails Strip */
.am-epaper-thumbnails-container {
    background: #ffffff;
    padding: 30px;
    border-radius: 24px;
    box-shadow: 0 10px 30px -10px rgba(15,23,42,0.03);
    margin-bottom: 40px;
    border: 1px solid rgba(15,23,42,0.04);
}
.am-epaper-thumbnails {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding-bottom: 15px;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}
.am-epaper-thumbnails::-webkit-scrollbar { height: 6px; }
.am-epaper-thumbnails::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
.am-epaper-thumbnail {
    flex: 0 0 auto;
    width: 120px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    transition: transform 0.3s ease;
}
.am-epaper-thumbnail:hover {
    transform: translateY(-5px);
}
.am-epaper-thumb-img {
    width: 100%;
    aspect-ratio: 2/3;
    object-fit: cover;
    object-position: top;
    border-radius: 12px;
    box-shadow: 0 8px 20px -8px rgba(0,0,0,0.15);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}
.am-epaper-thumbnail:hover .am-epaper-thumb-img {
    box-shadow: 0 15px 30px -10px rgba(37,99,235,0.3);
    border-color: #3b82f6;
}
.am-epaper-thumb-label {
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    padding: 4px 12px;
    border-radius: 20px;
    transition: all 0.3s ease;
}
.am-epaper-thumbnail:hover .am-epaper-thumb-label {
    background: #2563eb;
    color: #ffffff;
}

/* Main Viewer */
.am-epaper-viewer {
    background: #ffffff;
    padding: 20px;
    border-radius: 24px;
    box-shadow: 0 30px 60px -15px rgba(15,23,42,0.1);
    margin: 0 auto 40px auto;
    border: 1px solid rgba(15,23,42,0.04);
    max-width: 1000px;
    text-align: center;
}
.am-epaper-viewer-img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    display: block;
}

@media (max-width: 768px) {
    .am-epaper-header { flex-direction: column; align-items: stretch; padding: 24px; }
    .am-epaper-form { flex-direction: column; align-items: stretch; }
    .am-epaper-input, .am-epaper-select, .am-epaper-btn { width: 100%; min-width: 100%; }
    .am-epaper-share { flex-direction: column; align-items: flex-start; }
    .am-epaper-thumbnails-container { padding: 20px; }
}
</style>

<div class="am-epaper-root">
    <div class="container">
        
        <!-- Header: Filters & Share -->
        <div class="am-epaper-header">
            <form class="am-epaper-form" action="/epaper" method="get">
                <div class="am-epaper-input-group">
                    <label class="am-epaper-label" for="date">Find e-paper By Date</label>
                    <input type="date" name="date" id="date" class="am-epaper-input" value="{{ request('date') ?? ($enews && $enews->created_at ? $enews->created_at->format('Y-m-d') : '') }}">
                </div>
                <div class="am-epaper-input-group">
                    <label class="am-epaper-label">Select Edition</label>
                    <select class="am-epaper-select" name="edition">
                        <option disabled selected>Select Edition</option>
                        @foreach($editions as $key => $value)
                            <option @if($key == $enews->edition) selected @endif value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="am-epaper-btn">Apply Filters</button>
                @if (session('error'))
                    <p style="color:#ef4444; font-size: 14px; font-weight: 600; width: 100%;">{{ session('error') }}</p>
                @endif
            </form>

            <div class="am-epaper-share">
                <span class="am-share-title">Share E-Paper</span>
                <div class="am-share-buttons">
                    <a href="https://twitter.com/intent/tweet?text={{$share_url}}&url={{$share_url}}" class="am-share-btn twitter" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24"><path d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.69303 15.9418 3.69434C13.6326 3.69434 11.7597 5.56661 11.7597 7.87683C11.7597 8.20458 11.7973 8.52242 11.8676 8.82909C8.39047 8.65404 5.31007 6.99005 3.24678 4.45941C2.87529 5.09767 2.68005 5.82318 2.68104 6.56167C2.68104 8.01259 3.4196 9.29324 4.54149 10.043C3.87737 10.022 3.22788 9.84264 2.64718 9.51973C2.64654 9.5373 2.64654 9.55487 2.64654 9.57148C2.64654 11.5984 4.08819 13.2892 6.00199 13.6731C5.6428 13.7703 5.27232 13.8194 4.90022 13.8191C4.62997 13.8191 4.36771 13.7942 4.11279 13.7453C4.64531 15.4065 6.18886 16.6159 8.0196 16.6491C6.53813 17.8118 4.70869 18.4426 2.82543 18.4399C2.49212 18.4402 2.15909 18.4205 1.82812 18.3811C3.74004 19.6102 5.96552 20.2625 8.23842 20.2601C15.9316 20.2601 20.138 13.8875 20.138 8.36111C20.138 8.1803 20.1336 7.99886 20.1256 7.81997C20.9443 7.22845 21.651 6.49567 22.2125 5.65605Z"></path></svg>
                        Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{$share_url}}" class="am-share-btn fb" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24"><path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z"></path></svg>
                        Post
                    </a>
                    <a href="https://wa.me/?text={{ $share_url }}" class="am-share-btn whatsapp" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24"><path d="M12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22C10.1671 22 8.44851 21.5064 6.97086 20.6447L2.00516 22L3.35712 17.0315C2.49494 15.5536 2.00098 13.8345 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2ZM8.59339 7.30019L8.39232 7.30833C8.26293 7.31742 8.13607 7.34902 8.02057 7.40811C7.93392 7.45244 7.85348 7.51651 7.72709 7.63586C7.60774 7.74855 7.53857 7.84697 7.46569 7.94186C7.09599 8.4232 6.89729 9.01405 6.90098 9.62098C6.90299 10.1116 7.03043 10.5884 7.23169 11.0336C7.63982 11.9364 8.31288 12.8908 9.20194 13.7759C9.4155 13.9885 9.62473 14.2034 9.85034 14.402C10.9538 15.3736 12.2688 16.0742 13.6907 16.4482C13.6907 16.4482 14.2507 16.5342 14.2589 16.5347C14.4444 16.5447 14.6296 16.5313 14.8153 16.5218C15.1066 16.5068 15.391 16.428 15.6484 16.2909C15.8139 16.2028 15.8922 16.159 16.0311 16.0714C16.0311 16.0714 16.0737 16.0426 16.1559 15.9814C16.2909 15.8808 16.3743 15.81 16.4866 15.6934C16.5694 15.6074 16.6406 15.5058 16.6956 15.3913C16.7738 15.2281 16.8525 14.9166 16.8838 14.6579C16.9077 14.4603 16.9005 14.3523 16.8979 14.2854C16.8936 14.1778 16.8047 14.0671 16.7073 14.0201L16.1258 13.7587C16.1258 13.7587 15.2563 13.3803 14.7245 13.1377C14.6691 13.1124 14.6085 13.1007 14.5476 13.097C14.4142 13.0888 14.2647 13.1236 14.1696 13.2238C14.1646 13.2218 14.0984 13.279 13.3749 14.1555C13.335 14.2032 13.2415 14.3069 13.0798 14.2972C13.0554 14.2955 13.0311 14.292 13.0074 14.2858C12.9419 14.2685 12.8781 14.2457 12.8157 14.2193C12.692 14.1668 12.6486 14.1469 12.5641 14.1105C11.9868 13.8583 11.457 13.5209 10.9887 13.108C10.8631 12.9974 10.7463 12.8783 10.6259 12.7616C10.2057 12.3543 9.86169 11.9211 9.60577 11.4938C9.5918 11.4705 9.57027 11.4368 9.54708 11.3991C9.50521 11.331 9.45903 11.25 9.44455 11.1944C9.40738 11.0473 9.50599 10.9291 9.50599 10.9291C9.50599 10.9291 9.74939 10.663 9.86248 10.5183C9.97128 10.379 10.0652 10.2428 10.125 10.1457C10.2428 9.95633 10.2801 9.76062 10.2182 9.60963C9.93764 8.92565 9.64818 8.24536 9.34986 7.56894C9.29098 7.43545 9.11585 7.33846 8.95659 7.32007C8.90265 7.31384 8.84875 7.30758 8.79459 7.30402C8.66053 7.29748 8.5262 7.29892 8.39232 7.30833L8.59339 7.30019Z"></path></svg>
                        Send
                    </a>
                </div>
            </div>
        </div>

        <!-- Top Thumbnails -->
        <div class="am-epaper-thumbnails-container">
            <div class="am-epaper-thumbnails">
                @foreach ($pages as $p)
                    <a href="/epaper/{{ $enews->id }}/{{ $p->page_number }}" class="am-epaper-thumbnail">
                        <img class="am-epaper-thumb-img e-papers-thumbnail-poster-image" src="{{ $p->page_sm_url }}" alt="Page {{ $p->page_number }}" loading="lazy">
                        <span class="am-epaper-thumb-label">Page {{ $p->page_number }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Main Viewer -->
        <div class="am-epaper-viewer">
            @if ($active_page && $active_page->first())
                <img class="am-epaper-viewer-img e-paper-single-poster-image" src="{{ $active_page->page_url }}" alt="EPaper Active Page" loading="lazy">
            @endif
        </div>

        <!-- Bottom Thumbnails -->
        <div class="am-epaper-thumbnails-container">
            <div class="am-epaper-thumbnails">
                @foreach ($pages as $p)
                    <a href="/epaper/{{ $enews->id }}/{{ $p->page_number }}" class="am-epaper-thumbnail">
                        <img class="am-epaper-thumb-img e-papers-thumbnail-poster-image" src="{{ $p->page_sm_url }}" alt="Page {{ $p->page_number }}" loading="lazy">
                        <span class="am-epaper-thumb-label">Page {{ $p->page_number }}</span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
{{-- Advanced Security: Prevent Image Download, Copy, Screenshot, and Printing --}}
document.addEventListener("DOMContentLoaded", () => {
    
    // 1. Block Context Menu & Dragging for Images
    const images = [];
    const thumbnails = document.querySelectorAll('.e-papers-thumbnail-poster-image');
    if (thumbnails) { images.push(...thumbnails); }
    
    const main = document.querySelector('.e-paper-single-poster-image');
    if (main) { images.push(main); }
    
    images.forEach((it) => {
        it.addEventListener("contextmenu", (e) => e.preventDefault());
        it.addEventListener("dragstart", (e) => e.preventDefault());
        it.style.pointerEvents = "none"; // Prevents right-click and dragging entirely
    });

    // Restore pointer events on the container links so they are still clickable
    document.querySelectorAll('.am-epaper-thumbnail').forEach(link => {
        link.style.pointerEvents = "auto";
    });

    // 2. Block Keyboard Shortcuts (PrintScreen, Snipping Tool, Mac Screenshots)
    const blockKeys = (e) => {
        // PrintScreen (Windows/Linux)
        if (e.key === "PrintScreen" || e.keyCode === 44) {
            e.preventDefault();
            navigator.clipboard.writeText('Screenshots disabled.');
            blurScreen();
            setTimeout(unblurScreen, 2000);
        }
        
        // Windows Snipping Tool (Windows + Shift + S)
        if (e.metaKey && e.shiftKey && (e.key === 's' || e.key === 'S')) {
            e.preventDefault();
            blurScreen();
            setTimeout(unblurScreen, 2000);
        }

        // Mac Screenshots (Cmd + Shift + 3, 4, 5)
        if (e.metaKey && e.shiftKey && (e.key === '3' || e.key === '4' || e.key === '5')) {
            e.preventDefault();
            blurScreen();
            setTimeout(unblurScreen, 2000);
        }

        // Print (Ctrl/Cmd + P) or Save (Ctrl/Cmd + S) or Inspect (Ctrl/Cmd + U)
        if (e.ctrlKey || e.metaKey) {
            if (['p', 's', 'u', 'P', 'S', 'U'].includes(e.key)) {
                e.preventDefault();
            }
        }
    };

    document.addEventListener("keydown", blockKeys);
    document.addEventListener("keyup", blockKeys);

    // 3. Blur Screen Functions (used for keyboard shortcuts)
    const blurScreen = () => {
        const root = document.querySelector(".am-epaper-root");
        if(root) {
            root.style.filter = "blur(30px) grayscale(100%)";
            root.style.opacity = "0.1";
        }
    };
    const unblurScreen = () => {
        const root = document.querySelector(".am-epaper-root");
        if(root) {
            root.style.filter = "none";
            root.style.opacity = "1";
        }
    };

    // 4. Clear Clipboard on Copy Attempt
    document.addEventListener("copy", (e) => {
        e.preventDefault();
        e.clipboardData.setData('text/plain', 'Content protected.');
    });
});
</script>

<style>
/* Prevent Printing via CSS */
@media print {
    body {
        display: none !important;
    }
}
/* Prevent Text Selection globally on EPaper page */
.am-epaper-root {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    transition: filter 0.1s ease, opacity 0.1s ease;
}
/* Prevent image highlighting */
img {
    -webkit-user-drag: none;
    pointer-events: none;
}
</style>
@endsection