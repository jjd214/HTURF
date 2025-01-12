<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('pageTitle')</title>
    <meta name="description" content="{{ get_settings()->site_meta_description }}" />
    <meta name="keywords" content="{{ get_settings()->site_meta_keywords }}" />
    <meta name="author" content="{{ get_settings()->site_name }}" />
    <!-- Site favicon -->

    <link rel="icon" type="image/png" sizes="16x16" href="/images/site/{{ get_settings()->site_favicon }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- Include FontAwesome 6 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/icon-font.min.css" />
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ get_settings()->site_meta_keywords }}" />
    <meta property="og:description" content="{{ get_settings()->site_meta_description }}" />
    <meta property="og:image" content="/images/site/{{ get_settings()->site_image }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ get_settings()->site_name }}" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ get_settings()->site_name }}" />
    <meta name="twitter:description" content="{{ get_settings()->site_meta_description }}" />
    <meta name="twitter:image" content="/images/site/{{ get_settings()->site_image }}" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/toaster.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/extra-assets/ijaboCropTool/ijaboCropTool.min.css">
    <style>
        /* Styling for the table */
        .styled-table tbody tr td {
            border-bottom: 1px solid #ddd;
        }

        .styled-table tbody tr:last-child td {
            border-bottom: none;
            /* Remove the border for the last row */
        }
    </style>
    @livewireStyles
    @stack('stylesheets')
</head>

