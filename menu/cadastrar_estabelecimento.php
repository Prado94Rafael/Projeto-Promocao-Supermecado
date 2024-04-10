<?php
// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecte-se ao banco de dados
    $conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

    // Verifique a conexão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    // Capturar os dados do formulário e escapar para evitar injeção de SQL
    $nomeFantasia = $conexao->real_escape_string($_POST["NomeFantasia"]);
    $endereco = $conexao->real_escape_string($_POST["Endereco"]);
    $cidade = $conexao->real_escape_string($_POST["Cidade"]);
    $numeroLojas = $conexao->real_escape_string($_POST["NumeroLojas"]);

    // Query de inserção
    $sql = "INSERT INTO estabelecimentos (nome_fantasia, endereco, cidade, numero_lojas) VALUES ('$nomeFantasia', '$endereco', '$cidade', '$numeroLojas')";

    // Executar a query
    if ($conexao->query($sql) === TRUE) {
        echo "Estabelecimento cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar estabelecimento: " . $conexao->error;
    }

    // Fechar conexão
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css" alt="text-css">
    <script src="./script.js"></script>
    <title>Estabelecimentos</title>
</head>
<body>
    <div class="backgroud-img">
        <div class="conteudo">
            <h2 class="TituloPage" id="SecCadastEstab"> Cadastrar Estabelecimento</h2>
            <div class="formulario-cadastro">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="formCadEstab">
                    <input type="text" name="NomeFantasia" id="NomeFantasia" placeholder="Nome fantasia" class="botoesMenu"> 
                    <input type="text" name="Endereco" id="Endereco" placeholder="Endereço" class="botoesMenu">
                    <input type="text" name="Cidade" id="Cidade" placeholder="Cidade" class="botoesMenu">
                    <input type="number" name="NumeroLojas" id="NumeroLojas" placeholder="Número de lojas" class="botoesMenu"> 
            </div>
                <div class="botoesInput">
                    <input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar" class="botao-cadastro">
                    <!-- <input type="submit" name="Limpar" id="Limpar" value="Limpar" class="botao-cadastro" onclick="limparFormEstab()"> -->
                </div>
                </form>
            <a href="../menu.php"><button id="voltar-ao-menu" class="botao-cadastro">Voltar ao Menu</button></a>
        </div>
    </div>
</body>
</html>
