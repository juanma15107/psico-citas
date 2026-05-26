//var reacinar
//let se puede reacicnar y vive solo en un contexto
//const no cambia

console.log ("hola");
const user = 
{
    "email": "admin@admin.com",
    "password": "admin123",
    "user": "admin"
}

const formulario = document.getElementById("iniciarsesion");

 formulario.addEventListener("submit",function(event){
 event.preventDefault();

 let email = document.getElementById("email").value;
 let password = document.getElementById("password").value;

 //=== por seguridad

 if (user.email === email && user.password === password){

    sessionStorage.setItem("user",user.user);

  return alert("usuario encontrado");
  window.location.href="serviciosPsicologo.html"
 }
 return alert ("usuario no encontrado");
 console.log ("engtre");

 //local storage se tiene que limpiar la memoria para que se borre la info
 //sesion storage mientras la navegacion esta activa so se cierra se borra todo automaticamente
 
})