<body>

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            {{-- <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Search Here" />
                        <div class="dropdown">
                            <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                <i class="ion-arrow-down-c"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">From</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> --}}
        </div>
        <div class="header-right">
            {{-- <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div> --}}

            @livewire('admin.admin-header-profile-info')

            {{-- <div class="github-link">
					<a href="https://github.com/dropways/deskapp" target="_blank"
						><img src="/back/vendors/images/github.svg" alt=""
					/></a>
				</div> --}}
        </div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-1" checked="" />
                        <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-2" />
                        <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-3" />
                        <label class="custom-control-label" for="sidebaricon-3"><i
                                class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-1" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-1"><i
                                class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-2" />
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                                aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-3" />
                        <label class="custom-control-label" for="sidebariconlist-3"><i
                                class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-4" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-4"><i
                                class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-5" />
                        <label class="custom-control-label" for="sidebariconlist-5"><i
                                class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-6" />
                        <label class="custom-control-label" for="sidebariconlist-6"><i
                                class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        Reset Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="{{ route('admin.home') }}">
                <img src="/images/site/{{ get_settings()->site_logo }}" alt="" class="dark-logo" />
                <img src="/images/site/{{ get_settings()->site_logo }}" alt="" class="light-logo" />
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    @if (Route::is('admin.*'))
                        <li>
                            <a href="{{ route('admin.home') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.home') ? 'active' : '' }}">
                                <span class="micon bi bi-house"></span><span class="mtext">Home</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;"
                                class="dropdown-toggle {{ Route::is('admin.sales.*') ? 'active' : '' }}">
                                <span class="micon bi bi-cash-stack"></span><span class="mtext">Sales</span>
                            </a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('admin.sales.add-sales') }}"
                                        class="{{ Route::is('admin.sales.add-sales') ? 'active' : '' }}">Create sales
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.sales.all-transactions') }}"
                                        class="{{ Route::is('admin.sales.all-transactions') ? 'active' : '' }}">Transactions
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.sales.all-refunds') }}"
                                        class="{{ Route::is('admin.sales.all-refunds') ? 'active' : '' }}">Refunds
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;"
                                class="dropdown-toggle {{ Route::is('admin.product.*') ? 'active' : '' }}">
                                <span class="micon bi bi-cart2"></span><span class="mtext">Store Products</span>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('admin.product.all-products') }}"
                                        class="{{ Route::is('admin.product.all-products') ? 'active' : '' }}">All
                                        products</a></li>
                                <li><a href="{{ route('admin.product.add-product') }}"
                                        class="{{ Route::is('admin.product.add-product') ? 'active' : '' }}">Add
                                        product</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;"
                                class="dropdown-toggle {{ Route::is('admin.consignment.*') ? 'active' : '' }}">
                                <span class="micon bi bi-box-seam"></span><span class="mtext">Consignment</span>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('admin.consignment.all-consign') }}"
                                        class="{{ Route::is('admin.consignment.all-consign') ? 'active' : '' }} ">All
                                        consignments</a></li>
                                <li><a href="{{ route('admin.consignment.all-request') }}"
                                        class="{{ Route::is('admin.consignment.all-request') ? 'active' : '' }} ">All
                                        requests</a></li>
                                <li><a href="{{ route('admin.consignment.add-consign') }}"
                                        class="{{ Route::is('admin.consignment.add-consign') ? 'active' : '' }} ">Add
                                        consignment</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment.all-payments') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.payment.all-payments') ? 'active' : '' }}">
                                <span class="micon bi bi-cash-coin"></span><span class="mtext">Payments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.chat.all-chats') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.chat.all-chats') ? 'active' : '' }}">
                                <span class="micon bi bi-chat-right-dots"></span><span class="mtext">Chat</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <div class="sidebar-small-cap">Settings</div>
                        </li>
                        <li>
                            <a href="{{ route('admin.profile') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.profile') ? 'active' : '' }}">
                                <span class="micon bi bi-person"></span><span class="mtext">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.settings') ? 'active' : '' }}">
                                <span class="micon bi bi-gear"></span><span class="mtext">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.logs') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.logs') ? 'active' : '' }}">
                                <span class="micon bi bi-clipboard-data"></span>
                                <span class="mtext">Logs</span>
                            </a>
                        </li>
                    @endif
                    @if (Route::is('consignor.*'))
                        <li>
                            <a href="{{ route('consignor.home') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('consignor.home') ? 'active' : '' }}">
                                <span class="micon bi bi-house"></span><span class="mtext">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consignor.consignment.all-consignments') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('consignor.consignment.all-consignments') ? 'active' : '' }}">
                                <span class="micon bi bi-box-seam"></span><span class="mtext">My Inventory</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consignor.consignment.add-consignment') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('consignor.consignment.add-consignment') ? 'active' : '' }}">
                                <span class="micon bi bi-file-earmark-arrow-up"></span>
                                <span class="mtext">Consignment</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consignor.payment.all-payments') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('consignor.payment.all-payments') ? 'active' : '' }}">
                                <span class="micon bi bi-cash-coin"></span><span class="mtext">Payments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consignor.chat.all-chats') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('consignor.chat.all-chats') ? 'active' : '' }}">
                                <span class="micon bi bi-chat-right-dots"></span><span class="mtext">Chat</span>
                            </a>
                        </li>
                        <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <div class="sidebar-small-cap">Settings</div>
                        </li>
                        <li>
                            <a href="{{ route('consignor.profile') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('consignor.profile') ? 'active' : '' }}">
                                <span class="micon bi bi-person"></span><span class="mtext">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consignor.logout-handler') }}"
                                onclick="event.preventDefault();document.getElementById('userLogoutForm').submit();"
                                class="dropdown-toggle no-arrow">
                                <span class="micon bi bi-box-arrow-right"></span>
                                <span class="mtext">Logout</span>
                            </a>
                            <form action="{{ route('consignor.logout-handler') }}" id="userLogoutForm"
                                method="post">
                                @csrf
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">

            @yield('content')
            <div class="footer-wrap pd-20 mb-20 card-box">
                <p style="margin: 0; font-size: 14px; color: #6c757d;">
                    &copy; {{ date('Y') }} <strong>HypeArchivePh</strong>. Your trusted partner for online
                    consignment. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="/back/vendors/scripts/core.js"></script>
    <script src="/back/vendors/scripts/script.min.js"></script>
    <script src="/back/vendors/scripts/process.js"></script>
    <script src="/back/vendors/scripts/layout-settings.js"></script>
    <script src="/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>
    <script src="/back/vendors/scripts/toaster.js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
