<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:logo" content="{{ asset('favicon.ico') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ asset('og-image.png') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ asset('og-image.png') }}">

<!-- Fonts & Favicons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
<meta name="apple-mobile-web-app-title" content="FileStream" />
<link rel="manifest" href="{{ asset('site.webmanifest') }}" />
<!-- Cloudflare Web Analytics -->
<script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "577c7093fb1f474c96b4789473cb2432"}'></script><!-- End Cloudflare Web Analytics -->