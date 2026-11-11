<?php
// Activar errores temporalmente para diagnóstico si algo llega a fallar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../conexion.php");

$mensaje = "";
$tipoAlerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_docente = trim($_POST['nombre_docente'] ?? '');
    $curso = trim($_POST['curso'] ?? '');
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $motivo = trim($_POST['motivo'] ?? '');

    // Combinar fecha y hora para el campo de tipo DATETIME (si tu tabla usa fecha_hora)
    $fecha_hora = (!empty($fecha) && !empty($hora)) ? $fecha . ' ' . $hora . ':00' : '';

    if (!empty($nombre_docente) && !empty($curso) && !empty($fecha) && !empty($hora) && !empty($motivo)) {
        try {
            // Unificamos la información del docente en el campo motivo o la estructura que maneje tu tabla 'citas'
            $motivo_completo = "Docente: $nombre_docente | Curso: $curso | Motivo: $motivo";

            // Usamos la misma tabla 'citas' o la que corresponda en tu base de datos de usuarios
            $sql = "INSERT INTO citas (id_ticket, id_area, motivo, estado, sede, fecha_hora) 
                    VALUES (:id_ticket, :id_area, :motivo, :estado, :sede, :fecha_hora)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_ticket' => 1,
                ':id_area' => 2, // Área asignada para docentes
                ':motivo' => $motivo_completo,
                ':estado' => 'Pendiente',
                ':sede' => 'Medellín',
                ':fecha_hora' => $fecha_hora
            ]);

            $mensaje = "¡Acompañamiento solicitado con éxito!";
            $tipoAlerta = "success";
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
    <!-- CSS -->
    <link rel="stylesheet" href="../Estilos.css">
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
                            <a class="btn btn-logout" href="../Paginas/CerrarSesiónDocentes.html">Cerrar Sesión</a>
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

                    <!-- Alertas de estado (Éxito o Error) -->
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
                            <label class="form-label">Curso o grupo</label>
                            <input type="text" class="form-control" placeholder="Ejemplo: 10°B" name="curso" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha solicitada</label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" class="form-control" name="hora" required>
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
</body>

</html>