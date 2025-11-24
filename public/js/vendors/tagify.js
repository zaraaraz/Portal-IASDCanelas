// input tags (Tagify)

const tagInputs = document.querySelectorAll('input[name=tags]');
tagInputs.forEach((input) => {
  new Tagify(input);
});
