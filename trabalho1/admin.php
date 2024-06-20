<?php
require_once "conexao.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['nome']) || $_SESSION['nome'] != 'admin') {
    header("Location: index.php");
    exit();
}

$nome = isset($_GET['n']) ? $_GET['n'] : '';

voltar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Administração</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1, h2 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #aaa;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td.action {
            text-align: center;
        }

        td.action a {
            color: #aaa;
            text-decoration: none;
        }

        td.action a:hover {
            text-decoration: underline;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Página de Administração</h1>
        <p>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</p>
        <a href="logout.php">Sair</a>

        <h2>Produtos</h2>
        <table id="produtosTabela">
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Categoria</th>
            </tr>
        </table>

        <h2>Adicionar novo Produto</h2>
        <form name="cadastrarProduto" method="POST" action="conexao.php?cadProd">
            <label for="inputNome">Nome:</label>
            <input type="text" name="inputNome"><br><br>

            <label for="inputPreco">Preço:</label>
            <input type="number" name="inputPreco"><br><br>

            <label for="inputQuant">Quantidade:</label>
            <input type="number" name="inputQuant"><br><br>

            <label for="inputCat">Categoria:</label>
            <select name="inputCat">
                <?php
                $categorias = selectDados($connect, "categorias");

                foreach ($categorias as $cat) {
                ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nome'], ' (', $cat['id'], ')'; ?></option>
                <?php
                }
                ?>
            </select>
            <input type="submit" name="cadastroProd" value="Enviar">
        </form>

        <h2>Remover Produto</h2>
        <form name="removerProduto" method="POST" action="conexao.php?remProd">
            <select name="inputProd">
                <?php
                $produtos = selectDados($connect, "produtos");

                foreach ($produtos as $p) {
                ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo $p['nome'], ' (', $p['id'], ')'; ?></option>
                <?php
                }
                ?>
            </select>
            <input type="submit" name="removeProd" value="Remover" style="background: red; border: 2px solid black;">
        </form>

        <h2>Atualizar Produto</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th></th>
            </tr>
            <?php
            $produtos = selectDados($connect, 'produtos');

            foreach ($produtos as $produto) {
                $categoria = selectDados($connect, 'categorias', "id={$produto['categoria_id']}");

                if (!empty($categoria)) {
                    $catNome = $categoria[0]['nome'];
                    $catID = $categoria[0]['id'];
                } else {
                    $catNome = 'Categoria não encontrada';
                    $catID = '';
                }
            ?>
                <form name="atualizarProduto" method="POST" action="conexao.php?atProd">
                    <tr>
                        <td><input type="number" name="inputId" style="width: 50px;" value="<?php echo $produto['id']; ?>"></td>
                        <td><input type="text" name="inputNome" style="width: 150px;" value="<?php echo $produto['nome']; ?>"></td>
                        <td><input type="number" name="inputPreco" value="<?php echo $produto['preco']; ?>"> R$</td>
                        <td><input type="number" name="inputQuant" style="width: 100px;" value="<?php echo $produto['quantidade']; ?>"></td>
                        <td><?php echo $catNome, ' (', $catID, ')'; ?></td>
                        <td><input type="submit" name="atlProd" value="Atualizar"></td>
                    </tr>
                </form>
            <?php
            }
            ?>
        </table>

        <h2>Adicionar nova categoria</h2>
        <form name="cadastrarCategoria" method="POST" action="conexao.php?cadCat">
            <label for="inputNome">Nome:</label>
            <input type="text" name="inputNome"><br><br>
            <input type="submit" name="cadastroCat" value="Enviar">
        </form>
    </div>

    <script src="produtos.js"></script>
</body>
</html>
