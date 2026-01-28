const toggle = document.getElementById("toggleAccesibilidad");
const menu = document.getElementById("menuAccesibilidad");

// ===============================
// TAMAÑO DE LETRA
// ===============================
let tamano = parseInt(localStorage.getItem("tamanoLetra")) || 16;
document.body.style.fontSize = tamano + "px";

// Abrir / cerrar menú
toggle.addEventListener("click", () => {
  const isOpen = !menu.hasAttribute("hidden");
  menu.toggleAttribute("hidden");
  toggle.setAttribute("aria-expanded", String(!isOpen));
});

// Aumentar letra
document.getElementById("aumentar").addEventListener("click", () => {
  if (tamano < 24) {
    tamano++;
    document.body.style.fontSize = tamano + "px";
    localStorage.setItem("tamanoLetra", tamano);
  }
});

// Reducir letra
document.getElementById("reducir").addEventListener("click", () => {
  if (tamano > 12) {
    tamano--;
    document.body.style.fontSize = tamano + "px";
    localStorage.setItem("tamanoLetra", tamano);
  }
});

// ===============================
// TEMA CLARO / OSCURO
// ===============================
if (localStorage.getItem("tema") === "oscuro") {
  document.body.classList.add("tema-oscuro");
}

document.getElementById("tema").addEventListener("click", () => {
  document.body.classList.toggle("tema-oscuro");
  localStorage.setItem(
    "tema",
    document.body.classList.contains("tema-oscuro") ? "oscuro" : "claro"
  );
});

// ===============================
// SCROLL
// ===============================
document.getElementById("subir").addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

document.getElementById("bajar").addEventListener("click", () => {
  window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
});

// ===============================
// TECLA ESC
// ===============================
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && !menu.hasAttribute("hidden")) {
    menu.setAttribute("hidden", "");
    toggle.setAttribute("aria-expanded", "false");
    toggle.focus();
  }
});
