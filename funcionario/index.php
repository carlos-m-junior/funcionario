<?php
include "conexao.php";

// Determina qual página carregar
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    Sistema de Gerenciamento
</header>
<nav>
    <form method="get" style="display: inline;">
        <input type="hidden" name="page" value="home">
        <button type="submit">Início</button>
    </form>
    <form method="get" style="display: inline;">
        <input type="hidden" name="page" value="cadastro_funcionarios">
        <button type="submit">Cadastrar Funcionários</button>
    </form>
    <form method="get" style="display: inline;">
        <input type="hidden" name="page" value="cadastro_registros">
        <button type="submit">Cadastrar Registros</button>
    </form>
    <form method="get" style="display: inline;">
        <input type="hidden" name="page" value="exibir_registros">
        <button type="submit">Exibir Registros</button>
    </form>
</nav>
<div class="container">
    <?php
    // Edição de Registro
    if ($page == 'editar_registro' && isset($_GET['id'])) {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['data'];
            $hora = $_POST['hora'];
            $fun_codigo = $_POST['fun_codigo'];
            $sql = "UPDATE tbl_registro SET reg_data='$data', reg_hora='$hora', fun_codigo='$fun_codigo' WHERE reg_codigo=$id";
            if ($conn->query($sql)) {
                echo "<p>Registro atualizado com sucesso!</p>";
                echo "<a href='?page=exibir_registros'><button>Voltar</button></a>";
            } else {
                echo "<p>Erro ao atualizar: " . $conn->error . "</p>";
            }
        } else {
            $result = $conn->query("SELECT * FROM tbl_registro WHERE reg_codigo=$id");
            $row = $result->fetch_assoc();
            ?>
            <h2>Editar Registro</h2>
            <form method="POST">
                <label>Data:</label>
                <input type="date" name="data" value="<?php echo $row['reg_data']; ?>" required>
                <label>Hora:</label>
                <input type="time" name="hora" value="<?php echo $row['reg_hora']; ?>" required>
                <label>Funcionário:</label>
                <select name="fun_codigo" required>
                    <?php
                    $funcionarios = $conn->query("SELECT fun_codigo, fun_nome FROM tbl_funcionarios");
                    while ($func = $funcionarios->fetch_assoc()) {
                        $selected = $func['fun_codigo'] == $row['fun_codigo'] ? 'selected' : '';
                        echo "<option value='" . $func['fun_codigo'] . "' $selected>" . $func['fun_nome'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Salvar Alterações</button>
            </form>
            <?php
        }
    } elseif ($page == 'excluir_registro' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM tbl_registro WHERE reg_codigo=$id";
        if ($conn->query($sql)) {
            echo "<p>Registro excluído com sucesso!</p>";
        } else {
            echo "<p>Erro ao excluir: " . $conn->error . "</p>";
        }
        echo "<a href='?page=exibir_registros'><button>Voltar</button></a>";
    } elseif ($page == 'exibir_registros') {
        ?>
        <h2>Registros</h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Funcionário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT reg_codigo, reg_data, reg_hora, fun_nome 
                        FROM tbl_registro 
                        JOIN tbl_funcionarios ON tbl_registro.fun_codigo = tbl_funcionarios.fun_codigo";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['reg_codigo']}</td>
                            <td>{$row['reg_data']}</td>
                            <td>{$row['reg_hora']}</td>
                            <td>{$row['fun_nome']}</td>
                            <td>
                                <a href='?page=editar_registro&id={$row['reg_codigo']}'><button>Editar</button></a>
                                <a href='?page=excluir_registro&id={$row['reg_codigo']}'><button>Excluir</button></a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "<h2>Bem-vindo ao Sistema</h2><p>Escolha uma opção no menu acima.</p>";
    }
    ?>
</div>
</body>
</html>
