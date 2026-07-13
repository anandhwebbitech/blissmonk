@extends('admin.layouts.app')

@section('page-title', 'Edit Testimonial')

@section('content')
<style>
    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.02);
    }
    
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #166534;
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
    }

    .btn-save {
        background-color: #166534;
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background-color: #14532d;
        box-shadow: 0 8px 16px rgba(22, 101, 52, 0.2);
    }
</style>

<div class="container-fluid py-2">
    <div class="form-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Edit Testimonial Entry</h4>
                <p class="text-muted small mb-0">Modify the client credentials, update the target YouTube context URL, or switch structural visibility status.</p>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 10px; font-weight: 500;">
                <i class="fa fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <form id="testimonialEditForm" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-md-9">
                    <label class="form-label">Client Name / Video Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $testimonial->title }}" placeholder="e.g., John Doe - Trader Review">
                    <span class="text-danger small json-error" id="error-title"></span>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1" {{ $testimonial->is_active == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $testimonial->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <span class="text-danger small json-error" id="error-is_active"></span>
                </div>

                <div class="col-12">
                    <label class="form-label">YouTube Video Link</label>
                    <input type="url" name="video_url" id="video_url" class="form-control" value="{{ $testimonial->video_url }}" placeholder="e.g., https://www.youtube.com/watch?v=... or https://youtu.be/...">
                    <small class="text-muted d-block mt-1">Current clean stored structure link: <code class="text-success">{{ $testimonial->video_url }}</code></small>
                    <span class="text-danger small json-error" id="error-video_url"></span>
                </div>

            </div>

            <div class="mt-4 pt-2 text-end">
                <button type="submit" id="submitBtn" class="btn btn-save">
                    <i class="fa-solid fa-refresh me-2"></i> Update Testimonial
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // ✅ JQUERY VALIDATION ENGINE FOR TESTIMONIAL EDIT
    $("#testimonialEditForm").validate({
        rules: {
            title: { required: true, minlength: 3 },
            video_url: { required: true, url: true }
        },
        messages: {
            title: {
                required: "Please write a specific title or client name",
                minlength: "The client name must be at least 3 characters long"
            },
            video_url: {
                required: "Please insert a valid video URL context",
                url: "Please declare a valid URL string pattern"
            }
        },
        errorElement: "span",
        errorClass: "text-danger small mt-1 d-block",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        
        submitHandler: function (form) {
            let formData = new FormData(form);
            formData.append('_method', 'PUT'); // Laravel PUT Method Spoofing
            
            // Cleaning Error Messages
            $('.json-error').text('');
            $('.form-control, .form-select').removeClass('is-invalid');
            
            $('#submitBtn').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Syncing Testimonial Updates...');

            $.ajax({
                url: "{{ route('admin.testimonials.update', $testimonial->id) }}",
                type: "POST", // Method spoofing-kaga POST execute pannavendum
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Changes Saved!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = "{{ route('admin.testimonials.index') }}";
                        });
                    }
                },
                error: function (xhr) {
                    $('#submitBtn').prop('disabled', false).html('<i class="fa-solid fa-refresh me-2"></i> Update Testimonial');
                    
                    if (xhr.status === 422) {
                        let response = xhr.responseJSON;
                        
                        if (response.errors) {
                            $.each(response.errors, function (key, value) {
                                $(`#error-${key}`).text(value[0]);
                                $(`#${key}`).addClass('is-invalid');
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sync Failed',
                            text: xhr.responseJSON.message || 'An error occurred while modifying the testimonial master entry.'
                        });
                    }
                }
            });
            return false;
        }
    });

});
</script>
@endsection