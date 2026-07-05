@php $seo = app(\App\Services\SeoService::class); @endphp
@if ($ga = $seo->get('google_analytics_id'))
<script>
window.addEventListener('load', function() {
    var s = document.createElement('script');
    s.src = 'https://www.googletagmanager.com/gtag/js?id={{ $ga }}';
    s.async = true;
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $ga }}');
    window.gtag = gtag;
});
</script>
@endif
@if ($gtm = $seo->get('google_tag_manager_id'))
<script>
window.addEventListener('load', function() {
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $gtm }}');
});
</script>
@endif
