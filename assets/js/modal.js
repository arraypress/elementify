/**
 * Elementify Modal Component
 *
 * JavaScript for modal components.
 */
document.addEventListener('DOMContentLoaded', function () {
    // Find all modals
    const modals = document.querySelectorAll('.modal-overlay');

    // Process each modal
    modals.forEach(function (modal) {
        // Get modal ID
        const modalId = modal.id;

        // Find close buttons in this modal
        const closeButtons = modal.querySelectorAll('.modal-close');

        // Function to close modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Function to open modal
        function openModal() {
            modal.style.display = 'block';
        }

        // Add click handlers to close buttons
        closeButtons.forEach(function (button) {
            button.addEventListener('click', closeModal);
        });

        // Close modal when clicking outside
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Find all triggers for this modal
        const triggers = document.querySelectorAll(`[data-open-modal="${modalId}"]`);

        // Add click handlers to all triggers
        triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
        });

        // Handle all modal action buttons
        modal.querySelectorAll('[data-modal-action]').forEach(function (button) {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-modal-action');

                // Close the modal for cancel or confirm actions
                if (action === 'cancel' || action === 'confirm') {
                    closeModal();
                }

                // Dispatch a custom event so users can listen for actions
                const event = new CustomEvent('modal-action', {
                    detail: {
                        modalId: modalId,
                        action: action
                    },
                    bubbles: true
                });
                this.dispatchEvent(event);
            });
        });
    });
});