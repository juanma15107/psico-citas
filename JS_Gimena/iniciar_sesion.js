console.log('Hola');
const user = {
    "email": "admin@a.com",
    "password":"admin123",
    "user": "admin"
}
//const es contante y no puede cambiar,no se puede editar
const formulario = document.getElementById("iniciar_sesion");
//bsuca elemento que tenga ese id osea iniciosesion
formulario.addEventListener("submit",function(event){
    event.preventDefault();
 // el addevent va a escuchar un evento que seria el submit
 //  el preventdef va prevenir el comportamiento por defecto(que se recargue)
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    console.log("entre");
    if (user.email ===email && user.password === password){
        sessionStorage.setItem("user", user.user );
    
        window.location.href="./iniciaEstudiantes.html"
       return alert("usuario encontrado")

    }
    formulario.reset()
    //borra todos los datos si lo quieren formatear
    return alert("usuario no encontrado")
})
// return es para regresar si encuentra algo lo hace y si no retorna
// el id es para que lo pueda leer ,en iniciar sesion en un input se pone el id