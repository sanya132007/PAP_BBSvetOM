const caixaloginregistro = document.querySelector('.caixa-login-registro');
const registrobotao = document.querySelector('.registro-botao');
const loginbotao = document.querySelector('.login-botao');

registrobotao.addEventListener('click', () => {
    caixaloginregistro.classList.add('active');
});

loginbotao.addEventListener('click', () => {
    caixaloginregistro.classList.remove('active');
});
