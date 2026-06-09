document.getElementById("loginForm").addEventListener("submit", function (e) {

    e.preventDefault();

    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("password").value.trim();

    const mensajeError = document.getElementById("mensajeError");

    mensajeError.textContent = "";

    if (
        correo === "admin@psico.citas" &&
        password === "admin123"
    ) {

        localStorage.setItem("rol", "administrador");

        window.location.href = "./iniciaAdministrador.html";
    }

    else if (
        correo === "docente@psico.citas" &&
        password === "doc123"
    ) {

        localStorage.setItem("rol", "docente");

        window.location.href = "./iniciaDocentes.html";
    }

    else if (
        correo === "psicologo@psico.citas" &&
        password === "psi123"
    ) {

        localStorage.setItem("rol", "psicologo");

        window.location.href = "./iniciaPsicologo.html";
    }

    else if (
        correo === "estudiante@psico.citas" &&
        password === "est123"
    ) {

        localStorage.setItem("rol", "estudiante");

        window.location.href = "./iniciaEstudiantes.html";
    }

    else {

        mensajeError.textContent =
            "Correo o contraseña incorrectos.";

    }

});