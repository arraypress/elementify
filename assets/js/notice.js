document.addEventListener('DOMContentLoaded', function () {
    // Find all dismissible notices
    const notices = document.querySelectorAll('.notice.is-dismissible');

    notices.forEach(function (notice) {
        const dismissButton = notice.querySelector('.notice-dismiss');
        if (!dismissButton) return;

        dismissButton.addEventListener('click', function () {
            notice.style.display = 'none';
        });
    });
});