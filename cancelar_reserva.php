<?php
require 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>ID inválido para cancelamento de reserva.</p>";
    echo "<p><a href='reservas.php'>⬅ Voltar</a></p>";
    exit;
}

$id = intval($_GET['id']);

// Verifica se a reserva está ativa
$stmt = $conn->prepare("SELECT status FROM reservas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p>Reserva não encontrada.</p>";
    echo "<p><a href='reservas.php'>⬅ Voltar</a></p>";
    exit;
}

$row = $res->fetch_assoc();

if ($row['status'] !== 'ativa') {
    echo "<p>⚠️ Esta reserva já foi concluída ou cancelada.</p>";
    echo "<p><a href='reservas.php'>⬅ Voltar</a></p>";
    exit;
}

$stmt->close();

// Cancelar a reserva
$stmt = $conn->prepare("UPDATE reservas SET status = 'cancelada' WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: reservas.php");
exit;
?>

