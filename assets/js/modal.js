(function () {
    'use strict';

    /**
     * Modal functionality
     */
    class ElementifyModal {
        constructor(element) {
            this.modal = element;
            this.backdrop = element.querySelector('.modal-backdrop');
            this.dialog = element.querySelector('.modal-dialog');
            this.closeButtons = element.querySelectorAll('.modal-close, [data-dismiss="modal"]');

            this.init();
        }

        init() {
            // Close button handlers
            this.closeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.hide();
                });
            });

            // Backdrop click to close
            if (this.backdrop) {
                this.backdrop.addEventListener('click', (e) => {
                    if (e.target === this.backdrop) {
                        // Check if backdrop closing is disabled
                        if (!this.modal.dataset.backdrop || this.modal.dataset.backdrop !== 'static') {
                            this.hide();
                        }
                    }
                });
            }

            // ESC key to close
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isVisible()) {
                    this.hide();
                }
            });

            // Prevent dialog clicks from closing modal
            if (this.dialog) {
                this.dialog.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
        }

        show() {
            this.modal.style.display = 'block';
            this.modal.classList.add('show');
            this.modal.classList.remove('hide');

            // Focus management
            this.modal.setAttribute('aria-hidden', 'false');

            // Lock body scroll
            document.body.style.overflow = 'hidden';

            // Focus first focusable element
            setTimeout(() => {
                const focusable = this.modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if (focusable) {
                    focusable.focus();
                }
            }, 150);

            // Trigger custom event
            this.modal.dispatchEvent(new CustomEvent('modal:show'));
        }

        hide() {
            this.modal.classList.add('hide');
            this.modal.classList.remove('show');

            setTimeout(() => {
                this.modal.style.display = 'none';
                this.modal.setAttribute('aria-hidden', 'true');

                // Restore body scroll
                document.body.style.overflow = '';

                // Trigger custom event
                this.modal.dispatchEvent(new CustomEvent('modal:hide'));
            }, 150);
        }

        toggle() {
            if (this.isVisible()) {
                this.hide();
            } else {
                this.show();
            }
        }

        isVisible() {
            return this.modal.style.display === 'block' || this.modal.classList.contains('show');
        }
    }

    /**
     * Initialize modals
     */
    function initModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (!modal.elementifyModal) {
                modal.elementifyModal = new ElementifyModal(modal);
            }
        });
    }

    /**
     * Global modal controls
     */
    function initModalTriggers() {
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal-target]');
            if (trigger) {
                e.preventDefault();
                const targetId = trigger.dataset.modalTarget;
                const modal = document.getElementById(targetId);
                if (modal && modal.elementifyModal) {
                    modal.elementifyModal.show();
                }
            }
        });
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

    // Initialize everything
    domReady(() => {
        initModals();
        initModalTriggers();
    });

    // Re-initialize on dynamic content
    if (window.MutationObserver) {
        const observer = new MutationObserver((mutations) => {
            if (mutations.some(m => m.addedNodes.length > 0)) {
                initModals();
            }
        });

        domReady(() => {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    }

    // Global API
    window.ElementifyModal = {
        init: initModals,
        show: function (modalId) {
            const modal = document.getElementById(modalId);
            if (modal && modal.elementifyModal) {
                modal.elementifyModal.show();
            }
        },
        hide: function (modalId) {
            const modal = document.getElementById(modalId);
            if (modal && modal.elementifyModal) {
                modal.elementifyModal.hide();
            }
        }
    };

})();