<?php
session_start();
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    try {
        // Consultar el usuario en la BD
        $stmt = $pdo->prepare("SELECT id_usuario, nombre, rol, password FROM usuarios WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) { 

            // 🛡️ Prevenir ataques de fijación de sesión
            session_regenerate_id(true);    

            $_SESSION['usuario_id'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];

            // Redirección inicial según el rol
            switch ($_SESSION['rol']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'cliente':
                    header("Location: cliente_perfil.php");
                    break;
                case 'tecnico':
                    header("Location: tecnico_panel.php");
                    break;
                default:
                    header("Location: login.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Error en la autenticación: " . $e->getMessage());
    }
}
?>