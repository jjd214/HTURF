<div>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a wire:click.prevent='selectTab("general_settings")'
                    class="nav-link {{ $tab == 'general_settings' ? 'active' : '' }}" data-toggle="tab"
                    href="#general_settings" role="tab" aria-selected="true">General settings</a>
            </li>
            <li class="nav-item">
                <a wire:click.prevent='selectTab("logo_favicon")'
                    class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }} " data-toggle="tab"
                    href="#logo_favicon" role="tab" aria-selected="false">Logo and Favicon</a>
            </li>
            <li class="nav-item">
                <a wire:click.prevent='selectTab("social_networks")'
                    class="nav-link {{ $tab == 'social_networks' ? 'active' : '' }} " data-toggle="tab"
                    href="#social_networks" role="tab" aria-selected="false">Social networks</a>
            </li>
            {{-- <li class="nav-item">
                <a wire:click.prevent='selectTab("payment_methods")' class="nav-link {{ $tab == 'payment_methods' ?'active' : '' }} " data-toggle="tab" href="#payment_methods" role="tab" aria-selected="false">Payment methods</a>
            </li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab == 'general_settings' ? 'active show' : '' }} " id="general_settings"
                role="tabpanel">
                <div class="pd-20">
                    <form wire:submit.prevent="updateGeneralSettings" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site name: </b></label>
                                    <input type="text" class="form-control" placeholder="Enter site name"
                                        wire:model.defer="site_name">
                                    @error('site_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for=""><b>Site email: </b></label>
                                        <input type="text" class="form-control" placeholder="Enter site email"
                                            wire:model.defer="site_email">
                                        @error('site_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site phone: </b></label>
                                    <input type="text" class="form-control" placeholder="Enter site phone"
                                        wire:model.defer="site_phone">
                                    @error('site_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for=""><b>Site meta keywords: </b><small>Seperated by comma
                                                (a,b,c)</small></label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter site meta keywords"
                                            wire:model.defer="site_meta_keywords">
                                        @error('site_meta_keywords')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Site meta description</b></label>
                            <textarea name="" id="" cols="4" rows="4" class="form-control"
                                wire:model.defer="site_meta_description"></textarea>
                            @error('site_meta_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'active show' : '' }} " id="logo_favicon"
                role="tabpanel">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Site logo</h5>
                            <div class="mb-2 mt-1" style="max-width: 200px;">
                                <img wire:ignore src="/images/site/{{ $site_logo }}" alt=""
                                    data-ijabo-default-img="/images/site/{{ $site_logo }}"
                                    id="site_logo_image_preview" class="img-thumbnail">
                            </div>
                            <form action="{{ route('admin.change-logo') }}" method="post"
                                enctype="multipart/form-data" id="change_site_logo_form">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" wire:model="site_logo" name="site_logo" id="site_logo"
                                        class="form-control">
                                    <span class="text-danger error-text site_logo_error"></span>
                                    <div wire:loading wire:target="site_logo">
                                        <span class="text-success">Loading...</span>
                                    </div>
                                </div>
                                <button wire:loading.attr="disabled" type="submit" class="btn btn-primary">Change
                                    logo</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h5>Site favicon</h5>
                            <div class="mb-2 mt-1" style="max-width: 100px">
                                <img wire:ignore src="/images/site/{{ $site_favicon }}" alt=""
                                    class="img-thumbnail" id="site_favicon_image_preview"
                                    data-ijabo-default-img="/images/site/{{ $site_favicon }}">
                            </div>
                            <form action="{{ route('admin.change-favicon') }}" method="post"
                                enctype="multipart/form-data" id="change_site_favicon_form">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" name="site_favicon" wire:model="site_favicon"
                                        id="site_favicon" class="form-control">
                                    <span class="text-danger error-text site_favicon_error"></span>
                                    <div wire:loading wire:target="site_favicon">
                                        <span class="text-success">Loading...</span>
                                    </div>
                                </div>
                                <button wire:loading.attr="disabled" type="submit" class="btn btn-info">Change
                                    favicon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'social_networks' ? 'active show' : '' }} " id="social_networks"
                role="tabpanel">
                <div class="pd-20">
                    <form wire:submit.prevent="updateSocialNetworks" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><b>Facebook URL</b></label>
                                    <input type="text" wire:model.defer="facebook_url" class="form-control"
                                        placeholder="Enter facebook url">
                                    @error('facebook_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><b>Instagram URL</b></label>
                                    <input type="text" wire:model.defer="instagram_url" class="form-control"
                                        placeholder="Enter instagram url">
                                    @error('instagram_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><b>X / Twitter URL</b></label>
                                    <input type="text" wire:model.defer="twitter_url" class="form-control"
                                        placeholder="Enter twitter url">
                                    @error('twitter_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><b>Tiktok URL</b></label>
                                    <input type="text" class="form-control" wire:model.defer="tiktok_url"
                                        placeholder="Enter tiktok url">
                                    @error('tiktok_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><b>Shoppee URL</b></label>
                                    <input type="text" class="form-control" wire:model.defer="shoppee_url"
                                        placeholder="Enter shoppee url">
                                    @error('shoppee_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><b>Lazada URL</b></label>
                                    <input type="text" class="form-control" wire:model.defer="lazada_url"
                                        placeholder="Enter lazada url">
                                    @error('lazada_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update social networks</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'payment_methods' ? 'active show' : '' }} " id="payment_methods"
                role="tabpanel">
                <div class="pd-20">
                    --- Payment methods
                </div>
            </div>
        </div>
    </div>
</div>
