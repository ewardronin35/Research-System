@extends('layouts.guest-layout')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Research Form Access</h5>
    </div>
    <div class="card-body p-4">
        <p class="text-dark mb-4">Please enter the verification code provided by the researcher to access the submission form.</p>

        {{-- Display Success/Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @error('code')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('guest.research.verify_code') }}" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="code" class="form-label">Verification Code</label>
                <input type="text" class="form-control form-control-lg @error('code') is-invalid @enderror" id="code" name="code" required autofocus placeholder="Enter code here...">
                <div class="invalid-feedback">A verification code is required.</div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    Proceed to Form
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Standard Bootstrap 5 validation script
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()
</script>
@endpush