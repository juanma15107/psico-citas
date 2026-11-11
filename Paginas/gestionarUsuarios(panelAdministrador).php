<?php

include("../P.H.P_EJEMPLOS/conexion.php");


// AGREGAR USUARIO
if (isset($_POST["agregar_usuario"])) {

    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $edad = $_POST["edad"];
    $genero = $_POST["genero"];
    $documento = $_POST["documento"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $sqlAgregar = "INSERT INTO usuarios 
    (nombres, apellidos, edad, genero, documento, correo, contrasena)

    VALUES 
    (:nombres, :apellidos, :edad, :genero, :documento, :correo, :contrasena)";

    $stmtAgregar = $pdo->prepare($sqlAgregar);

    $stmtAgregar->execute([

        ":nombres" => $nombres,
        ":apellidos" => $apellidos,
        ":edad" => $edad,
        ":genero" => $genero,
        ":documento" => $documento,
        ":correo" => $correo,
        ":contrasena" => $contrasena

    ]);

}


// Consultar todos los usuarios
$sql = "SELECT * FROM usuarios";

// Ejecutar la consulta
$stmt = $pdo->query($sql);

// Guardar todos los usuarios
$usuarios = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Psico-Agenda</title>

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
                            <a class="nav-link active" href="./gestionarUsuarios(panelAdministrador).html">Gestionar
                                Usuarios</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./reportes(panelAdministrador).html">Reportes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./configuracion(panelAdministrador).html">Configuración</a>
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
            <h2 class="page-title">Gestión de Usuarios</h2>
            <p class="page-text">
                Administra estudiantes, docentes y psicólogos registrados en la plataforma.
            </p>
        </section>

        <section class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <input type="text" class="form-control search-input" placeholder="Buscar usuario..." id="buscar">

        <button 
          class="btn btn-add"
          data-bs-toggle="modal"
          data-bs-target="#modalAgregarUsuario">

         + Agregar Usuario

        </button>

        </section>

        <section class="table-responsive">

            <table class="table table-hover custom-table align-middle" id="tabla">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

    <?php foreach ($usuarios as $fila): ?>

        <tr>

            <td>
                <?php echo $fila["id_usuario"]; ?>
            </td>

            <td>
                <?php echo $fila["nombres"] . " " . $fila["apellidos"]; ?>
            </td>

            <td>
                <?php echo $fila["correo"]; ?>
            </td>

            <td>
                Usuario
            </td>

            <td>
                <button class="btn btn-sm btn-edit"
                data-bs-toggle="modal"
                data-bs-target="#modalEditarUsuario">        
                Editar
                </button>

                <form method="POST" style="display: inline;">

    <input 
        type="hidden" 
        name="id_usuario" 
        value="<?php echo $fila['id_usuario']; ?>">

    <button 
        type="submit"
        name="eliminar_usuario"
        class="btn btn-sm btn-delete"
        onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">

        Eliminar

    </button>

</form>

            </td>

        </tr>

    <?php endforeach; ?>

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
    <!-- Modal Agregar Usuario -->

<div class="modal fade" id="modalAgregarUsuario" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Agregar Usuario
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form method="POST">

                <div class="modal-body">

                    <!-- Nombres -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nombres
                        </label>

                        <input
                            type="text"
                            name="nombres"
                            class="form-control"
                            required>

                    </div>


                    <!-- Apellidos -->
                    <div class="mb-3">

                        <label class="form-label">
                            Apellidos
                        </label>

                        <input
                            type="text"
                            name="apellidos"
                            class="form-control"
                            required>

                    </div>


                    <!-- Edad -->
                    <div class="mb-3">

                        <label class="form-label">
                            Edad
                        </label>

                        <input
                            type="number"
                            name="edad"
                            class="form-control"
                            required>

                    </div>


                    <!-- Género -->
                    <div class="mb-3">

                        <label class="form-label">
                            Género
                        </label>

                        <select
                            name="genero"
                            class="form-select"
                            required>

                            <option value="">
                                Selecciona una opción
                            </option>

                            <option value="Masculino">
                                Masculino
                            </option>

                            <option value="Femenino">
                                Femenino
                            </option>

                        </select>

                    </div>


                    <!-- Documento -->
                    <div class="mb-3">

                        <label class="form-label">
                            Documento
                        </label>

                        <input
                            type="text"
                            name="documento"
                            class="form-control"
                            required>

                    </div>


                    <!-- Correo -->
                    <div class="mb-3">

                        <label class="form-label">
                            Correo
                        </label>

                        <input
                            type="email"
                            name="correo"
                            class="form-control"
                            required>

                    </div>


                    <!-- Contraseña -->
                    <div class="mb-3">

                        <label class="form-label">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            name="contrasena"
                            class="form-control"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>


                    <button
                        type="submit"
                        name="agregar_usuario"
                        class="btn btn-add">

                        Guardar Usuario

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="modal fade" id="modalEditarUsuario" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Editar Usuario
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form method="POST">

                <div class="modal-body">

                    <!-- Nombres -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nombres
                        </label>

                        <input
                            type="text"
                            name="nombres"
                            class="form-control"
                            required>

                    </div>


                    <!-- Apellidos -->
                    <div class="mb-3">

                        <label class="form-label">
                            Apellidos
                        </label>

                        <input
                            type="text"
                            name="apellidos"
                            class="form-control"
                            required>

                    </div>


                    <!-- Edad -->
                    <div class="mb-3">

                        <label class="form-label">
                            Edad
                        </label>

                        <input
                            type="number"
                            name="edad"
                            class="form-control"
                            required>

                    </div>


                    <!-- Género -->
                    <div class="mb-3">

                        <label class="form-label">
                            Género
                        </label>

                        <select
                            name="genero"
                            class="form-select"
                            required>

                            <option value="">
                                Selecciona una opción
                            </option>

                            <option value="Masculino">
                                Masculino
                            </option>

                            <option value="Femenino">
                                Femenino
                            </option>

                        </select>

                    </div>


                    <!-- Documento -->
                    <div class="mb-3">

                        <label class="form-label">
                            Documento
                        </label>

                        <input
                            type="text"
                            name="documento"
                            class="form-control"
                            required>

                    </div>


                    <!-- Correo -->
                    <div class="mb-3">

                        <label class="form-label">
                            Correo
                        </label>

                        <input
                            type="email"
                            name="correo"
                            class="form-control"
                            required>

                    </div>


                    <!-- Contraseña -->
                    <div class="mb-3">

                        <label class="form-label">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            name="contrasena"
                            class="form-control"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>


                    <button
                        type="submit"
                        name="editar_usuario"
                        class="btn btn-add">

                        Guardar Cambios

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
<script src="buscar.js"></script>
</html>