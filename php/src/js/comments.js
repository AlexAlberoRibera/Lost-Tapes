document.addEventListener('DOMContentLoaded', function () {
  // find the comments container for this page. It must include a data-product-id attribute
  const container = document.querySelector('[id^="comments-area-"]');
  if (!container) return;

  const productId = parseInt(container.dataset.productId || '1', 10);
  const list = container.querySelector('.comments-list');
  const form = container.querySelector('.comments-form');
  const textarea = container.querySelector('textarea[name="content"]');
  const submit = container.querySelector('button[type="submit"]');

  function formatDate(iso) {
    try { return new Date(iso).toLocaleString(); } catch(e){ return iso; }
  }

  function renderComments(items) {
    list.innerHTML = '';
    if (!items.length) {
      list.innerHTML = '<p class="muted">Sigue siendo el primero en opinar sobre esta película.</p>';
      return;
    }
    items.forEach(c => {
      const el = document.createElement('div');
      el.className = 'comment';
      el.innerHTML = `<div class="comment-head"><strong>${escapeHtml(c.userName)}</strong> <span class="comment-date">${formatDate(c.created_at)}</span></div><div class="comment-body">${escapeHtml(c.content)}</div>`;
      list.appendChild(el);
    });
  }

  function escapeHtml(s){ return String(s).replace(/[&<>"']/g, function(m){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]; }); }

  async function loadComments(){
    // API is served from /api/comments.php (php/src is the web root)
    try {
      const res = await fetch('/comments.php?productId=' + productId, { credentials: 'same-origin' });
      if (!res.ok) return;
      const items = await res.json();
      renderComments(items);
    } catch (err) {
      console.error('Failed to load comments', err);
      list.innerHTML = '<p class="muted">No se pudieron cargar los comentarios.</p>';
    }
  }

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    submit.disabled = true;
    const payload = { productId: productId, content: textarea.value.trim() };
    if (!payload.content) { submit.disabled=false; return; }
    try {
  const res = await fetch('/comments.php', { method:'POST', headers:{'Content-Type':'application/json'}, credentials: 'same-origin', body: JSON.stringify(payload) });
      if (res.ok) {
        const created = await res.json();
      // prepend
      const el = document.createElement('div'); el.className='comment'; el.innerHTML = `<div class="comment-head"><strong>${escapeHtml(created.userName)}</strong> <span class="comment-date">${formatDate(created.created_at)}</span></div><div class="comment-body">${escapeHtml(created.content)}</div>`;
      if (list.querySelector('.muted')) list.innerHTML = '';
      list.insertBefore(el, list.firstChild);
      textarea.value = '';
      } else if (res.status === 401) {
      // show inline feedback with link to login
      let fb = container.querySelector('.comments-feedback');
      if (!fb) { fb = document.createElement('div'); fb.className = 'comments-feedback'; container.insertBefore(fb, form); }
      fb.innerHTML = '<div class="global-error">Debes <a href="/auth/login.php">iniciar sesión</a> para poder comentar.</div>';
      } else {
        // try to read error details from JSON body
        let msg = 'Error al enviar el comentario. Intenta de nuevo.';
        try {
          const errBody = await res.json();
          if (errBody && errBody.error) msg = String(errBody.error);
        } catch (e) {}
        let fb = container.querySelector('.comments-feedback');
        if (!fb) { fb = document.createElement('div'); fb.className = 'comments-feedback'; container.insertBefore(fb, form); }
        fb.innerHTML = `<div class="global-error">${escapeHtml(msg)}</div>`;
      }
    } catch (err) {
      console.error('Failed to submit comment', err);
      let fb = container.querySelector('.comments-feedback');
      if (!fb) { fb = document.createElement('div'); fb.className = 'comments-feedback'; container.insertBefore(fb, form); }
      const msg = err && err.message ? String(err.message) : 'Error de red al enviar el comentario.';
      fb.innerHTML = `<div class="global-error">Error de red al enviar el comentario: ${escapeHtml(msg)}</div>`;
    }
    submit.disabled = false;
  });

  loadComments();
});
