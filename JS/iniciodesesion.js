const user = [
    {
        "email" : "admin@admin.com",
        "password" : "admin123",
        "user" : "admin"
    },
    {
        "email" : "est@est.com",
        "password" : "est123",
        "user" : "est"
    },
    {
        "email" : "maes@admin.com",
        "password" : "mae123",
        "user" : "maes"
    }

]
function iniciar_sesion(email, password){
    let usuarioEncontrado;
    for (let index = 0; index < user.length; index++){
        const element = user[index];
        if (element.email === email && element.password === password){
            break;
        }



        
    }
    
    if(usuarioEncontrado){
     sessionStorage.setItem("user" , usuarioEncontrado.user);
     alert("encontrado");
    }
    else{
     alert("usuario no encontrado")
    }
    
    
}


const formulario = document.getElementById("iniciar_sesion");

formulario.addEventListener("submit" , function (event) {
    event.preventDefault();
    const email = document.getElementById("exampleInputEmail").value;
    const password = document.getElementById("exampleInputpassword1").value;
    iniciar_sesion(email,password)
    
    
})