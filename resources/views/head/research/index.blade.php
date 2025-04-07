<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Research Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-4" id="researchTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="research-list-tab" data-bs-toggle="tab" data-bs-target="#research-list" type="button" role="tab" aria-controls="research-list" aria-selected="true">
                                <i class="fas fa-list me-2"></i>All Research Papers
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="add-research-tab" data-bs-toggle="tab" data-bs-target="#add-research" type="button" role="tab" aria-controls="add-research" aria-selected="false">
                                <i class="fas fa-plus-circle me-2"></i>Add New Research
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Tabs Content -->
                    <div class="tab-content" id="researchTabsContent">
                        <!-- Research List Tab -->
                        <div class="tab-pane fade show active" id="research-list" role="tabpanel" aria-labelledby="research-list-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="researchDataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Title</th>
            <th>Course</th>
            <th>Researchers</th>
            <th>Adviser</th>
            <th>Year</th>
            <th>Program</th>
            <th>Category</th>
            <th>Research Design</th>
            <th>Type</th>
            <th>Respondents</th>
            <th>Date Submitted</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($researchPapers ?? [] as $paper)
        <tr>
            <td>
                @if($paper->file_path)
                <a href="{{ route('head.research.download', $paper->id) }}" target="_blank" class="text-primary">
                    {{ $paper->title }}
                </a>
                @else
                {{ $paper->title }}
                @endif
            </td>
            <td>{{ $paper->course }}</td>
            <td>{{ $paper->researchers }}</td>
            <td>{{ $paper->adviser }}</td>
            <td>{{ $paper->year }}</td>
            <td>{{ $paper->program ?? 'N/A' }}</td>
            <td>{{ $paper->category ?? 'N/A' }}</td>
            <td>{{ $paper->research_design }}</td>
            <td>{{ $paper->research_type ?? 'N/A' }}</td>
            <td>{{ $paper->respondents_count ?? 'N/A' }}</td>
            <td>{{ $paper->created_at->format('M d, Y') }}</td>
            <td>
                <a href="{{ route('head.research.generate-report', ['id' => $paper->id]) }}" class="btn btn-success btn-sm" title="View Report">
                    <i class="fas fa-file-pdf"></i> Report
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Research Tab -->
                        <div class="tab-pane fade" id="add-research" role="tabpanel" aria-labelledby="add-research-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form id="researchForm" action="{{ route('head.research.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                        @csrf
                                        
                                        <div class="card mb-4">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Basic Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="title" class="form-label">Research Title<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                                        <div class="invalid-feedback">Please enter a research title</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="course" class="form-label">Course<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="course" name="course" required>
                                                            <option value="">Select Course</option>
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
                                                        <div class="invalid-feedback">Please select a course</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="year" class="form-label">Year<span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="year" name="year" min="2000" max="{{ date('Y') }}" value="{{ old('year', date('Y')) }}" required>
                                                        <div class="invalid-feedback">Please enter a valid year</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="category" class="form-label">Category</label>
                                                        <select class="form-select" id="category" name="category">
                                                            <option value="">Select Category</option>
                                                            <option value="Student" {{ old('category') == 'Student' ? 'selected' : '' }}>Student</option>
                                                            <option value="Faculty" {{ old('category') == 'Faculty' ? 'selected' : '' }}>Faculty</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="program" class="form-label">Program</label>
                                                        <select class="form-select" id="program" name="program">
                                                            <option value="">Select Program</option>
                                                            <option value="College" {{ old('program') == 'College' ? 'selected' : '' }}>College</option>
                                                            <option value="SHS" {{ old('program') == 'SHS' ? 'selected' : '' }}>SHS (Senior High School)</option>
                                                            <option value="BED" {{ old('program') == 'BED' ? 'selected' : '' }}>BED (Basic Education)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-4">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Research Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="researchers" class="form-label">Researchers<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="researchers" name="researchers" rows="2" placeholder="Enter researchers names separated by commas" required>{{ old('researchers') }}</textarea>
                                                        <div class="invalid-feedback">Please enter researcher names</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="adviser" class="form-label">Adviser<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="adviser" name="adviser" value="{{ old('adviser') }}" required>
                                                        <div class="invalid-feedback">Please enter adviser name</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="abstract" class="form-label">Abstract<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="abstract" name="abstract" rows="5" required>{{ old('abstract') }}</textarea>
                                                        <div class="invalid-feedback">Please enter an abstract</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
    <div class="col-md-12">
        <label for="keywords" class="form-label">Keywords<span class="text-danger">*</span></label>
        <select class="form-control select2-keywords" id="keywords" name="keywords[]" multiple="multiple" required>
            @if(old('keywords'))
                @foreach(explode(',', old('keywords')) as $keyword)
                    <option value="{{ trim($keyword) }}" selected>{{ trim($keyword) }}</option>
                @endforeach
            @endif
        </select>
        <small class="text-muted">Type keywords and press Enter to add. Use comma to separate keywords.</small>
        <div class="invalid-feedback">Please enter at least one keyword</div>
    </div>
</div>
                                            </div>
                                        </div>

                                        <div class="card mb-4">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Research Methodology</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="research_design" class="form-label">Research Design<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="research_design" name="research_design" required>
                                                            <option value="">Select Research Design</option>
                                                            <option value="Qualitative" {{ old('research_design') == 'Qualitative' ? 'selected' : '' }}>Qualitative</option>
                                                            <option value="Quantitative" {{ old('research_design') == 'Quantitative' ? 'selected' : '' }}>Quantitative</option>
                                                            <option value="Mixed Method" {{ old('research_design') == 'Mixed Method' ? 'selected' : '' }}>Mixed Method</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a research design</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="research_type" class="form-label">Research Type</label>
                                                        <select class="form-select" id="research_type" name="research_type">
                                                            <option value="">Select Research Type</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="respondents_count" class="form-label">Number of Respondents</label>
                                                        <input type="number" class="form-control" id="respondents_count" name="respondents_count" min="0" value="{{ old('respondents_count') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-4">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Research Document</h5>
                                            </div>
                                            <div class="card-body">
                                            <div class="row mb-3">
    <div class="col-md-12">
        <label for="research_file" class="form-label">Upload Research Paper (PDF)<span class="text-danger">*</span></label>
        <input type="file" 
               class="filepond" 
               name="research_file" 
               id="research_file" 
               data-max-file-size="10MB" 
               data-allowed-file-types="application/pdf"
               required>
        <div class="invalid-feedback">Please upload a PDF file</div>
        <small class="text-muted">Maximum file size: 10MB</small>
    </div>
</div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                                            <button type="submit" class="btn btn-primary">Submit Research</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Research Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Research Paper Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="view-content">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="fw-bold">Title:</label>
                                        <p id="view-title"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Course:</label>
                                        <p id="view-course"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Year:</label>
                                        <p id="view-year"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Category:</label>
                                        <p id="view-category"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Program:</label>
                                        <p id="view-program"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Research Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="fw-bold">Researchers:</label>
                                        <p id="view-researchers"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="fw-bold">Adviser:</label>
                                        <p id="view-adviser"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="fw-bold">Abstract:</label>
                                        <p id="view-abstract"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="fw-bold">Keywords:</label>
                                        <p id="view-keywords"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Research Methodology</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Research Design:</label>
                                        <p id="view-research_design"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Research Type:</label>
                                        <p id="view-research_type"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Number of Respondents:</label>
                                        <p id="view-respondents_count"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="download-link" class="btn btn-primary">Download Paper</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Research Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Research Paper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editResearchForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-id" name="id">
                        
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="edit-title" class="form-label">Research Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit-title" name="title" required>
                                        <div class="invalid-feedback">Please enter a research title</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edit-course" class="form-label">Course<span class="text-danger">*</span></label>
                                        <select class="form-select" id="edit-course" name="course" required>
                                            <option value="">Select Course</option>
                                            <option value="BSIT">BSIT</option>
                                            <option value="BSN">BSN</option>
                                            <option value="STEM">STEM</option>
                                            <option value="HUMMS">HUMMS</option>
                                            <option value="ABM">ABM</option>
                                            <option value="BLIS">BLIS</option>
                                            <option value="BSBA">BSBA</option>
                                            <option value="BEED">BEED</option>
                                            <option value="BSHM">BSHM</option>
                                            <option value="BSTM">BSTM</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a course</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit-year" class="form-label">Year<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="edit-year" name="year" min="2000" max="{{ date('Y') }}" required>
                                        <div class="invalid-feedback">Please enter a valid year</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edit-category" class="form-label">Category</label>
                                        <select class="form-select" id="edit-category" name="category">
                                            <option value="">Select Category</option>
                                            <option value="Student">Student</option>
                                            <option value="Faculty">Faculty</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit-program" class="form-label">Program</label>
                                        <select class="form-select" id="edit-program" name="program">
                                            <option value="">Select Program</option>
                                            <option value="College">College</option>
                                            <option value="SHS">SHS (Senior High School)</option>
                                            <option value="BED">BED (Basic Education)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Research Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="edit-researchers" class="form-label">Researchers<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="edit-researchers" name="researchers" rows="2" placeholder="Enter researchers names separated by commas" required></textarea>
                                        <div class="invalid-feedback">Please enter researcher names</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="edit-adviser" class="form-label">Adviser<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit-adviser" name="adviser" required>
                                        <div class="invalid-feedback">Please enter adviser name</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="edit-abstract" class="form-label">Abstract<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="edit-abstract" name="abstract" rows="5" required></textarea>
                                        <div class="invalid-feedback">Please enter an abstract</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="edit-keywords" class="form-label">Keywords<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit-keywords" name="keywords" placeholder="Enter keywords separated by commas" required>
                                        <div class="invalid-feedback">Please enter keywords</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Research Methodology</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edit-research_design" class="form-label">Research Design<span class="text-danger">*</span></label>
                                        <select class="form-select" id="edit-research_design" name="research_design" required>
                                            <option value="">Select Research Design</option>
                                            <option value="Qualitative">Qualitative</option>
                                            <option value="Quantitative">Quantitative</option>
                                            <option value="Mixed Method">Mixed Method</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a research design</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit-research_type" class="form-label">Research Type</label>
                                        <select class="form-select" id="edit-research_type" name="research_type">
                                            <option value="">Select Research Type</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edit-respondents_count" class="form-label">Number of Respondents</label>
                                        <input type="number" class="form-control" id="edit-respondents_count" name="respondents_count" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Research Document</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="edit-research_file" class="form-label">Upload Research Paper (PDF)</label>
                                        <input type="file" class="form-control" id="edit-research_file" name="research_file" accept="application/pdf">
                                        <small class="text-muted">Leave empty to keep the current file. Maximum file size: 10MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEdit">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Load CSS & JS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <!-- Add Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Register FilePond plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize
    );

    // Initialize FilePond
    document.addEventListener('DOMContentLoaded', function() {
        FilePond.setOptions({
            labelIdle: 'Drag & Drop your research paper PDF or <span class="filepond--label-action">Browse</span>',
            labelFileTypeNotAllowed: 'Invalid file type. Only PDF files are allowed.',
            labelMaxFileSizeExceeded: 'File is too large',
            labelMaxFileSize: 'Maximum file size is 10MB',
            acceptedFileTypes: ['application/pdf'],
            maxFileSize: '10MB',
            server: {
                url: '{{ route("head.research.filepond-upload") }}', // Create this route
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        // Create a FilePond instance
        const pond = FilePond.create(document.querySelector('input[name="research_file"]'));
    });
</script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var dataTable = $('#researchDataTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search research papers...",
                    lengthMenu: "_MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records available",
                    infoFiltered: "(filtered from _MAX_ total records)"
                },
                order: [[10, 'desc']], // Order by submission date (newest first)
        columnDefs: [
            { orderable: false, targets: 11 } // Disable sorting on the Actions column
        ]
    });

            // Handle Create Form Submission with SweetAlert
            $('#researchForm').on('submit', function(e) {
                e.preventDefault();
                
                // Check form validity
                if (!this.checkValidity()) {
                    e.stopPropagation();
                    $(this).addClass('was-validated');
                    return false;
                }
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Research paper submitted successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then((result) => {
                            // Refresh or redirect
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        // Format error messages
                        var errors = '';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errors += value + '<br>';
                            });
                        } else {
                            errors = 'An error occurred while submitting the research paper.';
                        }
                        
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            html: errors,
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

            // Populate research type dropdown based on selected research design
            $('#research_design, #edit-research_design').on('change', function() {
                var researchType;
                if ($(this).attr('id') === 'research_design') {
                    researchType = $('#research_type');
                } else {
                    researchType = $('#edit-research_type');
                }
                
                researchType.empty().append('<option value="">Select Research Type</option>');
                
                if (this.value === 'Qualitative') {
                    const types = ['Phenomenology', 'Case Study', 'Narrative', 'Multi Case Study'];
                    types.forEach(type => {
                        researchType.append(`<option value="${type}">${type}</option>`);
                    });
                } else if (this.value === 'Quantitative') {
                    const types = ['Descriptive', 'Correlational', 'Causal-Comparative', 'Experimental'];
                    types.forEach(type => {
                        researchType.append(`<option value="${type}">${type}</option>`);
                    });
                } else if (this.value === 'Mixed Method') {
                    const types = ['Convergent Parallel', 'Explanatory Sequential', 'Exploratory Sequential'];
                    types.forEach(type => {
                        researchType.append(`<option value="${type}">${type}</option>`);
                    });
                }
            });

            // View Research Paper - Load data into modal
            $(document).on('click', '.view-btn', function() {
                var id = $(this).data('id');
                
                $.ajax({
                    url: `/api/research/${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Populate view modal with research data
                        $('#view-title').text(data.title || 'N/A');
                        $('#view-course').text(data.course || 'N/A');
                        $('#view-year').text(data.year || 'N/A');
                        $('#view-category').text(data.category || 'N/A');
                        $('#view-program').text(data.program || 'N/A');
                        $('#view-researchers').text(data.researchers || 'N/A');
                        $('#view-adviser').text(data.adviser || 'N/A');
                        $('#view-abstract').text(data.abstract || 'N/A');
                        $('#view-research_design').text(data.research_design || 'N/A');
                        $('#view-research_type').text(data.research_type || 'N/A');
                        $('#view-respondents_count').text(data.respondents_count || 'N/A');
                        if (data.keywords) {
                const keywordsHtml = data.keywords.split(',')
                    .map(keyword => `<span class="badge bg-info me-1">${keyword.trim()}</span>`)
                    .join(' ');
                $('#view-keywords').html(keywordsHtml);
            } else {
                $('#view-keywords').text('N/A');
            }
                        // Set download link
                        $('#download-link').attr('href', '/head/research/' + id + '/download');
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to load research details.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

            // Edit Research Paper - Load data into modal
            $(document).on('click', '.report-btn', function() {
    var id = $(this).data('id');
    
    Swal.fire({
        title: 'Generate Report',
        text: "Do you want to generate a report for this research paper?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, generate report'
    }).then((result) => {
        if (result.isConfirmed) {
            // Fix for 404 error - Use absolute path and ensure query parameter is included
            window.location.href = "/head/research/generate-report?id=" + id;
        }
    });
});

            // Handle Edit Form Submission
            $('#saveEdit').on('click', function() {
                var form = $('#editResearchForm')[0];
                
                // Check form validity
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }
                
                var formData = new FormData(form);
                
                $.ajax({
                    url: $('#editResearchForm').attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#editModal').modal('hide');
                        
                        Swal.fire({
                            title: 'Success!',
                            text: 'Research paper updated successfully.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        var errors = '';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errors += value + '<br>';
                            });
                        } else {
                            errors = 'An error occurred while updating the research paper.';
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            html: errors,
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });
// Initialize Select2 for keywords
$('.select2-keywords').select2({
    tags: true,
    tokenSeparators: [','],
    placeholder: "Enter keywords separated by commas",
    theme: $('.dark').length ? 'select2-dark' : 'default'
});

// Custom styling for Select2 in dark mode
if ($('.dark').length) {
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .select2-dark.select2-container--default .select2-selection--multiple {
                background-color: #374151 !important;
                border-color: #4b5563 !important;
                color: #e5e7eb !important;
            }
            .select2-dark.select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #4b5563 !important;
                border-color: #6b7280 !important;
                color: #e5e7eb !important;
            }
            .select2-dark.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: #9ca3af !important;
            }
            .select2-dropdown {
                background-color: #374151 !important;
                border-color: #4b5563 !important;
                color: #e5e7eb !important;
            }
            .select2-search__field {
                background-color: #1f2937 !important;
                color: #e5e7eb !important;
            }
            .select2-results__option {
                color: #e5e7eb !important;
            }
            .select2-results__option--highlighted {
                background-color: #3b82f6 !important;
            }
        `)
        .appendTo('head');
}

            // Delete Research Paper
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/head/research/${id}`,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function() {
                                Swal.fire(
                                    'Deleted!',
                                    'Your research paper has been deleted.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the research paper.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // Generate Report Button Click
            $(document).on('click', '.report-btn', function() {
                var id = $(this).data('id');
                
                Swal.fire({
                    title: 'Generate Report',
                    text: "Do you want to generate a report for this research paper?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, generate report'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Fix for 404 error - Use the correct URL for generating reports
                        // Adding the ID as a query parameter
                        window.location.href = "{{ route('head.research.generate-report') }}?id=" + id;
                    }
                });
            });

            // Initialize any SweetAlert messages from session
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#3085d6'
                });
            @endif
            
            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            @endif
        });
    </script>

    <style>
        /* Dark mode compatibility */
        .dark .card {
            background-color: #1f2937;
            color: #e5e7eb;
        }
        .dark .card-header {
            background-color: #1e40af !important;
        }
        .dark .form-control, 
        .dark .form-select {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }
        .dark .form-control:focus, 
        .dark .form-select:focus {
            background-color: #374151;
            color: #e5e7eb;
        }
        .dark .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .dark .btn-secondary {
            background-color: #6b7280;
            border-color: #6b7280;
        }
        .dark label {
            color: #e5e7eb;
        }
        .dark .text-muted {
            color: #9ca3af !important;
        }
        
        /* DataTables Dark Mode */
        .dark .dataTables_wrapper .dataTables_length, 
        .dark .dataTables_wrapper .dataTables_filter, 
        .dark .dataTables_wrapper .dataTables_info, 
        .dark .dataTables_wrapper .dataTables_processing, 
        .dark .dataTables_wrapper .dataTables_paginate {
            color: #e5e7eb;
        }
        
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #e5e7eb !important;
        }
        
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #3b82f6 !important;
            color: white !important;
            border-color: #3b82f6 !important;
        }
        
        /* Tabs styling */
        .nav-tabs .nav-link {
            color: #6b7280;
            border: none;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid transparent;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
            background-color: transparent;
        }
        
        .dark .nav-tabs .nav-link {
            color: #9ca3af;
        }
        
        .dark .nav-tabs .nav-link.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
            background-color: transparent;
        }
        
        /* Badge colors */
        .badge.bg-success {
            background-color: #10b981 !important;
        }
        
        .badge.bg-warning {
            background-color: #f59e0b !important;
        }
        
        .badge.bg-secondary {
            background-color: #6b7280 !important;
        }
        
        /* Modal styling */
        .modal-content {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .dark .modal-content {
            background-color: #1f2937;
            color: #e5e7eb;
        }
        
        .dark .modal-header {
            border-bottom: 1px solid #374151;
        }
        
        .dark .modal-footer {
            border-top: 1px solid #374151;
        }
        
        /* View Modal Styling */
        .view-content label.fw-bold {
            display: block;
            margin-bottom: 0.25rem;
            color: #4b5563;
        }
        
        .dark .view-content label.fw-bold {
            color: #9ca3af;
        }
        
        .view-content p {
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #f9fafb;
            border-radius: 0.25rem;
        }
        
        .dark .view-content p {
            background-color: #374151;
        }
        .filepond--panel-root {
        background-color: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 0.375rem;
    }
    
    .dark .filepond--panel-root {
        background-color: #374151;
        border-color: #4b5563;
    }
    /* Additional styles for the improved table */
#researchDataTable {
    width: 100% !important;
}

.dataTables_wrapper .dataTables_scroll {
    margin-bottom: 1rem;
}

.dataTables_scrollBody {
    min-height: 400px;
}

/* Style for clickable research titles */
#researchDataTable tbody tr td:first-child a {
    font-weight: 500;
    text-decoration: none;
}

#researchDataTable tbody tr td:first-child a:hover {
    text-decoration: underline;
}

/* Dark mode compatibility for scrollable table */
.dark .dataTables_scrollBody::-webkit-scrollbar-track {
    background: #374151;
}

.dark .dataTables_scrollBody::-webkit-scrollbar-thumb {
    background-color: #6b7280;
    border-radius: 6px;
    border: 3px solid #374151;
}

/* Responsive table for smaller screens */
@media (max-width: 1200px) {
    #researchDataTable {
        display: block;
        width: 100%;
        overflow-x: auto;
    }
}
/* Fix dark mode in research index */
.dark .table {
    color: #e5e7eb;
}

.dark .table-hover tbody tr:hover {
    background-color: rgba(59, 130, 246, 0.1);
}

.dark .table thead th {
    background-color: #1e40af;
    color: white;
    border-color: #374151;
}

.dark .table-bordered,
.dark .table-bordered td,
.dark .table-bordered th {
    border-color: #4b5563;
}

.dark .bg-white,
.dark .bg-light {
    background-color: #1f2937 !important;
}

.dark .text-dark {
    color: #e5e7eb !important;
}

/* Fix Bootstrap component dark mode */
.dark .card,
.dark .modal-content,
.dark .nav-tabs {
    background-color: #1f2937 !important;
}

.dark .tab-content,
.dark .tab-pane {
    background-color: #1f2937 !important;
    color: #e5e7eb !important;
}

/* Fix Bootstrap form elements */
.dark .form-control,
.dark .form-select,
.dark .input-group-text {
    background-color: #374151 !important;
    color: #e5e7eb !important;
    border-color: #4b5563 !important;
}

/* DataTables specific dark mode fixes */
.dark .dataTables_wrapper .dataTables_length select,
.dark .dataTables_wrapper .dataTables_filter input {
    background-color: #374151;
    color: #e5e7eb;
    border-color: #4b5563;
}

.dark div.dataTables_wrapper div.dataTables_processing {
    background-color: rgba(31, 41, 55, 0.7);
}

.dark table.dataTable tbody tr {
    background-color: #1f2937;
}

.dark table.dataTable.stripe tbody tr.odd {
    background-color: #283548;
}

.dark table.dataTable.hover tbody tr:hover,
.dark table.dataTable.hover tbody tr.odd:hover,
.dark table.dataTable.hover tbody tr.even:hover {
    background-color: #2d3a4f;
}
    </style>
</x-app-layout>