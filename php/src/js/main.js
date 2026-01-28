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
  document.body.style.fontSize = tamano + "px";

  document.getElementById("aumentar").addEventListener("click", () => {
    tamano++;
    document.body.style.fontSize = tamano + "px";
    localStorage.setItem("tamanoLetra", tamano);
  });

  document.getElementById("reducir").addEventListener("click", () => {
    tamano--;
    document.body.style.fontSize = tamano + "px";
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
