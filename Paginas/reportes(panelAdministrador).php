
<?php

require_once '../P.H.P_EJEMPLOS/conexion.php';

try {

    $sqlTotal = "SELECT COUNT(*) FROM citas";
    $total = $pdo->query($sqlTotal)->fetchColumn();

    $sqlPendientes = "SELECT COUNT(*) FROM citas WHERE estado = 'Pendiente'";
    $pendientes = $pdo->query($sqlPendientes)->fetchColumn();

    $sqlAprobadas = "SELECT COUNT(*) FROM citas WHERE estado = 'Aprobada'";
    $aprobadas = $pdo->query($sqlAprobadas)->fetchColumn();

    $sqlAtendidas = "SELECT COUNT(*) FROM citas WHERE estado = 'Atendida'";
    $atendidas = $pdo->query($sqlAtendidas)->fetchColumn();

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

    <title>Reportes - Psico-Agenda</title>

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
                        <h1 class="logo-title">Panel Administrador</h1>
                        <p class="logo-text">Psico-Agenda</p>
                    </div>

                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="menu">

                    <ul class="navbar-nav align-items-lg-center">

                        <li class="nav-item">
                            <a class="nav-link" href="./iniciaAdministrador.html">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./gestionarUsuarios(panelAdministrador).html">
                                Gestionar Usuarios
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="./reportes(panelAdministrador).php">
                                Reportes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./configuracion(panelAdministrador).html">
                                Configuración
                            </a>
                        </li>

                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-logout" href="./CerrarSesionAdministrador.html">
                                Cerrar Sesión
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <main class="container py-5">

        <section class="text-center mb-5">

            <h2 class="page-title">
                Reportes y Estadísticas
            </h2>

            <p class="page-text">
                Consulta información general sobre las solicitudes de citas de Psico-Agenda.
            </p>

        </section>

        <section class="row g-4 mb-5">

            <div class="col-md-3">

                <div class="report-card">
                    <h3><?php echo $total; ?></h3>
                    <p>Total de citas</p>
                </div>

            </div>

            <div class="col-md-3">

                <div class="report-card">
                    <h3><?php echo $pendientes; ?></h3>
                    <p>Pendientes</p>
                </div>

            </div>

            <div class="col-md-3">

                <div class="report-card">
                    <h3><?php echo $aprobadas; ?></h3>
                    <p>Aprobadas</p>
                </div>

            </div>

            <div class="col-md-3">

                <div class="report-card">
                    <h3><?php echo $atendidas; ?></h3>
                    <p>Atendidas</p>
                </div>

            </div>

        </section>

        <section class="mb-4">

            <h3 class="page-title text-center mb-4">
                Solicitudes de citas registradas
            </h3>

            <div class="table-responsive">

                <table class="table table-hover custom-table align-middle">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Estudiante</th>
                            <th>Documento</th>
                            <th>Correo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (count($citas) > 0) { ?>

                            <?php foreach ($citas as $cita) { ?>

                                <tr>

                                    <td><?php echo $cita['id_cita']; ?></td>

                                    <td>
                                        <?php echo htmlspecialchars($cita['nombre_completo']); ?>
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
                                        <?php echo htmlspecialchars($cita['estado']); ?>
                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="8" class="text-center">
                                    Todavía no hay citas registradas.
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

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
