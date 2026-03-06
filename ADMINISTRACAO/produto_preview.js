document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. PREVIEW CAPA ---
    const inputFoto = document.getElementById('submeter-foto');
    const previewBox = document.getElementById('caixa-ver-foto');

    if (inputFoto) {
        inputFoto.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            // Validação: Só avança se for imagem
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewBox.innerHTML = '<p class="caixa-ver-texto">PREVIEW DA NOVA CAPA:</p>';
                    
                    const divContentor = document.createElement('div');
                    divContentor.className = 'foto-produto';
                    divContentor.style.width = '100%';
                    divContentor.style.height = 'auto';
                    divContentor.style.margin = '0 auto';

                    divContentor.innerHTML = `
                        <img src="${event.target.result}" class="ver-foto" style="display:block;">
                        <button type="button" class="botao-remover" onclick="window.limparCapa()">×</button>
                    `;
                    
                    previewBox.appendChild(divContentor);
                    previewBox.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } 
            else if (file) {
                // Se escolheu um ficheiro mas não é imagem
                alert("Por favor, seleciona apenas ficheiros de imagem (JPG, PNG, etc.)!");
                this.value = ""; 
                window.limparCapa();
            }
        });
    }

    window.limparCapa = function() {
        if(inputFoto) inputFoto.value = ""; 
        if(previewBox) {
            previewBox.style.display = 'none';
            previewBox.innerHTML = '';
        }
    };

    // --- 2. PREVIEW GALERIA ---
    const inputGaleria = document.getElementById('submeter-galeria');
    const galeriaBox = document.getElementById('caixa-ver-galeria-foto');
    const galeriaContainer = document.getElementById('caixa-ver-galeria-foto-painel');

    let listaFicheiros = [];

    if (inputGaleria) {
        inputGaleria.addEventListener('change', function() {
            // Filtra a lista: só deixa passar o que é imagem
            const selecionados = Array.from(this.files);
            const novosFicheiros = selecionados.filter(file => file.type.startsWith('image/'));

            // Se houver ficheiros que não são imagem, avisa
            if (novosFicheiros.length !== selecionados.length) {
                alert("Alguns ficheiros foram ignorados por não serem imagens.");
            }

            listaFicheiros = [...listaFicheiros, ...novosFicheiros];
            atualizarPreview();
        });
    }

    function atualizarPreview() {
        if(!galeriaContainer) return;
        galeriaContainer.innerHTML = ''; 
        
        if (listaFicheiros.length > 0) {
            galeriaBox.style.display = 'block'; 
            
            listaFicheiros.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.classList.add('foto-produto');
                    div.innerHTML = `
                        <img src="${e.target.result}" class="ver-foto-galeiria">
                        <button type="button" class="botao-remover" onclick="removerdover(${index})">×</button>
                    `;
                    galeriaContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            galeriaBox.style.display = 'none';
        }

        const dt = new DataTransfer();
        listaFicheiros.forEach(file => dt.items.add(file));
        inputGaleria.files = dt.files;
    }

    window.removerdover = function(index) {
        listaFicheiros.splice(index, 1);
        atualizarPreview();
    };
});