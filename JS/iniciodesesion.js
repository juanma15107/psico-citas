const user = {
    "email" : "admin@admin.com",
    "password" : "admin123",
    "user" : "admin"
}

const formulario = document.getElementById("iniciar_sesion");

formulario.addEventListener("submit" , function (event) {
    event.preventDefault();
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (user.email === email && user.password === password){
        sessionStorage.setItem("user", user.user);
        window.location.href="../index.html"
        return
    }
    return alert("usuario encontrado")
    
})