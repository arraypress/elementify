/**
 * Accordion Component JavaScript
 *
 * Handles accordion section toggling, multiple section support, and content visibility
 */
document.addEventListener('DOMContentLoaded', function () {
    // Find all accordions
    const accordions = document.querySelectorAll('.accordion');

    accordions.forEach(function (accordion) {
        // Get accordion ID
        const accordionId = accordion.id;
        // Check if multiple sections can be open
        const allowMultiple = accordion.getAttribute('data-allow-multiple') === 'true';
        // Find all headers
        const headers = accordion.querySelectorAll('.accordion-header');

        headers.forEach(function (header) {
            header.addEventListener('click', function () {
                const sectionId = this.getAttribute('data-section');
                const content = document.getElementById(sectionId);
                const isActive = this.classList.contains('active');

                // If not allowing multiple and this section is not active, close all sections
                if (!allowMultiple && !isActive) {
                    headers.forEach(function (h) {
                        h.classList.remove('active');
                    });

                    accordion.querySelectorAll('.accordion-content').forEach(function (c) {
                        c.style.display = 'none';
                    });
                }

                // Toggle this section
                this.classList.toggle('active');
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });
    });
});