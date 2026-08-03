<!doctype html>
<html lang="en">
<head>
<title>{{ $title }}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="google-site-verification" content="wL2DFo3NDViJyOlNZI_626hWAnYu-XnFZmURA4br3cc" />
<meta name="facebook-domain-verification" content="2cv2b4thia75eq6jcy5xs4u89wzm3m" />

<link rel="stylesheet" href="/assets/css/styles.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;900&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

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
<noscript><img height="1" width="1" style="display:none"
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

<body class="layout-rtl">
<div class="banner">
	<div class="banner-wrapper">
		<div class="banner-logo">
			<img class="banner-logo-img" src="/assets/img/logo.jpg" alt="Akhbar-e-mashriq Logo" loading="lazy">
		</div>
		<div class="banner-text">
			<a href="#" class="banner-text-link is-active">Read in Urdu</a>
			<a href="/article.html" class="banner-text-link">Read in Hindustani</a>
		</div>
	</div>
</div>

<nav class="navbar has-three-columns">
	<div class="navbar-wrapper">
		<div class="navbar-left" >
			<div class="navbar-content">
				<ul class="navbar-menu">
					<li class="navbar-menu-item is-active-transparent ml-0">
						<a href="/" class="navbar-menu-item-link is-active pl-0">Home</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Latest</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Calcutta</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Bengal</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">National</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Sports</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Entertainment</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Health</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Business</a>
					</li>
					<li class="navbar-menu-item">
						<a href="/article-by-category.html" class="navbar-menu-item-link">Editorial</a>
					</li>
					<li class="navbar-menu-item mr-12">
						<a href="#" class="navbar-menu-item-link">Video</a>
					</li>
				</ul>
				<div class="navbar-toggler" id="navMenuToggler" role="button">
					<svg id="hamburgerNavbarIcon" class="navbar-toggler-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M3 4H21V6H3V4ZM9 11H21V13H9V11ZM3 18H21V20H3V18Z"></path></svg>
					<svg id="closeNavbarIcon" class="navbar-toggler-icon hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12.0007 10.5865L16.9504 5.63672L18.3646 7.05093L13.4149 12.0007L18.3646 16.9504L16.9504 18.3646L12.0007 13.4149L7.05093 18.3646L5.63672 16.9504L10.5865 12.0007L5.63672 7.05093L7.05093 5.63672L12.0007 10.5865Z"></path></svg>
				</div>
			</div>
		</div>
		<div class="navbar-center" >

		</div>
		<div class="navbar-right" id="navMenu">
			<div class="navbar-content">
				<ul class="navbar-menu">
					<a href="/#" class="button navbar-menu-button">Book Advertisement</a>
				</ul>
			</div>
		</div>
	</div>
</nav>
 @yield('content')

</body>
</html>