document.addEventListener('DOMContentLoaded', function() {
    let container = document.getElementById('container');

    container.addEventListener('click', function(e) {
        let container = document.getElementById('container');
        container.classList.toggle('oppenned');
        document.body.classList.toggle('burger-menu-opened');
    });


	// get all elements with "language-switch" class
	let languageSwitch = document.getElementsByClassName('language-switch');

	for (let i = 0; i < languageSwitch.length; i++) {
		languageSwitch[i].addEventListener('click', function(e) {


		});
	}
});

