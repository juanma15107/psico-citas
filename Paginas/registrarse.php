
<?php

session_start();

require_once '../P.H.P_EJEMPLOS/conexion.php';

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $documento = trim($_POST['documento'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $rol = trim($_POST['rol'] ?? '');
    $grado = trim($_POST['grado'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (!in_array($rol, ['estudiante', 'docente'], true)) {

        $mensaje = "Selecciona un rol válido.";
        $tipoMensaje = "danger";

    } elseif ($nombres == "" || $apellidos == "" || $documento == "" || $correo == "") {

        $mensaje = "Completa todos los campos.";
        $tipoMensaje = "danger";

    } elseif ($rol == "estudiante" && $grado == "") {

        $mensaje = "Ingresa el grado que estás cursando.";
        $tipoMensaje = "danger";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Ingresa un correo electrónico válido.";
        $tipoMensaje = "danger";

    } elseif ($contrasena !== $confirmar) {

        $mensaje = "Las contraseñas no coinciden.";
        $tipoMensaje = "danger";

    } elseif (strlen($contrasena) < 8) {

        $mensaje = "La contraseña debe tener mínimo 8 caracteres.";
        $tipoMensaje = "danger";

    } else {

        try {

            $verificar = $pdo->prepare("
                SELECT id_usuario
                FROM usuarios
                WHERE documento = :documento OR correo = :correo
            ");

            $verificar->execute([
                'documento' => $documento,
                'correo' => $correo
            ]);

            if ($verificar->fetch()) {

                $mensaje = "Ya existe una cuenta con ese documento o correo.";
                $tipoMensaje = "danger";

            } else {

                $passwordSegura = password_hash($contrasena, PASSWORD_DEFAULT);

                if ($rol == "docente") {
                    $grado = null;
                }

                $registro = $pdo->prepare("
                    INSERT INTO usuarios
                    (nombres, apellidos, documento, correo, contrasena, rol, grado)
                    VALUES
                    (:nombres, :apellidos, :documento, :correo, :contrasena, :rol, :grado)
                ");

                $registro->execute([
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'documento' => $documento,
                    'correo' => $correo,
                    'contrasena' => $passwordSegura,
                    'rol' => $rol,
                    'grado' => $grado
                ]);

                session_regenerate_id(true);

                $_SESSION['usuario_id'] = $pdo->lastInsertId();
                $_SESSION['nombre'] = $nombres . " " . $apellidos;
                $_SESSION['rol'] = $rol;

                if ($rol == "estudiante") {
                    header("Location: ./iniciaEstudiantes.html");
                } else {
                    header("Location: ./iniciaDocentes.html");
                }

                exit();

            }

        } catch (PDOException $e) {

            $mensaje = "Ocurrió un error al crear la cuenta. Inténtalo nuevamente.";
            $tipoMensaje = "danger";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrarse - Psico-Agenda</title>

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
                            <a class="nav-link" href="../Inicio.html">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./iniciar_sesion.php">Iniciar Sesión</a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <main class="login-section container">

        <section class="login-card">

            <h2 class="login-title">
                Crear una cuenta
            </h2>

            <p class="login-text">
                Regístrate en Psico-Agenda para acceder a nuestros servicios.
            </p>

            <?php if ($mensaje != "") { ?>

                <div class="alert alert-<?php echo $tipoMensaje; ?> text-center">

                    <?php echo htmlspecialchars($mensaje); ?>

                </div>

            <?php } ?>

            <form action="registrarse.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">Tipo de usuario</label>

                    <select name="rol" id="rol" class="form-select input-custom" required>

                        <option value="estudiante" <?php echo (!isset($_POST['rol']) || $_POST['rol'] == 'estudiante') ? 'selected' : ''; ?>>
                            Estudiante
                        </option>

                        <option value="docente" <?php echo (isset($_POST['rol']) && $_POST['rol'] == 'docente') ? 'selected' : ''; ?>>
                            Docente
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">Nombres</label>

                    <input type="text" name="nombres" class="form-control input-custom"
                        placeholder="Ingresa tus nombres"
                        value="<?php echo htmlspecialchars($_POST['nombres'] ?? ''); ?>" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Apellidos</label>

                    <input type="text" name="apellidos" class="form-control input-custom"
                        placeholder="Ingresa tus apellidos"
                        value="<?php echo htmlspecialchars($_POST['apellidos'] ?? ''); ?>" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Documento</label>

                    <input type="text" name="documento" class="form-control input-custom"
                        placeholder="Ingresa tu documento"
                        value="<?php echo htmlspecialchars($_POST['documento'] ?? ''); ?>" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Correo institucional</label>

                    <input type="email" name="correo" class="form-control input-custom"
                        placeholder="Ingresa tu correo institucional"
                        value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>" required>

                </div>

                <div class="mb-3" id="campoGrado">

                    <label class="form-label">Grado</label>

                    <input type="text" name="grado" id="grado" class="form-control input-custom"
                        placeholder="Ejemplo: 10°"
                        value="<?php echo htmlspecialchars($_POST['grado'] ?? ''); ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">Contraseña</label>

                    <input type="password" name="contrasena" class="form-control input-custom"
                        placeholder="Mínimo 8 caracteres" minlength="8" required>

                </div>

                <div class="mb-4">

                    <label class="form-label">Confirmar contraseña</label>

                    <input type="password" name="confirmar" class="form-control input-custom"
                        placeholder="Repite tu contraseña" minlength="8" required>

                </div>

                <button type="submit" class="btn submit-button w-100">

                    Registrarse

                </button>

            </form>

            <p class="text-center mt-4 mb-0">

                ¿Ya tienes una cuenta?

                <a href="./iniciar_sesion.php" style="color: #7a3db8;">

                    Inicia sesión

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

    <script>

        const rol = document.getElementById("rol");
        const campoGrado = document.getElementById("campoGrado");
        const grado = document.getElementById("grado");

        function mostrarGrado() {

            if (rol.value == "estudiante") {

                campoGrado.style.display = "block";
                grado.required = true;

            } else {

                campoGrado.style.display = "none";
                grado.required = false;
                grado.value = "";

            }

        }

        rol.addEventListener("change", mostrarGrado);

        mostrarGrado();

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
