@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <form id="framework-bonuses-form" enctype="multipart/form-data">
        @csrf
        
        <!-- SECTION 1: FRAMEWORK (zx-) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="m-0"><i class="fa-solid fa-brain me-2 text-warning"></i> 1. Framework Section Configuration (zx-)</h5>
            </div>
            <div class="card-body bg-light">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Framework Section Title</label>
                        <input type="text" name="fw_title" class="form-control mb-3" value="{{ $section->fw_title }}">
                        
                        <label class="form-label fw-bold">Editorial Framework Image Asset</label>
                        <input type="file" name="fw_image" class="form-control">
                    </div>
                    <div class="col-md-4 text-center">
                        @if($section->fw_image)
                            <label class="d-block small text-muted">Active Graphic Asset</label>
                            <img src="{{ asset($section->fw_image) }}" class="img-fluid rounded border bg-dark p-2" style="max-height: 120px;">
                        @endif
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Opening Paragraph</label>
                        <textarea name="fw_paragraph_1" class="form-control" rows="2">{{ $section->fw_paragraph_1 }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Callout Emphasis Text (Light)</label>
                        <input type="text" name="fw_emphasis_light" class="form-control" value="{{ $section->fw_emphasis_light }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Callout Emphasis Text (Bold)</label>
                        <input type="text" name="fw_emphasis_bold" class="form-control" value="{{ $section->fw_emphasis_bold }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Framework List Context Paragraph</label>
                        <input type="text" name="fw_paragraph_2" class="form-control" value="{{ $section->fw_paragraph_2 }}">
                    </div>

                    <!-- Dynamic Framework Pointers List -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-primary">Framework List Items Tracker</label>
                        <div id="fw-list-wrapper">
                            @foreach($section->fw_list_items ?? ['Identify available trading time', 'Match the right market'] as $item)
                                <div class="d-flex mb-2 align-items-center dynamic-row">
                                    <input type="text" name="fw_list_items[]" class="form-control form-control-sm" value="{{ $item }}">
                                    <button type="button" class="btn btn-sm btn-danger ms-2 remove-row-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary append-row-btn" data-target="fw-list-wrapper" data-name="fw_list_items[]"><i class="fa-solid fa-plus me-1"></i>Add Framework Item</button>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Framework Conclusion Summary Block Text</label>
                        <input type="text" name="fw_conclusion" class="form-control" value="{{ $section->fw_conclusion }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- MATRIX PANEL: PERFECT FOR VS NOT FOR -->
        <div class="row g-4 mb-4">
            <!-- Perfect For Container Group -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-success text-white py-2 fw-bold">
                        <input type="text" name="perfect_title" class="form-control form-control-sm bg-transparent border-0 text-white fw-bold" value="{{ $section->perfect_title }}">
                    </div>
                    <div class="card-body bg-light">
                        <div id="perfect-list-wrapper">
                            @foreach($section->perfect_items ?? ['Beginner traders seeking consistency'] as $item)
                                <div class="d-flex mb-2 align-items-center dynamic-row">
                                    <input type="text" name="perfect_items[]" class="form-control form-control-sm" value="{{ $item }}">
                                    <button type="button" class="btn btn-sm btn-danger ms-2 remove-row-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-success append-row-btn" data-target="perfect-list-wrapper" data-name="perfect_items[]"><i class="fa-solid fa-plus"></i> Add Item</button>
                    </div>
                </div>
            </div>

            <!-- Not For Container Group -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-danger text-white py-2 fw-bold">
                        <input type="text" name="not_perfect_title" class="form-control form-control-sm bg-transparent border-0 text-white fw-bold" value="{{ $section->not_perfect_title }}">
                    </div>
                    <div class="card-body bg-light">
                        <div id="not-perfect-list-wrapper">
                            @foreach($section->not_perfect_items ?? ['Get-rich-quick seekers'] as $item)
                                <div class="d-flex mb-2 align-items-center dynamic-row">
                                    <input type="text" name="not_perfect_items[]" class="form-control form-control-sm" value="{{ $item }}">
                                    <button type="button" class="btn btn-sm btn-danger ms-2 remove-row-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-danger append-row-btn" data-target="not-perfect-list-wrapper" data-name="not_perfect_items[]"><i class="fa-solid fa-plus"></i> Add Item</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: EXCLUSIVE WEBINAR BONUSES (trd-) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="m-0"><i class="fa-solid fa-gift d-inline me-2"></i> 2. Exclusive Bonuses Layout Deck (trd-)</h5>
            </div>
            <div class="card-body bg-light">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Main Section Headline Title</label>
                        <input type="text" name="bonus_heading" class="form-control" value="{{ $section->bonus_heading }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-danger">Urgency Alert Indicator Strip Text</label>
                        <input type="text" name="urgent_text" class="form-control" value="{{ $section->urgent_text }}">
                    </div>

                    <!-- Grid Item Grid Content Cards Matrix Setup Dynamic Handling Loop -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-info">Dynamic Bonuses List Tracker</label>
                        <div id="bonus-cards-wrapper" class="row g-2">
                            @foreach($section->bonuses_cards ?? ['Prop Firm Challenge Passing Checklist', 'Buy/Sell Indicator Setup Guide'] as $card)
                                <div class="col-md-6 dynamic-row">
                                    <div class="d-flex align-items-center border p-2 bg-white rounded shadow-sm">
                                        <span class="text-secondary small me-2 fw-bold">Bonus Card:</span>
                                        <input type="text" name="bonuses_cards[]" class="form-control form-control-sm" value="{{ $card }}">
                                        <button type="button" class="btn btn-sm btn-link text-danger ms-1 remove-row-btn"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-bonus-card-btn" class="btn btn-sm btn-outline-info mt-2"><i class="fa-solid fa-square-plus me-1"></i>Add New Bonus Item Box</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SPLIT PANEL RISK FREE VS LOSS EXPIRES Matrix Segment Settings Section Grid Block Layer -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-secondary text-white py-3">
                <h5 class="m-0"><i class="fa-solid fa-arrows-split-up-and-left me-2"></i> 3. Registration Split Panel Parameters Matrix</h5>
            </div>
            <div class="card-body bg-light">
                <div class="row g-4">
                    <!-- Left Split Side Config Block Area -->
                    <div class="col-md-6 border-end">
                        <label class="form-label fw-bold text-success">🛡 Left Panel Heading</label>
                        <input type="text" name="risk_title" class="form-control mb-2" value="{{ $section->risk_title }}">
                        
                        <label class="form-label small fw-bold">Paragraph Rows Lines Stack</label>
                        <div id="risk-p-wrapper">
                            @foreach($section->risk_paragraphs ?? ['This webinar is completely FREE.', 'No risk.'] as $p)
                                <div class="d-flex mb-2 dynamic-row">
                                    <input type="text" name="risk_paragraphs[]" class="form-control form-control-sm" value="{{ $p }}">
                                    <button type="button" class="btn btn-sm btn-danger ms-2 remove-row-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-secondary append-row-btn" data-target="risk-p-wrapper" data-name="risk_paragraphs[]"><i class="fa-solid fa-plus"></i> Add Line</button>
                    </div>

                    <!-- Right Split Side Config Block Area -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-danger">⏳ Right Panel Alert Heading</label>
                        <input type="text" name="expire_title" class="form-control mb-2" value="{{ $section->expire_title }}">
                        
                        <label class="form-label small fw-bold">Subtitle Context</label>
                        <input type="text" name="expire_subtitle" class="form-control mb-2" value="{{ $section->expire_subtitle }}">

                        <label class="form-label small fw-bold">Consequence Rules Pointer Elements (X Bullet list rows)</label>
                        <div id="expire-items-wrapper">
                            @foreach($section->expire_items ?? ['Bonuses may be removed', 'Webinar access may be restricted'] as $item)
                                <div class="d-flex mb-2 dynamic-row">
                                    <input type="text" name="expire_items[]" class="form-control form-control-sm" value="{{ $item }}">
                                    <button type="button" class="btn btn-sm btn-danger ms-2 remove-row-btn"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-secondary append-row-btn" data-target="expire-items-wrapper" data-name="expire_items[]"><i class="fa-solid fa-plus"></i> Add Danger Consequence Rule</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER CTA MATRIX INTERACTION BLOCK ZONE PARAMETERS WRAPPER CARD -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body bg-dark text-white p-3">
                <div class="row g-2">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold text-muted">Footer Call to Action Base Text Context String</label>
                        <input type="text" name="footer_cta" class="form-control bg-secondary text-white border-0" value="{{ $section->footer_cta }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-warning">Highlight Action Accent Text</label>
                        <input type="text" name="footer_cta_highlight" class="form-control bg-secondary text-warning border-0" value="{{ $section->footer_cta_highlight }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- MASTER SAVE TRIGGER BAR BUTTON CONTROLS SYSTEM PANEL CONTROLLER SYNC -->
        <div class="text-end mb-5">
            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm"><i class="fa-solid fa-cloud-arrow-up me-2"></i>Sync Configuration Changes</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Append standard row structures cleanly
    $('.append-row-btn').click(function() {
        let targetId = $(this).data('target');
        let fieldName = $(this).data('name');
        let html = `
            <div class="d-flex mb-2 align-items-center dynamic-row">
                <input type="text" name="${fieldName}" class="form-control form-control-sm" placeholder="New row details line entry value element configuration data metric">
                <button type="button" class="btn btn-sm btn-danger ms-2 remove-row-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>`;
        $('#' + targetId).append(html);
    });

    // Special insertion execution architecture schema path configuration for grid structure bonus blocks boxes mapping
    $('#add-bonus-card-btn').click(function() {
        let html = `
            <div class="col-md-6 dynamic-row">
                <div class="d-flex align-items-center border p-2 bg-white rounded shadow-sm">
                    <span class="text-secondary small me-2 fw-bold">Bonus Card:</span>
                    <input type="text" name="bonuses_cards[]" class="form-control form-control-sm" placeholder="Bonus Target Title">
                    <button type="button" class="btn btn-sm btn-link text-danger ms-1 remove-row-btn"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>`;
        $('#bonus-cards-wrapper').append(html);
    });

    // Handle generic row removals instantly inside workspace contexts dynamically mapped logic components fields
    $(document).on('click', '.remove-row-btn', function() {
        $(this).closest('.dynamic-row').remove();
    });

    // AJAX Form sync validation monitoring handling architecture via transactional logic parameters tracking systems operations safely
    $('#framework-bonuses-form').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Processing Master Update Synced State Pipeline Tasks Structure Execution...');

        $.ajax({
            url: "{{ route('admin.framework-bonuses.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                submitBtn.prop('disabled', false).html('<i class="fa-solid fa-cloud-arrow-up me-2"></i>Sync Configuration Changes');
                if(response.status) {
                    Swal.fire({
                        title: 'Success Master Matrix Updated!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Synchronize Realtime Display View Layout Infrastructure UI',
                        confirmButtonColor: '#10b981',
                        timer: 2500,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function() {
                submitBtn.prop('disabled', false).html('<i class="fa-solid fa-cloud-arrow-up me-2"></i>Sync Configuration Changes');
                Swal.fire({
                    title: 'System Integration Block Processing Error Fallback Exception Encountered',
                    text: 'Please look closely at parameters values configurations matrix lists structures data chains mappings array items errors bounds checking loops rules inputs records variables states.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        });
    });
});
</script>
@endsection