<div>
    <style>
        .chat_send .icon i {
            color: black !important;
        }
    </style>
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
                        @forelse ($users as $user)
                            <ul>
                                <li wire:click.prevent="selectedUser({{ $user->userId }})"
                                    class="{{ $receiver_id === $user->userId ? 'active' : '' }}">
                                    <a href="#">
                                        <img src="{{ $user->picture }}" alt="{{ $user->name }}"
                                            class="mCS_img_loaded">
                                        <h3 class="clearfix">{{ $user->name }}</h3>
                                        <p>
                                            <i
                                                class="fa fa-circle {{ $user->is_online ? 'text-light-green' : 'text-light-red text-muted' }} text-light-green"></i>
                                            {{ $user->is_online ? 'online' : 'offline' }}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @empty
                            {{ __('No contacts.') }}
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12">
                <form wire:submit.prevent="sendMessage">
                    <div class="chat-detail">
                        <div class="chat-profile-header clearfix">
                            <div class="left">
                                @if ($userProfileHeader)
                                    <div class="clearfix">
                                        <div class="chat-profile-photo">
                                            <img src="{{ $userProfileHeader->picture }}"
                                                alt="{{ $userProfileHeader->name }}">
                                        </div>
                                        <div class="chat-profile-name">
                                            <h3 class="text-dark">{{ $userProfileHeader->name }}</h3>
                                            <span>{{ $userProfileHeader->email }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="right text-right">
                                <div class="dropdown">
                                    <a class="btn btn-outline-dark dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown">
                                        Setting
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item text-light-dark" href="#">Delete Chat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-box">
                            <div class="chat-desc "
                                style="max-height: 500px; overflow-y: auto; display: flex; flex-direction: column-reverse;"
                                wire:poll="refreshMessage">
                                @forelse ($messages as $message)
                                    <ul>
                                        <li
                                            class="clearfix {{ $message->sender_id == $admin->id ? 'admin_chat' : '' }} ">
                                            <span class="chat-img">
                                                <img src="{{ $message->sender_id == $admin->id ? $admin->picture : $userProfileHeader->picture }}"
                                                    alt="{{ $admin->name }}" class="mCS_img_loaded">
                                            </span>
                                            <div class="chat-body clearfix">
                                                <p>{{ $message->message }}</p>
                                                <div class="chat_time">
                                                    {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                @empty
                                    @if ($userProfileHeader)
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="chat-profile-photo mb-3">
                                                <img src="{{ $userProfileHeader->picture }}"
                                                    alt="{{ $userProfileHeader->name }}" class="rounded-circle"
                                                    style="height: 70px; width: 70px; margin-top: 20px;">
                                            </div>
                                            <div class="chat-profile-name text-center">
                                                <p>{{ $userProfileHeader->name }}</p>
                                                <span class="text-muted"><small>Consignor</small></span>
                                            </div>
                                        </div>
                                    @endif
                                @endforelse
                            </div>

                            <div class="chat-footer">
                                <div class="file-upload">
                                    <a href="#" style="visibility: hidden;"><i class="fa fa-paperclip"></i></a>
                                </div>
                                <div class="chat_text_area">
                                    <textarea placeholder="Type your message…" wire:model='chat_message'></textarea>
                                </div>
                                <div class="chat_send">
                                    <button class="btn btn-link" type="submit">
                                        <div class="icon">

                                            <i class="icon-copy ion-paper-airplane"></i>
                                        </div>
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
