<div>
    <div class="bg-white border-radius-4 box-shadow mb-30">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="chat-list bg-light-gray">
                    <div class="chat-search">
                        <span class="ti-search"></span>
                        <input type="text" placeholder="Search Contact">
                    </div>
                    <div class="notification-list chat-notification-list customscroll mCustomScrollbar _mCS_4">
                        <ul>
                            <li>
                                <a href="#">
                                    <img src="{{ $admin->picture }}" alt="" class="mCS_img_loaded">
                                    <h3 class="clearfix">{{ $admin->name }}</h3>
                                    <p>
                                        <i
                                            class="fa fa-circle {{ $admin->is_online ? 'text-light-green' : 'text-muted' }}"></i>
                                        {{ $admin->is_online ? 'online' : 'offline' }}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12">
                <form wire:submit.prevent="sendMessage">

                    <div class="chat-detail">
                        <div class="chat-profile-header clearfix">
                            <div class="left">
                                <div class="clearfix">
                                    <div class="chat-profile-photo">
                                        <img src="{{ $admin->picture }}" alt="{{ $admin->name }}">
                                    </div>
                                    <div class="chat-profile-name">
                                        <h3>{{ $admin->name }}</h3>
                                        <span>{{ $admin->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="right text-right">
                                <div class="dropdown">
                                    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown">
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
                            <div class="chat-desc customscroll" style="max-height: 500px; overflow-y: auto;">
                                @forelse ($messages as $message)
                                    <ul>
                                        <li class="clearfix {{ $message->sender_id == '1' ? '' : 'admin_chat' }} ">
                                            <span class="chat-img">
                                                <img src="{{ $message->sender_id == '1' ? $admin->picture : Auth::user()->picture }}"
                                                    alt="" class="mCS_img_loaded">
                                            </span>
                                            <div class="chat-body clearfix">
                                                <p>
                                                    {{ $message->message }}
                                                </p>
                                                <br>
                                                <div class="chat_time">
                                                    {{ $message->created_at->format('Y-m-d') }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                @empty
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="chat-profile-photo mb-3">
                                            <img src="{{ $admin->picture }}" alt="{{ $admin->name }}"
                                                class="rounded-circle"
                                                style="height: 70px; width: 70px; margin-top: 20px;">
                                        </div>
                                        <div class="chat-profile-name text-center">
                                            <p>{{ $admin->name }}</p>
                                            <span class="text-muted"><small>Admin</small></span>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <div class="chat-footer">
                                <div class="file-upload">
                                    <a href="#"><i class="fa fa-paperclip"></i></a>
                                </div>
                                <div class="chat_text_area">
                                    <input type="hidden" wire:model.defer="sender_id">
                                    <textarea placeholder="Type your message…" wire:model="message"></textarea>
                                </div>
                                <div class="chat_send">
                                    <button class="btn btn-link" type="submit">
                                        <i class="icon-copy ion-paper-airplane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
