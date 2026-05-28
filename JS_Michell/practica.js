//var reacinar
//let se puede reacicnar y vive solo en un contexto
//const no cambia

console.log ("hola");
const user = [
{
    "email": "admin@adm.com",
    "password": "adm123",
    "user": "admin"
},
{
    "email": "estudiante@est.com",
    "password": "est123",
    "user": "estudiante"
},
{
    "email": "maestro@mae.com",
    "password": "mae123",
    "user": "maestro"
},
 {
    "email": "psicologo@psi.com",
    "password": "psi123",
    "user": "psicologo"
}
]


const formulario = document.getElementById("iniciarsesion");

 formulario.addEventListener("submit",function(event){
 event.preventDefault();

 let email = document.getElementById("email").value;
 let password = document.getElementById("password").value;

 //=== por seguridad

 let usuarioEncontrado = usuarios.find(u => u.email === emailInput && u.password === passwordImput);

 if (usuarioEncontrado){
    sessionStorage.setItem("userRole", usuarioEncontrado.role);

    if(usuarioEncontrado.role === "admin"){
      window.location.href = "admininicioo.html";
    } else if (usuarioEncontrado.role === "estudiante"){
      window.location.href = "iniciaEstudiantes.html";
    }
    return;
}

formulario.reset();
alert("usuario no encntrado");

 //local storage se tiene que limpiar la memoria para que se borre la info
 //sesion storage mientras la navegacion esta activa so se cierra se borra todo automaticamente
 
})


