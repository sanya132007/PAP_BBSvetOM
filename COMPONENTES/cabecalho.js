document.addEventListener('DOMContentLoaded', () => {
    const barrasmenu = document.querySelector('#menu-barras3'); 
    const navegacao = document.querySelector('.navegacao'); 
    const fundonavegacao = document.querySelector('.navegacao-fundo'); 

    if (barrasmenu) {
        barrasmenu.addEventListener('click', () => { 
            barrasmenu.classList.toggle('change'); 
            navegacao.classList.toggle('active'); 
            fundonavegacao.classList.toggle('active'); 
        });
    }
});

function abrirCarrinho() {
    const lateral = document.getElementById('carrinho-lateral');
    const overlay = document.getElementById('overlay-carrinho');
    
    if (lateral && overlay) {
        lateral.classList.add('ativo');
        overlay.style.display = 'block';
        
        fetch('../PROCESSOS/process_carrinho_obter.php')
            .then(res => res.json())
            .then(data => {
                const corpo = document.getElementById('conteudo-carrinho');
                let total = 0;
                
                if (data.length === 0) {
                    corpo.innerHTML = '<p style="text-align:center; padding:20px;">Vazio</p>';
                    document.querySelector('.total').innerText = "Total: 0.00€";
                    return;
                }

                corpo.innerHTML = '';
                data.forEach(item => {
                    total += parseFloat(item.preco);
                    corpo.innerHTML += `
                        <div style="display:flex; gap:10px; margin-bottom:10px; border-bottom:1px solid #ddd; padding-bottom:5px;">
                            <img src="../ANEXOS/${item.imagem_capa}" style="width:50px;">
                            <div>
                                <p style="margin:0; font-size:12px;">${item.nome}</p>
                                <p style="margin:0; font-weight:bold;">${item.preco}€</p>
                            </div>
                        </div>`;
                });
                document.querySelector('.total').innerText = "Total: " + total.toFixed(2) + "€";
            })
            .catch(err => console.error("Erro ao carregar carrinho:", err));
    }
}

function adicionarProduto(id) {
    let dados = new FormData();
    dados.append('id_produto', id);

    fetch('../PROCESSOS/process_carrinho_adicionar.php', {
        method: 'POST',
        body: dados
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'sucesso') {
            abrirCarrinho(); 
        } else {
            alert(res.mensagem);
            if(res.mensagem === 'Login obrigatório!') {
                window.location.href = 'login_registro.php';
            }
        }
    })
    .catch(err => console.error("Erro ao adicionar:", err));
}


function removerDoCarrinho(id_carrinho) {
    fetch('../PROCESSOS/process_carrinho_remover.php?id=' + id_carrinho)
        .then(() => {
            abrirCarrinho(); 
        });
}

function fecharCarrinho() {
    const lateral = document.getElementById('carrinho-lateral');
    const overlay = document.getElementById('overlay-carrinho');
    if (lateral) lateral.classList.remove('ativo');
    if (overlay) overlay.style.display = 'none';
}