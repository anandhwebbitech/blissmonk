@extends('admin.layouts.app')

@section('page-title', 'FAQ Master')

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

    #faq-table {
        font-size: 14px;
        border-color: #f1f5f9;
    }

    #faq-table th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0 !important;
    }

    #faq-table td {
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
            <li class="breadcrumb-item active">FAQ Master</li>
        </ol>
    </nav>

    <div class="table-card">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">FAQ List</h4>
                <p class="text-muted small mb-0">Manage and view all accordion-style dynamic FAQ entries.</p>
            </div>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-add">
                <i class="fa fa-plus-circle me-2"></i> Add New FAQ
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="faq-table" style="width:100%">
                <thead>
                    <tr>
                        <th width="60px">Order</th>
                        <th>Question</th>
                        <th width="150px">Highlight</th>
                        <th>Full Answer</th>
                        <th width="150px" class="text-center">Action</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$(function () {
    $('#faq-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.faqs.index') }}', 
        columns: [
            { data: 'sort_order', name: 'sort_order' }, 
            { data: 'question', name: 'question' }, 
            { data: 'highlight_answer', name: 'highlight_answer' }, 
            { data: 'full_answer', name: 'full_answer' }, 
            { data: 'action', className: 'text-center', orderable: false, searchable: false },
        ],
        language: {
            searchPlaceholder: "Search FAQs...",
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
        text: "This FAQ entry will be permanently removed from the website!",
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
                        $('#faq-table').DataTable().ajax.reload(null, false);
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