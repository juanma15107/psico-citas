
<?php

require_once '../P.H.P_EJEMPLOS/conexion.php';

$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $documento = trim($_POST['documento'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $rol = trim($_POST['rol'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (!in_array($rol, ['administrador', 'psicologo'], true)) {

        $mensaje = "Selecciona un rol válido.";
        $tipoMensaje = "danger";

    } elseif ($nombres == "" || $apellidos == "" || $documento == "" || $correo == "") {

        $mensaje = "Completa todos los campos.";
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

                $registro = $pdo->prepare("
                    INSERT INTO usuarios
                    (nombres, apellidos, documento, correo, contrasena, rol)
                    VALUES
                    (:nombres, :apellidos, :documento, :correo, :contrasena, :rol)
                ");

                $registro->execute([
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'documento' => $documento,
                    'correo' => $correo,
                    'contrasena' => $passwordSegura,
                    'rol' => $rol
                ]);

                $mensaje = "¡La cuenta se creó correctamente! Ya puedes registrar otra.";
                $tipoMensaje = "success";

            }

        } catch (PDOException $e) {

            $mensaje = "Ocurrió un error al crear la cuenta.";
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

    <title>Crear Cuentas Privadas - Psico-Agenda</title>

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

            </div>

        </nav>

    </header>

    <main class="login-section container">

        <section class="login-card">

            <h2 class="login-title">
                Crear cuenta privada
            </h2>

            <p class="login-text">
                Registro de administradores y psicólogo.
            </p>

            <?php if ($mensaje != "") { ?>

                <div class="alert alert-<?php echo $tipoMensaje; ?> text-center">

                    <?php echo htmlspecialchars($mensaje); ?>

                </div>

            <?php } ?>

            <form action="crear_cuentas_privadas.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">Tipo de usuario</label>

                    <select name="rol" class="form-select input-custom" required>

                        <option value="">Selecciona un rol</option>

                        <option value="administrador"
                            <?php echo (($_POST['rol'] ?? '') == 'administrador') ? 'selected' : ''; ?>>
                            Administrador
                        </option>

                        <option value="psicologo"
                            <?php echo (($_POST['rol'] ?? '') == 'psicologo') ? 'selected' : ''; ?>>
                            Psicólogo
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">Nombres</label>

                    <input type="text" name="nombres" class="form-control input-custom"
                        placeholder="Ingresa los nombres" required
                        value="<?php echo htmlspecialchars($_POST['nombres'] ?? ''); ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">Apellidos</label>

                    <input type="text" name="apellidos" class="form-control input-custom"
                        placeholder="Ingresa los apellidos" required
                        value="<?php echo htmlspecialchars($_POST['apellidos'] ?? ''); ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">Documento</label>

                    <input type="text" name="documento" class="form-control input-custom"
                        placeholder="Ingresa el documento" required
                        value="<?php echo htmlspecialchars($_POST['documento'] ?? ''); ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">Correo institucional</label>

                    <input type="email" name="correo" class="form-control input-custom"
                        placeholder="Ingresa el correo institucional" required
                        value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">Contraseña</label>

                    <input type="password" name="contrasena" class="form-control input-custom"
                        placeholder="Mínimo 8 caracteres" minlength="8" required>

                </div>

                <div class="mb-4">

                    <label class="form-label">Confirmar contraseña</label>

                    <input type="password" name="confirmar" class="form-control input-custom"
                        placeholder="Repite la contraseña" minlength="8" required>

                </div>

                <button type="submit" class="btn submit-button w-100">

                    Crear cuenta

                </button>

            </form>

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
