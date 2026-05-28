//Bloquea paneles
document.addEventListener("DOMContentLoaded", function(){
    sessionStorage.getItem("user");
    if(user !== "admin"){
        window.location.href="iniciar_sesion.html"
    }
})

//Inicio Sesión.
const user = [
    {
        "email": "admin@admin.com",
        "passwors" : "ad123",
        "user" : "admin"
    },
    {
        "email": "admin@estu.com",
        "passwors" : "es123",
        "user" : "est"
    },
    {
        "email": "admin@maes.com",
        "passwors" : "mae123",
        "user" : "maes"
    }

]

const formulario = document.getElementById('formulario');
formulario.addEventListener("submit", function(event) {
    event.preventDefault();
    const email = document.getElementById("exampleInputEmail1").value;
    const passaword = document.getElementById("exampleInputPassaword1").value;
    inicioSesion(email,passaword);

})