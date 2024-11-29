const calendarBody = document.querySelector(".calendar-body");
const monthYearDisplay = document.querySelector(".month-year");
const prevMonthBtn = document.querySelector(".prev-month");
const nextMonthBtn = document.querySelector(".next-month");
const currentDate = new Date();

function fetchTasks(month, year) {
  fetch(`get-tasks.php?month=${month + 1}&year=${year}`) // +1 karena bulan di JS dimulai dari 0
    .then((response) => response.json())
    .then((data) => {
      data.forEach((task) => {
        const taskDate = new Date(task.due_date).getDate();
        const cell = document.querySelector(`td[data-day="${taskDate}"]`);
        if (cell) {
          const taskElement = document.createElement("div");
          taskElement.textContent = task.title;
          taskElement.classList.add("task");

          if (task.status === "completed") {
            taskElement.classList.add("completed");
          } else if (task.status === "in_progress") {
            taskElement.classList.add("in-progress");
          } else {
            taskElement.classList.add("pending");
          }

          cell.appendChild(taskElement);
        }
      });
    })
    .catch((error) => console.error("Error fetching tasks:", error));
}

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();

  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  monthYearDisplay.textContent = `${monthNames[month]} ${year}`;

  calendarBody.innerHTML = "";

  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  let row = document.createElement("tr");
  for (let i = 0; i < firstDay; i++) {
    const emptyCell = document.createElement("td");
    row.appendChild(emptyCell);
  }

  for (let day = 1; day <= daysInMonth; day++) {
    const cell = document.createElement("td");
    cell.textContent = day;
    cell.setAttribute("data-day", day);

    if ((firstDay + day - 1) % 7 === 0) {
      calendarBody.appendChild(row);
      row = document.createElement("tr");
    }
    row.appendChild(cell);
  }

  if (row.children.length > 0) {
    calendarBody.appendChild(row);
  }

  fetchTasks(month, year);
}

renderCalendar(currentDate);

prevMonthBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});

nextMonthBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});
