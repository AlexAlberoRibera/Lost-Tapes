document.addEventListener('DOMContentLoaded', function () {
  const area = document.querySelector('[id^="rating-area-"]');
  if (!area) return;
  const productId = parseInt(area.dataset.productId || '1', 10);
  const likeBtn = area.querySelector('#likeBtn');
  const likeCountEl = area.querySelector('#likeCount');
  const ratingInfo = area.querySelector('#ratingInfo');

  function setState(summary) {
    if (!summary) return;
    likeCountEl.textContent = String(summary.likes || 0);
    if (summary.liked) likeBtn.classList.add('liked'); else likeBtn.classList.remove('liked');
    // Prefer showing an average if present; otherwise show number of likes (if any) or a fallback message
    if (summary.average !== null) {
      ratingInfo.textContent = `Media ${Number(summary.average).toFixed(1)} (${summary.rating_count || 0})`;
    } else if ((summary.likes || 0) > 0) {
      ratingInfo.textContent = `${summary.likes} ${summary.likes === 1 ? 'Me gusta' : 'Me gusta'}`;
    } else {
      ratingInfo.textContent = 'Sin valoraciones';
    }
  }

  async function load() {
    try {
      const res = await fetch('/ratings.php?productId=' + productId, { credentials: 'same-origin' });
      if (!res.ok) return;
      const json = await res.json();
      setState(json);
    } catch (e) { console.error('Failed to load ratings', e); }
  }

  likeBtn.addEventListener('click', async function () {
    likeBtn.disabled = true;
    try {
  const res = await fetch('/ratings.php', { method: 'POST', headers: {'Content-Type':'application/json'}, credentials: 'same-origin', body: JSON.stringify({ productId: productId, action: 'toggle_like' }) });
      if (res.ok) {
        const json = await res.json();
        setState(json);
      } else if (res.status === 401) {
        alert('Debes iniciar sesión para marcar Me gusta.');
      } else {
        const txt = await res.text();
        console.error('ratings post error', res.status, txt);
        alert('Error al actualizar Me gusta');
      }
    } catch (e) {
      console.error('Failed to toggle like', e);
      alert('Error de red al marcar Me gusta');
    }
    likeBtn.disabled = false;
  });

  load();
});
