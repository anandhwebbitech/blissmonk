@extends('admin.layouts.app')

@section('page-title', 'Email Template Settings')

@section('content')
<style>
    .control-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.01);
    }
    .btn-save {
        background-color: #0d6efd;
        color: #ffffff;
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 10px;
    }
    .btn-save:hover { background-color: #0b5ed7; color: #ffffff; }
    /* CKEditor editable area styling height fix */
    .ck-editor__editable_inline { 
        min-height: 160px !important; 
        background-color: #ffffff !important;
        color: #000000 !important;
    }
</style>

<div class="container-fluid py-2">
    <div class="control-card">
        <div class="mb-4">
            <h4 class="fw-bold mb-1" style="color: #0f172a;">Webinar Confirmation Email Builder</h4>
            <p class="text-muted small">Update email text blocks, learning points, and corporate footer signatures dynamically.</p>
        </div>

        <form id="template-form" method="POST" action="{{ route('admin.email-template.store') }}">
            @csrf

            <div class="row">
                <!-- Mail Subject -->
                <div class="mb-4 col-12">
                    <label class="form-label fw-bold">Email Subject Line</label>
                    <input type="text" name="subject" class="form-control" value="{{ $template->subject ?? "🎉 You're Registered! Welcome to the Prop Trading Mastery Webinar" }}" required>
                </div>

                <!-- Section 1: During This LIVE Session You'll Learn -->
                <div class="mb-4 col-md-6">
                    <label class="form-label fw-bold text-success">📋 During This LIVE Session You'll Learn (Ordered List)</label>
                    <textarea name="what_you_will_learn" id="editor-learn" class="form-control">{{ $template->what_you_will_learn ?? '' }}</textarea>
                </div>

                <!-- Section 2: Before the Webinar -->
                <div class="mb-4 col-md-6">
                    <label class="form-label fw-bold text-warning">💡 Before the Webinar (Ordered List)</label>
                    <textarea name="before_webinar" id="editor-before" class="form-control">{{ $template->before_webinar ?? '' }}</textarea>
                </div>

                <!-- Section 3: Dynamic Custom Note -->
                <div class="mb-4 col-12">
                    <div class="alert alert-secondary py-2 mb-2 small" style="background-color: #f8fafc;">
                        <i class="fa-solid fa-circle-info me-2 text-primary"></i><strong>Available Shortcodes:</strong> 
                        Use <code>@{{name}}</code>, <code>@{{phone}}</code>, <code>@{{email}}</code>, or <code>@{{city}}</code> inside this custom box.
                    </div>
                    <label class="form-label fw-bold text-primary">🔵 Custom Highlight Note Area</label>
                    <textarea name="body_content" id="editor-note" class="form-control">{{ $template->body_content ?? '' }}</textarea>
                </div>

                <div class="col-12"><h6 class="fw-bold text-dark mt-2 mb-3"><i class="fa-solid fa-signature me-2"></i>Footer Contact Info</h6></div>

                <!-- Signatures Detail Panels -->
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Company Name</label>
                    <input type="text" name="company_name" class="form-control" value="{{ $template->company_name ?? 'Bliss Monk Tech Solutionsz' }}" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Support Email ID</label>
                    <input type="email" name="company_email" class="form-control" value="{{ $template->company_email ?? 'bharath@blissmonktech.com' }}" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Helpline Phone Number</label>
                    <input type="text" name="company_phone" class="form-control" value="{{ $template->company_phone ?? '+91 9894180719' }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-save" id="btn-template-submit">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Update Email Dynamic Components
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- JQuery matrum CKEditor Scripts properly structured -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

<script>
$(document).ready(function() {
    let editorLearn, editorBefore, editorNote;
    const toolbarConfig = { 
        toolbar: [ 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'undo', 'redo' ] 
    };

    // Safe Initialization Wrapper function
    function initCKEditors() {
        if (typeof ClassicEditor === 'undefined') {
            console.error('CKEditor Script missing or failed to load from CDN.');
            return;
        }

        // 1. Editor Learn
        ClassicEditor.create(document.querySelector('#editor-learn'), toolbarConfig)
            .then(editor => {
                editorLearn = editor;
                if(editor.getData().trim() === "") {
                    editor.setData(`<ol><li>How Professional Prop Traders Think &amp; Trade</li><li>Common Mistakes That Prevent Traders from Becoming Consistently Profitable</li><li>Risk Management Techniques Used by Successful Traders</li></ol>`);
                }
            }).catch(error => console.error(error));

        // 2. Editor Before
        ClassicEditor.create(document.querySelector('#editor-before'), toolbarConfig)
            .then(editor => {
                editorBefore = editor;
                if(editor.getData().trim() === "") {
                    editor.setData(`<ol><li>Join 10–15 minutes early.</li><li>Ensure you have a stable internet connection.</li><li>Keep a notebook ready.</li><li>Attend from a quiet location.</li></ol>`);
                }
            }).catch(error => console.error(error));

        // 3. Editor Note
        ClassicEditor.create(document.querySelector('#editor-note'), toolbarConfig)
            .then(editor => {
                editorNote = editor;
            }).catch(error => console.error(error));
    }

    // Run initialization
    initCKEditors();

    // AJAX Form submit sync
    $('#template-form').on('submit', function(e) {
        e.preventDefault();

        // Sync data from CKEditor instances to textareas before form posting
        if(editorLearn) $('#editor-learn').val(editorLearn.getData());
        if(editorBefore) $('#editor-before').val(editorBefore.getData());
        if(editorNote) $('#editor-note').val(editorNote.getData());

        let formData = new FormData(this);
        $('#btn-template-submit').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving Layout...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#btn-template-submit').prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Update Email Dynamic Components');
                if (response.status) {
                    Swal.fire({ icon: 'success', title: 'Saved!', text: response.message, showConfirmButton: false, timer: 2000 });
                } else {
                    Swal.fire({ icon: 'error', title: 'Failed', text: response.message || 'Something went wrong.' });
                }
            },
            error: function() {
                $('#btn-template-submit').prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Update Email Dynamic Components');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong while saving.' });
            }
        });
    });
});
</script>
@endsection