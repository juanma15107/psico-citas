const user={
    function iniciaEstudiantes(email,password){
    for( let index = 0; index  <user.leght; index++){
        const element = user[index];
        console.log("index",index);
        console.log("elemento",element.email);
        console.log("elemento",element.password);
        console.log("elemento",element.user);

    }
}}


document.addEventListener("DOMContentLoaded", function(){
    sessionStorage.getItem("user");
    if(user !== "estud"){
        window.location.href="iniciar_sesion.html"
    }
})