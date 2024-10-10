<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>@yield('pageTitle')</title>

		<!-- Site favicon -->
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="/images/site/{{ get_settings()->site_favicon }}"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="/back/vendors/styles/icon-font.min.css"
		/>
        <link rel="stylesheet" type="text/css" href="/back/vendors/styles/toaster.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
        @livewireStyles
        @stack('stylesheets')
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="login.html">
						<img src="/images/site/{{ get_settings()->site_logo }}" alt="" />
					</a>
				</div>
				<div class="login-menu">
                    <ul>
                    @if ( !Route::is('admin.*') )

                        @if ( Route::is('consignor.login'))
                            <li><a href="{{ route('consignor.register') }}">Register</a></li>
                        @else
                            <li><a href="{{ route('consignor.login') }}">login</a></li>
                        @endif

                    @endif
                    </ul>
				</div>
			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<img src="/back/vendors/images/login-page-img.png" alt="" />
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
