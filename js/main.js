document.addEventListener('DOMContentLoaded', function() {
	let languageSwitch = document.getElementsByClassName('language-switch');

	for (let i = 0; i < languageSwitch.length; i++) {
		languageSwitch[i].addEventListener('change', loadTranslation);
	}

	if ( languageSwitch ) {
		loadTranslation();
	}
});

function loadTranslation() {
	let language     = document.querySelector('input[name="language-switch"]:checked').value;
	let translations = cartografiasTranslations;
	let textElements = document.querySelectorAll('[data-translation-id]');

	for (let i = 0; i < textElements.length; i++) {
		let translationId = textElements[i].getAttribute('data-translation-id');
		let translation = translations[language][translationId];
		textElements[i].innerText = translation;
	}
}

