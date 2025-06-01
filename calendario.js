// ======================
// CONFIGURACIÓN INICIAL
// ======================
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
let currentMonth = 4; // mayo (recuerda que enero es 0)
let currentYear = 2025;

const startMonth = 7, startYear = 2024, endMonth = 6, endYear = 2025;

const events = {
  "2024-08-12": { title: "Inicio de semestre", color: "#e2c131" },
  "2024-08-05": { title: "Preinscripción", color: "#c2d5ec" },
  "2024-08-06": { title: "Preinscripción", color: "#c2d5ec" },
  "2024-08-07": { title: "Preinscripción", color: "#c2d5ec" },
  "2024-08-08": { title: "Preinscripción", color: "#c2d5ec" },
  "2024-08-09": { title: "Preinscripción", color: "#c2d5ec" },
  
   "2025-01-06": { title: "Periodo de preinscripción", color: "#c2d5ec" },
    "2025-01-07": { title: "Periodo de preinscripción", color: "#c2d5ec" },
    "2025-01-07": { title: "Periodo de preinscripción", color: "#c2d5ec" },
    "2025-01-08": { title: "Periodo de preinscripción", color: "#c2d5ec" },
    "2025-01-09": { title: "Periodo de preinscripción", color: "#c2d5ec" },
    "2025-01-10": { title: "Periodo de preinscripción", color: "#c2d5ec" },
"2025-01-15": { title: "examen javascripr", color: "#30814b" },

    
    "2024-08-01": { title: "Suspensión de labores", color: "#30814b" },
    "2024-08-02": { title: "Suspensión de labores", color: "#30814b" },

    "2024-09-16": { title: "Suspensión de labores", color: "#30814b" },

    "2024-10-01": { title: "Suspensión de labores", color: "#30814b" },

    "2024-11-02": { title: "Suspensión de labores", color: "#30814b" },
    "2024-11-18": { title: "Suspensión de labores", color: "#30814b" },

    "2024-12-12": { title: "Suspensión de labores", color: "#30814b" },
    "2024-12-25": { title: "Suspensión de labores", color: "#30814b" },

    "2025-01-01": { title: "Suspensión de labores", color: "#30814b" },

    "2025-02-03": { title: "Suspensión de labores", color: "#30814b" },

    "2025-03-17": { title: "Suspensión de labores", color: "#30814b" },

    "2025-04-14": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-15": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-16": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-17": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-18": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-21": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-22": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-23": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-24": { title: "Suspensión de labores", color: "#30814b" },
    "2025-04-25": { title: "Suspensión de labores", color: "#30814b" },

    "2025-05-01": { title: "Suspensión de labores", color: "#30814b" },
    "2025-05-05": { title: "Suspensión de labores", color: "#30814b" },
    "2025-05-10": { title: "Suspensión de labores", color: "#30814b" },
    "2025-05-15": { title: "Suspensión de labores", color: "#30814b" },

    "2024-09-23": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-09-24": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-09-25": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-09-26": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-09-27": { title: "Periodo de evaluación", color: "#9bd7a0" },

    "2024-11-04": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-11-05": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-11-06": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-11-07": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-11-08": { title: "Periodo de evaluación", color: "#9bd7a0" },

    "2024-12-02": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-12-03": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-12-04": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-12-05": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2024-12-06": { title: "Periodo de evaluación", color: "#9bd7a0" },

    
    "2025-03-03": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-03-04": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-03-05": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-03-06": { title: "Periodo de evaluación", color: "#9bd7a0" },

    "2025-04-07": { title: "Periodo de evaluación", color: "#FFC0CB" },
    "2025-04-08": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-04-09": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-04-10": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-04-11": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-04-11": { title: "Periodo de evaluación", color: "#9bd7a0" },

    "2025-06-09": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-06-10": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-06-11": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-06-12": { title: "Periodo de evaluación", color: "#9bd7a0" },
    "2025-06-13": { title: "Periodo de evaluación", color: "#9bd7a0" },


  
    "2024-12-09": { title: "Exámenes extraordinarios", color: "#dbb0cd" },
    "2024-12-10": { title: "Exámenes extraordinarios", color: "#dbb0cd" },
    "2025-06-16": { title: "Exámenes extraordinarios", color: "#dbb0cd" },
    "2025-06-17": { title: "Exámenes extraordinarios", color: "#dbb0cd" },
    "2025-06-18": { title: "Exámenes extraordinarios", color: "#dbb0cd" },

    "2024-12-11": { title: "Exámenes a título", color: "#8bb8a2" },
    "2024-12-13": { title: "Exámenes a título", color: "#8bb8a2" },
    "2025-06-19": { title: "Exámenes a título", color: "#8bb8a2" },
    "2025-06-20": { title: "Exámenes a título", color: "#8bb8a2" },

   
   
    "2025-10-15": { title: "Día de la UICSLP", color: "#e2c131" },
    
   
    "2024-12-16": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-17": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-18": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-19": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-20": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-23": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-24": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-26": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-27": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-30": { title: "Vacaciones", color: "#86d5c3" },
    "2024-12-31": { title: "Vacaciones", color: "#86d5c3" },

    "2025-01-02": { title: "Vacaciones", color: "#86d5c3" },
    "2025-01-03": { title: "Vacaciones", color: "#86d5c3" },

    "2025-07-14": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-15": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-16": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-17": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-18": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-21": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-22": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-23": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-24": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-25": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-28": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-29": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-30": { title: "Vacaciones", color: "#86d5c3" },
    "2025-07-31": { title: "Vacaciones", color: "#86d5c3" },


   
    "2025-06-13": { title: "Fin de semestre", color: "#e2c131" }
  
};

