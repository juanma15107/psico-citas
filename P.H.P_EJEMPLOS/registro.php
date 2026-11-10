<?php
require_once 'conexion.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nombre = $_POST['nombre']; // salchipapa = name de los imput
        $edad = $_POST['edad'];
        $correo = $_POST['correo'];

        try{
            $sql = "INSERT INTO la tabla que van a editar (nombre, edad, correo) //estos son los nombres de las columnas de la db VALUES (:nombre, :edad, :correo)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                'nombre' => $nombre,
                'edad' => $edad,
                'correo' => $correo,
            ]);

            $mensaje = "Usuario registrado correctamente". $nombre;


        }catch (PDOException $e){
            $mensaje = "error en la DB" . $e->getMessage();
        }

        
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RATITA</title>
    <link rel="stylesheet" href="style (1).css">
</head>

<body>
    <form id="formulario" action="registro.php" method="POST">
        <input type="text" id="Nombre" name="nombre">
        <input type="number" id="_Edad" name="edad">
        <input type="email" id="Correo" name="correo">

        <button type="submit">Enviar</button>
        
    </form>

    <div>
        <h2 id="Titulo">Hola</h2>
        <p id="Texto">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, odio! Culpa nisi recusandae
            voluptate ipsa,
            hic voluptatibus iste temporibus, quaerat ratione iure inventore facilis quo explicabo error minus ducimus.
            Illo.
        </p>
    </div>
</body>

</html>