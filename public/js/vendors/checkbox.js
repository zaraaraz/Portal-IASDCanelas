// Checkbox

const checkBox = () => {
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-check-all]').forEach((checkAll) => {
      checkAll.addEventListener('click', function () {
        const container = this.closest('[data-check-container]');
        const checkboxes = container.querySelectorAll('input[type="checkbox"]:not([data-check-all])');

        checkboxes.forEach((checkbox) => {
          checkbox.checked = this.checked;
        });

        checkAll.removeAttribute('data-indeterminate');
      });

      const container = checkAll.closest('[data-check-container]');
      const checkboxes = container.querySelectorAll('input[type="checkbox"]:not([data-check-all])');

      checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('click', function () {
          const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
          const someChecked = Array.from(checkboxes).some((cb) => cb.checked);

          if (allChecked) {
            checkAll.checked = true;
            checkAll.removeAttribute('data-indeterminate');
          } else if (someChecked) {
            checkAll.checked = false;
            checkAll.setAttribute('data-indeterminate', 'true');
          } else {
            checkAll.checked = false;
            checkAll.removeAttribute('data-indeterminate');
          }
        });
      });
    });
  });
};

checkBox();
