<?php
// Inicialize as variáveis dos resultados dos selects
$resultadoProdutos = null;
$resultadoSupermercados = null;
$resultadoMarcas = null;

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecte-se ao banco de dados
    $conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

    // Verifique a conexão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    // Capturar os dados do formulário e escapar para evitar injeção de SQL
    $produto = $conexao->real_escape_string($_POST["produto"]);
    $supermercado = $conexao->real_escape_string($_POST["supermercado"]);
    $marca = $conexao->real_escape_string($_POST["marca"]);
    $preco = $conexao->real_escape_string($_POST["preco"]);

    // Verificar se já existe um registro para este produto neste estabelecimento
    $queryVerificar = "SELECT * FROM preco_produtos_lojas WHERE nome_produto = '$produto' AND nome_fantasia = '$supermercado' AND marca = '$marca'";
    $resultadoVerificar = $conexao->query($queryVerificar);

    if ($resultadoVerificar->num_rows > 0) {
        // Atualizar o preço se já existir um registro para este produto neste estabelecimento
        $sql = "UPDATE preco_produtos_lojas SET preco = '$preco' WHERE nome_produto = '$produto' AND nome_fantasia = '$supermercado' AND marca = '$marca'";
    } else {
        // Inserir um novo registro se não existir um registro para este produto neste estabelecimento
        $sql = "INSERT INTO preco_produtos_lojas (nome_fantasia, nome_produto, marca, preco) VALUES ('$supermercado', '$produto', '$marca', '$preco')";
    }

    // Executar a query
    if ($conexao->query($sql) === TRUE) {
        echo "Preço do produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar preço do produto: " . $conexao->error;
    }

    // Fechar conexão
    $conexao->close();
}

// Conecte-se ao banco de dados para buscar os produtos e supermercados
$conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

// Verifique a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Query para selecionar todos os produtos
$queryProdutos = "SELECT nome_produto FROM produtos";
$resultadoProdutos = $conexao->query($queryProdutos);

// Query para selecionar todos os supermercados
$querySupermercados = "SELECT nome_fantasia FROM estabelecimentos";
$resultadoSupermercados = $conexao->query($querySupermercados);

// Fechar conexão
$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto em Supermercado</title>
    <script>
        // Função para carregar as marcas de acordo com o produto selecionado
        function carregarMarcas() {
            var produtoSelecionado = document.getElementById("produto").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var marcas = JSON.parse(xhr.responseText);
                    var marcaDropdown = document.getElementById("marca");
                    marcaDropdown.innerHTML = "";
                    for (var i = 0; i < marcas.length; i++) {
                        var option = document.createElement("option");
                        option.text = marcas[i];
                        option.value = marcas[i];
                        marcaDropdown.add(option);
                    }
                }
            };
            xhr.open("GET", "buscar_marcas.php?produto=" + produtoSelecionado, true);
            xhr.send();
        }
    </script>
</head>
<body>
    <a href="../menu.php"><button>Voltar ao Menu</button></a>
    <h2>Cadastrar Produto em Supermercado</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="produto">Produto:</label><br>
        <select id="produto" name="produto" onchange="carregarMarcas()" required>
            <option value="">Selecione o Produto</option>
            <?php
            // Loop através dos resultados e criar as opções do menu suspenso para produtos
            if ($resultadoProdutos && $resultadoProdutos->num_rows > 0) {
                while ($linhaProduto = $resultadoProdutos->fetch_assoc()) {
                    echo "<option value='" . $linhaProduto['nome_produto'] . "'>" . $linhaProduto['nome_produto'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <!-- Seleção da marca -->
        <label for="marca">Marca:</label><br>
        <select id="marca" name="marca" required>
            <option value="">Selecione a Marca</option>
        </select><br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" id="preco" name="preco" step="0.01" required><br><br>

        <label for="supermercado">Supermercado:</label><br>
        <select id="supermercado" name="supermercado" required>
            <option value="">Selecione o Supermercado</option>
            <?php
            // Loop através dos resultados e criar as opções do menu suspenso para supermercados
            if ($resultadoSupermercados && $resultadoSupermercados->num_rows > 0) {
                while ($linhaSupermercado = $resultadoSupermercados->fetch_assoc()) {
                    echo "<option value='" . $linhaSupermercado['nome_fantasia'] . "'>" . $linhaSupermercado['nome_fantasia'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Cadastrar Produto">
    </form>
</body>
</html>
