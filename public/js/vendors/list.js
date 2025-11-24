// list js

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-list]').forEach((listElement) => {
    if (!listElement.id) return; // Ensure the element has an ID

    var dataListValue = listElement.getAttribute('data-list');
    var valueNames = dataListValue.split(',');

    var options = {
      valueNames: valueNames,
      page: 10,
      searchClass: 'listjs-search',
      sortClass: 'listjs-sorter',
      pagination: [
        {
          name: 'pagination',
          paginationClass: 'pagination',
          left: 1,
          right: 1,
          item: '<li class="page-item"><a class="page-link page" href="#"></a></li>',
        },
      ],
    };

    var listjs = new List(listElement.id, options); // Pass ID instead of element

    function update_entries_label(listjs) {
      var total_items = listjs.items.length;
      var visible_items = listjs.visibleItems.length;
      var showing_items_label = total_items + ' entries found';
      var label = listElement.querySelector('.listjs-showing-items-label');
      if (label) label.innerHTML = showing_items_label;
    }

    update_entries_label(listjs);

    listjs.on('updated', function () {
      update_entries_label(listjs);
    });

    var itemsPerPageInput = listElement.querySelector('.listjs-items-per-page');
    if (itemsPerPageInput) {
      itemsPerPageInput.addEventListener('change', function () {
        var items = this.value;
        listjs.page = items;
        listjs.update();
      });
    }

    var currentPage = 1;
    var itemsPerPage = 10;

    function updateButtons() {
      var totalPages = Math.ceil(listjs.items.length / itemsPerPage);
      var prevBtn = listElement.querySelector('.prev');
      var nextBtn = listElement.querySelector('.next');

      if (prevBtn) prevBtn.disabled = currentPage === 1;
      if (nextBtn) nextBtn.disabled = currentPage === totalPages;
    }

    var prevBtn = listElement.querySelector('.prev');
    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        if (currentPage > 1) {
          currentPage--;
          listjs.show((currentPage - 1) * itemsPerPage, itemsPerPage);
          updateButtons();
        }
      });
    }

    var nextBtn = listElement.querySelector('.next');
    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        if (currentPage * itemsPerPage < listjs.items.length) {
          currentPage++;
          listjs.show((currentPage - 1) * itemsPerPage, itemsPerPage);
          updateButtons();
        }
      });
    }

    updateButtons();
  });
});
