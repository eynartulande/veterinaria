<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Veterinaria - Agendamiento de Citas</title>
    <!-- Vinculación del archivo CSS independiente -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Clínica Veterinaria</h1>
        <p>Sistema de Reserva y Agendamiento de Citas (CitasAgendaModulo)</p>
    </div>

    <div class="card">
        <div id="alertBox" class="alert"></div>

        <form id="appointmentForm">
            <div class="form-group">
                <label>Rol del Operador (RN-11):</label>
                <select id="operatorRole" required>
                    <option value="Recepcion">Recepción</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Profesional">Profesional Veterinario</option>
                </select>
            </div>

            <div class="form-group">
                <label>Paciente (Mascota - Dueño):</label>
                <select id="petOwner" required>
                    <option value="">Seleccione un paciente...</option>
                    <option value="Firulais - Carlos Mendoza">Firulais (Perro) - Carlos Mendoza</option>
                    <option value="Michi - Ana Gómez">Michi (Gato) - Ana Gómez</option>
                </select>
            </div>

            <div class="form-group">
                <label>Médico Veterinario:</label>
                <select id="doctor" required>
                    <option value="">Seleccione un profesional...</option>
                    <option value="Dr. Roberto Gómez">Dr. Roberto Gómez - Medicina General</option>
                    <option value="Dra. Laura Martínez">Dra. Laura Martínez - Cirugía</option>
                </select>
            </div>

            <div class="form-group">
                <label>Servicio Requerido:</label>
                <select id="service" required>
                    <option value="">Seleccione un servicio...</option>
                    <option value="Vacunación Canina">Vacunación Canina (30 min)</option>
                    <option value="Consulta General">Consulta General (30 min)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha y Hora de la Cita:</label>
                <input type="datetime-local" id="appointmentDateTime" required>
            </div>

            <button type="submit" class="btn">Agendar Nueva Cita</button>
        </form>

        <h3 style="margin-top: 35px; color: #374151;">Citas Programadas</h3>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Fecha / Hora</th>
                    <th>Paciente</th>
                    <th>Veterinario</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="appointmentsList">
                <tr>
                    <td>2026-10-22 09:00</td>
                    <td>Firulais (Carlos Mendoza)</td>
                    <td>Dr. Roberto Gómez</td>
                    <td>Vacunación Canina</td>
                    <td><span class="badge badge-scheduled">Programada</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const alertBox = document.getElementById('alertBox');
        const role = document.getElementById('operatorRole').value;
        const dateTimeVal = document.getElementById('appointmentDateTime').value;
        const selectedTime = new Date(dateTimeVal);
        const now = new Date();
        
        // Calcular horas de anticipación (RN-04)
        const diffHours = (selectedTime - now) / (1000 * 60 * 60);

        alertBox.style.display = 'block';

        // Validación RN-11
        if (role === 'Profesional') {
            alertBox.className = 'alert alert-danger';
            alertBox.innerHTML = '⚠️ Error: El rol Profesional no tiene permisos para agendar citas (RN-11).';
            return;
        }

        // Validación RN-04
        if (diffHours < 2) {
            alertBox.className = 'alert alert-danger';
            alertBox.innerHTML = '⚠️ Error: Las citas deben programarse con al menos 2 horas de anticipación (RN-04).';
            return;
        }

        // Si pasa las reglas: Éxito
        alertBox.className = 'alert alert-success';
        alertBox.innerHTML = '✅ Cita agendada exitosamente (Cita registrada con éxito).';

        // Agregar fila a la tabla
        const pet = document.getElementById('petOwner').value;
        const doctor = document.getElementById('doctor').value;
        const service = document.getElementById('service').value;

        const tbody = document.getElementById('appointmentsList');
        const newRow = `
            <tr>
                <td>${dateTimeVal.replace('T', ' ')}</td>
                <td>${pet}</td>
                <td>${doctor}</td>
                <td>${service}</td>
                <td><span class="badge badge-scheduled">Programada</span></td>
            </tr>
        `;
        tbody.innerHTML += newRow;
    });
</script>

</body>
</html>