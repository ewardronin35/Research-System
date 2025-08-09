
@extends('layouts.guest-layout')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
@endpush

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add New Research Paper</h5>
    </div>
    <div class="card-body p-4">
        <form id="researchForm" action="{{ route('guest.research.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            
            <input type="hidden" name="research_file_path" id="research_file_path">
            <h6 class="text-primary fw-bold">Part 1: Basic Information</h6>
            <hr class="mb-4">
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <label for="title" class="form-label">Research Title<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    <div class="invalid-feedback">Please enter a research title.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="course" class="form-label">Course<span class="text-danger">*</span></label>
                    <select class="form-select" id="course" name="course" required>
                        <option value="" disabled selected>Select Course</option>
                        <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>BSIT</option>
                        <option value="BSN" {{ old('course') == 'BSN' ? 'selected' : '' }}>BSN</option>
                        <option value="STEM" {{ old('course') == 'STEM' ? 'selected' : '' }}>STEM</option>
                        <option value="HUMMS" {{ old('course') == 'HUMMS' ? 'selected' : '' }}>HUMMS</option>
                        <option value="ABM" {{ old('course') == 'ABM' ? 'selected' : '' }}>ABM</option>
                        <option value="BLIS" {{ old('course') == 'BLIS' ? 'selected' : '' }}>BLIS</option>
                        <option value="BSBA" {{ old('course') == 'BSBA' ? 'selected' : '' }}>BSBA</option>
                        <option value="BEED" {{ old('course') == 'BEED' ? 'selected' : '' }}>BEED</option>
                        <option value="BSHM" {{ old('course') == 'BSHM' ? 'selected' : '' }}>BSHM</option>
                        <option value="BSTM" {{ old('course') == 'BSTM' ? 'selected' : '' }}>BSTM</option>
                    </select>
                    <div class="invalid-feedback">Please select a course.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label">Year<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="year" name="year" min="2000" max="{{ date('Y') }}" value="{{ old('year', date('Y')) }}" required>
                    <div class="invalid-feedback">Please enter a valid year.</div>
                </div>
            </div>

            <h6 class="text-primary fw-bold mt-4">Part 2: Research Details</h6>
            <hr class="mb-4">
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <label for="researchers" class="form-label">Researchers<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="researchers" name="researchers" rows="2" placeholder="Enter full names, separated by commas" required>{{ old('researchers') }}</textarea>
                    <div class="invalid-feedback">Please enter the researchers' names.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="adviser" class="form-label">Adviser<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="adviser" name="adviser" value="{{ old('adviser') }}" required>
                    <div class="invalid-feedback">Please enter the adviser's name.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Your Email Address<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="Approval status will be sent here">
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="abstract" class="form-label">Abstract<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="abstract" name="abstract" rows="5" required>{{ old('abstract') }}</textarea>
                    <div class="invalid-feedback">Please enter an abstract.</div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="keywords" class="form-label">Keywords<span class="text-danger">*</span></label>
                    <select class="form-control" id="keywords" name="keywords[]" multiple="multiple" required>
                        @if(old('keywords'))
                            @foreach(old('keywords') as $keyword)
                                <option value="{{ $keyword }}" selected>{{ $keyword }}</option>
                            @endforeach
                        @endif
                    </select>
                    <small class="text-muted">Type a keyword and press Enter to add it.</small>
                    <div class="invalid-feedback">Please provide at least one keyword.</div>
                </div>
            </div>

            <h6 class="text-primary fw-bold mt-4">Part 3: Methodology & Document</h6>
            <hr class="mb-4">
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="research_design" class="form-label">Research Design<span class="text-danger">*</span></label>
                    <select class="form-select" id="research_design" name="research_design" required>
                         <option value="" disabled selected>Select Research Design</option>
                         <option value="Qualitative" {{ old('research_design') == 'Qualitative' ? 'selected' : '' }}>Qualitative</option>
                         <option value="Quantitative" {{ old('research_design') == 'Quantitative' ? 'selected' : '' }}>Quantitative</option>
                         <option value="Mixed Method" {{ old('research_design') == 'Mixed Method' ? 'selected' : '' }}>Mixed Method</option>
                    </select>
                    <div class="invalid-feedback">Please select a research design.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="research_type" class="form-label">Research Type</label>
                    <select class="form-select" id="research_type" name="research_type">
                        <option value="">Select a design first...</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="respondents_count" class="form-label">Number of Respondents</label>
                    <input type="number" class="form-control" id="respondents_count" name="respondents_count" min="0" value="{{ old('respondents_count') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="research_file" class="form-label">Upload PDF Document<span class="text-danger">*</span></label>
                    <input type="file" class="filepond" name="research_file" id="research_file" required>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button type="reset" class="btn btn-outline-secondary">Reset Fields</button>
                <button type="submit" class="btn btn-primary">Submit for Approval</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#keywords').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: 'Enter keywords and press Enter',
            theme: 'bootstrap-5'
        });

        const pond = FilePond.create(document.querySelector('input[id="research_file"]'), {
            labelIdle: `Drag & Drop your PDF or <span class="filepond--label-action">Browse</span>`,
            server: {
                url: '{{ route("guest.filepond.upload") }}',
                process: {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    onload: (response) => {
                        document.getElementById('research_file_path').value = response;
                        return response;
                    }
                },
                revert: (uniqueFileId, load, error) => {
                    // Send revert request to server
                    fetch('{{ route("guest.filepond.revert") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'text/plain',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: uniqueFileId
                    });
                    document.getElementById('research_file_path').value = '';
                    load();
                }
            }
        });
        
        $('#research_design').on('change', function() {
            const design = $(this).val();
            const typeDropdown = $('#research_type');
            typeDropdown.empty().append('<option value="">Select Research Type</option>');
            let types = [];
            if (design === 'Qualitative') {
                types = ['Phenomenology', 'Case Study', 'Narrative', 'Multi Case Study'];
            } else if (design === 'Quantitative') {
                types = ['Descriptive', 'Correlational', 'Causal-Comparative', 'Experimental'];
            } else if (design === 'Mixed Method') {
                types = ['Convergent Parallel', 'Explanatory Sequential', 'Exploratory Sequential'];
            }
            types.forEach(type => {
                typeDropdown.append(`<option value="${type}">${type}</option>`);
            });
        }).trigger('change');

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
    });
    </script>
@endpush
