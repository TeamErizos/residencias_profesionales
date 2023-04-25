// Este código debería estar en un archivo aparte llamado logout.js
$(document).ready(function() {
    // Escuchar el evento de clic del botón
    $('#logout-btn').on('click', function(e) {
      e.preventDefault(); // Prevenir que el enlace se abra en una nueva página
  
      // Enviar una petición AJAX para cerrar la sesión
      $.ajax({
        type: 'POST',
        url: 'logout.php',
        success: function(response) {
          // Si la petición es exitosa, redireccionar al usuario a la página de inicio
          window.location.href = 'index.php';
        }
      });
    });
  });
  