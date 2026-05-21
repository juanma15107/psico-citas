//link con la pagina de admin,falta crearla y debajo del footer linkearla
document.addEventListener("DOMContentLoaded", function(){
    sessionStorage.getItem("user");
    if(user !== "admin"){
        window.location.href="iniciar_sesion.html"
    }
})
// item es para saber si la persona esta logueada, para saber si es administtador y rcoger el dato 