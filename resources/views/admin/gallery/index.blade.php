@extends('admin.layouts.app')

@section('page-title', 'Gallery Master')

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

    #gallery-table {
        font-size: 14px;
        border-color: #f1f5f9;
    }

    #gallery-table th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0 !important;
    }

    #gallery-table td {
        padding: 12px 16px;
        vertical-align: middle;
        color: #334155;
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
            <li class="breadcrumb-item active">Gallery Master</li>
        </ol>
    </nav>

    <div class="table-card">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Gallery List</h4>
                <p class="text-muted small mb-0">Manage and view all media gallery master entries.</p>
            </div>
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-add">
                <i class="fa fa-plus-circle me-2"></i> Add New Image
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="gallery-table" style="width:100%">
                <thead>
                    <tr>
                        <th width="80px">ID</th>
                        <th>Gallery Name</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th width="120px">Status</th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script>
$(function () {
    $('#gallery-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.galleries.index') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' }, 
            { data: 'image', orderable: false, searchable: false },
            
            { data: 'category', name: 'category', defaultContent: '-' }, 
            
            { data: 'status', orderable: false, searchable: false },
            { data: 'action', className: 'text-center', orderable: false, searchable: false },
        ],
        language: {
            searchPlaceholder: "Search records...",
            search: ""
        }
    });
});
</script>

<script>
$(document).on('click', '.delete', function () {

    let url = $(this).data('route');

    Swal.fire({
        title: 'Are you sure?',
        text: "This image will be permanently removed from storage!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', // Premium alert red
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
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#gallery-table').DataTable().ajax.reload(null, false);
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