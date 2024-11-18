
// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Obtener el botón de "Cerrar sesión" por su id
    const logoutButton = document.getElementById('logoutButton');

    // Verificar si el botón de "Cerrar sesión" existe en el DOM
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            // Aquí borramos las cookies o localStorage (según como manejes la sesión)
            // Ejemplo con localStorage:
            localStorage.removeItem('usuario'); // Remover los datos de sesión almacenados

            // Si usas cookies, puedes hacer algo como esto:
            // document.cookie = "usuario=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";

            // Redirigir al usuario a la página de login
            window.location.href = '../../../web_unab/login/login.html';
        });
    }
});
