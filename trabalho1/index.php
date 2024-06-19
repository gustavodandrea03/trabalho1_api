<?php
require_once "conexao.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['login'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['inputNome'];
        $id = $_POST['inputId'];

        if (!empty($nome) && !empty($id)) {
            $query = "SELECT * FROM clientes WHERE nome = ? AND id = ?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("si", $nome, $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['nome'] = $nome;
                $_SESSION['id'] = $id;
                echo "Login realizado com sucesso! Redirecionando...";
                header("Location: pgClient.php?n=" . urlencode($nome) . "&id=" . urlencode($id));
                exit();
            } else {
                echo "Nome ou ID incorretos.";
            }
        } else {
            echo "Preencha todos os campos.";
        }
    }
    if (isset($_SESSION['nome']) && $_SESSION['nome'] == 'admin') {
        header("Location: admin.php");
        exit();
    }

    if (isset($_SESSION['nome']) && $_SESSION['nome'] != 'admin') {
        header("Location: clientes.php");
        exit();
    }

    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Loja</title>
    <meta charset="utf-8"/>
    <meta name="author" content="Gustavo Gonçalves Dandrea"/>
    <meta name="keywords" content="loja, produtos, clientes"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/x-icon" href="Imagens/">

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
            margin: 0;
        }

        .menu ul {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 20px;
        }

        .menu ul li {
            display: inline-block;
            margin-right: 20px;
        }

        .menu ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .topo {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .clients {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .clients p {
            margin: 0;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
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

        a {
            text-decoration: none;
            color: #333;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<nav class="menu">
    <ul>
        <li><a href="admin.php">Página Administradora</a></li>
        <li><a href="clientes.php">Faça seu pedido aqui!</a></li>
    </ul>
</nav>

<div class="topo">
    <h1>Loja Online</h1>
    <p>Página Principal</p>
    <p>Seja bem vindo!</p>
</div>

<h2>Clientes</h2>

<?php
$clientes = selectDados($connect, "clientes");

foreach ($clientes as $c) {
?>
<div class="clients">
    <hr>
    <p><?php echo 'Cliente ',$c['id'],' = Nome: ',$c['nome'], ', Altura: ',$c['altura'],', Cidade: ',$c['cidade_id']; ?></p>
</div>
<?php
}
?>

<h2>Cadastrar</h2>

<form name="cadastro" method="POST" action="conexao.php?cadastrar">
    <label for="inputNome">Nome:</label>
    <input type="text" name="inputNome"><br><br>

    <label for="inputAlt">Altura (cm):</label>
    <input type="number" name="inputAlt" min="0" max="250"><br><br>

    <label for="inputNasc">Data de nascimento:</label>
    <input type="date" name="inputNasc"><br><br>

    <label for="inputCid">Cidade:</label>
    <select name="inputCid">
        <?php
        $cidades = selectDados($connect, "cidades");

        foreach ($cidades as $cid) {
        ?>
        <option value="<?php echo $cid['id'] ?>"><?php echo $cid['nome'],'(', $cid['id'],')' ?></option>
        <?php
        }
        ?>
    </select>
    <input type="submit" name="cadastro" value="Enviar">
</form>

<h2>Login</h2>
<form name="login" method="POST" action="conexao.php?login">
    <label for="inputNome">Nome:</label>
    <input type="text" name="inputNome"><br><br>

    <label for="inputNome">Id:</label>
    <input type="text" name="inputId"><br><br>

    <input type="submit" name="logon" value="Entrar">
</form>

<a href="logout.php">Sair</a>

</body>
</html>
