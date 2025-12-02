// Controlador de carrusel
(()=>{
  // Objetos Html (DOM)
  const track = document.querySelector('.carrusel-track');
  const items = Array.from(document.querySelectorAll('.carrusel-item'));
  const prevBtn = document.querySelector('.carrusel-btn.prev');
  const nextBtn = document.querySelector('.carrusel-btn.next');
  const dots = Array.from(document.querySelectorAll('.dot'));

  if(!track || items.length === 0) return;

  // Determina si el slide esta activo, usa el indice representado en la variable current, en caso contrario define la variable current = 0
  let current = items.findIndex(item => item.classList.contains('active'));
  if(current < 0) current = 0;

  
  const CSS_MAX_WIDTH = 1000;
  // Set a sensible max-width for each image so it is never upscaled.
  // We keep slides at 100% container width and scale images inside them
  // preserving aspect ratio (object-fit: contain). This keeps one slide
  // visible at a time while the image itself won't be upscaled.
  function applyNaturalMaxWidths(){
    const containerW = track.parentElement.clientWidth;
    const maxAllowed = Math.min(CSS_MAX_WIDTH, Math.round(containerW * 0.92));
    items.forEach(item => {
      const img = item.querySelector('img');
      if (img) {
        // prefer naturalWidth but cap to maxAllowed
        // remove any inline sizing so CSS (object-fit:cover) controls appearance
        img.style.maxWidth = '';
        img.style.width = '';
        img.style.height = '';
        img.style.display = '';
        img.style.margin = '';
      }
    });
  }

  // With slides 100% width, centering is simply translating by current * containerWidth
  function centerCurrent(){
    const containerW = track.parentElement.clientWidth;
    const translate = Math.round(current * containerW);
    track.style.transform = `translateX(${-translate}px)`;
  }

  // Aplica las funciones anteriores y actualiza las clases active en items y puntos para reflejar el slide actual
  function update(){
    applyNaturalMaxWidths();
    centerCurrent();
    items.forEach((it, idx) => it.classList.toggle('active', idx === current));
    dots.forEach((d, idx) => d.classList.toggle('active', idx === current));
  }

  // Actualizar current para mostrar la imagen que corresponda
  function prev(){ current = (current - 1 + items.length) % items.length; update(); }
  function next(){ current = (current + 1) % items.length; update(); }

  // Control de las flechas y los puntos
  prevBtn && prevBtn.addEventListener('click', prev);
  nextBtn && nextBtn.addEventListener('click', next);
  dots.forEach((dot, idx) => dot.addEventListener('click', () => { current = idx; update(); }));

  // soporte para teclado
  document.addEventListener('keydown', e => {
    if(e.key === 'ArrowLeft') prev();
    if(e.key === 'ArrowRight') next();
  });

  // Actualizar la pagina para que cuando recargen o cambien el tamaño, se active la funcion update para centrar el carrusel
  window.addEventListener('load', update);
  window.addEventListener('resize', update);
})();
