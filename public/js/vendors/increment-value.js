// quantity Input

function initializeQuantityControls() {
  // Get all the minus and plus buttons
  const minusButtons = document.querySelectorAll('.quantity-btn.minus');
  const plusButtons = document.querySelectorAll('.quantity-btn.plus');

  // Add event listeners for all minus buttons
  minusButtons.forEach((button) => {
    button.addEventListener('click', function () {
      const quantityInput = this.nextElementSibling;
      let currentValue = parseInt(quantityInput.value);
      if (currentValue > parseInt(quantityInput.min)) {
        quantityInput.value = currentValue - 1;
      }
    });
  });

  // Add event listeners for all plus buttons
  plusButtons.forEach((button) => {
    button.addEventListener('click', function () {
      const quantityInput = this.previousElementSibling;
      let currentValue = parseInt(quantityInput.value);
      quantityInput.value = currentValue + 1;
    });
  });
}

// Initialize the controls
initializeQuantityControls();
