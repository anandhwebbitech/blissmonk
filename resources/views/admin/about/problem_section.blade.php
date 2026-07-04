@extends('admin.layouts.app')

@section('content')
<style>
    /* Google Fonts & Modern Standard Typography */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .editor-clean-wrapper {
        background-color: #f8fafc; /* Light Slate Background */
        padding: 2rem;
        border-radius: 16px;
        font-family: 'Inter', sans-serif !important;
    }
    
    .editor-section-card {
        background: #ffffff;
        border-radius: 12px;
        color: #1e293b;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    
    /* Elegant Accent Borders */
    .accent-primary { border-top: 4px solid #3b82f6; }
    .accent-success { border-top: 4px solid #10b981; }

    /* Form Labels styling */
    .editor-clean-wrapper label {
        font-family: 'Inter', sans-serif !important;
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
    }

    /* CKEditor Clean Theme Overrides */
    .ck-editor__editable_inline {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #1e293b !important;
        font-family: 'Inter', sans-serif !important;
        min-height: 180px;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        padding: 1rem 1.25rem !important;
    }
    .ck-editor__editable_inline:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .ck-toolbar {
        background: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        border-bottom: none !important;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
    }

    .display-fade {
        animation: fadeInEffect 0.3s ease-in-out;
    }
    @keyframes fadeInEffect {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Page Content Editor</h1>
            <p class="text-muted small mb-0">Unga website section-in text matrum lists-ai keezhe ulla CKEditor-il neradiyaga maatri save seithukollalam.</p>
        </div>
    </div>

    <!-- Main Live-Editor Form Wrapper -->
    <form id="problem-section-form" enctype="multipart/form-data" novalidate>
        @csrf
        
        <div class="editor-clean-wrapper shadow-sm">
            <div class="container-fluid p-0">
                
                <!-- SECTION 1: Main Challenge Area (Accent Primary Blue) -->
                <div class="editor-section-card accent-primary p-4">
                    <h5 class="fw-bold text-primary mb-4 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-pen-to-square"></i> Main Banner & Challenges Section
                    </h5>

                    <div class="row g-4">
                        <!-- Left Side Rich Content Area -->
                        <div class="col-lg-7">
                            <!-- Heading Input -->
                            <div class="mb-4">
                                <label class="form-label mb-1">Main Question Heading</label>
                                <input type="text" name="heading" id="heading" class="form-control py-2" style="border-radius: 8px;"
                                       value="{{ $problem->heading ?? 'Are You Tired Of Working Hard In Trading But Seeing Little To No Results?' }}" required>
                                <div class="text-danger small mt-1 error-message" id="error-heading"></div>
                            </div>

                            <!-- Subheading Lead Text -->
                            <div class="mb-4">
                                <label class="form-label mb-1">Subheading Lead Text</label>
                                <input type="text" name="subheading_lead" id="subheading_lead" class="form-control py-2 text-muted" style="border-radius: 8px;"
                                       value="{{ $problem->subheading_lead ?? 'Maybe you\'ve been here before...' }}" required>
                                <div class="text-danger small mt-1 error-message" id="error-subheading_lead"></div>
                            </div>

                            <!-- Integrated CKEditor 1: Challenges List & Context -->
                            <div class="mb-4">
                                <label class="form-label mb-2">Challenges Content Area (Good Steps, Breaks, and Failure Loops)</label>
                                <p class="text-muted small mb-2"><i class="fa-solid fa-circle-info"></i> Enter your custom text here. Use the toolbar's **Bulleted List** icon to format your good steps or failure loops easily.</p>
                                <textarea name="challenges_rich_content" id="challenges_rich_content" class="form-control ck-editor-target" required>
                                    @if(!empty($problem->challenges_rich_content))
                                        {!! $problem->challenges_rich_content !!}
                                    @else
                                        <p><strong>GOOD STEPS LOOP:</strong></p>
                                        <ul>
                                            <li>You start the week motivated.</li>
                                            <li>You find a few setups.</li>
                                            <li>You enter trades.</li>
                                        </ul>
                                        <p><strong>Then suddenly...</strong></p>
                                        <p><strong>FAILURE LOOP DETAILS:</strong></p>
                                        <ul>
                                            <li>You overtrade.</li>
                                            <li>You break your rules.</li>
                                            <li>You chase losses.</li>
                                            <li>You risk too much trying to recover.</li>
                                        </ul>
                                    @endif
                                </textarea>
                                <div class="text-danger small mt-1 error-message" id="error-challenges_rich_content"></div>
                            </div>

                            <!-- Footer text -->
                            <div class="mb-2">
                                <label class="form-label mb-1">Section End Note (Footer Text)</label>
                                <input type="text" name="footer_text" id="footer_text" class="form-control py-2" style="border-radius: 8px;"
                                       value="{{ $problem->footer_text ?? 'And before you know it, another month is gone.' }}" required>
                                <div class="text-danger small mt-1 error-message" id="error-footer_text"></div>
                            </div>
                        </div>

                        <!-- Right Side Image Block -->
                        <div class="col-lg-5">
                            <div class="p-4 rounded-3 h-100 d-flex flex-column justify-content-center" style="background: #f1f5f9; border: 1px solid #e2e8f0;">
                                <label class="form-label mb-3 d-flex align-items-center gap-2"><i class="fa-solid fa-image text-primary"></i> Section Media Showcase</label>
                                
                                <div class="text-center mb-4 bg-white p-3 rounded-3 border">
                                    @if(!empty($problem->image))
                                        <img src="{{ asset($problem->image) }}" class="img-fluid rounded-2" style="max-height: 200px; object-fit: contain;" alt="Showcase Media">
                                    @else
                                        <div class="py-5 text-muted small">
                                            <i class="fa-solid fa-chart-pie fs-1 d-block mb-2 text-secondary"></i>
                                            No asset uploaded. Default placeholder will render live.
                                        </div>
                                    @endif
                                </div>

                                <input type="file" name="image" id="image" class="form-control">
                                <div class="text-danger small mt-1 error-message" id="error-image"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Deep Dive Insights & Call to Action (Accent Success Green) -->
                <div class="editor-section-card accent-success p-4">
                    <h5 class="fw-bold text-success mb-4 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> Detailed Breakdowns & CTA
                    </h5>

                    <div class="row g-4">
                        <!-- Left Dynamic Column (Old Blue Card Content) -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label mb-1">Left Card Title</label>
                                <input type="text" name="worst_part_title" id="worst_part_title" class="form-control py-2 fw-bold" style="border-radius: 8px;"
                                       value="{{ $problem->worst_part_title ?? 'The worst part?' }}" required>
                                <div class="text-danger small mt-1 error-message" id="error-worst_part_title"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label mb-2">Description and Details Box</label>
                                <textarea name="worst_part_desc_content" id="worst_part_desc_content" class="form-control ck-editor-target" required>
                                    @if(!empty($problem->worst_part_desc_content))
                                        {!! $problem->worst_part_desc_content !!}
                                    @else
                                        <p>You know trading can change your financial future. You know people are getting funded. You know traders are receiving payouts from prop firms.</p>
                                        <p>But somehow... You're still stuck trying to figure out what actually works.</p>
                                    @endif
                                </textarea>
                                <div class="text-danger small mt-1 error-message" id="error-worst_part_desc_content"></div>
                            </div>
                        </div>

                        <!-- Right Dynamic Column (Old Green Card Content + Questions) -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label mb-1">Right Card Title</label>
                                <input type="text" name="wondering_title" id="wondering_title" class="form-control py-2 fw-bold" style="border-radius: 8px;"
                                       value="{{ $problem->wondering_title ?? 'Deep down, you\'re wondering:' }}" required>
                                <div class="text-danger small mt-1 error-message" id="error-wondering_title"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label mb-2">Target Questions & Action Invitation Block</label>
                                <textarea name="wondering_rich_content" id="wondering_rich_content" class="form-control ck-editor-target" required>
                                    @if(!empty($problem->wondering_rich_content))
                                        {!! $problem->wondering_rich_content !!}
                                    @else
                                        <ul>
                                            <li>"Will I ever become consistently profitable?"</li>
                                            <li>"Will I ever pass a prop firm challenge?"</li>
                                            <li>"Will I ever trade larger capital without risking my own money?"</li>
                                        </ul>
                                        <p><em>If this sounds familiar... This webinar was created specifically for you.</em></p>
                                    @endif
                                </textarea>
                                <div class="text-danger small mt-1 error-message" id="error-wondering_rich_content"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Fixed Save Button Panel bottom bar -->
        <div class="card mt-4 border-0 shadow-sm p-3 bg-white" style="border-radius: 12px; border: 1px solid #e2e8f0 !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="text-muted small"><i class="fa-solid fa-circle-check text-success me-1"></i> Changes configured through rich-text editor editors sync automatically upon application saving.</span>
                <button type="submit" id="submit-btn" class="btn btn-primary px-5 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes & Apply Live
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 Plugin Injection -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CKEditor 5 Classic CDN Component Injection -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@36.0.1/build/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        
        // Initialize CKEditor instances globally and hold references
        let editors = {};
        $('.ck-editor-target').each(function() {
            let id = $(this).attr('id');
            ClassicEditor
                .create(this, {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
                })
                .then(editor => {
                    editors[id] = editor;
                })
                .catch(error => {
                    console.error('CKEditor Initialization Error on target #' + id, error);
                });
        });

        // Form AJAX Handle Script Data mapping block
        $('#problem-section-form').on('submit', function(e) {
            e.preventDefault();
            $('.error-message').text('');
            
            let btn = $('#submit-btn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Saving updates...');

            // Explicitly sync CKEditor data back to textarea elements before dispatching
            for (let id in editors) {
                if (editors.hasOwnProperty(id)) {
                    $('#' + id).val(editors[id].getData());
                }
            }

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.problem.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Save Changes & Apply Live');
                    if(response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Database Updated Successfully!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Save Changes & Apply Live');
                    
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            let errorKey = key.replace(/\./g, '_');
                            $('#error-' + errorKey).text(value[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please clear missing configuration fields.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong while routing data package to controller.'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection