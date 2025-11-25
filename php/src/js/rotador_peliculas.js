document.addEventListener("DOMContentLoaded", () => {
  const portadas = document.querySelectorAll('.pelicula .portada');

  portadas.forEach(img => {      
    let index = 1;

    setInterval(() => {
      index = (index % 15) + 1;  // 15 cantidad de imgs por diretorio
      img.src = `./public/img/peliculas/${img.alt}/${index}.png`;
    }, 6000); //milisegundos
  });
});