console.log('Hola');
const user = {
    //arraye {}
    {
    "email": "admin@a.com",
    "password":"admin123",
    "user": "admin"
    }
    // funcion:es un bloque de codigo que comple una sola tarea(gmail.password.user)
    {
     "email": "admin@maes.com",
    "password":"mae123",
    "user": "mae"

    }
}
function iniciar_sesion(email,password){
    for( let index = 0; index  <user.leght; index++){
        const element = user[index];
        console.log("index",index);
        console.log("elemento",element.email);
        console.log("elemento",element.password);
        console.log("elemento",element.user);

    }

    let usuarioencontrado;
    for(const element of user){
        if(element.email === email && element.password ===password){
            usuarioencontrado
        }
//cuales son los metodos de los arreglos mas utilizados javascript
    }








    console.log(email);
}
//const es contante y no puede cambiar,no se puede editar
const formulario = document.getElementById("iniciar_sesion");|
//bsuca elemento que tenga ese id osea iniciosesion
formulario.addEventListener("submit",function(event){
    event.preventDefault();
   
 // el addevent va a escuchar un evento que seria el submit
 //  el preventdef va prevenir el comportamiento por defecto(que se recargue)
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
     iniciar_sesion(email,password)
    console.log("entre");
    if (user.email ===email && user.password === password){
        sessionStorage.setItem("user", element.user );
    
        window.location.href="./iniciaEstudiantes.html"
       return alert("usuario encontrado")

    }
    formulario.reset()
    //borra todos los datos si lo quieren formatear
    return alert("usuario no encontrado")
})
// return es para regresar si encuentra algo lo hace y si no retorna
// el id es para que lo pueda leer ,en iniciar sesion en un input se pone el id 
// arraye para gaurdar diferentes tipos de datos dentro de una variable