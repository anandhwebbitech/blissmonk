@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🔥 Edit Split Decision Block</h5>
        </div>
        <div class="card-body bg-light">
            <form id="funded-section-form">
                @csrf
                
                <!-- Main Header Setting -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Main Top Headline</label>
                    <input type="text" name="main_heading" class="form-control" value="{{ $section->main_heading }}">
                </div>

                <div class="row g-4">
                    <!-- LEFT CONTAINER CONFIGURATION (Red Indicator) -->
                    <div class="col-md-5">
                        <div class="card border-danger h-100">
                            <div class="card-header bg-danger text-white py-2 fw-bold">Left Pane (Pain Points Box)</div>
                            <div class="card-body">
                                <label class="form-label small fw-bold">Box Description Text</label>
                                <textarea name="left_title" class="form-control mb-3" rows="2">{{ $section->left_title }}</textarea>

                                <label class="form-label small fw-bold">Red "✕" Bullets List</label>
                                <div id="left-points-wrapper">
                                    @foreach($section->left_points ?? ['Jump between strategies.', 'Overtrade.'] as $point)
                                        <div class="d-flex mb-2 target-row">
                                            <input type="text" name="left_points[]" class="form-control form-control-sm" value="{{ $point }}">
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-row-btn">✕</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-danger mt-2" onclick="addNewRow('left-points-wrapper', 'left_points[]')">+ Add Point</button>
                            </div>
                        </div>
                    </div>

                    <!-- CENTER DIVIDER BLOCK -->
                    <div class="col-md-2 d-flex flex-column justify-content-center align-items-center text-center">
                        <label class="form-label small fw-bold text-muted">Middle Circle Text</label>
                        <input type="text" name="divider_text" class="form-control text-center fw-bold bg-white" value="{{ $section->divider_text }}" style="max-width: 90px; border-radius: 50px;">
                    </div>

                    <!-- RIGHT CONTAINER CONFIGURATION (Green Indicator) -->
                    <div class="col-md-5">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white py-2 fw-bold">Right Pane (Solution Framework Box)</div>
                            <div class="card-body">
                                <label class="form-label small fw-bold">Box Description/Pitch Text</label>
                                <textarea name="right_title" class="form-control mb-3" rows="2">{{ $section->right_title }}</textarea>

                                <label class="form-label small fw-bold">Green Dot Bullets List</label>
                                <div id="right-points-wrapper">
                                    @foreach($section->right_points ?? ['Learn system rules seamlessly.'] as $point)
                                        <div class="d-flex mb-2 target-row">
                                            <input type="text" name="right_points[]" class="form-control form-control-sm" value="{{ $point }}">
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-row-btn">✕</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-success mt-2" onclick="addNewRow('right-points-wrapper', 'right_points[]')">+ Add Point</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DUAL CTA ACTION UTILITIES CONFIGURATION TRACK -->
                <div class="row g-3 mt-4 border-top pt-4">
                    <!-- Left Primary Button Fields -->
                    <div class="col-md-6 border-end">
                        <h6 class="text-success fw-bold">🟢 Action Button 1 (Primary Highlight CTA)</h6>
                        <input type="text" name="btn1_text" class="form-control mb-2" placeholder="Button Title" value="{{ $section->btn1_text }}">
                        <input type="text" name="btn1_url" class="form-control mb-2" placeholder="Destination Redirect Link URL" value="{{ $section->btn1_url }}">
                        <input type="text" name="btn1_subtext" class="form-control form-control-sm text-muted" placeholder="Bottom Caption/Urgency text" value="{{ $section->btn1_subtext }}">
                    </div>

                    <!-- Right Secondary Outline Fields -->
                    <div class="col-md-6">
                        <h6 class="text-info fw-bold">⚪ Action Button 2 (Secondary/WhatsApp Link)</h6>
                        <input type="text" name="btn2_text" class="form-control mb-2" placeholder="Button Title" value="{{ $section->btn2_text }}">
                        <input type="text" name="btn2_url" class="form-control mb-2" placeholder="Destination Redirect Link URL" value="{{ $section->btn2_url }}">
                        <input type="text" name="btn2_subtext" class="form-control form-control-sm text-muted" placeholder="Bottom Caption/Urgency text" value="{{ $section->btn2_subtext }}">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Save Dashboard Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Logic to handle runtime additions of bullet parameters rows
function addNewRow(wrapperId, inputName) {
    let rowHtml = `
        <div class="d-flex mb-2 target-row">
            <input type="text" name="${inputName}" class="form-control form-control-sm" placeholder="Enter list row context text value">
            <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-row-btn" onclick="this.closest('.target-row').remove()">✕</button>
        </div>`;
    document.getElementById(wrapperId).insertAdjacentHTML('beforeend', rowHtml);
}

// Global hook processing elements cleanup routines
document.addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('remove-row-btn')){
        e.target.closest('.target-row').remove();
    }
});

// Async form handling integration pipeline logic routine tasks 
document.getElementById('funded-section-form').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    
    fetch("{{ route('admin.funded-section.update') }}", {
        method: "POST",
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => { if(data.success) alert(data.message); })
    .catch(() => alert('Synchronization Error Encountered'));
});
</script>
@endsection