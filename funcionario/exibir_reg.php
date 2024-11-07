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
