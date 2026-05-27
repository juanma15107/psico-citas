const formulario =
    document.getElementById(
        "inicio_sesion"
    )
formulario.addEventListener(
    "submit",
    enviar)

function enviar(event) {
    event.preventDefault();

    let cargo =
        document.getElementById(
            "rol"
        ).value;
    let email =
        document.getElementById(
            "correo"
        ).value;
    let password =
        document.getElementById(
            "cont"
        ).value;

    if (cargo === "") {
        alert(
            "ingresa tu rol"
        );
        return;
    }
    if (email === "") {
        alert(
            "ingresa tu email"
        );
        return;
    }
    if (password === "") {
        alert(
            "ingresa tu contraseña"
        );
        return;
    }
    //admn
    if (
        cargo === "administrador"
        &&
        email === "admin.pscico@gmail.com"
        &&
        password === "13579"
    ) {
        alert(
            "Usuario encontrado"
        );
        alert(
            "Bienvenido administrador"
        );
        localStorage.setItem(
            "usuario",
            "administrador"
        );
        localStorage.setItem(
            "correo",
            "email"
        );
        window.location.href =
            "...";
        return;

    }
    //docente(profesor)
    if (
        cargo === "Docente"
        &&
        email === "doc.pscico@gmail.com"
        &&
        password === "123456"
    ) {
        alert(
            "Usuario encontrado"
        );
        alert(
            "Bienvenido Docente"
        );
        localStorage.setItem(
            "usuario",
            "Docente"
        );
        localStorage.setItem(
            "correo",
            "email"
        );
        window.location.href =
            "Paginas/iniciaDocentes.html";
        return;

    }
    //Estudiante
    if (
        cargo === "Estudiante"
        &&
        email === "Estd.pscico@gmail.com"
        &&
        password === "7890"
    ) {
        alert(
            "Usuario encontrado"
        );
        alert(
            "Bienvenido Estudiante"
        );
        localStorage.setItem(
            "usuario",
            "Estudiante"
        );
        localStorage.setItem(
            "correo",
            "email"
        );
        window.location.href =
            "Paginas/iniciaEstudiantes.html";
        return;

    }
    //psicologo
    if (
        cargo === "Psicologo"
        &&
        email === "psico.pscico@gmail.com"
        &&
        password === "123456"
    ) {
        alert(
            "Usuario encontrado"
        );
        alert(
            "Bienvenido Psicologo"
        );
        localStorage.setItem(
            "usuario",
            "Psicologo"
        );
        localStorage.setItem(
            "correo",
            "email"
        );
        window.location.href =
            "Paginas/iniciaPsicologo.html";
        return;

    }

    alert(
        "usuario encontrado"
    );

}


function cerrarsesion() {
    alert(
        "cerrando sesion"
    );
    localStorage.removeItem(
        "usuario"
    );
    localStorage.removeItem(
        "correo"
    );
    alert(
        "sesion cerrada correctamente"
    );
    window.location.href =
        "index.html";
}

