<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
</head>
<body>
    <h2 id="Menu">Bem-vindo!</h2>
    <h3>Escolha uma opção:</h3>
    <ul>
        <li><a href="./menu/cadastrar_estabelecimento.php">Cadastrar Estabelecimento</a></li>
        <li><a href="./menu/cadastrar_produto.php">Cadastrar Produto</a></li>
        <li><a href="./menu/cadastrar_produto_estabelecimento.php">Cadastrar Produto em Estabelecimento</a></li>
        <li><a href="./menu/promocoes.php">Promoção de Estabelecimento</a></li>
        <li><a href="index.php">Sair</a></li>
    </ul>
</body>
</html>