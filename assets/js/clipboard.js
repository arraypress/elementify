(function () {
    'use strict';

    /**
     * Initialize clipboard functionality
     */
    function init() {
        const copyButtons = document.querySelectorAll('.clipboard-container .clipboard-button');

        copyButtons.forEach(button => {
            if (button.getAttribute('data-initialized') === 'true') {
                return; // Skip already initialized buttons
            }

            // Mark as initialized
            button.setAttribute('data-initialized', 'true');

            // Add click handler
            button.addEventListener('click', handleClick);

            // Add click handler for the text field for better usability
            const container = button.closest('.simple-clipboard-container');
            if (container) {
                const textEl = container.querySelector('.clipboard-text');
                if (textEl) {
                    textEl.addEventListener('click', function () {
                        button.click(); // Trigger the copy button click
                    });
                }
            }
        });
    }

    /**
     * Handle click on copy button
     *
     * @param {Event} event Click event
     */
    function handleClick(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const clipboardId = button.getAttribute('data-clipboard-id');
        if (!clipboardId) return;

        const hiddenInput = document.getElementById(clipboardId);
        if (!hiddenInput) return;

        const container = button.closest('.clipboard-container');
        const textToCopy = hiddenInput.value;

        // Save button's original appearance
        const originalInnerHTML = button.innerHTML;

        // Try to copy using modern clipboard API
        if (navigator && navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    showSuccess(button, container);
                    setTimeout(() => {
                        button.innerHTML = originalInnerHTML;
                        button.classList.remove('success');
                        if (container) container.classList.remove('copied');
                    }, 1500);
                })
                .catch(err => {
                    console.error('Copy failed:', err);
                    fallbackCopy(textToCopy, button, container, originalInnerHTML);
                });
        } else {
            fallbackCopy(textToCopy, button, container, originalInnerHTML);
        }
    }

    /**
     * Fallback copy method for older browsers
     *
     * @param {string} text Text to copy
     * @param {HTMLElement} button Button element
     * @param {HTMLElement} container Container element
     * @param {string} originalHTML Original button HTML
     */
    function fallbackCopy(text, button, container, originalHTML) {
        try {
            // Create temporary textarea
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';  // Avoid scrolling to bottom
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            const successful = document.execCommand('copy');
            document.body.removeChild(textarea);

            if (successful) {
                showSuccess(button, container);
            } else {
                showError(button, container);
            }

            // Reset button after delay
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('success', 'error');
                if (container) container.classList.remove('copied');
            }, 1500);
        } catch (err) {
            console.error('Fallback copy failed:', err);
            showError(button, container);

            // Reset button after delay
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('error');
                if (container) container.classList.remove('copied');
            }, 1500);
        }
    }

    /**
     * Show success state
     *
     * @param {HTMLElement} button Button element
     * @param {HTMLElement} container Container element
     */
    function showSuccess(button, container) {
        button.classList.add('success');
        button.innerHTML = '<span class="dashicons dashicons-yes"></span>';
        if (container) container.classList.add('copied');

        // Optional: Show a temporary tooltip
        const tooltip = document.createElement('div');
        tooltip.className = 'clipboard-tooltip';
        tooltip.textContent = 'Copied!';
        tooltip.style.position = 'absolute';
        tooltip.style.backgroundColor = 'rgba(0,0,0,0.7)';
        tooltip.style.color = '#fff';
        tooltip.style.padding = '4px 8px';
        tooltip.style.borderRadius = '3px';
        tooltip.style.fontSize = '12px';
        tooltip.style.zIndex = '999999';
        tooltip.style.opacity = '0';
        tooltip.style.transition = 'opacity 0.2s ease';

        document.body.appendChild(tooltip);

        // Position the tooltip
        const rect = button.getBoundingClientRect();
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
        tooltip.style.left = (rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)) + 'px';

        // Show the tooltip
        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 10);

        // Hide and remove the tooltip
        setTimeout(() => {
            tooltip.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(tooltip);
            }, 200);
        }, 1000);
    }

    /**
     * Show error state
     *
     * @param {HTMLElement} button Button element
     * @param {HTMLElement} container Container element
     */
    function showError(button, container) {
        button.classList.add('error');
        button.innerHTML = '<span class="dashicons dashicons-no"></span>';
        if (container) container.classList.add('error');
    }

    /**
     * DOM ready helper
     */
    function domReady(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    // Initialize
    domReady(init);

    // Re-initialize on dynamic content
    if (window.MutationObserver) {
        const observer = new MutationObserver(function (mutations) {
            if (mutations.some(m => m.addedNodes.length > 0)) {
                init();
            }
        });

        domReady(() => {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    } else {
        // Fallback for older browsers
        window.addEventListener('load', init);
    }

    // Make init function available
    window.ElementifySimpleClipboard = {init};
})();