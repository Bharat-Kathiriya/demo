document.addEventListener('click', function (event) {
  var target = event.target.closest('[data-confirm]');
  if (!target) {
    return;
  }

  var message = target.getAttribute('data-confirm');
  if (message && !window.confirm(message)) {
    event.preventDefault();
    event.stopPropagation();
  }
});

document.addEventListener('submit', function (event) {
  var form = event.target;
  if (!form || !form.matches('form')) {
    return;
  }

  if (form.dataset.wgcSubmitting === '1') {
    event.preventDefault();
    return;
  }

  form.dataset.wgcSubmitting = '1';
  var submitter = event.submitter || document.activeElement;
  if (!submitter || !form.contains(submitter) || !submitter.matches('button, input[type="submit"]')) {
    submitter = form.querySelector('button[type="submit"], input[type="submit"]');
  }

  window.setTimeout(function () {
    var buttons = form.querySelectorAll('button, input[type="submit"]');
    buttons.forEach(function (button) {
      if (button.disabled) {
        return;
      }
      if (button === submitter) {
        button.classList.add('is-loading');
        if (button.tagName === 'BUTTON') {
          button.textContent = 'Working...';
        } else {
          button.value = 'Working...';
        }
      }
      button.disabled = true;
    });
  }, 0);
});
