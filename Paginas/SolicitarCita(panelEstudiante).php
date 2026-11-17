
<?php
require_once '../P.H.P_EJEMPLOS/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $grado = $_POST['grado'];
    $curso = $_POST['curso'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];

    try {

        $sql = "INSERT INTO citas 
        (nombre_completo, documento, correo_institucional, rol_solicitante, grado, curso_grupo, fecha, hora, motivo) 
        VALUES 
        (:nombre, :documento, :correo, :rol, :grado, :curso, :fecha, :hora, :motivo)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'nombre' => $nombre,
            'documento' => $documento,
            'correo' => $correo,
            'rol' => 'Estudiante',
            'grado' => $grado,
            'curso' => $curso,
            'fecha' => $fecha,
            'hora' => $hora,
            'motivo' => $motivo
        ]);

        $mensaje = "Cita registrada correctamente, " . $nombre;

    } catch (PDOException $e) {

        $mensaje = "No se pudo registrar la cita. Inténtalo nuevamente.";

    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Solicitar Cita - Psico-Agenda</title>

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

                        <h1 class="logo-title">
                            Panel del Estudiante
                        </h1>

                        <p class="logo-text">
                            Psico-Agenda
                        </p>

                    </div>

                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse justify-content-end" id="menu">

                    <ul class="navbar-nav align-items-lg-center">

                        <li class="nav-item">
                            <a class="nav-link" href="./iniciaEstudiantes.html">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./servicioEstudiantes.html">
                                Servicios
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./verEstado(panelEstudiante).html">
                                Ver Estado
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="./SolicitarCita(panelEstudiante).php">
                                Solicitar Cita
                            </a>
                        </li>

                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-logout" href="./CerrarSesiónEstudiantes.html">
                                Cerrar Sesión
                            </a>
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
                    Solicita tu cita psicológica
                </h2>

                <p class="texto-cita">

                    En Psico-Agenda nos preocupamos por tu bienestar emocional.
                    Agenda fácilmente un espacio de acompañamiento psicológico
                    y recibe apoyo profesional en un ambiente seguro y confiable.

                </p>

                <div class="info-box">

                    <h5>
                        ¿Qué puedes hacer aquí?
                    </h5>

                    <ul>

                        <li>Solicitar una nueva cita psicológica.</li>
                        <li>Elegir fecha y hora disponible.</li>
                        <li>Explicar brevemente tu situación.</li>
                        <li>Recibir acompañamiento profesional.</li>

                    </ul>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="formulario-cita">

                    <h3 class="text-center mb-4">
                        Formulario de Cita
                    </h3>

                    <?php if ($mensaje != "") { ?>
                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($mensaje); ?>
                        </div>
                    <?php } ?>

                    <form method="POST" action="SolicitarCita(panelEstudiante).php">

                        <div class="mb-3">

                            <label class="form-label">
                                Nombre completo
                            </label>

                            <input type="text" class="form-control"
                                placeholder="Ingresa tu nombre" name="nombre" required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Documento
                            </label>

                            <input type="text" class="form-control"
                                placeholder="Ingresa tu documento" name="documento" required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Correo institucional
                            </label>

                            <input type="email" class="form-control"
                                placeholder="correo@institucion.edu" name="correo" required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Grado
                            </label>

                            <input type="text" class="form-control"
                                placeholder="Ejemplo: 10°" name="grado" required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Curso
                            </label>

                            <input type="text" class="form-control"
                                placeholder="Ejemplo: 1" name="curso" required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Fecha
                            </label>

                            <input type="date" class="form-control" name="fecha" required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Hora
                            </label>

                            <input type="time" class="form-control" name="hora" required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Motivo de la cita
                            </label>

                            <textarea class="form-control" rows="4"
                                placeholder="Describe brevemente el motivo de la cita"
                                name="motivo" required></textarea>

                        </div>

                        <button type="submit" class="btn btn-cita w-100">
                            Solicitar Cita
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
