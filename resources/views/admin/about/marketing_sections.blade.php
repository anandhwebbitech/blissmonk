@extends('admin.layouts.app')

@section('content')
<!-- CKEditor CDN Content Delivery Network Link -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<style>
    /* படம் image_cd8422.jpg மற்றும் image_cd8f08.jpg-ன் வடிவமைப்பு */
    .preview-canvas {
        background-color: #fcfbfe;
        border-radius: 16px;
        padding: 3rem 2rem;
        border: 1px solid #e2e8f0;
    }
    .accent-left-line {
        border-left: 4px solid #3b82f6;
        padding-left: 15px;
    }
    .result-dark-card {
        background-color: #1e2229;
        color: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
    }
    .result-dark-card h5 { color: #ef4444 !important; font-weight: 700; }

    .truth-light-card {
        background-color: #ffffff;
        border-radius: 14px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        border-top: 4px solid #10b981;
    }
    .truth-light-card h5 { color: #10b981 !important; font-weight: 700; }

    /* Section 2 க்கான பிரத்யேக லைட் தீம் பிரிவியூ ஸ்டைல் */
    .program-preview-canvas {
        background-color: #f7fafc;
        border-radius: 16px;
        padding: 3rem 2rem;
        border: 1px solid #e2e8f0;
    }
    .gambling-warning-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        border-top: 4px solid #ef4444;
        box-shadow: 0 4px 15px rgba(0,0,0,0.01);
    }
    .gambling-warning-card h6 { color: #ef4444 !important; font-weight: 700; }

    .ck-editor__editable_inline {
        min-height: 120px !important;
        background: transparent !important;
        border: 1px dashed #cbd5e1 !important;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Visual Component Manager</h1>
        </div>
    </div>

    <form id="marketing-standalone-form" enctype="multipart/form-data">
        @csrf
        
        <!-- MODULE 1: RETAIL TRADING PROBLEMS -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa-solid fa-pen-to-square me-1"></i> Edit Section 1: Retail Trading Failures</h6>
            </div>
            <div class="card-body">
                <div class="preview-canvas shadow-inner">
                    <div class="row g-4">
                        
                        <!-- Left Column Layout -->
                        <div class="col-lg-7">
                            <div class="accent-left-line mb-4">
                                <div class="mb-2">
                                    <label class="text-muted small d-block">[Why Heading & Subheading]</label>
                                    <textarea name="why_heading" id="editor_why_heading">
                                        {!! $section->why_heading ?? '<h2>Why Most Traders Never Get Funded</h2>' !!}
                                    </textarea>
                                    <div class="mt-2">
                                        <input type="text" name="why_subheading" class="form-control form-control-sm" placeholder="Why Subheading" value="{{ $section->why_subheading ?? 'An objective analysis of retail trading failures.' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 mt-4">
                                <label class="text-muted small d-block">[Lead Text & Problems List]</label>
                                <div class="mb-2">
                                    <input type="text" name="lead_text" class="form-control form-control-sm" placeholder="Lead Text" value="{{ $section->lead_text ?? 'Most traders believe their problem is strategy. It\'s not.' }}">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="problem_label" class="form-control form-control-sm" placeholder="Problem Label" value="{{ $section->problem_label ?? 'The real problem is:' }}">
                                </div>
                                <textarea name="problems_list" id="editor_problems_list">
                                    @if(is_array($section->problems_list))
                                        <ul>
                                            @foreach($section->problems_list as $problem) <li>{{ $problem }}</li> @endforeach
                                        </ul>
                                    @else
                                        {!! $section->problems_list ?? '<ul><li>They trade too much.</li><li>They trade the wrong markets.</li></ul>' !!}
                                    @endif
                                </textarea>
                            </div>
                        </div>

                        <!-- Right Column Layout -->
                        <div class="col-lg-5 d-flex flex-column gap-3">
                            <!-- As a Result Block -->
                            <div class="result-dark-card shadow">
                                <label class="text-secondary small d-block">[Result Title & Desc]</label>
                                <div class="mb-2">
                                    <input type="text" name="result_title" class="form-control form-control-sm bg-dark text-white border-secondary" value="{{ $section->result_title ?? 'As a result...' }}">
                                </div>
                                <textarea name="result_desc" id="editor_result_desc">
                                    {!! $section->result_desc ?? '<p class="small text-white-50">They fail challenge after challenge. Lose confidence. And continue risking personal capital.</p>' !!}
                                </textarea>
                            </div>
                            
                            <!-- The Truth Block -->
                            <div class="truth-light-card shadow-sm">
                                <label class="text-muted small d-block">[Truth Title & Desc]</label>
                                <div class="mb-2">
                                    <input type="text" name="truth_title" class="form-control form-control-sm" value="{{ $section->truth_title ?? 'The truth is:' }}">
                                </div>
                                <textarea name="truth_desc" id="editor_truth_desc">
                                    {!! $section->truth_desc ?? '<p class="small text-muted">Success in prop trading comes from discipline, structure, market selection, and risk management.</p>' !!}
                                </textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- MODULE 2: PROGRAM VALUE PROP (Based on image_cd8f08.jpg) -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa-solid fa-pen-to-square me-1"></i> Edit Section 2: Value Prop Architecture</h6>
            </div>
            <div class="card-body">
                <div class="program-preview-canvas">
                    <div class="row g-4">
                        
                        <!-- Left Column (Heading & Image) -->
                        <div class="col-lg-5">
                            <div class="mb-4">
                                <label class="text-muted small d-block">[Program Headline & Subheadline]</label>
                                <textarea name="program_headline" id="editor_program_headline">
                                    {!! $section->program_headline ?? '<h3>🚀 Introducing The Million Dollar Prop Funded Trader Program™</h3>' !!}
                                </textarea>
                                <div class="mt-2">
                                    <textarea name="program_subheadline" class="form-control form-control-sm" rows="2">{{ $section->program_subheadline ?? 'A structured trader development system designed to help retail traders become funded traders.' }}</textarea>
                                </div>
                            </div>

                            <div class="p-3 bg-white rounded border border-dashed text-center shadow-sm">
                                <label class="text-dark small fw-bold d-block mb-2 text-start"><i class="fa-solid fa-image me-1"></i> Program Image</label>
                                @if(!empty($section->program_image))
                                    <img src="{{ asset($section->program_image) }}" class="img-fluid rounded mb-2 border d-block mx-auto" style="max-height: 100px;">
                                @endif
                                <input type="file" name="program_image" class="form-control form-control-sm bg-light">
                            </div>
                        </div>

                        <!-- Right Column (Discover, Benefits & Pain Points) -->
                        <div class="col-lg-7 d-flex flex-column justify-content-between">
                            <div class="mb-4">
                                <label class="text-muted small d-block">[Discover Text & Benefits List]</label>
                                <div class="mb-2">
                                    <input type="text" name="discover_text" class="form-control form-control-sm" value="{{ $section->discover_text ?? 'Inside this webinar, you\'ll discover the exact framework that helps traders:' }}">
                                </div>
                                <textarea name="benefits_list" id="editor_benefits_list">
                                    @if(is_array($section->benefits_list))
                                        <ul>
                                            @foreach($section->benefits_list as $benefit) <li>{{ $benefit }}</li> @endforeach
                                        </ul>
                                    @else
                                        {!! $section->benefits_list ?? '<ul><li>✔️ Choose the right market based on time</li><li>✔️ Focus only on high-probability opportunities</li></ul>' !!}
                                    @endif
                                </textarea>
                            </div>

                            <!-- Bottom Warning/Solution Card -->
                            <div class="gambling-warning-card shadow-sm mt-2">
                                <label class="text-muted small d-block">[Pain Point & Solution Text]</label>
                                <div class="mb-2">
                                    <input type="text" name="pain_point_text" class="form-control form-control-sm text-danger fw-bold" value="{{ $section->pain_point_text ?? 'INSTEAD OF GAMBLING WITH PERSONAL FUNDS...' }}">
                                </div>
                                <textarea name="solution_text" id="editor_solution_text">
                                    {!! $section->solution_text ?? '<h5>You\'ll learn how professional traders think, manage risk, and scale.</h5>' !!}
                                </textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Toolbar -->
        <div class="card shadow-sm border-0 p-3 mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" id="submit-btn" class="btn btn-primary px-5 font-weight-bold">Save Configuration</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const editorIds = [
            '#editor_why_heading', 
            '#editor_problems_list', 
            '#editor_result_desc', 
            '#editor_truth_desc', 
            '#editor_program_headline', 
            '#editor_benefits_list', 
            '#editor_solution_text'
        ];
        
        editorIds.forEach(id => {
            ClassicEditor.create(document.querySelector(id), {
                toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'undo', 'redo']
            }).catch(error => { console.error(error); });
        });

        $('#marketing-standalone-form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.marketing.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.status) { location.reload(); }
                }
            });
        });
    });
</script>
@endsection