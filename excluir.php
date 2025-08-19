<?php
require 'config.php';

if (!isset($_GET['tipo'], $_GET['id'])) {
    die("Parâmetros inválidos.");
}

$tipo = $_GET['tipo'];
$id = intval($_GET['id']);

$validos = ['livros' => 'Livros', 'autores' => 'Autores', 'editoras' => 'Editoras', 'generos' => 'Generos', 'idiomas' => 'Idiomas'];

if (!array_key_exists($tipo, $validos)) {
    die("Tipo inválido.");
}

$tabela = $validos[$tipo];

// Prepare para evitar SQL injection (tabela não pode ser parametrizada em prepared statements, por isso controle via whitelist)
$sql = "DELETE FROM $tabela WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo ucfirst($tipo) . " excluído com sucesso.<br>";
    echo "<a href='{$tipo}.php'>Voltar</a>";
} else {
    echo "Erro ao excluir: " . $conn->error;
}

$stmt->close();
$conn->close();
?>



