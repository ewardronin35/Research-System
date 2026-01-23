<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Research Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Course Report -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <h5 class="text-lg font-semibold text-primary dark:text-primary-light mb-4">
                                <i class="fas fa-chart-bar mr-2"></i>Research by Course
                            </h5>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Generate a report of research papers by academic course.
                            </p>
                            <form action="{{ route('head.reports.export') }}" method="GET">
                                <input type="hidden" name="type" value="course">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    <i class="fas fa-download mr-2"></i>Export Course Report
                                </button>
                            </form>
                        </div>

                        <!-- Year Report -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <h5 class="text-lg font-semibold text-success dark:text-success-light mb-4">
                                <i class="fas fa-calendar-alt mr-2"></i>Research by Year
                            </h5>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Export a comprehensive report of research papers by year.
                            </p>
                            <form action="{{ route('head.reports.export') }}" method="GET">
                                <input type="hidden" name="type" value="year">
                                <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-download mr-2"></i>Export Year Report
                                </button>
                            </form>
                        </div>

                        <!-- Methodology Report -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <h5 class="text-lg font-semibold text-info dark:text-info-light mb-4">
                                <i class="fas fa-flask mr-2"></i>Research Methodology
                            </h5>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Generate a report of research papers by methodology.
                            </p>
                            <form action="{{ route('head.reports.export') }}" method="GET">
                                <input type="hidden" name="type" value="methodology">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500">
                                    <i class="fas fa-download mr-2"></i>Export Methodology Report
                                </button>
                            </form>
                        </div>

                        <!-- Category Report -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <h5 class="text-lg font-semibold text-warning dark:text-warning-light mb-4">
                                <i class="fas fa-users mr-2"></i>Research by Category
                            </h5>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Export a report of research papers by category.
                            </p>
                            <form action="{{ route('head.reports.export') }}" method="GET">
                                <input type="hidden" name="type" value="category">
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    <i class="fas fa-download mr-2"></i>Export Category Report
                                </button>
                            </form>
                        </div>

                        <!-- All Research Report -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <h5 class="text-lg font-semibold text-danger dark:text-danger-light mb-4">
                                <i class="fas fa-database mr-2"></i>All Research Papers
                            </h5>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Download a comprehensive report of all research papers.
                            </p>
                            <form action="{{ route('head.reports.export') }}" method="GET">
                                <input type="hidden" name="type" value="all">
                                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    <i class="fas fa-download mr-2"></i>Export All Research
                                </button>
                            </form>
                        </div>

                        <!-- Custom Report Generator -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <h5 class="text-lg font-semibold text-dark dark:text-gray-200 mb-4">
                                <i class="fas fa-cogs mr-2"></i>Custom Report Generator
                            </h5>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Create a customized research report with advanced filters.
                            </p>
                            <button type="button" 
                                    class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                                    x-data 
                                    @click="$dispatch('open-modal', 'custom-report-modal')">
                                <i class="fas fa-tools mr-2"></i>Generate Custom Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Report Modal -->
    <div 
        x-data="{ show: false }"
        x-show="show"
        x-on:open-modal.window="if ($event.detail === 'custom-report-modal') show = true"
        x-on:close-modal.window="if ($event.detail === 'custom-report-modal') show = false"
        x-transition
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity"
                aria-hidden="true"
            >
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
            >
                <form action="{{ route('head.reports.custom') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Custom Research Report Generator
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Courses</label>
                                <select name="course[]" id="course" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSN">BSN</option>
                                    <option value="STEM">STEM</option>
                                    <option value="HUMMS">HUMMS</option>
                                    <option value="ABM">ABM</option>
                                </select>
                            </div>

                            <div>
                                <label for="research_design" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Research Design</label>
                                <select name="research_design[]" id="research_design" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="Qualitative">Qualitative</option>
                                    <option value="Quantitative">Quantitative</option>
                                    <option value="Mixed Method">Mixed Method</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year Range</label>
                                <div class="flex space-x-2">
                                    <input type="number" name="year_start" placeholder="Start Year" 
                                           min="2000" max="{{ date('Y') }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" />
                                    <input type="number" name="year_end" placeholder="End Year" 
                                           min="2000" max="{{ date('Y') }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" />
                                </div>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <select name="category[]" id="category" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="Student">Student</option>
                                    <option value="Faculty">Faculty</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="fields" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Fields to Export</label>
                                <select name="fields[]" id="fields" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="title" selected>Title</option>
                                    <option value="course" selected>Course</option>
                                    <option value="researchers" selected>Researchers</option>
                                    <option value="adviser">Adviser</option>
                                    <option value="year" selected>Year</option>
                                    <option value="category">Category</option>
                                    <option value="research_design">Research Design</option>
                                    <option value="abstract">Abstract</option>
                                    <option value="keywords">Keywords</option>
                                </select>
                            </div>

                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Export Format</label>
                                <select name="format" id="format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600">
                                    <option value="csv">CSV</option>
                                    <option value="excel">Excel</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="report_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Name</label>
                            <input id="report_name" name="report_name" type="text" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600" 
                                   placeholder="Enter a name for your report" />
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" 
                                    @click="show = false"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    document.addEventListener('alpine:init', () => {
        // Initialize Select2 for multiple select dropdowns
        $(document).ready(function() {
            $('select[multiple]').select2({
                placeholder: 'Select options',
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>
@endpush