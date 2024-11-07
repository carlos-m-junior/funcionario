<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $sql = "INSERT INTO tbl_funcionarios (fun_nome, fun_cargo) VALUES ('$nome', '$cargo')";
    if ($conn->query($sql)) {
        echo "<p>Funcionário cadastrado com sucesso!</p>";
    } else {
        echo "<p>Erro ao cadastrar: " . $conn->error . "</p>";
    }
}
?>
<h2>Cadastro de Funcionários</h2>
<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <label>Cargo:</label>
    <input type="text" name="cargo" required>
    <button type="submit">Cadastrar</button>
</form>
