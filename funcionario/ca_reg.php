<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $fun_codigo = $_POST['fun_codigo'];
    $sql = "INSERT INTO tbl_registro (reg_data, reg_hora, fun_codigo) VALUES ('$data', '$hora', '$fun_codigo')";
    if ($conn->query($sql)) {
        echo "<p>Registro cadastrado com sucesso!</p>";
    } else {
        echo "<p>Erro ao cadastrar: " . $conn->error . "</p>";
    }
}
?>
<h2>Cadastro de Registros</h2>
<form method="POST">
    <label>Data:</label>
    <input type="date" name="data" required>
    <label>Hora:</label>
    <input type="time" name="hora" required>
    <label>Funcionário:</label>
    <select name="fun_codigo" required>
        <?php
        $result = $conn->query("SELECT fun_codigo, fun_nome FROM tbl_funcionarios");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['fun_codigo'] . "'>" . $row['fun_nome'] . "</option>";
        }
        ?>
    </select>
    <button type="submit">Cadastrar</button>
</form>
