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
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($erro)) echo "<p>$erro</p>"; ?>
    <form method="post" action="">
        <label for="username">Usuário:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>