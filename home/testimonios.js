document.addEventListener("DOMContentLoaded", () => {
    let currentIndex = 0;
    let testimonios = [];

    // Función para obtener testimonios de la API
    function cargarTestimonios() {
        fetch("api/obtener_testimonios.php?")
            .then(response => response.json())
            .then(data => {
                testimonios = data;
                mostrarTestimonio();
            })
            .catch(error => console.error("Error al cargar testimonios:", error));
    }

    // Función para alternar testimonios
    function mostrarTestimonio() {
        if (testimonios.length === 0) return;

        const testimonialDisplay = document.getElementById("testimonial-display");
        const testimonio = testimonios[currentIndex];
        testimonialDisplay.innerHTML = `
            <p class="testimonial-text">"${testimonio.texto}"</p>
            <p class="testimonial-author">– ${testimonio.autor}</p>
        `;

        currentIndex = (currentIndex + 1) % testimonios.length;
    }

    // Alternar testimonios cada 5 segundos
    setInterval(mostrarTestimonio, 6000);

    // Llamar a cargarTestimonios al cargar la página
    cargarTestimonios();
})
