@extends('admin.layouts.app')

@section('page-title', 'Edit Webinar')

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

    /* Premium Banner Dropzone/Preview styling */
    .image-preview-wrapper {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 15px;
        background: #f8fafc;
        text-align: center;
        position: relative;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: border-color 0.2s ease;
    }

    .image-preview-wrapper:hover {
        border-color: #166534;
    }

    #bannerPreview {
        max-width: 100%;
        max-height: 180px;
        border-radius: 8px;
        object-fit: cover;
    }

    .upload-placeholder {
        color: #64748b;
    }

    .upload-placeholder i {
        font-size: 32px;
        color: #94a3b8;
        margin-bottom: 10px;
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
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Edit Scheduled Webinar</h4>
                <p class="text-muted small mb-0">Modify the timing, speaker credentials, or updating meeting stream targets.</p>
            </div>
            <a href="{{ route('admin.webinars.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 10px; font-weight: 500;">
                <i class="fa fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <form id="webinarEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- Webinar Title -->
                <div class="col-md-8">
                    <label class="form-label">Webinar Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $webinar->title }}" placeholder="Enter webinar title">
                    <span class="text-danger small json-error" id="error-title"></span>
                </div>

                <!-- Status -->
                <div class="col-md-4">
                    <label class="form-label">Webinar Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="upcoming" {{ $webinar->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="live" {{ $webinar->status == 'live' ? 'selected' : '' }}>Live</option>
                        <option value="completed" {{ $webinar->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <span class="text-danger small json-error" id="error-status"></span>
                </div>

                <!-- Speaker Name -->
                <div class="col-md-5">
                    <label class="form-label">Speaker / Host Name</label>
                    <input type="text" name="speaker_name" id="speaker_name" class="form-control" value="{{ $webinar->speaker_name }}" placeholder="Enter speaker name">
                    <span class="text-danger small json-error" id="error-speaker_name"></span>
                </div>

                <!-- Date & Time -->
                <div class="col-md-4">
                    <label class="form-label">Webinar Schedule (Date & Time)</label>
                    <input type="datetime-local" name="webinar_date" id="webinar_date" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($webinar->webinar_date)) }}">
                    <span class="text-danger small json-error" id="error-webinar_date"></span>
                </div>

                <!-- Duration -->
                <div class="col-md-3">
                    <label class="form-label">Duration (Minutes)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" value="{{ $webinar->duration_minutes }}" min="1">
                    <span class="text-danger small json-error" id="error-duration_minutes"></span>
                </div>

                <!-- Streaming / Meeting Link -->
                <div class="col-12">
                    <label class="form-label">Meeting URL (Zoom / Google Meet / Youtube Link)</label>
                    <input type="url" name="meeting_link" id="meeting_link" class="form-control" value="{{ $webinar->meeting_link }}" placeholder="https://zoom.us/j/... or live stream URL">
                    <span class="text-danger small json-error" id="error-meeting_link"></span>
                </div>

                <!-- Brief Description -->
                <div class="col-md-7">
                    <label class="form-label">Session Description</label>
                    <textarea name="description" id="description" class="form-control" rows="8" placeholder="Outline the topics covered in this masterclass...">{{ $webinar->description }}</textarea>
                    <span class="text-danger small json-error" id="error-description"></span>
                </div>

                <!-- Banner Image Upload with Current Preview Check -->
                <div class="col-md-5">
                    <label class="form-label">Webinar Banner Cover</label>
                    <div class="image-preview-wrapper" onclick="$('#bannerInput').click();">
                        <div class="upload-placeholder" id="uploadText" style="{{ $webinar->banner_image ? 'display: none;' : '' }}">
                            <i class="fa-regular fa-image d-block"></i>
                            <span class="fw-semibold text-primary">Click to update image</span> or drag and drop<br>
                            <small class="text-muted">PNG, JPG or JPEG (Max: 5MB)</small>
                        </div>
                        <img id="bannerPreview" 
                            src="{{ $webinar->banner_image ? asset('upload/banner_image/' . $webinar->banner_image) : '' }}"     
                             alt="Banner Preview" 
                             style="{{ $webinar->banner_image ? 'display: block;' : 'display: none;' }}">
                    </div>
                    <input type="file" name="banner_image" id="bannerInput" class="d-none" accept="image/*">
                    <span class="text-danger small json-error" id="error-banner_image"></span>
                </div>

            </div>

            <div class="mt-4 pt-2 text-end">
                <button type="submit" id="submitBtn" class="btn btn-save">
                    <i class="fa fa-refresh me-2"></i> Update Webinar Details
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // ✅ LIVE IMAGE PREVIEW REPLACEMENT
    $('#bannerInput').on('change', function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $('#uploadText').hide();
                $('#bannerPreview').attr('src', event.target.result).show();
            }
            reader.readAsDataURL(file);
        }
    });

    // ✅ JQUERY VALIDATION ENGINE
    $("#webinarEditForm").validate({
        rules: {
            title: { required: true, minlength: 5 },
            speaker_name: { required: true },
            webinar_date: { required: true },
            duration_minutes: { required: true, digits: true },
            meeting_link: { required: true, url: true },
            status: { required: true }
        },
        messages: {
            title: "Please enter a descriptive webinar title",
            speaker_name: "Please specify the speaker name",
            webinar_date: "Please select a valid schedule date & time",
            duration_minutes: "Please input valid duration in minutes",
            meeting_link: "Please provide a valid meeting URL (e.g., Zoom link)",
            status: "Please choose an active status"
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
            formData.append('_method', 'PUT'); 
            $('.json-error').text('');
            $('.form-control, .form-select').removeClass('is-invalid');
            
            $('#submitBtn').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Syncing Updates...');

            $.ajax({
                url: "{{ route('admin.webinars.update', $webinar->id) }}",
                type: "POST", 
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
                            window.location.href = "{{ route('admin.webinars.index') }}";
                        });
                    }
                },
                error: function (xhr) {
                    $('#submitBtn').prop('disabled', false).html('<i class="fa fa-refresh me-2"></i> Update Webinar Details');
                    
                    if (xhr.status === 422) {
                        let response = xhr.responseJSON;
                        if (response.message && !response.errors) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Duplicate Live Session',
                                text: response.message,
                                confirmButtonColor: '#166534'
                            });
                        } 
                        else if (response.errors) {
                            $.each(response.errors, function (key, value) {
                                $(`#error-${key}`).text(value[0]);
                                $(`#${key}`).addClass('is-invalid');
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sync Failed',
                            text: xhr.responseJSON.message || 'Something went wrong while modifying the database entry.'
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