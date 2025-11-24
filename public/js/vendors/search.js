// search

function searchWord() {
  const input = document.getElementById('globalSearchInput').value.toLowerCase(); // Get search input
  const listItems = document.querySelectorAll('.modal-body li'); // Select all list items inside the modal body

  listItems.forEach((item) => {
    const text = item.textContent.toLowerCase(); // Get the text content of each list item
    if (text.includes(input)) {
      item.style.display = ''; // Show items that match
    } else {
      item.style.display = 'none'; // Hide items that don't match
    }
  });
}
