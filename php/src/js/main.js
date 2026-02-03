document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.getElementById("toggleAccesibilidad");
  const menu = document.getElementById("menuAccesibilidad");

  if (!toggle || !menu) return;

  // Mostrar / ocultar menú
  toggle.addEventListener("click", () => {
    const abierto = !menu.hasAttribute("hidden");
    menu.toggleAttribute("hidden");
    toggle.setAttribute("aria-expanded", String(!abierto));
  });

  // Cambiar tamaño de letra
  let tamano = localStorage.getItem("tamanoLetra");
  tamano = tamano ? parseInt(tamano) : 16;

  function aplicarTamano() {
    document.body.style.fontSize = tamano + "px";

    document.querySelectorAll("h2").forEach(h2 => {
      h2.style.fontSize = (tamano + 6) + "px"; // opcional: un poco más grande
    });
     document.querySelectorAll("h5").forEach(h5 => {
      h5.style.fontSize = (tamano + 4) + "px"; // opcional: un poco más grande
    });
  }

  aplicarTamano();

  document.getElementById("aumentar").addEventListener("click", () => {
    tamano++;
    aplicarTamano();
    localStorage.setItem("tamanoLetra", tamano);
  });

  document.getElementById("reducir").addEventListener("click", () => {
    tamano--;
    aplicarTamano();
    localStorage.setItem("tamanoLetra", tamano);
  });


  // Tema claro / oscuro
  document.getElementById("tema").addEventListener("click", () => {
    document.body.classList.toggle("tema-oscuro");
  });

  // Subir / bajar
  document.getElementById("subir").addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  document.getElementById("bajar").addEventListener("click", () => {
    window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
  });
});
