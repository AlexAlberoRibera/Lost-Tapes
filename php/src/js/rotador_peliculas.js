
  document.addEventListener("DOMContentLoaded", () => {
    const peliculas = [
      { selector: '.portadaAndreiRublev img', carpeta: 'andreiRublev', cantidad: 15 },
      { selector: '.portadaBrandedToKill img', carpeta: 'brandedToKill', cantidad: 15 },
      { selector: '.portadaHarakiri img', carpeta: 'harakiri', cantidad: 15 },
    ];

    peliculas.forEach(p => {
      const img = document.querySelector(p.selector);
      let index = 1;

      setInterval(() => {
        index = (index % p.cantidad) + 1;
        img.src = `./public/img/peliculas/${p.carpeta}/${index}.png`;
      }, 6000); // milisegundos
    });
  });

