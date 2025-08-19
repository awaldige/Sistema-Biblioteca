<?php
require 'config.php';

$result = $conn->query("SHOW TABLES LIKE 'emprestimos'");
if ($result->num_rows > 0) {
    echo "Tabela 'emprestimos' existe!";
} else {
    echo "Tabela 'emprestimos' NÃO encontrada.";
}
?>





