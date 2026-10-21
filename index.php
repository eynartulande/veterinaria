<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Veterinaria - Sistema de Reserva y Agendamiento</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    
    <!-- Banner de Alerta Superior -->
    <div id="alertBanner" class="alert-banner">
        <div class="alert-content">
            <span>✔</span>
            <span id="alertMessage">Cita agendada exitosamente (Cita registrada con éxito)</span>
        </div>
        <button class="alert-close" onclick="document.getElementById('alertBanner').style.display='none'">✕</button>
    </div>

    <div class="main-grid">
        
        <!-- Columna Izquierda: Formulario de Agendamiento -->
        <div class="card-form">
            <div class="header-teal">
                <h2>📅 Agendar Nueva Cita</h2>
                <p>Selecciona fecha y franja horaria</p>
            </div>
            
            <form id="appointmentForm" class="form-body">
                <div class="form-group">
                    <label>Rol del Operador</label>
                    <select id="operatorRole" class="form-control" required>
                        <option value="Recepcion" selected>Recepción</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Profesional">Profesional Veterinario</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Paciente (Mascota - Dueño)</label>
                    <select id="petOwner" class="form-control" required>
                        <option value="" disabled selected>Seleccione un paciente...</option>
                        <option value="Firulais|Carlos Mendoza">Firulais - Carlos Mendoza</option>
                        <option value="Michi|Ana Gómez">Michi - Ana Gómez</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Médico Veterinario</label>
                    <select id="doctor" class="form-control" required>
                        <option value="" disabled selected>Seleccione un profesional...</option>
                        <option value="Dr. Roberto Gómez">Dr. Roberto Gómez</option>
                        <option value="Dra. Laura Martínez">Dra. Laura Martínez</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Servicio Requerido</label>
                    <select id="service" class="form-control" required>
                        <option value="" disabled selected>Seleccione un servicio...</option>
                        <option value="Vacunación Canina">Vacunación Canina</option>
                        <option value="Consulta General">Consulta General</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha de la Cita</label>
                    <input type="datetime-local" id="appointmentDateTime" class="form-control" required>
                </div>

                <button type="submit" class="btn-primary">Guardar Cita</button>
            </form>
        </div>

        <!-- Columna Derecha: Disponibilidad y Lista de Citas -->
        <div class="right-column">
            
            <!-- Disponibilidad del Día -->
            <div class="card-white">
                <div class="section-header">
                    <div>
                        <div class="section-title">🕒 Disponibilidad del Día</div>
                        <div class="section-subtitle">Horarios: 7–8, 8–10, 10–12, 14–16</div>
                    </div>
                    <div class="date-picker-group">
                        <input type="text" value="22/10/2026" class="form-control" style="width: 110px; text-align: center; font-size: 0.85rem;" readonly>
                        <button class="btn-sm">Ver</button>
                    </div>
                </div>

                <div class="availability-grid">
                    <div class="slot-box slot-occupied">
                        <span>07:00 AM – 08:00</span>
                        <span class="badge-pill badge-red">Ocupado</span>
                    </div>
                    <div class="slot-box slot-available">
                        <span>08:00 AM – 10:00</span>
                        <span class="badge-pill badge-green">Disponible</span>
                    </div>
                    <div class="slot-box slot-available">
                        <span>10:00 AM – 12:00</span>
                        <span class="badge-pill badge-green">Disponible</span>
                    </div>
                    <div class="slot-box slot-available">
                        <span>02:00 PM – 04:00</span>
                        <span class="badge-pill badge-green">Disponible</span>
                    </div>
                </div>
            </div>

            <!-- Citas Programadas -->
            <div class="card-white">
                <div class="section-header">
                    <div class="section-title">📋 Citas Programadas (2026-10-22)</div>
                </div>

                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Veterinario</th>
                            <th>Servicio</th>
                            <th style="text-align: center;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsList">
                        <tr>
                            <td><span class="time-badge">07:00 – 07:20</span></td>
                            <td class="patient-info">
                                <strong>Firulais</strong>
                                <span>Carlos Mendoza</span>
                            </td>
                            <td>Dr. Roberto Gómez</td>
                            <td>Vacunación Canina</td>
                            <td style="text-align: center;">
                                <button class="btn-icon-danger" onclick="this.closest('tr').remove()">🗑</button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="time-badge">23:49 – 00:09</span></td>
                            <td class="patient-info">
                                <strong>Firulais</strong>
                                <span>Carlos Mendoza</span>
                            </td>
                            <td>Dr. Roberto Gómez</td>
                            <td>Vacunación Canina</td>
                            <td style="text-align: center;">
                                <button class="btn-icon-danger" onclick="this.closest('tr').remove()">🗑</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

<script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const alertBanner = document.getElementById('alertBanner');
        const alertMessage = document.getElementById('alertMessage');
        const role = document.getElementById('operatorRole').value;
        const dateTimeVal = document.getElementById('appointmentDateTime').value;
        const selectedTime = new Date(dateTimeVal);
        const now = new Date();
        
        const diffHours = (selectedTime - now) / (1000 * 60 * 60);

        alertBanner.style.display = 'flex';

        // Validaciones de Reglas de Negocio
        if (role === 'Profesional') {
            alertBanner.style.backgroundColor = '#f8d7da';
            alertBanner.style.borderColor = '#f5c6cb';
            alertBanner.style.color = '#721c24';
            alertMessage.innerHTML = 'Error: El rol Profesional no tiene permisos para agendar citas (RN-11).';
            return;
        }

        if (diffHours < 2) {
            alertBanner.style.backgroundColor = '#f8d7da';
            alertBanner.style.borderColor = '#f5c6cb';
            alertBanner.style.color = '#721c24';
            alertMessage.innerHTML = 'Error: Las citas deben programarse con al menos 2 horas de anticipación (RN-04).';
            return;
        }

        // Si es Exitoso
        alertBanner.style.backgroundColor = '#d1e7dd';
        alertBanner.style.borderColor = '#badbcc';
        alertBanner.style.color = '#0f5132';
        alertMessage.innerHTML = 'Cita agendada exitosamente (Cita registrada con éxito)';

        // Agregar fila a la tabla
        const petVal = document.getElementById('petOwner').value.split('|');
        const doctor = document.getElementById('doctor').value;
        const service = document.getElementById('service').value;

        const hours = selectedTime.getHours().toString().padStart(2, '0');
        const minutes = selectedTime.getMinutes().toString().padStart(2, '0');
        const timeStr = `${hours}:${minutes} – ${hours}:${(parseInt(minutes)+20).toString().padStart(2, '0')}`;

        const tbody = document.getElementById('appointmentsList');
        const newRow = `
            <tr>
                <td><span class="time-badge">${timeStr}</span></td>
                <td class="patient-info">
                    <strong>${petVal[0]}</strong>
                    <span>${petVal[1]}</span>
                </td>
                <td>${doctor}</td>
                <td>${service}</td>
                <td style="text-align: center;">
                    <button class="btn-icon-danger" onclick="this.closest('tr').remove()">🗑</button>
                </td>
            </tr>
        `;
        tbody.innerHTML += newRow;
    });
</script>

</body>
</html>