// para bloquear paginas

document.addEventListener("DOMContentLoaded",function () {
let user = sessionStorage.getItem("user")
if(user !== "psicologo"){
    window.location.href = "./inicialPsicologo.html"
}
})