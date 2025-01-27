'use strict';
let events = [];
document.addEventListener('DOMContentLoaded', async function () {
  try {
    let response = await fetch('/api/citas');
    if (response.ok) {
      let data = await response.json();

      // Mapeamos los datos recibidos y los asignamos a la estructura deseada
      events = data.map(cita => ({
        // id: cita.id,
        url: '', // Puedes agregar una URL si lo necesitas
        title: cita.title, // Asumiendo que 'title' existe en los datos de la cita
        start: cita.start, // Asegúrate de que 'start' esté en el formato adecuado
        end: cita.end, // Asegúrate de que 'end' esté en el formato adecuado
        allDay: false, // Por si no hay valor de allDay
        extendedProps: {
          calendar: 'Personal' // O personaliza este valor si es necesario
        }
      }));

      // Imprime los eventos después de haberlos cargado
      console.log(events);
    } else {
      console.error('Error al cargar las citas');
    }
  } catch (error) {
    console.error('Error en la solicitud:', error);
  }
});
console.log(events);
