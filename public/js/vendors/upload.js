// uplaod

document.getElementById('uploadCard').addEventListener('click', function () {
  const fileInput = document.getElementById('fileInput');
  fileInput.click();

  fileInput.addEventListener(
    'change',
    function () {
      let fileName = this.files.length > 0 ? this.files[0].name : 'No file chosen';
      document.getElementById('fileLabel').textContent = fileName;
    },
    { once: true }
  ); // Using { once: true } to ensure the event listener is triggered only once per click
});
