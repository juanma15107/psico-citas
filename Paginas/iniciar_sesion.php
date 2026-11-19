
<?php

session_start();

require_once '../P.H.P_EJEMPLOS/conexion.php';

$mensajeError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    try {

        $consulta = $pdo->prepare("
            SELECT id_usuario, nombres, apellidos, correo, contrasena, rol
            FROM usuarios
            WHERE correo = :correo
            AND estado = 1
        ");

        $consulta->execute([
            'correo' => $correo
        ]);

        $usuario = $consulta->fetch();

        if ($usuario && password_verify($password, $usuario['contrasena'])) {

            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombres'] . " " . $usuario['apellidos'];
            $_SESSION['rol'] = $usuario['rol'];

            switch (strtolower(trim($usuario['rol']))) {

                case 'estudiante':

                    header("Location: ./iniciaEstudiantes.html");
                    exit();

                case 'docente':
                case 'profesor':

                    header("Location: ./iniciaDocentes.html");
                    exit();

                case 'psicologo':
                case 'psicólogo':

                    header("Location: ./iniciaPsicologo.html");
                    exit();

                case 'administrador':
                case 'admin':

                    header("Location: ./iniciaAdministrador.html");
                    exit();

                default:

                    session_destroy();
                    $mensajeError = "El rol de esta cuenta no está configurado.";

            }

        } else {

            $mensajeError = "Correo o contraseña incorrectos.";

        }

    } catch (PDOException $e) {

        $mensajeError = "Ocurrió un error al iniciar sesión.";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar Sesión - Psico-Agenda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../ESTILOS/Estilos.css">

</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg navbar-light navbar-custom">

            <div class="container">

                <a class="navbar-brand d-flex align-items-center gap-3" href="../Inicio.html">

                    <img src="../imagenes/Black_and_Beige_Elegant_Simple_Flower_Circle_Logo-removebg-preview (3).png"
                        alt="Logo" class="logo">

                    <div>
                        <h1 class="logo-title">Psico-Agenda</h1>
                        <p class="logo-text">¡Cuida tu mente, cuida de ti!</p>
                    </div>

                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse justify-content-end" id="menu">

                    <ul class="navbar-nav align-items-lg-center">

                        <li class="nav-item">
                            <a class="nav-link" href="../Inicio.html">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./servicios.html">
                                Servicios
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./Acercadenosotros.html">
                                Sobre Nosotros
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./Creadores.html">
                                Creadores
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./Contactanos.html">
                                Contactanos
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <main class="login-section container">

        <section class="login-card">

            <h2 class="login-title">
                Iniciar Sesión
            </h2>

            <p class="login-text">

                Ingresa con tu información institucional para acceder
                a la plataforma Psico-Agenda.

            </p>

            <?php if ($mensajeError != "") { ?>

                <div class="alert alert-danger text-center">

                    <?php echo htmlspecialchars($mensajeError); ?>

                </div>

            <?php } ?>

            <form action="iniciar_sesion.php" method="POST">

                <div class="mb-3">

                    <input type="email" name="correo" class="form-control input-custom"
                        placeholder="Correo Institucional" required>

                </div>

                <div class="mb-3">

                    <input type="password" name="password" class="form-control input-custom"
                        placeholder="Contraseña" required>

                </div>

                <button type="submit" class="btn submit-button w-100">

                    Ingresar

                </button>

            </form>

            <p class="text-center mt-4">

                ¿No tienes una cuenta?

                <a href="./registrarse.php" style="color: #7a3db8;">
                    Regístrate aquí
                </a>

            </p>

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
