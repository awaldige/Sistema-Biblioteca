<?php
require 'config.php';

if (!isset($_GET['id'])) {
    echo "ID do empréstimo não informado.";
    exit;
}

$id_emprestimo = intval($_GET['id']);

// Verificar se o empréstimo existe
$sql = "SELECT * FROM emprestimos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_emprestimo);
$stmt->execute();
$result = $stmt->get_result();
$emprestimo = $result->fetch_assoc();
$stmt->close();

if (!$emprestimo) {
    echo "Empréstimo não encontrado.";
    exit;
}

$id_exemplar = $emprestimo['id_exemplar'];

// Atualizar o empréstimo: definir data_devolucao e status como 'devolvido'
$sql = "UPDATE emprestimos SET data_devolucao = CURDATE(), status = 'devolvido' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_emprestimo);
$stmt->execute();
$stmt->close();

// Atualizar status da reserva (se houver uma ativa) para 'concluída'
$sql = "UPDATE reservas SET status = 'concluída' 
        WHERE id_exemplar = ? AND status = 'ativa' 
        ORDER BY data_reserva ASC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_exemplar);
$stmt->execute();
$stmt->close();

// Redireciona de volta à lista de empréstimos
header("Location: emprestimos.php");
exit;
?>
