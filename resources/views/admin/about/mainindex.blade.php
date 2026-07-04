@extends('admin.layouts.app')

@section('page-title', 'Webinar Hero Section')

@section('content')
<style>
    /* Premium Premium Dark Background Card matching image_ec1761.png */
    .preview-container {
        background-color: #0b0f12;
        background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        background-size: 20px 20px;
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        position: relative;
    }

    .preview-title {
        color: #ffffff; 
        font-weight: 800;
        font-size: 42px;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }

    .preview-subtitle {
        color: #ffffff;
        font-weight: 700;
        font-size: 20px;
        letter-spacing: 0.5px;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .preview-desc {
        color: #9ca3af;
        line-height: 1.8;
        font-size: 16px;
        font-weight: 400;
    }
    
    .preview-desc p {
        margin-bottom: 20px;
    }

    .preview-buttons-flex {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .btn-preview-yellow {
        background-color: #f1c40f;
        background-image: linear-gradient(to bottom, #f39c12, #f1c40f);
        color: #000000;
        font-weight: 700;
        border: none;
        padding: 14px 28px;
        border-radius: 10px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-preview-green {
        background-color: #2ecc71;
        color: #ffffff;
        font-weight: 600;
        border: none;
        padding: 14px 28px;
        border-radius: 10px;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
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

    .btn-update:hover {
        background-color: #14532d;
        color: #ffffff;
    }

    .ck-editor__editable_inline {
        min-height: 250px;
    }
</style>

<div class="container-fluid py-2">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item active">Webinar Hero Setup</li>
        </ol>
    </nav>

   

    <!-- FORM CONTROL PANEL -->
    <div class="control-card">
        <div class="mb-4">
            <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Update Hero Content</h4>
            <p class="text-muted small mb-0">Modify fields below. Add button links and type in text components smoothly.</p>
        </div>

        <form id="hero-form" method="POST" action="{{ route('admin.hero.store') }}">
            @csrf

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Main Header Title</label>
                    <input type="text" name="title" id="input-title" class="form-control" value="{{ $hero->title ?? 'Million Dollar Prop Funded Trader Program' }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Subtitle Accent Line</label>
                    <input type="text" name="subtitle" id="input-subtitle" class="form-control" value="{{ $hero->subtitle ?? 'STOP TRADING YOUR OWN MONEY.' }}" required>
                </div>

                <!-- CKEditor Layout -->
                <div class="mb-4 col-md-12">
                    <label class="form-label fw-bold">Main Description Content Panel (Supports Emojis & Formats)</label>
                    <textarea name="description" id="input-desc" class="form-control" rows="6">{{ $hero->description ?? '' }}</textarea>
                </div>

                <div class="col-12"><h6 class="fw-bold text-success mb-3"><i class="fa-solid fa-link me-2"></i>Action Buttons & Hyperlinks Configuration</h6></div>

                <!-- Register Button Inputs -->
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Register Button Text</label>
                    <input type="text" name="btn_register_text" id="input-btn-register" class="form-control" value="{{ $hero->btn_register_text ?? 'Register For Free Webinar' }}" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Register Redirect URL Link</label>
                    <input type="url" name="btn_register_url" class="form-control" placeholder="https://yourwebsite.com/register" value="{{ $hero->btn_register_url ?? '' }}">
                </div>

                <!-- WhatsApp Button Inputs -->
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">WhatsApp Button Text</label>
                    <input type="text" name="btn_whatsapp_text" id="input-btn-whatsapp" class="form-control" value="{{ $hero->btn_whatsapp_text ?? 'JOIN WHATSAPP GROUP' }}" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">WhatsApp Group URL Link</label>
                    <input type="url" name="btn_whatsapp_url" class="form-control" placeholder="https://chat.whatsapp.com/invitelink" value="{{ $hero->btn_whatsapp_url ?? '' }}">
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
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

<script>
$(document).ready(function() {
    let globalRichEditor;

    ClassicEditor
        .create(document.querySelector('#input-desc'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
        })
        .then(editor => {
            globalRichEditor = editor;
            editor.model.document.on('change:data', () => {
                $('#live-desc').html(editor.getData() || '<p>Enter description content.</p>');
            });

            if(editor.getData().trim() === "") {
                let templateContent = `<p>Become a Disciplined Prop-Funded Trader. Managing $1M+ Capital Without Risking Large Personal Capital.</p><p><strong>⚡ Free Live Webinar</strong> Reveals The Exact Framework Used To Help Retail Traders Transition From Inconsistent Trading To Professional Prop-Funded Trading.</p><p>Learn how to trade Forex, Gold, and Crypto using a proven Buy/Sell Indicator, trade only 30–60 minutes per day, and follow a step-by-step roadmap to scale from a $10K funded account toward managing $1M+ in prop firm capital.</p>`;
                editor.setData(templateContent);
            }
        });
    
    $('#input-title').on('input', function() { $('#live-title').text($(this).val() || 'Million Dollar Prop Funded Trader Program'); });
    $('#input-subtitle').on('input', function() { $('#live-subtitle').text($(this).val() || 'STOP TRADING YOUR OWN MONEY.'); });
    $('#input-btn-register').on('input', function() { $('#live-btn-register').text($(this).val() || 'Register For Free Webinar'); });
    $('#input-btn-whatsapp').on('input', function() { $('#live-btn-whatsapp-text').text($(this).val() || 'JOIN WHATSAPP GROUP'); });

    $('#hero-form').on('submit', function(e) {
        e.preventDefault(); 
        if(globalRichEditor) { $('#input-desc').val(globalRichEditor.getData()); }

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
                if (response.status) {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.message, showConfirmButton: false, timer: 2000 });
                }
            },
            error: function() {
                $('#btn-submit').prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Save & Apply Changes');
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Something went wrong!' });
            }
        });
    });
});
</script>
@endsection 