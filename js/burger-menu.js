document.addEventListener('DOMContentLoaded', function() {
    let container = document.getElementById('container');

	if (container) {
		container.addEventListener('click', function(e) {
			let container = document.getElementById('container');
			container.classList.toggle('opened');
			document.body.classList.toggle('burger-menu-opened');
		});
	}

	let searchFilterToggler = document.getElementById('search-filter-toggler');

	if (searchFilterToggler) {
		searchFilterToggler.addEventListener('click', function() {
			document.body.classList.toggle('search-filter-opened');
		});
	}
});
