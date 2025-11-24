// Colorpicker.js

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.color-palette').forEach(function (element) {
    element.addEventListener('click', function () {
      var colorCodeElement = this.querySelector('.color-swatch-body-value');
      if (!colorCodeElement) {
        console.error('Color code element not found!');
        return;
      }

      var copyText = colorCodeElement.textContent.trim();

      // Try copying using Clipboard API
      navigator.clipboard
        .writeText(copyText)
        .then(function () {
          console.log('Copied to clipboard:', copyText);
        })
        .catch(function () {
          // Fallback if Clipboard API fails
          fallbackCopyTextToClipboard(copyText);
        });

      // Create tooltip element
      var tooltip = document.createElement('div');
      tooltip.className = 'customTooltip';
      tooltip.textContent = `Copied! ${copyText}`;

      var rect = element.getBoundingClientRect();
      tooltip.style.position = 'absolute';
      tooltip.style.position = 'absolute';
      tooltip.style.top = `${rect.top + window.pageYOffset}px`;
      tooltip.style.left = `${rect.left + window.pageXOffset}px`;

      // Append and adjust with CSS transform
      document.body.appendChild(tooltip);

      // Apply transform to offset tooltip by percentage
      tooltip.style.transform = 'translate(28%, 28%)'; // Example offsets

      setTimeout(function () {
        tooltip.parentNode.removeChild(tooltip);
      }, 1000);
    });
  });
});
