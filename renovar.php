<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Atualiza a data_emprestimo para hoje e incrementa renovacoes
    $stmt = $conn->prepare("UPDATE emprestimos SET data_emprestimo = CURDATE(), renovacoes = renovacoes + 1 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: emprestimos.php');
exit;
?>