let reservasDB = [];

function getFirstDayOfMonth(month, year) {
  return new Date(year, month, 1).getDay();
}
function getDaysInMonth(month, year) {
  return new Date(year, month + 1, 0).getDate();
}
function formatFecha(year, month, day) {
  return `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
}

function renderCalendar() {
  const calendar = document.getElementById("calendar");
  const monthYear = document.getElementById("month-year");
  calendar.innerHTML = "";
  monthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;

  if (currentYear < startYear || (currentYear === startYear && currentMonth < startMonth) ||
      currentYear > endYear || (currentYear === endYear && currentMonth > endMonth)) return;

  const firstDay = getFirstDayOfMonth(currentMonth, currentYear);
  const daysInMonth = getDaysInMonth(currentMonth, currentYear);
  const weekdays = ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"];

  weekdays.forEach(day => {
    const el = document.createElement("div");
    el.className = "weekday";
    el.textContent = day;
    calendar.appendChild(el);
  });

  for (let i = 0; i < firstDay; i++) {
    const emptyCell = document.createElement("div");
    emptyCell.className = "day";
    calendar.appendChild(emptyCell);
  }

  for (let day = 1; day <= daysInMonth; day++) {
    const dateStr = formatFecha(currentYear, currentMonth, day);
    const dayElement = document.createElement("div");
    dayElement.className = "day";
    dayElement.textContent = day;

    if (events[dateStr]) {
      dayElement.style.backgroundColor = events[dateStr].color;
      dayElement.title = events[dateStr].title;
      dayElement.addEventListener("click", () => {
        alert(`Evento: ${events[dateStr].title}\nFecha: ${dateStr}`);
      });
    } else if (reservasDB.some(r => r.fecha === dateStr)) {
  const reserva = reservasDB.find(r => r.fecha === dateStr);
  dayElement.classList.add("dia-ocupado");
  dayElement.title = "Ya hay una reserva";
  dayElement.addEventListener("click", () => {
    alert(`Este día ya tiene una reserva:\nMotivo: ${reserva.descripcion}`);

  });
    } else {
  // Solo permitir abrir el modal si es admin
  if (typeof ROL_USUARIO !== "undefined" && ROL_USUARIO === "admin") {
    dayElement.addEventListener("click", () => {
      abrirModal(dateStr);
    });
  }
}

    calendar.appendChild(dayElement);
  }
}

function changeMonth(offset) {
  let newMonth = currentMonth + offset;
  let newYear = currentYear;

  if (newMonth < 0) { newMonth = 11; newYear--; }
  else if (newMonth > 11) { newMonth = 0; newYear++; }

  if (newYear < startYear || (newYear === startYear && newMonth < startMonth) ||
      newYear > endYear || (newYear === endYear && newMonth > endMonth)) return;

  currentMonth = newMonth;
  currentYear = newYear;
  renderCalendar();
}

function cargarReservas() {
  fetch("dias_ocupados.php")
    .then(res => res.json())
    .then(data => {
      reservasDB = data;
      renderCalendar();
    });
}

// ==== FUNCIONES MODAL ====
function abrirModal(fecha) {
  document.getElementById("modalFecha").value = fecha;
  document.getElementById("modalReserva").style.display = "block";
}

function cerrarModal() {
  document.getElementById("modalReserva").style.display = "none";
}

document.getElementById("prev-month").addEventListener("click", () => changeMonth(-1));
document.getElementById("next-month").addEventListener("click", () => changeMonth(1));
document.addEventListener("DOMContentLoaded", cargarReservas);
