<?php
// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Estabelece a conexão com o banco de dados
    $conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

    // Verifica a conexão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    // Capturar os dados do formulário e escapar para evitar injeção de SQL
    $nomeProduto = $conexao->real_escape_string($_POST["NomeProduto"]);
    $marca = $conexao->real_escape_string($_POST["Marca"]);
    $tamanhoQuantidade = $conexao->real_escape_string($_POST["TamQuant"]);

    // Tratamento da imagem
    $nomeImagem = $_FILES['Imagem']['name'];
    $caminhoTempImagem = $_FILES['Imagem']['tmp_name'];
    $caminhoSalvarImagem = './imagem/' . $nomeImagem;

    // Move o arquivo de imagem para o diretório desejado
    if (move_uploaded_file($caminhoTempImagem, $caminhoSalvarImagem)) {
        // Query de inserção com o caminho da imagem
        $sql = "INSERT INTO produtos (nome_produto, marca, tamanho_quantidade, imagem) VALUES ('$nomeProduto', '$marca', '$tamanhoQuantidade', '$caminhoSalvarImagem')";

        // Executar a query
        if ($conexao->query($sql) === TRUE) {
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar produto: " . $conexao->error;
        }
    } else {
        echo "Erro ao fazer o upload da imagem.";
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
    <title>Cadastrar Produto</title>
</head>
<body>
    <a href="../menu.php"><button>Voltar ao Menu</button></a>
    <h2 class="TituloPage" id="secCadastProd">Cadastrar Produtos</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="formCadProd">
        <input type="text" name="NomeProduto" id="NomeProduto" placeholder="Nome do produto" class="styleInputs">
        <input type="text" name="Marca" id="Marca" placeholder="Marca" class="styleInputs">
        <input type="text" name="TamQuant" id="TamQuant" placeholder="Tamanho/quantidade" class="styleInputs">
        <input type="file" name="Imagem" id="Imagem" class="styleInputs">

        <div class="botoesInput">
            <input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar" class="botoesMenu">
            <input type="submit" name="Limpar" id="Limpar" value="Limpar" class="botoesMenu" onclick="limparFormProd()">
        </div>
    </form>
</body>
</html>
