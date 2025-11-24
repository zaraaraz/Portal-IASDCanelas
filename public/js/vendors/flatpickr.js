// flatpickr
const flatpickrElements = document.querySelectorAll('.flatpickr');
if (flatpickrElements.length) {
  flatpickrElements.forEach((element) => {
    flatpickr(element, {
      disableMobile: true,
    });
  });
}

const timepickrElements = document.querySelectorAll('.timepickr');
if (timepickrElements.length) {
  timepickrElements.forEach((element) => {
    flatpickr(element, {
      enableTime: true,
      noCalendar: true,
      dateFormat: 'H:i',
    });
  });
}
