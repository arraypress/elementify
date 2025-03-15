/**
 * Elementify Range With Display Component
 *
 * Handles the functionality of the range slider with value display.
 */
(function ($) {
    'use strict';

    /**
     * Initialize all range with display elements
     */
    function initRangeWithDisplay() {
        $('.elementify-range-input').each(function () {
            const $input = $(this);
            const $displayElement = $('#' + $input.data('display-id'));

            // Update display on input change
            $input.on('input change', function () {
                updateDisplay($input, $displayElement);
            });

            // Initial update
            updateDisplay($input, $displayElement);
        });
    }

    /**
     * Update the display value
     *
     * @param {jQuery} $input Range input element
     * @param {jQuery} $display Display element
     */
    function updateDisplay($input, $display) {
        if ($display.length) {
            // Format the value if needed (e.g., adding units, decimal places)
            const value = formatValue($input.val(), $input);
            $display.text(value);
        }
    }

    /**
     * Format the value with units or decimal places if needed
     *
     * @param {string|number} value The raw value
     * @param {jQuery} $input The input element with optional data attributes
     * @return {string} The formatted value
     */
    function formatValue(value, $input) {
        // Check for custom formatting options via data attributes
        const decimals = $input.data('decimals') || 0;
        const unit = $input.data('unit') || '';

        // If it's a number and decimals are specified, format it
        if (!isNaN(value) && decimals > 0) {
            value = parseFloat(value).toFixed(decimals);
        }

        // Add unit if specified
        if (unit) {
            value = value + unit;
        }

        return value;
    }

    // Initialize on document ready
    $(document).ready(function () {
        initRangeWithDisplay();

        // Also handle dynamically added elements
        $(document).on('elementify:components-loaded', initRangeWithDisplay);
    });

})(jQuery);