let formulario = document.getElementById("IniciarSesion");
//function enviar() { }
formulario.addEventListener("Submit", function (event) {
    event.preventDefault(); //Prevenga el comportamiento por defecto
    console.log("No se recargo", formulario)
    let email = document.getElementById("email").value
    let password = document.getElementById("password").value
    //console.log("email", email);
    //Console.log("password", password);
})
//*Let, console, NOOOO=VAR
//Las funciones reciben parametros=event

//necesito guardar en el local estoraje que tipo de usuario inicio sesión para poder darle 
// acceso a diferentes páginas de mi aplicación, como loqueo dichas páginas si el usuario 
// no tiene permiso, en JS
