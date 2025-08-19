<?php
// Inclui o arquivo de configuração do banco
require 'config.php';

// Coleta os dados do formulário
$titulo = $_POST['titulo'];
$id_autor = $_POST['id_autor'];
$id_editora = $_POST['id_editora'];
$id_genero = $_POST['id_genero'];
// $id_idioma = $_POST['id_idioma']; // REMOVIDO
$ano_publicacao = $_POST['ano_publicacao'] ?? null;
$isbn = $_POST['isbn'] ?? null;
$paginas = $_POST['paginas'] ?? null;

// Prepara a SQL, sem o campo id_idioma
$sql = "INSERT INTO Livros (titulo, id_autor, id_editora, id_genero, ano_publicacao, isbn, paginas) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Ajuste os tipos para refletir os parâmetros: s = string, i = inteiro
// titulo (string), id_autor (int), id_editora (int), id_genero (int), ano_publicacao (int), isbn (string), paginas (int)
$stmt->bind_param("siiiisi", $titulo, $id_autor, $id_editora, $id_genero, $ano_publicacao, $isbn, $paginas);

// Executa
if ($stmt->execute()) {
    echo "Livro salvo com sucesso!<br>";
    echo "<a href='index.php'>Voltar à Lista</a>";
} else {
    echo "Erro ao salvar livro: " . $conn->error;
}

// Fecha conexão
$stmt->close();
$conn->close();
?>
