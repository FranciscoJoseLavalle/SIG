const toggleButton = document.querySelector('.toggleButton')
const aside = document.querySelector('.asidePage');
const header = document.querySelector('.headerPage');
const main = document.querySelector('.mainPage');

toggleButton.addEventListener('click', () => {
    aside.classList.add('transition');
    aside.classList.toggle('asideClosed');
    header.classList.add('transition');
    header.classList.toggle('headerOpened');
    main.classList.add('transition');
    main.classList.toggle('mainOpened');
})