document.addEventListener('DOMContentLoaded', function () {
    // Find all tab containers
    const tabContainers = document.querySelectorAll('.tabs-container');

    tabContainers.forEach(function (tabContainer) {
        const tabLinks = tabContainer.querySelectorAll('.tabs-nav a');

        tabLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Remove active class from all tabs
                tabLinks.forEach(function (tab) {
                    tab.classList.remove('active');
                });

                // Hide all tab content
                tabContainer.querySelectorAll('.tab-content').forEach(function (content) {
                    content.classList.remove('active');
                });

                // Add active class to clicked tab
                this.classList.add('active');

                // Show corresponding tab content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
});