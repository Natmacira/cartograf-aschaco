document.addEventListener('DOMContentLoaded', function() {
    let container = document.getElementById('container');

    container.addEventListener('click', function(e) {
        let container = document.getElementById('container');
        container.classList.toggle('oppenned');
        document.body.classList.toggle('burger-menu-opened');
    });
});

