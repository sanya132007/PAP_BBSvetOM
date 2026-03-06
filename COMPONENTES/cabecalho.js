const barrasmenu = document.querySelector('#menu-barras3');

const navegacao = document.querySelector('.navegacao');

const fundonavegacao = document.querySelector('.navegacao-fundo');



barrasmenu.addEventListener('click', () => {

    barrasmenu.classList.toggle('change');

    navegacao.classList.toggle('active');

    fundonavegacao.classList.toggle('active');

});



document.querySelectorAll('.navegacao a').forEach(link => {

    link.addEventListener('click', () => {

        barrasmenu.classList.remove('change');

        navegacao.classList.remove('active');

        fundonavegacao.classList.remove('active');

    });

});



function abrirCarrinho() {

    document.getElementById('carrinho-lateral').classList.add('ativo');

    document.getElementById('overlay-carrinho').style.display = 'block';

}



function fecharCarrinho() {

    document.getElementById('carrinho-lateral').classList.remove('ativo');

    document.getElementById('overlay-carrinho').style.display = 'none';

}