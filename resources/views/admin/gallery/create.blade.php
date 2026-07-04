@extends('admin.layouts.app')

@section('page-title', 'Add Gallery')

@section('content')
<style>
    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
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

    .preview-box {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 10px;
        display: inline-block;
        background: #f8fafc;
        min-width: 120px;
        min-height: 120px;
        text-align: center;
    }

    #imagePreview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        display: none;
    }

    .preview-placeholder {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 45px;
    }

    .btn-save {
        background-color: #166534;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
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
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Add New Gallery</h4>
                <p class="text-muted small mb-0">Upload images into the media master storage.</p>
            </div>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 10px; font-weight: 500;">
                <i class="fa fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <form id="galleryForm" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label">Gallery Title / Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter image or gallery name">
                    <span class="text-danger small json-error" id="error-name"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Select Category <span class="text-muted small fw-normal">(Optional)</span></label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Choose Category</option>
                        {{-- @foreach($categories as $cat)
                            <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
                        @endforeach --}}
                    </select>
                    <span class="text-danger small json-error" id="error-category"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                    <div class="form-text text-muted mt-1" style="font-size: 11px;">Supports JPG, PNG, WebP up to 2MB.</div>
                    <span class="text-danger small json-error" id="error-image"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <span class="text-danger small json-error" id="error-status"></span>
                </div>

                <div class="col-12">
                    <label class="form-label d-block">Image Preview</label>
                    <div class="preview-box">
                        <div class="preview-placeholder" id="placeholderText">No image chosen</div>
                        <img id="imagePreview" src="">
                    </div>
                </div>

            </div>

            <div class="mt-4 pt-2">
                <button type="submit" id="submitBtn" class="btn btn-save">
                    <i class="fa fa-cloud-arrow-up me-2"></i> Save to Gallery
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // ✅ LIVE IMAGE PREVIEW
    $('#imageInput').change(function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#placeholderText').hide();
            $('#imagePreview').attr('src', e.target.result).fadeIn();
        }
        if (this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        } else {
            $('#imagePreview').hide();
            $('#placeholderText').show();
        }
    });

    // ✅ JQUERY VALIDATION (Only client side primary check)
    $("#galleryForm").validate({
        rules: {
            name: { required: true, minlength: 2 },
            image: { required: true },
            status: { required: true }
        },
        messages: {
            name: "Please enter gallery title",
            image: "Please upload an image file",
            status: "Please select status"
        },
        errorElement: "span",
        errorClass: "text-danger small mt-1 d-block",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        
        // JQuery Valid ஆன பிறகு சப்மிட்டை தடுத்து AJAX மூலம் அனுப்பும் பகுதி:
        submitHandler: function (form) {
            
            let formData = new FormData(form);
            
            // கிளீனிங் எரர் டெக்ஸ்ட்கள்
            $('.json-error').text('');
            $('.form-control, .form-select').removeClass('is-invalid');
            
            // டிஸேபிள் பட்டன் (டபுள் கிளிக் தடுக்க)
            $('#submitBtn').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving...');

            $.ajax({
                url: "{{ route('admin.galleries.store') }}",
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        // ஸ்வீட் அலர்ட் மூலமாக மெசேஜ் காட்டி இன்டெக்ஸ் பக்கத்திற்கு ரீடைரக்ட் செய்தல்
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = "{{ route('admin.galleries.index') }}";
                        });
                    }
                },
                error: function (xhr) {
                    // பட்டனை பழைய நிலைக்கு கொண்டு வருதல்
                    $('#submitBtn').prop('disabled', false).html('<i class="fa fa-cloud-arrow-up me-2"></i> Save to Gallery');
                    
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        
                        // லாராவெல் கொடுக்கும் அனைத்து வேலிடேஷன் எரர்களையும் லூப் செய்து காட்டுதல்
                        $.each(errors, function (key, value) {
                            $(`#error-${key}`).text(value[0]);
                            $(`#${key}`).addClass('is-invalid');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.'
                        });
                    }
                }
            });
            return false; // Prevent traditional html redirect submission
        }
    });

});
</script>
@endsection