// calendar js

document.addEventListener('DOMContentLoaded', function () {
  // Initialize variables
  const calendarEl = document.getElementById('calendar');
  const calendarTitle = document.getElementById('calendar-title');
  const addEventButton = document.getElementById('add-new-event-btn');
  const updateEventButton = document.getElementById('update-event-btn');
  const deleteEventButton = document.getElementById('btn-delete-event');
  const editEventButton = document.getElementById('btn-edit-event');
  const createEventButton = document.getElementById('create-new-event-btn');
  const todayBtn = document.getElementById('today-btn');
  const prevMonthBtn = document.getElementById('prev-month');
  const nextMonthBtn = document.getElementById('next-month');
  const calendarViewSelect = document.getElementById('calendar-view');
  const addEditEventModal = new bootstrap.Modal(document.getElementById('add-edit-event-modal'));
  const viewEventModal = new bootstrap.Modal(document.getElementById('view-event-modal'));

  const defaultEvents = [
    {
      id: 1,
      title: 'Company Meeting',
      start: moment().startOf('month').add(5, 'days').format('YYYY-MM-DD'),
      description: 'Discuss project updates',
      className: 'bg-primary-subtle text-primary-emphasis',
    },
    {
      id: 2,
      title: 'Product Launch',
      start: moment().startOf('month').add(12, 'days').format('YYYY-MM-DD'),
      end: moment().startOf('month').add(15, 'days').format('YYYY-MM-DD'),
      description: 'Launch new product',
      className: 'bg-success-subtle text-success-emphasis',
    },
  ];

  let selectedEvent = null;

  // Initialize Flatpickr
  const flatpickrConfig = {
    enableTime: true,
    dateFormat: 'Y-m-d H:i',
  };
  flatpickr('#eventStart', flatpickrConfig);
  flatpickr('#eventEnd', flatpickrConfig);

  // Initialize FullCalendar
  const calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: false,
    initialView: 'dayGridMonth',
    initialDate: moment().format('YYYY-MM-DD'),
    editable: true,
    selectable: true,
    events: defaultEvents,
    height: '65vh',
    // contentHeight: 'auto', // Adjust content height dynamically if needed
    eventClick: function (info) {
      selectedEvent = info.event;
      document.getElementById('view-event-modal-title').innerText = selectedEvent.title;
      document.getElementById('view-event-description').innerText = selectedEvent.extendedProps.description || 'No description';
      document.getElementById('view-event-dates').innerText =
        selectedEvent.start && selectedEvent.end ? `${selectedEvent.start.toLocaleString()} - ${selectedEvent.end.toLocaleString()}` : selectedEvent.start.toLocaleString();
      document.getElementById('view-event-location').innerText = selectedEvent.extendedProps.location || 'No location specified';
      document.getElementById('selected-event-id').value = selectedEvent.id;
      viewEventModal.show();
    },
    dateClick: function (info) {
      clearEventForm();
      document.getElementById('eventStart')._flatpickr.setDate(info.date);
      addEventButton.classList.remove('d-none'); // Show "Add Event" button
      updateEventButton.classList.add('d-none'); // Hide "Update Event" button
      addEditEventModal.show();
    },
  });

  calendar.render();

  const updateCalendarTitle = () => {
    calendarTitle.textContent = calendar.view.title;
  };
  updateCalendarTitle();

  // Event Handlers
  prevMonthBtn.addEventListener('click', () => {
    calendar.prev();
    updateCalendarTitle();
  });

  nextMonthBtn.addEventListener('click', () => {
    calendar.next();
    updateCalendarTitle();
  });

  todayBtn.addEventListener('click', () => {
    calendar.today();
    updateCalendarTitle();
  });

  calendarViewSelect.addEventListener('change', (e) => {
    calendar.changeView(e.target.value);
    updateCalendarTitle();
  });

  createEventButton.addEventListener('click', () => {
    clearEventForm();
    addEventButton.classList.remove('d-none'); // Show "Add Event" button
    updateEventButton.classList.add('d-none'); // Hide "Update Event" button
    addEditEventModal.show();
  });

  addEventButton.addEventListener('click', (e) => {
    e.preventDefault();
    const newEvent = {
      id: defaultEvents.length + 1,
      title: document.getElementById('event-title').value,
      start: document.getElementById('eventStart').value,
      end: document.getElementById('eventEnd').value || null,
      description: document.getElementById('event-description').value,
      location: document.getElementById('event-location').value,
      className: document.getElementById('event-category').value,
    };
    calendar.addEvent(newEvent);
    defaultEvents.push(newEvent);
    addEditEventModal.hide();
    clearEventForm();
  });

  updateEventButton.addEventListener('click', (e) => {
    e.preventDefault();

    if (selectedEvent) {
      selectedEvent.setProp('title', document.getElementById('event-title').value);
      selectedEvent.setStart(document.getElementById('eventStart').value);
      selectedEvent.setEnd(document.getElementById('eventEnd').value || null);
      selectedEvent.setExtendedProp('description', document.getElementById('event-description').value);
      selectedEvent.setExtendedProp('location', document.getElementById('event-location').value);
      selectedEvent.setProp('classNames', [document.getElementById('event-category').value]);
      addEditEventModal.hide();
      clearEventForm();
    }
  });

  deleteEventButton.addEventListener('click', () => {
    if (selectedEvent) {
      selectedEvent.remove();
      viewEventModal.hide();
    }
  });

  // Prepare form for editing an existing event
  editEventButton.addEventListener('click', () => {
    if (selectedEvent) {
      document.getElementById('event-title').value = selectedEvent.title;
      document.getElementById('eventStart')._flatpickr.setDate(selectedEvent.start);
      document.getElementById('eventEnd')._flatpickr.setDate(selectedEvent.end || null);
      document.getElementById('event-description').value = selectedEvent.extendedProps.description || '';
      document.getElementById('event-location').value = selectedEvent.extendedProps.location || '';
      document.getElementById('event-category').value = selectedEvent.classNames[0];

      addEventButton.classList.add('d-none'); // Hide "Add Event" button
      updateEventButton.classList.remove('d-none'); // Show "Update Event" button
      addEditEventModal.show();
      viewEventModal.hide();
    }
  });

  const clearEventForm = () => {
    document.getElementById('event-title').value = '';
    document.getElementById('eventStart')._flatpickr.clear();
    document.getElementById('eventEnd')._flatpickr.clear();
    document.getElementById('event-description').value = '';
    document.getElementById('event-location').value = '';
    document.getElementById('event-category').value = 'bg-primary-subtle';
    selectedEvent = null;
  };
});
