@extends('admin.layouts.app')

@section('content')
    <style>
        .dark-preview-deck {
            background-color: #0d1117;
            border-radius: 12px;
            padding: 2.5rem;
            color: #c9d1d9;
        }

        .accent-badge-select {
            max-width: 110px;
            font-size: 0.75rem;
        }

        .module-card-item {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 text-white"><i class="fa-solid fa-layer-group me-2 text-info"></i> Webinar Modules Component
                    Settings</h5>
            </div>
            <div class="card-body bg-light">
                <form id="webinar-modules-form" enctype="multipart/form-data">
                    @csrf

                    <!-- Section Headings & Image Base -->
                    <div class="row mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Component Main Title</label>
                            <input type="text" name="section_title" class="form-control mb-3"
                                value="{{ $section->section_title ?? '📦 What You\'ll Learn In The Free Webinar' }}">

                            <label class="form-label fw-bold">Hero Editorial Image</label>
                            <input type="file" name="editorial_image" class="form-control">
                        </div>
                        <div class="col-md-5">
                            @if ($section->editorial_image)
                                <label class="d-block small text-muted">Current Asset Preview</label>
                                <img src="{{ asset($section->editorial_image) }}"
                                    class="img-fluid rounded border bg-dark p-2" style="max-height: 140px;">
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="fw-bold mb-3 text-secondary">Modules Management Framework</h5>

                    <!-- Container dynamically populated via iteration logic or standard base matrix block -->
                    <div id="modules-wrapper-deck" class="row g-3">
                        @if (!empty($section->modules_data) && is_array($section->modules_data))
                            @foreach ($section->modules_data as $modIdx => $module)
                                <div class="col-md-6 module-container-node" id="module_node_{{ $modIdx }}">
                                    <div class="p-3 module-card-item shadow-sm">
                                        <div class="d-flex justify-content-between mb-2">
                                            <input type="text" name="module_title[]"
                                                class="form-control form-control-sm bg-dark text-white border-secondary"
                                                placeholder="Module Title" value="{{ $module['title'] }}">
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm ms-2 remove-module-node"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </div>

                                        <div class="sub-items-group-deck mt-3">
                                            @foreach ($module['items'] as $itemIdx => $item)
                                                <div class="d-flex align-items-center gap-2 mb-2 sub-item-row">
                                                    <select name="module_accents[{{ $modIdx }}][]"
                                                        class="form-select form-select-sm accent-badge-select bg-secondary text-white">
                                                        <option value="none"
                                                            {{ $item['accent'] == 'none' ? 'selected' : '' }}>Standard (—)
                                                        </option>
                                                        <option value="green"
                                                            {{ $item['accent'] == 'green' ? 'selected' : '' }}>Green (▲)
                                                        </option>
                                                        <option value="red"
                                                            {{ $item['accent'] == 'red' ? 'selected' : '' }}>Red (▼)</option>
                                                    </select>
                                                    <input type="text" name="module_items[{{ $modIdx }}][]"
                                                        class="form-control form-control-sm"
                                                        placeholder="Bullet pointer rule description"
                                                        value="{{ $item['text'] }}">
                                                    <button type="button" class="btn btn-sm text-danger remove-sub-item"><i
                                                            class="fa-solid fa-xmark"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-link text-info btn-sm mt-1 add-new-bullet-row"
                                            data-module-id="{{ $modIdx }}"><i class="fa-solid fa-plus me-1"></i> Add
                                            Pointer Item</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- fallback placeholder node template -->
                            <div class="col-md-6 module-container-node">
                                <div class="p-3 module-card-item shadow-sm">
                                    <div class="d-flex justify-content-between mb-2">
                                        <input type="text" name="module_title[]"
                                            class="form-control form-control-sm bg-dark text-white border-secondary"
                                            placeholder="Module Title"
                                            value="Module 1 – The Prop Firm Opportunity Blueprint">
                                    </div>
                                    <div class="sub-items-group-deck mt-3">
                                        <div class="d-flex align-items-center gap-2 mb-2 sub-item-row">
                                            <select name="module_accents[0][]"
                                                class="form-select form-select-sm accent-badge-select bg-secondary text-white">
                                                <option value="none">Standard</option>
                                                <option value="green">Green</option>
                                                <option value="red">Red</option>
                                            </select>
                                            <input type="text" name="module_items[0][]"
                                                class="form-control form-control-sm" value="How prop firms work">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-link text-info btn-sm mt-1 add-new-bullet-row"
                                        data-module-id="0"><i class="fa-solid fa-plus me-1"></i> Add Pointer Item</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="button" id="add-master-module-block" class="btn btn-outline-primary btn-sm"><i
                                class="fa-solid fa-square-plus me-2"></i>Add New Module Block</button>
                        <button type="submit" class="btn btn-success px-5 font-weight-bold">Save System Layout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let moduleCounter = $('.module-container-node').length;

            // Add pointer rows inside target scope elements modules list layout blocks
            $(document).on('click', '.add-new-bullet-row', function() {
                let modId = $(this).data('module-id');
                let wrapper = $(this).siblings('.sub-items-group-deck');
                let html = `
            <div class="d-flex align-items-center gap-2 mb-2 sub-item-row">
                <select name="module_accents[${modId}][]" class="form-select form-select-sm accent-badge-select bg-secondary text-white">
                    <option value="none">Standard</option>
                    <option value="green">Green</option>
                    <option value="red">Red</option>
                </select>
                <input type="text" name="module_items[${modId}][]" class="form-control form-control-sm" placeholder="New structural text tracking rule elements">
                <button type="button" class="btn btn-sm text-danger remove-sub-item"><i class="fa-solid fa-xmark"></i></button>
            </div>`;
                wrapper.append(html);
            });

            // Remove single lists
            $(document).on('click', '.remove-sub-item', function() {
                $(this).closest('.sub-item-row').remove();
            });
            $(document).on('click', '.remove-module-node', function() {
                $(this).closest('.module-container-node').remove();
            });

            // Master module container construction dynamic insertion mapping logic architecture
            $('#add-master-module-block').click(function() {
                let html = `
            <div class="col-md-6 module-container-node">
                <div class="p-3 module-card-item shadow-sm">
                    <div class="d-flex justify-content-between mb-2">
                        <input type="text" name="module_title[]" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="New Component Module Title Setup">
                        <button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-module-node"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="sub-items-group-deck mt-3">
                        <div class="d-flex align-items-center gap-2 mb-2 sub-item-row">
                            <select name="module_accents[${moduleCounter}][]" class="form-select form-select-sm accent-badge-select bg-secondary text-white">
                                <option value="none">Standard</option>
                                <option value="green">Green</option>
                                <option value="red">Red</option>
                            </select>
                            <input type="text" name="module_items[${moduleCounter}][]" class="form-control form-control-sm" placeholder="Primary initialization parameter field string pointer">
                        </div>
                    </div>
                    <button type="button" class="btn btn-link text-info btn-sm mt-1 add-new-bullet-row" data-module-id="${moduleCounter}"><i class="fa-solid fa-plus me-1"></i> Add Pointer Item</button>
                </div>
            </div>`;
                $('#modules-wrapper-deck').append(html);
                moduleCounter++;
            });


            $('#webinar-modules-form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                // UI/UX Improvement: Disable the button and show a "Saving..." state
                let submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Saving Layout...');

                $.ajax({
                    url: "{{ route('admin.webinar-modules.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Re-enable the submit button
                        submitBtn.prop('disabled', false).text('Save System Layout');

                        if (response.status) {
                            // Success SweetAlert
                            Swal.fire({
                                title: 'Success!',
                                text: response.message ||
                                    'Webinar Matrix synced successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#10b981', // Emerald green tone
                                timer: 3000, // Automatically closes after 3 seconds
                                timerProgressBar: true
                            }).then((result) => {
                                // Reloads the page only after the alert is dismissed or timed out
                                location.reload();
                            });
                        } else {
                            // Application-level error handling
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong while processing your request.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Re-enable the submit button on failure
                        submitBtn.prop('disabled', false).text('Save System Layout');

                        // Server-level fallback error alert
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Server error encountered. Please check your inputs.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                });
            });
        });
    </script>
@endsection
