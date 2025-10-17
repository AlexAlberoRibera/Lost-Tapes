// Simple carousel controller
(function(){
  const track = document.querySelector('.carousel-track');
  const items = Array.from(document.querySelectorAll('.carousel-item'));
  const prevBtn = document.querySelector('.carousel-btn.prev');
  const nextBtn = document.querySelector('.carousel-btn.next');
  const dots = Array.from(document.querySelectorAll('.dot'));
  if(!track || items.length===0) return;

  let current = items.findIndex(i=>i.classList.contains('active'));
  if(current<0) current = 0;

  function update(){
    // compute center index and translate so that current item is centered
    const containerWidth = track.parentElement.clientWidth;
    const item = items[current];
    const itemWidth = item.getBoundingClientRect().width + parseFloat(getComputedStyle(track).gap || 8);
    const offset = (containerWidth - itemWidth) / 2;
    const x = - (items.slice(0,current).reduce((acc,it)=> acc + it.getBoundingClientRect().width + parseFloat(getComputedStyle(track).gap || 8), 0)) + offset;
    track.style.transform = `translateX(${x}px)`;
    items.forEach((it,idx)=> it.classList.toggle('active', idx===current));
    dots.forEach((d,idx)=> d.classList.toggle('active', idx===current));
  }

  function prev(){ current = (current - 1 + items.length) % items.length; update(); }
  function next(){ current = (current + 1) % items.length; update(); }

  if(prevBtn) prevBtn.addEventListener('click', prev);
  if(nextBtn) nextBtn.addEventListener('click', next);
  dots.forEach((d,idx)=> d.addEventListener('click', ()=>{ current = idx; update(); }));

  // keyboard support
  document.addEventListener('keydown', (e)=>{
    if(e.key==='ArrowLeft') prev();
    if(e.key==='ArrowRight') next();
  });

  // initial
  window.addEventListener('load', update);
  window.addEventListener('resize', update);
})();
