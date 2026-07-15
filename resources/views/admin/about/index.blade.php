@extends('admin.layouts.app')

@section('page-title', 'Who We Are & Expertise Section')

@section('content')
<style>
    .preview-container {
        background-color: #0b0f12;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }
    .text-preview-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 35px;
        height: 100%;
        min-height: 380px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .preview-title {
        color: #4ade80; 
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }
    .preview-desc {
        color: #9ca3af;
        line-height: 1.8;
        font-size: 15px;
        font-weight: 400;
        white-space: pre-line;
    }
    .image-preview-box {
        border-radius: 15px;
        overflow: hidden;
        width: 100%;
        height: 100%;
        min-height: 380px;
        background: #1e293b;
    }
    .image-preview-box img {
        width: 100%;
        height: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 15px;
    }
    .expertise-preview-box {
        background: #0d1216;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 40px;
        margin-top: 25px;
    }
    .exp-live-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .exp-live-title .text-green { color: #4ade80; }
    .exp-live-title .text-white { color: #ffffff; margin-left: 8px; }
    .exp-live-p {
        color: #9ca3af;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 30px;
    }
    .expertise-grid-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
    .expertise-item-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-left: 3px solid #ef4444; 
        border-radius: 10px;
        padding: 20px;
        color: #e2e8f0;
        font-size: 14px;
        font-weight: 500;
        min-height: 80px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    .expertise-item-card:nth-child(even) {
        border-left-color: #4ade80;
    }
    .control-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.01);
    }
    .btn-update {
        background-color: #166534;
        color: #ffffff;
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 10px;
    }
    .btn-update:hover { background-color: #14532d; color: #ffffff; }
    .item-row {
        background: #f8fafc;
        padding: 10px;
        border-radius: 12px;
        margin-bottom: 10px;
        border: 1px solid #e2e8f0;
    }
    /* Media Preview Wrapper Style */
    .media-preview-wrapper {
        position: relative;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 10px;
        background: #f8fafc;
        margin-top: 10px;
    }
    .btn-remove-media {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }
    .btn-remove-media:hover { background: #dc2626; transform: scale(1.05); }
</style>

<div class="container-fluid py-2">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item active">Who We Are Master</li>
        </ol>
    </nav>

    <div class="control-card">
        <div class="mb-4">
            <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Update Section Details</h4>
            <p class="text-muted small mb-0">Modify fields below. Changes will sync up instantly in the premium preview panel.</p>
        </div>

        <form id="about-form" method="POST" action="{{ route('admin.abouts.store') }}" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="remove_image" id="remove-image-flag" value="0">
            <input type="hidden" name="remove_video" id="remove-video-flag" value="0">

            <div class="row mb-4">
                <div class="col-12"><h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-address-card me-2"></i>Primary Content</h5></div>
                
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Heading Title</label>
                    <input type="text" name="title" id="input-title" class="form-control" value="{{ $about->title ?? 'Who we are' }}" required>
                    <div class="text-danger small mt-1 error-message" id="error-title"></div>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Replace Section Image</label>
                    <input type="file" name="image" id="input-image" class="form-control" accept="image/*">
                    <div class="text-danger small mt-1 error-message" id="error-image"></div>
                    
                    <div class="media-preview-wrapper id-img-box" style="{{ !empty($about->image) ? '' : 'display:none;' }}">
                        <button type="button" class="btn-remove-media" id="action-remove-image" title="Remove Image"><i class="fa-solid fa-trash-can"></i></button>
                        <img src="{{ !empty($about->image) ? asset($about->image) : '' }}" id="form-img-preview" class="img-fluid rounded" style="max-height: 150px; width: 100%; object-fit: cover;">
                    </div>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">YouTube Video Link</label>
                    <input type="url" name="video_url" id="input-video-url" class="form-control" value="{{ $about->video_url ?? '' }}" placeholder="https://www.youtube.com/watch?v=...">
                    <div class="text-danger small mt-1 error-message" id="error-video_url"></div>
                    
                    <div class="media-preview-wrapper id-video-box" style="{{ !empty($about->video_url) ? '' : 'display:none;' }}">
                        <button type="button" class="btn-remove-media" id="action-remove-video" title="Remove Video Link"><i class="fa-solid fa-trash-can"></i></button>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $about->video_url ?? '' }}" id="form-video-preview" allowfullscreen style="border-radius: 8px;"></iframe>
                        </div>
                    </div>
                </div>

                <div class="mb-3 col-md-12">
                    <label class="form-label fw-bold">Description Content</label>
                    <textarea name="description" id="input-desc" class="form-control" rows="4" required>{{ $about->description ?? '' }}</textarea>
                    <div class="text-danger small mt-1 error-message" id="error-description"></div>
                </div>
            </div>

            <hr class="my-4" style="border-top: 1px dashed #cbd5e1;">

            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-danger mb-0"><i class="fa-solid fa-brain me-2"></i>Our Expertise Section</h5>
                    <button type="button" class="btn btn-sm btn-dark" id="add-item-btn" style="border-radius: 8px;">
                        <i class="fa-solid fa-plus me-1"></i> Add Expertise Item
                    </button>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Expertise Section Title</label>
                    <input type="text" name="expertise_title" id="input-exp-title" class="form-control" value="{{ $about->expertise_title ?? 'Our Expertise' }}" required>
                    <div class="text-danger small mt-1 error-message" id="error-expertise_title"></div>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Expertise Subtitle / Focus</label>
                    <input type="text" name="expertise_subtitle" id="input-exp-subtitle" class="form-control" value="{{ $about->expertise_subtitle ?? 'Prop Trading Excellence' }}" required>
                    <div class="text-danger small mt-1 error-message" id="error-expertise_subtitle"></div>
                </div>

                <div class="mb-3 col-md-12">
                    <label class="form-label fw-bold">Expertise Description Paragraph</label>
                    <textarea name="expertise_description" id="input-exp-desc" class="form-control" rows="3" required>{{ $about->expertise_description ?? 'We specialize...' }}</textarea>
                    <div class="text-danger small mt-1 error-message" id="error-expertise_description"></div>
                </div>

                <div class="mb-3 col-md-12">
                    <label class="form-label fw-bold mb-2">Expertise Items (Manage Fields)</label>
                    <div id="expertise-items-container">
                        @if(!empty($about->expertise_items) && is_array($about->expertise_items))
                            @foreach($about->expertise_items as $item)
                                <div class="d-flex align-items-center item-row">
                                    <input type="text" name="expertise_items[]" class="form-control exp-item-input me-2" value="{{ $item }}" required>
                                    <button type="button" class="btn btn-danger remove-item-btn"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex align-items-center item-row">
                                <input type="text" name="expertise_items[]" class="form-control exp-item-input me-2" value="Funded Account & Prop Firm Strategies" required>
                                    <button type="button" class="btn btn-danger remove-item-btn"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        @endif
                    </div>
                    <div class="text-danger small mt-1 error-message" id="error-expertise_items"></div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-update" id="btn-submit">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Save & Apply Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    
    function updateLiveExpertiseGrid() {
        let gridContainer = $('#live-expertise-grid');
        if(gridContainer.length === 0) return;
        gridContainer.empty();

        $('.exp-item-input').each(function() {
            let val = $(this).val();
            if(val.trim() !== "") {
                let cardHtml = `<div class="expertise-item-card">${val}</div>`;
                gridContainer.append(cardHtml);
            }
        });
    }

    // YouTube URL-ல் இருந்து Video ID மற்றும் Embed URL எடுப்பதற்கான பொதுவான ஃபங்ஷன்
    function getEmbedUrl(url) {
        if (!url) return '';
        
        // ஏற்கனவே embed URL ஆக இருந்தால் அதை அப்படியே ரிட்டர்ன் செய்யும்
        if (url.includes('youtube.com/embed/')) {
            return url;
        }

        let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        let match = url.match(regExp);
        
        if (match && match[2].length === 11) {
            return "https://www.youtube.com/embed/" + match[2];
        }
        return '';
    }

    // Page Load ஆகும்போதே வீடியோ ப்ரீவியூவைச் சரி செய்யும் லாஜிக்
    function initVideoPreview() {
        let initialUrl = $('#input-video-url').val();
        if (initialUrl) {
            let embedUrl = getEmbedUrl(initialUrl);
            if (embedUrl) {
                $('#form-video-preview').attr('src', embedUrl);
                $('.id-video-box').show();
                $('#remove-video-flag').val('0');
            } else {
                $('.id-video-box').hide();
            }
        } else {
            $('.id-video-box').hide();
        }
    }

    // Page load-ல் ஃபங்ஷனை ரன் செய்யவும்
    initVideoPreview();

    // பயனர் புதிய லிங்க் டைப் செய்யும்போதும் ப்ரீவியூ மாறும்
    $('#input-video-url').on('input', function() {
        let url = $(this).val();
        let embedUrl = getEmbedUrl(url);
        
        if (embedUrl) {
            $('#form-video-preview').attr('src', embedUrl);
            $('.id-video-box').fadeIn(200);
            $('#remove-video-flag').val('0');
        } else {
            if (url === '') {
                $('.id-video-box').fadeOut(200);
                $('#form-video-preview').attr('src', '');
            }
        }
    });

    // Remove Image பட்டன் 
    $('#action-remove-image').on('click', function() {
        $('#input-image').val(''); 
        $('.id-img-box').fadeOut(200); 
        $('#remove-image-flag').val('1'); 
        $('#live-image').attr('src', ''); 
    });

    // Remove Video பட்டன்
    $('#action-remove-video').on('click', function() {
        $('#input-video-url').val(''); 
        $('.id-video-box').fadeOut(200); 
        $('#form-video-preview').attr('src', ''); 
        $('#remove-video-flag').val('1'); 
    });

    $('#input-image').on('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#form-img-preview').attr('src', e.target.result);
                $('.id-img-box').fadeIn(200);
                $('#remove-image-flag').val('0'); 
                
                if($('#live-image').length) {
                    $('#live-image').attr('src', e.target.result);
                }
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Sync Text Control bindings
    $('#input-title').on('input', function() { $('#live-title').text($(this).val() || 'Who we are'); });
    $('#input-desc').on('input', function() { $('#live-desc').text($(this).val() || 'Enter description'); });
    $('#input-exp-title').on('input', function() { $('#live-exp-title').text($(this).val() || 'Our Expertise'); });
    $('#input-exp-subtitle').on('input', function() { $('#live-exp-subtitle').text($(this).val() || 'Focus Subtitle'); });
    $('#input-exp-desc').on('input', function() { $('#live-exp-desc').text($(this).val() || 'Expertise intro.'); });
    $(document).on('input', '.exp-item-input', function() { updateLiveExpertiseGrid(); });

    $('#add-item-btn').on('click', function() {
        let newRow = `
            <div class="d-flex align-items-center item-row" style="display:none;">
                <input type="text" name="expertise_items[]" class="form-control exp-item-input me-2" required placeholder="Enter new expertise point...">
                <button type="button" class="btn btn-danger remove-item-btn"><i class="fa-solid fa-trash"></i></button>
            </div>`;
        $(newRow).appendTo('#expertise-items-container').fadeIn(200);
        updateLiveExpertiseGrid();
    });

    $(document).on('click', '.remove-item-btn', function() {
        if ($('#expertise-items-container .item-row').length > 1) {
            $(this).closest('.item-row').fadeOut(200, function() {
                $(this).remove();
                updateLiveExpertiseGrid();
            });
        } else {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'You must keep at least one expertise item!' });
        }
    });

    $('#about-form').on('submit', function(e) {
        e.preventDefault(); 
        $('.error-message').text('');
        
        let formData = new FormData(this); 
        $('#btn-submit').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#btn-submit').prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Save & Apply Changes');
                
                if($('#remove-image-flag').val() == '1') $('.id-img-box').hide();
                if($('#remove-video-flag').val() == '1') $('.id-video-box').hide();
                $('#remove-image-flag').val('0');
                $('#remove-video-flag').val('0');

                Swal.fire({ icon: 'success', title: 'Success!', text: 'Settings saved successfully!', showConfirmButton: false, timer: 2000 });
            },
            error: function(xhr) {
                $('#btn-submit').prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Save & Apply Changes');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.title) $('#error-title').text(errors.title[0]);
                    if (errors.image) $('#error-image').text(errors.image[0]);
                    if (errors.video_url) $('#error-video_url').text(errors.video_url[0]); 
                    if (errors.description) $('#error-description').text(errors.description[0]);
                    if (errors.expertise_title) $('#error-expertise_title').text(errors.expertise_title[0]);
                    if (errors.expertise_subtitle) $('#error-expertise_subtitle').text(errors.expertise_subtitle[0]);
                    if (errors.expertise_description) $('#error-expertise_description').text(errors.expertise_description[0]);
                    if (errors.expertise_items) $('#error-expertise_items').text(errors.expertise_items[0]);
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Something went wrong! Please try again.' });
                }
            }
        });
    });
});
</script>
@endsection