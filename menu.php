<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css" alt="text-css">
    <title>Menu</title>
</head>
<body>
    <div class="backgroud-img">
        <div class="conteudo">
            <h2 id="Menu" class="TituloPage">Bem-vindo!</h2>
            <ul class="menu-lista">
                <li  class="botoesMenu"><a href="./menu/cadastrar_estabelecimento.php">Cadastrar Estabelecimento</a></li>
                <li class="botoesMenu"><a href="./menu/cadastrar_produto.php" >Cadastrar Produto</a></li>
                <li class="botoesMenu"><a href="./menu/cadastrar_produto_estabelecimento.php">Cadastrar Produto em Estabelecimento</a></li>
                <li class="botoesMenu"><a href="./menu/promocoes.php">Promoção de Estabelecimento</a></li>
                <li class="botoesMenu"><a href="index.php">Sair</a></li>
            </ul>
        </div>
    </div>
</body>
</html>