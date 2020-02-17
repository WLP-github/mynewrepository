<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body>
    @include('layouts.nav')
    <section class="page-section portfolio" id="portfolio">
        {{-- loading image --}}
        <div class="se-pre-con"></div>
        
        @yield('content')
    </section>
    @include('layouts.footer')
    @include('layouts.footer-script')

    @yield('script')
</body>
</html>