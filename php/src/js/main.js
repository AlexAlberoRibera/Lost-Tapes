document.addEventListener('DOMContentLoaded', function () {
	const toggle = document.getElementById('sessionToggle');
	const dropdown = document.getElementById('sessionDropdown');

	if (!toggle || !dropdown) return;

	toggle.addEventListener('click', function (e) {
		e.preventDefault();
		const isShown = dropdown.classList.toggle('show');
		toggle.setAttribute('aria-expanded', isShown ? 'true' : 'false');
		dropdown.setAttribute('aria-hidden', isShown ? 'false' : 'true');
	});

	// close when clicking outside
	document.addEventListener('click', function (e) {
		if (!dropdown.classList.contains('show')) return;
		const target = e.target;
		if (!dropdown.contains(target) && !toggle.contains(target)) {
			dropdown.classList.remove('show');
			toggle.setAttribute('aria-expanded', 'false');
			dropdown.setAttribute('aria-hidden', 'true');
		}
	});

	// close on Escape
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && dropdown.classList.contains('show')) {
			dropdown.classList.remove('show');
			toggle.setAttribute('aria-expanded', 'false');
			dropdown.setAttribute('aria-hidden', 'true');
			toggle.focus();
		}
	});
});
