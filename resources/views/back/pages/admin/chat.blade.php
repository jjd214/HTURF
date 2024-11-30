@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Chat')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Chat</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Chat
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="bg-white border-radius-4 box-shadow mb-30">
    <div class="row no-gutters">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="chat-list bg-light-gray">
                <div class="chat-search">
                    <span class="ti-search"></span>
                    <input type="text" placeholder="Search Contact">
                </div>
                <div class="notification-list chat-notification-list customscroll mCustomScrollbar _mCS_4"><div id="mCSB_4" class="mCustomScrollBox mCS-dark-2 mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_4_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                    <ul>
                        <li class="active">
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-green"></i> online
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-green"></i> online
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-warning"></i> active 5
                                    min
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-warning"></i> active 4
                                    min
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-warning"></i> active 3
                                    min
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-orange"></i>
                                    offline
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-orange"></i>
                                    offline
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-orange"></i>
                                    offline
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-orange"></i>
                                    offline
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-orange"></i>
                                    offline
                                </p>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="vendors/images/img.jpg" alt="" class="mCS_img_loaded">
                                <h3 class="clearfix">John Doe</h3>
                                <p>
                                    <i class="fa fa-circle text-light-orange"></i>
                                    offline
                                </p>
                            </a>
                        </li>
                    </ul>
                </div><div id="mCSB_4_scrollbar_vertical" class="mCSB_scrollTools mCSB_4_scrollbar mCS-dark-2 mCSB_scrollTools_vertical mCSB_scrollTools_onDrag_expand" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_4_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 196px; max-height: 409.68px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div class="chat-detail">
                <div class="chat-profile-header clearfix">
                    <div class="left">
                        <div class="clearfix">
                            <div class="chat-profile-photo">
                                <img src="vendors/images/profile-photo.jpg" alt="">
                            </div>
                            <div class="chat-profile-name">
                                <h3>Rachel Curtis</h3>
                                <span>New York, USA</span>
                            </div>
                        </div>
                    </div>
                    <div class="right text-right">
                        <div class="dropdown">
                            <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                Setting
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Export Chat</a>
                                <a class="dropdown-item" href="#">Search</a>
                                <a class="dropdown-item text-light-orange" href="#">Delete Chat</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-box">
                    <div class="chat-desc customscroll mCustomScrollbar _mCS_5"><div id="mCSB_5" class="mCustomScrollBox mCS-dark-2 mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_5_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                        <ul>
                            <li class="clearfix admin_chat">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img2.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>Maybe you already have additional info?</p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix admin_chat">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img2.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>
                                        It is to early to provide some kind of estimation
                                        here. We need user stories.
                                    </p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img1.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>
                                        We are just writing up the user stories now so
                                        will have requirements for you next week. We are
                                        just writing up the user stories now so will have
                                        requirements for you next week.
                                    </p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img1.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>
                                        Essentially the brief is for you guys to build an
                                        iOS and android app. We will do backend and web
                                        app. We have a version one mockup of the UI,
                                        please see it attached. As mentioned before, we
                                        would simply hand you all the assets for the UI
                                        and you guys code. If you have any early questions
                                        please do send them on to myself. Ill be in touch
                                        in coming days when we have requirements prepared.
                                        Essentially the brief is for you guys to build an
                                        iOS and android app. We will do backend and web
                                        app. We have a version one mockup of the UI,
                                        please see it attached. As mentioned before, we
                                        would simply hand you all the assets for the UI
                                        and you guys code. If you have any early questions
                                        please do send them on to myself. Ill be in touch
                                        in coming days when we have.
                                    </p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix admin_chat">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img2.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>Maybe you already have additional info?</p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix admin_chat">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img2.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>
                                        It is to early to provide some kind of estimation
                                        here. We need user stories.
                                    </p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img1.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>
                                        We are just writing up the user stories now so
                                        will have requirements for you next week. We are
                                        just writing up the user stories now so will have
                                        requirements for you next week.
                                    </p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img1.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <p>
                                        Essentially the brief is for you guys to build an
                                        iOS and android app. We will do backend and web
                                        app. We have a version one mockup of the UI,
                                        please see it attached. As mentioned before, we
                                        would simply hand you all the assets for the UI
                                        and you guys code. If you have any early questions
                                        please do send them on to myself. Ill be in touch
                                        in coming days when we have requirements prepared.
                                        Essentially the brief is for you guys to build an
                                        iOS and android app. We will do backend and web
                                        app. We have a version one mockup of the UI,
                                        please see it attached. As mentioned before, we
                                        would simply hand you all the assets for the UI
                                        and you guys code. If you have any early questions
                                        please do send them on to myself. Ill be in touch
                                        in coming days when we have.
                                    </p>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix upload-file">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img1.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="upload-file-box clearfix">
                                        <div class="left">
                                            <img src="vendors/images/upload-file-img.jpg" alt="" class="mCS_img_loaded">
                                            <div class="overlay">
                                                <a href="#">
                                                    <span><i class="fa fa-angle-down"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <h3>Big room.jpg</h3>
                                            <a href="#">Download</a>
                                        </div>
                                    </div>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                            <li class="clearfix upload-file admin_chat">
                                <span class="chat-img">
                                    <img src="vendors/images/chat-img2.jpg" alt="" class="mCS_img_loaded">
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="upload-file-box clearfix">
                                        <div class="left">
                                            <img src="vendors/images/upload-file-img.jpg" alt="" class="mCS_img_loaded">
                                            <div class="overlay">
                                                <a href="#">
                                                    <span><i class="fa fa-angle-down"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <h3>Big room.jpg</h3>
                                            <a href="#">Download</a>
                                        </div>
                                    </div>
                                    <div class="chat_time">09:40PM</div>
                                </div>
                            </li>
                        </ul>
                    </div><div id="mCSB_5_scrollbar_vertical" class="mCSB_scrollTools mCSB_5_scrollbar mCS-dark-2 mCSB_scrollTools_vertical mCSB_scrollTools_onDrag_expand" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_5_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 53px; max-height: 322.68px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                    <div class="chat-footer">
                        <div class="file-upload">
                            <a href="#"><i class="fa fa-paperclip"></i></a>
                        </div>
                        <div class="chat_text_area">
                            <textarea placeholder="Type your message…"></textarea>
                        </div>
                        <div class="chat_send">
                            <button class="btn btn-link" type="submit">
                                <i class="icon-copy ion-paper-airplane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
