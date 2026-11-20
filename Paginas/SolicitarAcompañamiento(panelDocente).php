<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../P.H.P_EJEMPLOS/conexion.php';

$mensaje = "";
$tipoAlerta = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_docente = trim($_POST['nombre_docente'] ?? '');
    $documento      = trim($_POST['documento'] ?? '');
    $correo         = trim($_POST['correo_institucional'] ?? '');
    $curso          = trim($_POST['curso_grupo'] ?? '');
    $fecha          = trim($_POST['fecha'] ?? '');
    $hora           = trim($_POST['hora'] ?? '');
    $motivo         = trim($_POST['motivo'] ?? '');

    if (strlen($hora) === 5) {
        $hora .= ':00';
    }

    if ($nombre_docente !== '' && $documento !== '' && $curso !== '' && $fecha !== '' && $hora !== '' && $motivo !== '') {
        try {
            $sqlCheck = "SELECT COUNT(*)
                         FROM citas
                         WHERE fecha = :fecha
                           AND hora = :hora
                           AND estado IN ('Aprobada', 'Confirmada')";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                ':fecha' => $fecha,
                ':hora'  => $hora
            ]);

            if ((int)$stmtCheck->fetchColumn() > 0) {
                $mensaje = "Ese día y hora ya fueron aceptados por el psicólogo y están bloqueados.";
                $tipoAlerta = "warning";
            } else {
                if ($correo === '') {
                    $stmtUser = $pdo->prepare("SELECT correo FROM usuarios WHERE documento = :documento LIMIT 1");
                    $stmtUser->execute([':documento' => $documento]);
                    $usuario = $stmtUser->fetch();
                    $correo = $usuario['correo'] ?? 'sin-correo@institucion.edu.co';
                }

                $sql = "INSERT INTO citas (
                            nombre_completo,
                            documento,
                            correo_institucional,
                            fecha,
                            hora,
                            motivo,
                            estado,
                            rol_solicitante,
                            curso_grupo,
                            grado
                        ) VALUES (
                            :nombre_completo,
                            :documento,
                            :correo_institucional,
                            :fecha,
                            :hora,
                            :motivo,
                            'Pendiente',
                            'Docente',
                            :curso_grupo,
                            :grado
                        )";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nombre_completo'      => $nombre_docente,
                    ':documento'            => $documento,
                    ':correo_institucional' => $correo,
                    ':fecha'                => $fecha,
                    ':hora'                 => $hora,
                    ':motivo'               => $motivo,
                    ':curso_grupo'          => $curso,
                    ':grado'                => mb_substr($curso, 0, 20)
                ]);

                $mensaje = "¡Solicitud enviada! Quedará en estado Pendiente hasta que el psicólogo la acepte.";
                $tipoAlerta = "success";
            }
        } catch (PDOException $e) {
            $mensaje = "Error al registrar en la base de datos: " . $e->getMessage();
            $tipoAlerta = "danger";
        }
    } else {
        $mensaje = "Por favor, completa todos los campos del formulario.";
        $tipoAlerta = "warning";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Acompañamiento - Psico-Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../ESTILOS/Estilos.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                    <img src="../imagenes/Black_and_Beige_Elegant_Simple_Flower_Circle_Logo-removebg-preview (3).png"
                        alt="Logo" class="logo">
                    <div>
                        <h1 class="logo-title">Panel del Docente</h1>
                        <p class="logo-text">Psico-Agenda</p>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="menu">
                    <ul class="navbar-nav align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="./iniciaDocentes.html">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./serviciosDocente.html">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./SolicitarAcompañamiento(panelDocente).php">Solicitar Acompañamiento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./verEstudiantes(panelDocente).html">Ver Estudiantes</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-logout" href="./CerrarSesiónDocentes.html">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container cita-section">
        <section class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="titulo-cita">
                    Solicitar acompañamiento psicológico
                </h2>
                <p class="texto-cita">
                    Este espacio permite a los docentes solicitar
                    apoyo psicológico para grupos o estudiantes
                    que necesiten acompañamiento emocional,
                    fortalecimiento de convivencia o intervención
                    dentro del entorno escolar.
                </p>

                <div class="info-box">
                    <h5>¿Qué puedes solicitar?</h5>
                    <ul>
                        <li>Charlas sobre bienestar emocional.</li>
                        <li>Talleres de convivencia escolar.</li>
                        <li>Actividades para manejo del estrés.</li>
                        <li>Intervenciones grupales.</li>
                        <li>Acompañamiento psicológico para cursos.</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="formulario-cita">
                    <h3 class="text-center mb-4">
                        Solicitud de Acompañamiento
                    </h3>

                    <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-<?= $tipoAlerta; ?> alert-dismissible fade show" role="alert">
                            <strong><?= htmlspecialchars($mensaje); ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre del docente</label>
                            <input type="text" class="form-control" placeholder="Ingresa tu nombre" name="nombre_docente" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Número de documento</label>
                            <input type="text" class="form-control" placeholder="Ingresa tu número de documento" name="documento" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo institucional</label>
                            <input type="email" class="form-control" placeholder="correo@institucion.edu.co" name="correo_institucional">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Curso o grupo</label>
                            <input type="text" class="form-control" placeholder="Ejemplo: 10°B" name="curso_grupo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Día de la cita</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" min="<?= date('Y-m-d'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hora de la cita</label>
                            <select class="form-select" id="hora" name="hora" disabled required>
                                <option value="">Primero selecciona el día</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Motivo de la solicitud</label>
                            <textarea class="form-control" rows="4" placeholder="Describe el acompañamiento que necesita el grupo" name="motivo" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-cita w-100">
                            Solicitar Acompañamiento
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer text-center">
        <p class="footer-title">
            &copy; Psico-Agenda
        </p>
        <p>
            Cra. 50B #97a-30, Santa Cruz, Medellín
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const inputFecha = document.getElementById('fecha');
        const selectHora = document.getElementById('hora');
        const horasJornada = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00'];

        inputFecha.addEventListener('change', async () => {
            const fecha = inputFecha.value;
            selectHora.innerHTML = '<option value="">Cargando horas...</option>';
            selectHora.disabled = true;

            if (!fecha) {
                selectHora.innerHTML = '<option value="">Primero selecciona el día</option>';
                return;
            }

            try {
                const res = await fetch(`../P.H.P_EJEMPLOS/api_citas.php?fecha=${encodeURIComponent(fecha)}`);
                const data = await res.json();
                const bloqueadas = new Set(data.bloqueadas || []);

                selectHora.innerHTML = '<option value="">Selecciona una hora</option>';
                let algunaLibre = false;

                horasJornada.forEach((hora) => {
                    const opt = document.createElement('option');
                    opt.value = hora;
                    if (bloqueadas.has(hora)) {
                        opt.textContent = `${hora} (Bloqueada - ya aceptada)`;
                        opt.disabled = true;
                    } else {
                        opt.textContent = hora;
                        algunaLibre = true;
                    }
                    selectHora.appendChild(opt);
                });

                selectHora.disabled = !algunaLibre;
                if (!algunaLibre) {
                    selectHora.innerHTML = '<option value="">No hay horas libres este día</option>';
                }
            } catch (e) {
                selectHora.innerHTML = '<option value="">Error al cargar horas</option>';
            }
        });
    </script>
</body>

</html>