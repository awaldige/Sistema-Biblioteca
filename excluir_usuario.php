<?php
require 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do usuário não informado.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM Usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: usuarios.php");
    exit;
} else {
    echo "Erro ao excluir usuário: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
