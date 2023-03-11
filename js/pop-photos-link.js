document.addEventListener('DOMContentLoaded', function () {
    let containerArray = document.getElementsByClassName('link-container');
    let imageNationArray = document.getElementsByClassName('nation-img');
    let closeBtnArray = document.getElementsByClassName('close-btn');

  

    for (let index = 0; index < imageNationArray.length; index++) {
        const element = imageNationArray[index];
        element.addEventListener("click", function (e) {
            containerArray[index].classList.add('oppenned');
            console.log('hola')
        });
        
    }

    for (let index = 0; index < closeBtnArray.length; index++) {
        const element = closeBtnArray[index];
        element.addEventListener("click", function (e) {
            containerArray[index].classList.remove('oppenned');
            console.log('hola')
        });
        
    }

   
});