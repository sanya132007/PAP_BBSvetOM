<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registo - BBSvetOM</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/caixaicons@2.1.4/css/caixaicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="RECURSOS/CSS/styles.css">
    <link rel="stylesheet" href="RECURSOS/CSS/login_registro.css">
</head>
<body>
    
    <div class="caixa-login-registro">
        
        <div class="formulario login">
            <form action="PROCESSOS/process_login.php" method="POST">
                <h1>Entrar na minha conta</h1>
                <a href="_index.php" class="logo">BBSvetOM</a>
                
                <div class="submeter-caixa">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="submeter-caixa">
                    <input type="password" name="password" placeholder="Palavra-passe" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="esqueci-ligacao">
                    <a href="#">Esqueceu a palavra-passe?</a>
                </div>
                <button type="submit" name="botao-entrar" class="botao">Entrar</button>
                
                <p>Ou entra com plataformas sociais:</p>
                <div class="icones-redes">
                    <a href="#" class="google"><i class="bi bi-google"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="apple"><i class="bi bi-apple"></i></a>
                </div>
            </form>
        </div>

        <div class="formulario registro">
            <form action="PROCESSOS/process_registro.php" method="POST">
                <h1>Registo da minha conta</h1>
                <a href="_index.php" class="logo">BBSvetOM</a>
                
                <div class="submeter-caixa">
                    <input type="text" name="nome" placeholder="Nome" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="submeter-caixa">
                    <input type="text" name="apelido" placeholder="Apelido" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="submeter-caixa">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="submeter-caixa">
                    <input type="password" name="password" placeholder="Palavra-passe" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="submeter-caixa">
                    <input type="password" name="confirmar_password" placeholder="Confirmar palavra-passe" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" name="botao-registrar" class="botao">Registar</button>
            </form>
        </div>

        <div class="mexer-caixa">
            <div class="mexer-panel mexer-esquerda">
                <h1>Bem-vindo de volta!</h1>
                <p>Não tem uma conta?</p>
                <button class="botao registro-botao">Registar</button>
            </div>
            <div class="mexer-panel mexer-direita">
                <h1>Bem-vindo!</h1>
                <p>Já tem uma conta?</p>
                <button class="botao login-botao">Entrar</button>
            </div>
        </div>
    </div>

    <script src="RECURSOS/JS/login_registro.js" defer></script>
</body>
</html>