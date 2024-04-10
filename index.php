<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se as credenciais estão corretas
    if ($_POST['username'] == 'usuario' && $_POST['password'] == 'senha123') {
        // Credenciais corretas, redireciona para outra página
        header("Location: menu.php");
        exit();
    } else {
        // Credenciais incorretas, exibe mensagem de erro
        $erro = "Nome de usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" alt="text-css">
    <title>Login</title>
</head>
<body>
    <span>Usuairo: usuario</span></br>
    <span>Senha: senha123</span>
    <div class="teladelogin">
        <Div class="titulo">
            <p class="h1-1">Pro</p>
            <p class="h1-2">mo</p>
            <p class="h1-3">ção</p>
        </Div>
        <form method="post" action="" class="formulario">
            <!-- <label for="username">Usuário:</label><br> -->
            <input type="text" id="username" name="username" placeholder="👾Usuário">
            <!-- <label for="password">Senha:</label><br> -->
            <input type="password" id="password" name="password" placeholder="🔑Senha"><br><br>
            <input type="submit" value="Login" class="botaoentrar">

            <?php if(isset($erro)) echo "<p>$erro</p>"; ?>
        </form>
    </div>
</body>
</html>