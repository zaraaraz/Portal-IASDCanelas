// sidebar menu js

'use strict';
(function () {
  var url = window.location.href;
  var path = url.replace(window.location.protocol + '//' + window.location.host + '/', '');
  var elements = document.querySelectorAll('ul#sidebarnav a');

  elements.forEach(function (element) {
    if (element.href === url || element.href === path) {
      var currentElement = element;

      while (currentElement.parentElement && !currentElement.parentElement.classList.contains('sidebar-nav')) {
        if (currentElement.parentElement.tagName === 'LI') {
          // Add 'active' class to nav-link
          currentElement.classList.add('active');

          // Add 'active' class to nav-item (li)
          currentElement.parentElement.classList.add('active');
        }

        if (currentElement.parentElement.tagName === 'UL' && !currentElement.parentElement.classList.contains('sidebarnav')) {
          currentElement.parentElement.classList.add('in');
        }

        currentElement = currentElement.parentElement;
      }
    }
  });
})();
