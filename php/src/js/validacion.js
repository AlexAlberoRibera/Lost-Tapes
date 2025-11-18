document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.form-contacto');
  const checkbox = document.getElementById('btn-validar');

  form.addEventListener('submit', function(e) {
    // Solo validar con JS si checkbox está marcado
    if (checkbox.checked) {
      e.preventDefault();

      const nombre = document.getElementById('nombre').value.trim();
      const email = document.getElementById('email').value.trim();
      const asunto = document.getElementById('asunto').value.trim();
      const mensaje = document.getElementById('mensaje').value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (nombre === '') { alert('Por favor, ingresa tu nombre completo.'); return; }
      if (!emailRegex.test(email)) { alert('Por favor,  un correo electrónico válido.'); return; }
      if (asunto === '') { alert('Por favor, ingresa el asunto.'); return; }
      if (mensaje === '') { alert('Por favor, escribe tu mensaje.'); return; }

      form.submit();
    }
    // Checkbox no marcado → PHP valida
  });
});
