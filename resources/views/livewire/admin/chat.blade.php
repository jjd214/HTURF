<div>
    <div class="bg-white border-radius-4 box-shadow mb-30">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="chat-list bg-light-gray">
                    <div class="chat-search">
                        <span class="ti-search"></span>
                        <input type="text" placeholder="Search Contact" wire:model.live="search_contact">
                    </div>
                    <div class="notification-list chat-notification-list customscroll"
                        style="max-height: 400px; overflow-y: auto;">
                        <ul>
                            @forelse ($users as $user)
                                <li wire:key="{{ $user->id }}" wire:click="selectUser({{ $user->id }})"
                                    class="cursor-pointer">
                                    <a href="#">
                                        <img src="{{ $user->picture }}" alt="{{ $user->name }}"
                                            class="mCS_img_loaded">
                                        <h3 class="clearfix">{{ $user->name }}</h3>
                                        <p>
                                            <i
                                                class="fa fa-circle {{ $user->is_online ? 'text-light-green' : 'text-muted' }}"></i>
                                            {{ $user->is_online ? 'online' : 'offline' }}
                                        </p>
                                    </a>
                                </li>
                            @empty
                                <h1 class="h4 text-muted text-center">{{ __('No contacts.') }}</h1>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12">
                <form wire:submit.prevent="sendMessage">
                    <div class="chat-detail">
                        <div class="chat-profile-header clearfix">
                            <div class="left">
                                @if ($selectedUser)
                                    <div class="clearfix">
                                        <div class="chat-profile-photo">
                                            <img src="{{ $selectedUser->picture }}" alt="{{ $selectedUser->name }}">
                                        </div>
                                        <div class="chat-profile-name">
                                            <h3>{{ $selectedUser->name }}</h3>
                                            <span>{{ $selectedUser->email ?? '' }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p>Select a user to start chatting</p>
                                    </div>
                                @endif
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
                                <div wire:loading wire:target="selectUser">
                                    <p>Loading chat...</p>
                                </div>
                                {{--  Has conversation --}}
                                @if ($conversation)
                                    <ul>
                                        @foreach ($conversation_messages as $message)
                                            <li class="clearfix admin_chat">
                                                <span class="chat-img">
                                                    <img src="{{ $admin->picture }}" alt=""
                                                        class="mCS_img_loaded">
                                                </span>
                                                <div class="chat-body">
                                                    <p>{{ $message->message }}</p>
                                                    <div class="chat_time">{{ $message->created_at }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{-- No conversation --}}
                                    @if ($selectedUser)
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="chat-profile-photo mb-3">
                                                <img src="{{ $selectedUser->picture }}"
                                                    alt="{{ $selectedUser->name }}" class="rounded-circle"
                                                    style="height: 70px; width: 70px; margin-top: 20px;">
                                            </div>
                                            <div class="chat-profile-name text-center">
                                                <p>{{ $selectedUser->name }}</p>
                                                <span class="text-muted"><small>Consignor</small></span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                {{-- <ul>
                                            <li class="clearfix admin_chat">
                                                <span class="chat-img">
                                                    <img src="vendors/images/chat-img2.jpg" alt=""
                                                        class="mCS_img_loaded">
                                                </span>
                                                <div class="chat-body clearfix">
                                                    <p>Maybe you already have additional info?</p>
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
                                        </ul> --}}


                            </div>

                            <div class="chat-footer">
                                <div class="file-upload">
                                    <a href="#"><i class="fa fa-paperclip"></i></a>
                                </div>
                                <div class="chat_text_area">
                                    <input type="hidden" wire:model.defer='sender_id'>
                                    <input type="hidden" wire:model.defer='receiver_id'>
                                    <textarea placeholder="Type your message…" wire:model='message'></textarea>
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
