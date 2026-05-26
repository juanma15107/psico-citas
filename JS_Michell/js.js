console.log ("hola");
const user = [
{
    "email": "admin@admin.com",
    "password": "admin123",
    "user": "admin"
},
{
    "email": "admin@estu.com",
    "password": "es123",
    "user": "estudiante"
},
{
    "email": "admin@maes.com",
    "password": "maes123",
    "user": "maestro"
}
]

function iniciodeSesion (email, password){
    for (let index = 0 ; index < user.length; index++){
    const elemet = user [index];
    if (element.email === email && element.password === password){
        alert("encontrado");
        sessionStorage.setItem("user",elemet.user);
        break;
    }
    alert("no encontrado");
    }
    formulario = document.getElementById('formulario');
 
}
