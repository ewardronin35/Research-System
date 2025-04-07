<!-- resources/views/components/loading-overlay.blade.php -->

<div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-xl flex flex-col items-center">
        <div class="animate-spin mb-4">
            <img src="{{ asset('pilarLogo.png') }}" alt="Pilar Logo" class="w-24 h-24">
        </div>
        <div class="mt-2 text-indigo-600 dark:text-indigo-400 font-semibold">Loading...</div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Functions to control the overlay
        window.showLoading = function() {
            document.getElementById('loading-overlay').classList.remove('hidden');
        };
        
        window.hideLoading = function() {
            document.getElementById('loading-overlay').classList.add('hidden');
        };

        // Hide loading after a small delay when page is fully loaded
        window.addEventListener('load', function() {
            // Use a timeout to ensure everything is fully rendered
            setTimeout(function() {
                hideLoading();
            }, 300); // 300ms delay to ensure everything is fully loaded
        });

        // Show loading when navigating away
        window.addEventListener('beforeunload', function(e) {
            // Only show loading if it's an actual navigation, not a page refresh
            if (e.currentTarget.performance.navigation.type !== 1) {
                showLoading();
            }
        });
        
        // Force hide loading after a maximum time (failsafe)
        setTimeout(function() {
            hideLoading();
        }, 5000); // 5 seconds maximum loading time
    });
</script>