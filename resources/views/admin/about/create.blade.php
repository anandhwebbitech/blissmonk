@extends('admin.layouts.app')

@section('page-title', 'Add FAQ')

@section('content')
<style>
    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.02);
    }
    
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #166534;
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
    }

    .btn-save {
        background-color: #166534;
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background-color: #14532d;
        box-shadow: 0 8px 16px rgba(22, 101, 52, 0.2);
    }
</style>

<div class="container-fluid py-2">
    <div class="form-card">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Create New FAQ</h4>
                <p class="text-muted small mb-0">Fill in the fields below to add a new question and structured answer to the public accordion display.</p>
            </div>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 10px; font-weight: 500;">
                <i class="fa fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <form id="faqForm" method="POST">
            @csrf

            <div class="row g-4">

                <!-- FAQ Question -->
                <div class="col-md-9">
                    <label class="form-label">FAQ Question</label>
                    <input type="text" name="question" id="question" class="form-control" placeholder="e.g., What is the minimum capital required for the Evaluation Phase?">
                    <span class="text-danger small json-error" id="error-question"></span>
                </div>

                <!-- Sort Order -->
                <div class="col-md-3">
                    <label class="form-label">Sort Order (Sequence)</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="1" min="1">
                    <span class="text-danger small json-error" id="error-sort_order"></span>
                </div>

                <!-- Highlight Answer -->
                <div class="col-12">
                    <label class="form-label">Highlight Text / Badge Label <span class="text-muted fw-normal">(Optional)</span></label>
                    <input type="text" name="highlight_answer" id="highlight_answer" class="form-control" placeholder="e.g., Recommended, Important, No Time Limit">
                    <span class="text-danger small json-error" id="error-highlight_answer"></span>
                </div>

                <!-- Full Answer Description -->
                <div class="col-12">
                    <label class="form-label">Full Comprehensive Answer</label>
                    <textarea name="full_answer" id="full_answer" class="form-control" rows="8" placeholder="Provide a detailed and transparent answer regarding this specific query..."></textarea>
                    <span class="text-danger small json-error" id="error-full_answer"></span>
                </div>

            </div>

            <div class="mt-4 pt-2 text-end">
                <button type="submit" id="submitBtn" class="btn btn-save">
                    <i class="fa-solid fa-circle-check me-2"></i> Save FAQ Entry
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // ✅ JQUERY VALIDATION ENGINE FOR FAQ
    $("#faqForm").validate({
        rules: {
            question: { required: true, minlength: 10 },
            sort_order: { required: true, digits: true, min: 1 },
            full_answer: { required: true, minlength: 15 }
        },
        messages: {
            question: {
                required: "Please write a specific FAQ question",
                minlength: "The question details must be at least 10 characters long"
            },
            sort_order: {
                required: "Please declare a structural sequence order",
                digits: "Sort order sequence must be a clean valid number",
                min: "Sequence cannot be lower than 1"
            },
            full_answer: {
                required: "Please write down the descriptive full answer text",
                minlength: "The solution answer text must be at least 15 characters long"
            }
        },
        errorElement: "span",
        errorClass: "text-danger small mt-1 d-block",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        
        submitHandler: function (form) {
            let formData = new FormData(form);
            
            // கிளீனிங் எரர் மெசேஜஸ்
            $('.json-error').text('');
            $('.form-control').removeClass('is-invalid');
            
            $('#submitBtn').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Committing FAQ Entry...');

            $.ajax({
                url: "{{ route('admin.faqs.store') }}",
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'FAQ Entry Added!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = "{{ route('admin.faqs.index') }}";
                        });
                    }
                },
                error: function (xhr) {
                    $('#submitBtn').prop('disabled', false).html('<i class="fa-solid fa-circle-check me-2"></i> Save FAQ Entry');
                    
                    if (xhr.status === 422) {
                        let response = xhr.responseJSON;
                        
                        if (response.errors) {
                            $.each(response.errors, function (key, value) {
                                $(`#error-${key}`).text(value[0]);
                                $(`#${key}`).addClass('is-invalid');
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Transaction Failed',
                            text: xhr.responseJSON.message || 'An error occurred while saving the FAQ entry into database context.'
                        });
                    }
                }
            });
            return false;
        }
    });

});
</script>
@endsection