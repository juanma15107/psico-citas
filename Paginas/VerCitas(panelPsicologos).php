
<?php

require_once '../P.H.P_EJEMPLOS/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_cita = $_POST['id_cita'];
    $estado = $_POST['estado'];

    $estadosPermitidos = ['Pendiente', 'Aprobada', 'Rechazada', 'Atendida'];

    if (in_array($estado, $estadosPermitidos)) {

        try {

            $sqlActualizar = "UPDATE citas SET estado = :estado WHERE id_cita = :id_cita";

            $stmtActualizar = $pdo->prepare($sqlActualizar);

            $stmtActualizar->execute([
                'estado' => $estado,
                'id_cita' => $id_cita
            ]);

            $mensaje = "Estado de la solicitud actualizado correctamente.";

        } catch (PDOException $e) {

            $mensaje = "No fue posible actualizar el estado de la solicitud.";

        }

    } else {

        $mensaje = "El estado seleccionado no es válido.";

    }

}

try {

    $sql = "SELECT * FROM citas ORDER BY fecha DESC, hora DESC";

    $stmt = $pdo->query($sql);

    $citas = $stmt->fetchAll();

} catch (PDOException $e) {

    die("Error al consultar las citas.");

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ver Citas - Psico-Agenda</title>

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
                            Panel del Psicólogo
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
                            <a class="nav-link" href="./iniciaPsicologo.html">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./serviciosPsicologos.html">
                                Servicios
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="./VerCitas(panelPsicologos).php">
                                Ver Citas
                            </a>
                        </li>

                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-logout" href="./CerrarSesiónPsicologo.html">
                                Cerrar Sesión
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <main class="container citas-section">

        <section class="text-center citas-header">

            <h2 class="citas-title">
                Solicitudes de Acompañamiento
            </h2>

            <p class="citas-text">

                Consulta las solicitudes realizadas por estudiantes y docentes,
                revisa los horarios programados y realiza seguimiento
                al estado de cada acompañamiento psicológico.

            </p>

        </section>

        <?php if ($mensaje != "") { ?>

            <div class="alert alert-info text-center">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>

        <?php } ?>

        <section class="table-responsive">

            <table class="table table-custom align-middle">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo de solicitante</th>
                        <th>Grado</th>
                        <th>Curso o grupo</th>
                        <th>Documento</th>
                        <th>Correo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Actualizar</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (count($citas) > 0) { ?>

                        <?php foreach ($citas as $cita) { ?>

                            <tr>

                                <td>
                                    <?php echo $cita['id_cita']; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($cita['nombre_completo']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($cita['rol_solicitante'] ?? 'Estudiante'); ?>
                                </td>

                                <td>
                                    <?php echo !empty($cita['grado']) ? htmlspecialchars($cita['grado']) : '—'; ?>
                                </td>

                                <td>
                                    <?php echo !empty($cita['curso_grupo']) ? htmlspecialchars($cita['curso_grupo']) : '—'; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($cita['documento']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($cita['correo_institucional']); ?>
                                </td>

                                <td>
                                    <?php echo date('d/m/Y', strtotime($cita['fecha'])); ?>
                                </td>

                                <td>
                                    <?php echo date('h:i A', strtotime($cita['hora'])); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($cita['motivo']); ?>
                                </td>

                                <td>
                                    <strong>
                                        <?php echo htmlspecialchars($cita['estado']); ?>
                                    </strong>
                                </td>

                                <td>

                                    <form method="POST" action="VerCitas(panelPsicologos).php">

                                        <input type="hidden" name="id_cita"
                                            value="<?php echo $cita['id_cita']; ?>">

                                        <select name="estado" class="form-select form-select-sm mb-2">

                                            <option value="Pendiente"
                                                <?php if ($cita['estado'] == 'Pendiente') echo 'selected'; ?>>
                                                Pendiente
                                            </option>

                                            <option value="Aprobada"
                                                <?php if ($cita['estado'] == 'Aprobada') echo 'selected'; ?>>
                                                Aprobada
                                            </option>

                                            <option value="Rechazada"
                                                <?php if ($cita['estado'] == 'Rechazada') echo 'selected'; ?>>
                                                Rechazada
                                            </option>

                                            <option value="Atendida"
                                                <?php if ($cita['estado'] == 'Atendida') echo 'selected'; ?>>
                                                Atendida
                                            </option>

                                        </select>

                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            Guardar
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="12" class="text-center">
                                Todavía no hay solicitudes registradas.
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

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
