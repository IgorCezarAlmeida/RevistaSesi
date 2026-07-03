document.addEventListener('DOMContentLoaded', function () {
  var confirmButtons = document.querySelectorAll('[data-confirm]');
  confirmButtons.forEach(function (btn) {
    btn.addEventListener('click', function (event) {
      if (!window.confirm(btn.getAttribute('data-confirm'))) {
        event.preventDefault();
      }
    });
  });
});

