
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.form-contacto');

  form.addEventListener('submit', function(e) {
    e.preventDefault(); // Evita envío automático

    // Obtener valores
    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const asunto = document.getElementById('asunto').value.trim();
    const mensaje = document.getElementById('mensaje').value.trim();

    // Expresión regular para validar email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validaciones
    if (nombre === '') {
      alert('Por favor, ingresa tu nombre completo.');
      return;
    }

    if (!emailRegex.test(email)) {
      alert('Por favor, ingresa un correo electrónico válido.');
      return;
    }

    if (asunto === '') {
      alert('Por favor, ingresa el asunto.');
      return;
    }

    if (mensaje === '') {
      alert('Por favor, escribe tu mensaje.');
      return;
    }

    // Si todo está bien, se puede enviar el formulario
    form.submit();
  });
});
