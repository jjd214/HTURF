<div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="card-box pd-20 fixed-height-card overflow-hidden">
            {{-- <div class="pd-20 card-box height-100-p"> --}}
                <div class="profile-photo">
                    <a href="javascript:;" onclick="event.preventDefault();document.getElementById('userProfilePictureFile').click();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                    <img src="{{ $user->picture }}" alt="" class="avatar-photo" id="userProfilePicture">
                    <input type="file" name="userProfilePictureFile" id="userProfilePictureFile" class="d-none" style="opacity: 0;">
                </div>
                <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
                <p class="text-center text-muted font-14">
                    {{ $user->email }}
                </p>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item">
                                <a wire:click.prevent='selectTab("personal_details")' class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}" data-toggle="tab" href="#personal_details" role="tab">Personal details</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click.prevent='selectTab("update_password")' class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}" data-toggle="tab" href="#update_password" role="tab">Update password</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Timeline Tab start -->
                            <div class="tab-pane fade {{ $tab == 'personal_details' ? 'active show' : '' }}" id="personal_details" role="tabpanel">
                                <div class="pd-20">
                                    <form wire:submit='updateUserPersonalDetails()'>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Full name</label>
                                                    <input type="text" class="form-control" placeholder="Enter full name" wire:model.live='name'>
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Username</label>
                                                    <input type="text" class="form-control" placeholder="Enter username" wire:model.live='username'>
                                                    @error('username')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control" placeholder="Enter email" wire:model.live='email' @readonly(true)>
                                                    @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="number" class="form-control" placeholder="Enter phone number" wire:model.live='phone'>
                                                    @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Addresss</label>
                                                    <textarea class="form-control" placeholder="Enter your address" wire:model.live='address'></textarea>
                                                    @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                            </div>
                            <!-- Timeline Tab End -->
                            <!-- Tasks Tab start -->
                            <div class="tab-pane fade {{ $tab == 'update_password' ? 'active show' : '' }}" id="update_password" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    <form wire:submit.prevent="updatePassword">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Current password</label>
                                                    <input type="password" class="form-control" wire:model.defer="current_password" placeholder="Enter current password">
                                                    @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">New password</label>
                                                    <input type="password" class="form-control" placeholder="Enter new password" wire:model.defer="new_password">
                                                    @error('new_password')
                                                    <span class="text-danger"> {{ $message }} </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Confirm new password</label>
                                                    <input type="password" class="form-control" placeholder="Confirm new password" wire:model.defer="new_password_confirmation">
                                                    @error('new_password_confirmation')
                                                    <span class="text-danger"> {{ $message }} </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button wire:loading.attr="disabled" type="submit" class="btn btn-primary">
                                            <div wire:loading.delay class="spinner-border spinner-border-sm" role="status" >
                                                <span class="visually-hidden"></span>
                                            </div>
                                            Update password
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!-- Tasks Tab End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
