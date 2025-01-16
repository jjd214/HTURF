<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('pageTitle')</title>
    {{-- <meta name="description" content="{{ get_settings()->site_meta_description }}" />
    <meta name="keywords" content="{{ get_settings()->site_meta_keywords }}" />
    <meta name="author" content="{{ get_settings()->site_name }}" /> --}}

    <!-- Site favicon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="/images/site/{{ get_settings()->site_favicon }}" /> --}}

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/toaster.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/background.css" />

    <!-- Mobile Specific Metas -->
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ get_settings()->site_meta_keywords }}" />
    <meta property="og:description" content="{{ get_settings()->site_meta_description }}" />
    <meta property="og:image" content="/images/site/{{ get_settings()->site_image }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ get_settings()->site_name }}" /> --}}

    @livewireStyles
    @stack('stylesheets')
</head>

<body class="login-page black">
    <div class="login-header box-shadow black">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{ route('home-page') }}">
                    <img src="/images/site/{{ get_settings()->site_logo }}" alt="" />
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    @if (!Route::is('admin.*'))

                        @if (Route::is('consignor.login'))
                            <li><a class="text-white" href="{{ route('consignor.register') }}">Register</a></li>
                        @else
                            <li><a href="{{ route('consignor.login') }}" class="text-white">Login</a></li>
                        @endif

                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="/images/site/qwe.png" class="w-75 ml-5" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="/back/vendors/scripts/core.js"></script>
    <script src="/back/vendors/scripts/script.min.js"></script>
    <script src="/back/vendors/scripts/process.js"></script>
    <script src="/back/vendors/scripts/layout-settings.js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
