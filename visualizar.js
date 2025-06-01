const horarios = [
  { inicio: "07:00", fin: "07:50" },
  { inicio: "07:50", fin: "08:40" },
  { inicio: "08:40", fin: "09:30" },
  { inicio: "09:30", fin: "09:50", tipo: "receso" },
  { inicio: "09:50", fin: "10:40" },
  { inicio: "10:40", fin: "11:30" },
  { inicio: "11:30", fin: "12:20" },
  { inicio: "12:20", fin: "13:10" },
  { inicio: "13:10", fin: "13:50", tipo: "intercambio" },
  { inicio: "13:50", fin: "14:40" },
  { inicio: "14:40", fin: "15:30" },
  { inicio: "15:30", fin: "16:20" },
  { inicio: "16:20", fin: "16:40", tipo: "receso" },
  { inicio: "16:40", fin: "17:30" },
  { inicio: "17:30", fin: "18:20" },
  { inicio: "18:20", fin: "19:10" },
  { inicio: "19:10", fin: "20:00" }
];

const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
const tabla = document.getElementById("tabla-bloques");
const rangoSemana = document.getElementById("rango-semana");
const btnAnterior = document.getElementById("semana-anterior");
const btnSiguiente = document.getElementById("semana-siguiente");

let semanaOffset = 0;
let semanaActual = [];

function siguienteHora(hora) {
  const [h, m] = hora.split(":").map(Number);
  const nueva = new Date(0, 0, 0, h, m + 50);
  return nueva.toTimeString().substring(0, 5);
}

function obtenerSemana(offset = 0) {
  const hoy = new Date();
  const lunes = new Date(hoy.setDate(hoy.getDate() - hoy.getDay() + 1 + offset * 7));
  const semana = [];
  for (let i = 0; i < 5; i++) {
    const dia = new Date(lunes);
    dia.setDate(lunes.getDate() + i);
    semana.push(dia);
  }
  return semana;
}

function formatearFecha(date) {
  return date.toISOString().split('T')[0];
}

function cargarSemana() {
  semanaActual = obtenerSemana(semanaOffset);
  const inicio = formatearFecha(semanaActual[0]);
  const fin = formatearFecha(semanaActual[4]);
  rangoSemana.textContent = `${inicio} al ${fin}`;
  tabla.innerHTML = "";
  fetch(`obtener_reservas.php?inicio=${inicio}&fin=${fin}`)
    .then(res => res.json())
    .then(data => crearTabla(data));
}

function crearTabla(reservas) {
  horarios.forEach(bloque => {
    const fila = document.createElement("tr");
    const celdaHora = document.createElement("td");
    celdaHora.textContent = `${bloque.inicio} - ${bloque.fin}`;
    fila.appendChild(celdaHora);

    semanaActual.forEach(fecha => {
      const celda = document.createElement("td");
      const fechaStr = formatearFecha(fecha);

      if (bloque.tipo === "receso" || bloque.tipo === "intercambio") {
        celda.textContent = bloque.tipo === "receso" ? "Receso" : "Intercambio";
        celda.classList.add("intermedio");
      } else {
        const reserva = reservas.find(r => r.fecha === fechaStr && r.hora === bloque.inicio);
        const ahora = new Date();
        const fechaHoraBloque = new Date(`${fechaStr}T${bloque.inicio}`);

        if (reserva) {
          celda.innerHTML = `<strong>${reserva.nombre}</strong><br><small>${reserva.motivo}</small>`;
          celda.classList.add("ocupado");
        } else if (fechaHoraBloque < ahora) {
          celda.textContent = "No disponible";
          celda.classList.add("pasado");
        } else {
          celda.textContent = "Disponible";
          celda.classList.add("disponible");

          // Solo permitir clic si NO es alumno
          if (typeof ROL_USUARIO !== "undefined" && ROL_USUARIO !== "alumno") {
            celda.addEventListener("click", () => {
              bloqueActual = celda;
              fechaSeleccionada = celda.dataset.fecha;
              horaSeleccionada = celda.dataset.hora;

              const diaNombre = dias[new Date(fechaSeleccionada).getDay() - 1];
              infoHorario.textContent = `Reservar: ${diaNombre} ${fechaSeleccionada} ${horaSeleccionada}`;

              nombreInput.value = "";
              motivoInput.value = "";
              dialogo.showModal();
            });
          }
        }
      }

      fila.appendChild(celda);
    });

    tabla.appendChild(fila);
  });
}


btnAnterior.addEventListener("click", () => {
  semanaOffset--;
  cargarSemana();
});
btnSiguiente.addEventListener("click", () => {
  semanaOffset++;
  cargarSemana();
});

cargarSemana();
