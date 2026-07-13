@extends('admin.layouts.app')

@section('page-title', 'Testimonial Master')

@section('content')
<style>
    /* Premium Table Card Design */
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.01);
    }

    #testimonial-table {
        font-size: 14px;
        border-color: #f1f5f9;
    }

    #testimonial-table th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0 !important;
    }

    #testimonial-table td {
        padding: 12px 16px;
        vertical-align: middle;
        color: #334155;
    }

    /* Video Preview Thumbnail CSS */
    .video-preview-container {
        position: relative;
        width: 120px;
        height: 68px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }
    
    .video-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .video-preview-container:hover img {
        transform: scale(1.05);
    }

    .play-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 18px;
        transition: background 0.3s ease;
    }

    .video-preview-container:hover .play-overlay {
        background: rgba(22, 101, 52, 0.7); /* Green overlay on hover */
    }

    /* Breadcrumb styling refinement */
    .breadcrumb-item a {
        color: #166534;
        text-decoration: none;
        font-weight: 600;
    }
    
    .breadcrumb-item.active {
        color: #64748b;
        font-weight: 500;
    }

    /* Action Buttons */
    .btn-add {
        background-color: #166534;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .btn-add:hover {
        background-color: #14532d;
        color: #ffffff;
        box-shadow: 0 6px 12px rgba(22, 101, 52, 0.15);
    }
</style>

<div class="container-fluid py-2">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie me-1"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Testimonial Master</li>
        </ol>
    </nav>

    <div class="table-card">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Testimonial List</h4>
                <p class="text-muted small mb-0">Manage and view all video testimonials and YouTube links.</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-add">
                <i class="fa fa-plus-circle me-2"></i> Add New Testimonial
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="testimonial-table" style="width:100%">
                <thead>
                    <tr>
                        <th width="60px">#</th>
                        <th>Title / Client Name</th>
                        <th width="160px">Video Preview</th>
                        <th width="120px">Status</th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="videoPreviewModal" tabindex="-1" aria-labelledby="videoPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden; background: #000;">
            <div class="modal-header border-0 pb-0 position-absolute end-0 top-0" style="z-index: 999;">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe src="" id="previewIframe" allowfullscreen allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(function () {
    $('#testimonial-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.testimonials.index') }}', 
        columns: [
            { data: 'id', name: 'id' }, 
            { data: 'title', name: 'title' }, 
            { data: 'video_preview', name: 'video_preview', orderable: false, searchable: false }, 
            { data: 'is_active', name: 'is_active' }, 
            { data: 'action', className: 'text-center', orderable: false, searchable: false },
        ],
        language: {
            searchPlaceholder: "Search Testimonials...",
            search: ""
        }
    });

    // Handle Play Video Modal Trigger
    $(document).on('click', '.open-video-modal', function() {
        let embedUrl = $(this).data('embed');
        // Autoplay text-ah link kooda merge panradhu
        let autoplayUrl = embedUrl + "?autoplay=1";
        $('#previewIframe').attr('src', autoplayUrl);
        $('#videoPreviewModal').modal('show');
    });

    // Modal close aagum pothu video play aaguratha stop panna clean logic
    $('#videoPreviewModal').on('hidden.bs.modal', function () {
        $('#previewIframe').attr('src', '');
    });
});
</script>

<script>
$(document).on('click', '.delete', function () {
    let url = $(this).data('route');

    Swal.fire({
        title: 'Are you sure?',
        text: "This testimonial entry will be permanently removed from the website!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', 
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#testimonial-table').DataTable().ajax.reload(null, false);
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong during deletion!', 'error');
                }
            });
        }
    });
});
</script>
@endsection