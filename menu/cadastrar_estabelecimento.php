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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estabelecimentos</title>
</head>
<body>
    <a href="../menu.php"><button>Voltar ao Menu</button></a>
    <h2 class="TituloPage" id="SecCadastEstab"> Cadastrar Estabelecimento</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="formCadEstab">
        <input type="text" name="NomeFantasia" id="NomeFantasia" placeholder="Nome fantasia" class="styleInputs"> </br>
        <input type="text" name="Endereco" id="Endereco" placeholder="Endereço" class="styleInputs">
        <input type="text" name="Cidade" id="Cidade" placeholder="Cidade" class="styleInputs">
        <input type="number" name="NumeroLojas" id="NumeroLojas" placeholder="Número de lojas" class="styleInputs"> </br>

        <div class="botoesInput">
            <input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar" class="botoesMenu">
            <input type="submit" name="Limpar" id="Limpar" value="Limpar" class="botoesMenu" onclick="limparForEstab()">
        </div>
    </form>
</body>
</html>
