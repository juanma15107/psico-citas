document.querySelector('#buscar').addEventListener('keyup', function(){
    const textoBusqueda = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tabla tbody tr');

    filas.forEach(fila => {
        const contenidoFila = fila.textContent.toLowerCase();

        if (contenidoFila.includes(textoBusqueda)){
            fila.style.display ='';
        } else {
            fila.style.display ='none';
        }
    });
})

x