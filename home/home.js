function setcomentario() {

    let data = {
        comentario: document.getElementById('comentario').value,
        autor: document.getElementById('autor').value
    };


    fetch("api/agregar_testimonio.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Tipo de contenido
        },
        body: JSON.stringify(data) // Convertir el objeto a una cadena JSON
    })
        .then(response => response.json())
        .then(data => {
            if (data.isSuccess) {
                alert('El comentario se guardo con exito');
                document.getElementById('comentario').value = '';
                document.getElementById('autor').value = '';
            }
            else {
                alert(data.errorMessage)
            }
        })
        .catch(error => console.error("Error al cargar testimonios:", error));
}

document.getElementById('send').addEventListener('click', function () {
    setcomentario();
});