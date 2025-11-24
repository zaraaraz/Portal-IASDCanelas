// kanban

const kanbanSections = ['#do', '#progress', '#review', '#done'].map((selector) => document.querySelector(selector));
if (kanbanSections.some((section) => section !== null)) {
  dragula(kanbanSections.filter(Boolean));
}
