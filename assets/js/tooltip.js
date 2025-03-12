/**
 * Tooltip Component JavaScript
 *
 * Handles tooltip positioning, triggers, and accessibility
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize all tooltips
        initTooltips();
    });

    function initTooltips() {
        // Changed selector to match your HTML structure
        const tooltipWrappers = document.querySelectorAll('.tooltip');

        tooltipWrappers.forEach(function (wrapper) {
            const target = wrapper.querySelector('[data-tooltip="true"]');
            const tooltip = wrapper.querySelector('.tooltip-content');

            if (!target || !tooltip) return;

            const trigger = target.getAttribute('data-tooltip-trigger') || 'hover';
            const delay = parseInt(target.getAttribute('data-tooltip-delay') || '0', 10);

            // Set ARIA attributes for accessibility
            const tooltipId = 'tooltip-' + Math.random().toString(36).substr(2, 9);
            tooltip.id = tooltipId;
            target.setAttribute('aria-describedby', tooltipId);

            // Add trigger attributes to tooltip content
            tooltip.setAttribute('data-tooltip-trigger', trigger);

            // Handle different trigger types
            switch (trigger) {
                case 'hover':
                    setupHoverTrigger(wrapper, target, tooltip, delay);
                    break;
                case 'click':
                    setupClickTrigger(wrapper, target, tooltip, delay);
                    break;
                case 'focus':
                    setupFocusTrigger(wrapper, target, tooltip, delay);
                    break;
            }

            // Handle positioning check on window resize
            window.addEventListener('resize', function () {
                checkPosition(tooltip);
            });
        });
    }

    function setupHoverTrigger(wrapper, target, tooltip, delay) {
        let timeout;

        // Show on hover
        target.addEventListener('mouseenter', function () {
            clearTimeout(timeout);
            if (delay > 0) {
                timeout = setTimeout(function () {
                    showTooltip(tooltip);
                    checkPosition(tooltip);
                }, delay);
            } else {
                showTooltip(tooltip);
                checkPosition(tooltip);
            }
        });

        // Hide when mouse leaves
        wrapper.addEventListener('mouseleave', function () {
            clearTimeout(timeout);
            hideTooltip(tooltip);
        });

        // Also handle focus for accessibility
        target.addEventListener('focus', function () {
            showTooltip(tooltip);
            checkPosition(tooltip);
        });

        target.addEventListener('blur', function () {
            hideTooltip(tooltip);
        });
    }

    function setupClickTrigger(wrapper, target, tooltip, delay) {
        let isVisible = false;

        target.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (isVisible) {
                hideTooltip(tooltip);
                wrapper.classList.remove('tooltip-active');
                isVisible = false;
            } else {
                if (delay > 0) {
                    setTimeout(function () {
                        showTooltip(tooltip);
                        checkPosition(tooltip);
                        wrapper.classList.add('tooltip-active');
                        isVisible = true;
                    }, delay);
                } else {
                    showTooltip(tooltip);
                    checkPosition(tooltip);
                    wrapper.classList.add('tooltip-active');
                    isVisible = true;
                }
            }
        });

        // Hide on click outside
        document.addEventListener('click', function (e) {
            if (isVisible && !wrapper.contains(e.target)) {
                hideTooltip(tooltip);
                wrapper.classList.remove('tooltip-active');
                isVisible = false;
            }
        });

        // Handle escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isVisible) {
                hideTooltip(tooltip);
                wrapper.classList.remove('tooltip-active');
                isVisible = false;
            }
        });
    }

    function setupFocusTrigger(wrapper, target, tooltip, delay) {
        target.addEventListener('focus', function () {
            if (delay > 0) {
                setTimeout(function () {
                    showTooltip(tooltip);
                    checkPosition(tooltip);
                }, delay);
            } else {
                showTooltip(tooltip);
                checkPosition(tooltip);
            }
        });

        target.addEventListener('blur', function () {
            hideTooltip(tooltip);
        });
    }

    function showTooltip(tooltip) {
        tooltip.style.visibility = 'visible';
        tooltip.style.opacity = '1';
    }

    function hideTooltip(tooltip) {
        tooltip.style.visibility = 'hidden';
        tooltip.style.opacity = '0';
    }

    function checkPosition(tooltip) {
        // Get tooltip position
        const position = tooltip.classList.contains('tooltip-top') ? 'top' :
            tooltip.classList.contains('tooltip-right') ? 'right' :
                tooltip.classList.contains('tooltip-bottom') ? 'bottom' : 'left';

        const rect = tooltip.getBoundingClientRect();
        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;

        // Check if tooltip is off-screen
        const isOffRight = rect.right > windowWidth;
        const isOffLeft = rect.left < 0;
        const isOffTop = rect.top < 0;
        const isOffBottom = rect.bottom > windowHeight;

        // If tooltip is off-screen, adjust its position
        if (isOffRight && position === 'right') {
            tooltip.classList.remove('tooltip-right');
            tooltip.classList.add('tooltip-left');
        } else if (isOffLeft && position === 'left') {
            tooltip.classList.remove('tooltip-left');
            tooltip.classList.add('tooltip-right');
        } else if (isOffTop && position === 'top') {
            tooltip.classList.remove('tooltip-top');
            tooltip.classList.add('tooltip-bottom');
        } else if (isOffBottom && position === 'bottom') {
            tooltip.classList.remove('tooltip-bottom');
            tooltip.classList.add('tooltip-top');
        }
    }
})();