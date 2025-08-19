<?php
require 'config.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'] ?? null;

$sql = "INSERT INTO Usuarios (nome, email, telefone) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $telefone);

if ($stmt->execute()) {
    echo "Usuário salvo com sucesso!<br>";
    echo "<a href='usuarios.php'>Voltar à lista</a>";
} else {
    echo "Erro ao salvar usuário: " . $conn->error;
}

$stmt->close();
$conn->close();
?>



