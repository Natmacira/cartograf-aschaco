document.addEventListener('DOMContentLoaded', function() {

    loadTranslation();




    let container = document.getElementById('container');

    container.addEventListener('click', function(e) {
        let container = document.getElementById('container');
        container.classList.toggle('opened');
        document.body.classList.toggle('burger-menu-opened');
    });
});

function loadTranslation( languageId = 'es' ) {
    languagesCartografias.{[es]}
}