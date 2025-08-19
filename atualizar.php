<?php
require 'config.php';

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$id_autor = $_POST['id_autor'];
$id_editora = $_POST['id_editora'];
$id_genero = $_POST['id_genero'];
$id_idioma = $_POST['id_idioma'];
$ano_publicacao = $_POST['ano_publicacao'] ?? null;
$isbn = $_POST['isbn'] ?? null;
$paginas = $_POST['paginas'] ?? null;

// Prepara a SQL para update
$sql = "UPDATE Livros SET titulo=?, id_autor=?, id_editora=?, id_genero=?, id_idioma=?, ano_publicacao=?, isbn=?, paginas=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiiiisii", $titulo, $id_autor, $id_editora, $id_genero, $id_idioma, $ano_publicacao, $isbn, $paginas, $id);

if ($stmt->execute()) {
    echo "Livro atualizado com sucesso!<br>";
    echo "<a href='index.php'>Voltar à Lista</a>";
} else {
    echo "Erro ao atualizar livro: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
