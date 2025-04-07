// resources/js/loading.js
document.addEventListener('DOMContentLoaded', function() {
    // Functions to control the overlay
    window.showLoading = function() {
        document.getElementById('loading-overlay').classList.remove('hidden');
    };
    
    window.hideLoading = function() {
        document.getElementById('loading-overlay').classList.add('hidden');
    };

    // Handle back/forward browser navigation
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Page was loaded from cache (back/forward navigation)
            hideLoading();
        }
    });

    // Handle beforeunload to prevent showing loading on page refresh
    let isRefreshing = false;
    window.addEventListener('beforeunload', function() {
        isRefreshing = true;
        setTimeout(() => {
            isRefreshing = false;
        }, 1000);
    });

    // Add loading state to all links and form submissions
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a');
        
        if (target && 
            !target.classList.contains('no-loading') && 
            !target.hasAttribute('target') &&
            !target.getAttribute('href').startsWith('#')) {
            showLoading();
        }
    });

    // Handle form submissions
    document.addEventListener('submit', function(e) {
        const form = e.target;
        
        if (!form.classList.contains('no-loading')) {
            showLoading();
        }
    });

    // Ensure the overlay is hidden when the page loads
    hideLoading();
});