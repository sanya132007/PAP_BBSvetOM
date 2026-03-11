const barrasmenu = document.querySelector('#menu-barras3'); 
const navegacao = document.querySelector('.nav-admin'); 
const fundonavegacao = document.querySelector('.navegacao-fundo'); 

barrasmenu.addEventListener('click', () => { 
    barrasmenu.classList.toggle('change'); 
    navegacao.classList.toggle('active'); 
    fundonavegacao.classList.toggle('active'); 
});

document.querySelectorAll('.nav-admin a').forEach(link => {
    link.addEventListener('click', () => {
        barrasmenu.classList.remove('change');
        navegacao.classList.remove('active');
        fundonavegacao.classList.remove('active');
    });
});
