@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Settings')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Settings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-4">
    @livewire('admin.admin-settings')
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('site_logo').addEventListener('change', function (event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function () {
            const preview = document.getElementById('site_logo_image_preview');
            preview.src = reader.result;
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    });

    $('#change_site_logo_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 1) {
                    $('#site_logo_image_preview').attr('src', '/images/site/' + response.new_logo + '?' + new Date().getTime());
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'success',
                            message: response.msg,
                        }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'error',
                            message: response.msg,
                        }
                    }));
                }
            },
            error: function() {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        type: 'error',
                        message: 'An unexpected error occurred. Please try again.',
                    }
                }));
            }
        });
    });

    document.getElementById('site_favicon').addEventListener('change', function (event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function () {
            const preview = document.getElementById('site_favicon_image_preview');
            preview.src = reader.result;
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    });

    $('#change_site_favicon_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 1) {
                    $('#site_favicon_image_preview').attr('src', '/images/site/' + response.new_favicon + '?' + new Date().getTime());
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'success',
                            message: response.msg,
                        }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'error',
                            message: response.msg,
                        }
                    }));
                }
            },
            error: function() {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        type: 'error',
                        message: 'An unexpected error occurred. Please try again.',
                    }
                }));
            }
        });
    });
</script>
@endpush
