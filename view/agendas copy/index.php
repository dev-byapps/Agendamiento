<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Semanal de Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .calendar-container {
            margin: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .calendar-header button:hover {
            background-color: #0056b3;
        }

        .week-view {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border: 1px solid #ccc;
        }

        .day-column {
            border: 1px solid #ccc;
            min-height: 500px;
            display: flex;
            flex-direction: column;
        }

        .hour-row {
            border-bottom: 1px solid #eee;
            padding: 10px;
            flex: 1;
        }

        .agendado {
            background-color: #ffcccc;
        }

        .disponible {
            background-color: #ccffcc;
        }

        .reservar-btn {
            margin-top: 5px;
            padding: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .reservar-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="calendar-container">
        <div class="calendar-header">
            <button id="prev-week">Semana Anterior</button>
            <h2 id="week-label"></h2>
            <button id="next-week">Próxima Semana</button>
        </div>

        <div id="week-view" class="week-view">
            <!-- Las columnas de cada día se generarán dinámicamente aquí -->
        </div>
    </div>

    <script>
        const horarios = [{
                fecha: '2024-10-20',
                hora_inicio: '10:00',
                hora_fin: '11:00',
                estado: 'disponible'
            },
            {
                fecha: '2024-10-21',
                hora_inicio: '14:00',
                hora_fin: '15:00',
                estado: 'agendado'
            },
            {
                fecha: '2024-10-22',
                hora_inicio: '16:00',
                hora_fin: '17:00',
                estado: 'disponible'
            },
            {
                fecha: '2024-10-23',
                hora_inicio: '09:00',
                hora_fin: '10:00',
                estado: 'agendado'
            },
            {
                fecha: '2024-10-24',
                hora_inicio: '13:00',
                hora_fin: '14:00',
                estado: 'disponible'
            },
            {
                fecha: '2024-10-25',
                hora_inicio: '10:00',
                hora_fin: '11:00',
                estado: 'disponible'
            },
            {
                fecha: '2024-10-26',
                hora_inicio: '12:00',
                hora_fin: '13:00',
                estado: 'agendado'
            }
        ];

        // Configuración inicial
        let currentDate = new Date();
        const weekView = document.getElementById('week-view');
        const weekLabel = document.getElementById('week-label');

        // Función para obtener la semana actual
        function getWeekStart(date) {
            const dayOfWeek = date.getDay(); // 0 (domingo) - 6 (sábado)
            const diff = date.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1); // Ajustar al lunes
            return new Date(date.setDate(diff));
        }

        // Función para avanzar o retroceder semanas
        function changeWeek(offset) {
            currentDate.setDate(currentDate.getDate() + (offset * 7));
            renderWeek();
        }

        // Formatear fecha en formato "YYYY-MM-DD"
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Renderizar la vista semanal
        function renderWeek() {
            const weekStart = getWeekStart(new Date(currentDate));
            weekView.innerHTML = ''; // Limpiar vista anterior

            // Actualizar etiqueta de semana
            const weekEnd = new Date(weekStart);
            weekEnd.setDate(weekEnd.getDate() + 6);
            weekLabel.textContent = `Semana del ${weekStart.toLocaleDateString()} al ${weekEnd.toLocaleDateString()}`;

            // Generar columnas de los días
            for (let i = 0; i < 7; i++) {
                const dayColumn = document.createElement('div');
                dayColumn.classList.add('day-column');
                const currentDay = new Date(weekStart);
                currentDay.setDate(weekStart.getDate() + i);

                // Encabezado del día
                const dayLabel = document.createElement('h4');
                dayLabel.textContent = currentDay.toLocaleDateString();
                dayColumn.appendChild(dayLabel);

                // Rellenar horas (de 8:00 a 17:00 por ejemplo)
                for (let hour = 8; hour <= 17; hour++) {
                    const hourRow = document.createElement('div');
                    hourRow.classList.add('hour-row');
                    hourRow.textContent = `${hour}:00 - ${hour + 1}:00`;

                    // Buscar citas que coincidan con la fecha y hora
                    const formattedDate = formatDate(currentDay);
                    const cita = horarios.find(h => h.fecha === formattedDate && parseInt(h.hora_inicio) === hour);

                    if (cita) {
                        if (cita.estado === 'agendado') {
                            hourRow.classList.add('agendado');
                            hourRow.textContent += ' (Agendado)';
                        } else if (cita.estado === 'disponible') {
                            hourRow.classList.add('disponible');
                            const reservarBtn = document.createElement('button');
                            reservarBtn.textContent = 'Reservar';
                            reservarBtn.classList.add('reservar-btn');
                            reservarBtn.onclick = function() {
                                alert(`Cita reservada para ${formattedDate} a las ${cita.hora_inicio}`);
                                // Aquí puedes agregar lógica para reservar la cita
                            };
                            hourRow.appendChild(reservarBtn);
                        }
                    }

                    dayColumn.appendChild(hourRow);
                }

                weekView.appendChild(dayColumn);
            }
        }

        // Event listeners para cambiar de semana
        document.getElementById('prev-week').onclick = function() {
            changeWeek(-1);
        };
        document.getElementById('next-week').onclick = function() {
            changeWeek(1);
        };

        // Inicializar con la semana actual
        renderWeek();
    </script>

</body>

</html>