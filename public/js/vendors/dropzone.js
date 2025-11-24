// Dropzone

Dropzone.autoDiscover = false;

const myDropzone = new Dropzone('#my-dropzone', {
  url: 'https://httpbin.org/post',
  maxFilesize: 5,
  acceptedFiles: 'image/*',
  addRemoveLinks: true,
  autoProcessQueue: true,
});

// Add event listeners
myDropzone.on('addedfile', function (file) {
  console.log('File added: ' + file.name);
  // Find the remove button and add Bootstrap classes
  setTimeout(() => {
    const removeButton = file.previewElement.querySelector('.dz-remove');
    if (removeButton) {
      removeButton.classList.add('btn', 'btn-subtle-primary', 'btn-sm', 'mt-1'); // Add Bootstrap classes
      // Customize text if needed
    }
  }, 10);
});

myDropzone.on('removedfile', function (file) {
  console.log('File removed: ' + file.name);
});

myDropzone.on('success', function (file, response) {
  console.log('File uploaded successfully:', response);
});
