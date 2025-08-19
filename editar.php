<?php
require 'config.php';

// Verifica se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do livro não informado.");
}

$id = intval($_GET['id']);

// Busca o livro atual
$sql = "SELECT * FROM Livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Livro não encontrado.");
}

$livro = $result->fetch_assoc();

// Busca dados para os selects
$autores = $conn->query("SELECT id, nome FROM Autores");
$editoras = $conn->query("SELECT id, nome FROM Editoras");
$generos = $conn->query("SELECT id, nome FROM Generos");
$idiomas = $conn->query("SELECT id, nome FROM Idiomas");

// Processa atualização se enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $id_autor = $_POST['id_autor'];
    $id_editora = $_POST['id_editora'];
    $id_genero = $_POST['id_genero'];
    $id_idioma = $_POST['id_idioma'];
    $ano_publicacao = $_POST['ano_publicacao'] ?: null;
    $isbn = $_POST['isbn'] ?: null;
    $paginas = $_POST['paginas'] ?: null;

    $sql = "UPDATE Livros SET titulo=?, id_autor=?, id_editora=?, id_genero=?, id_idioma=?, ano_publicacao=?, isbn=?, paginas=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiiiisi", $titulo, $id_autor, $id_editora, $id_genero, $id_idioma, $ano_publicacao, $isbn, $paginas, $id);

    if ($stmt->execute()) {
        echo "Livro atualizado com sucesso!<br>";
        echo "<a href='index.php'>Voltar à lista</a>";
        exit;
    } else {
        echo "Erro ao atualizar livro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <h2>Editar Livro</h2>
    <form method="post">
        <label>Título:<br>
            <input type="text" name="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>" required>
        </label><br><br>

        <label>Autor:<br>
            <select name="id_autor" required>
                <option value="">Selecione</option>
                <?php while($autor = $autores->fetch_assoc()): ?>
                    <option value="<?= $autor['id'] ?>" <?= $autor['id'] == $livro['id_autor'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($autor['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Editora:<br>
            <select name="id_editora" required>
                <option value="">Selecione</option>
                <?php while($editora = $editoras->fetch_assoc()): ?>
                    <option value="<?= $editora['id'] ?>" <?= $editora['id'] == $livro['id_editora'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($editora['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Gênero:<br>
            <select name="id_genero" required>
                <option value="">Selecione</option>
                <?php while($genero = $generos->fetch_assoc()): ?>
                    <option value="<?= $genero['id'] ?>" <?= $genero['id'] == $livro['id_genero'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genero['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Idioma:<br>
            <select name="id_idioma" required>
                <option value="">Selecione</option>
                <?php while($idioma = $idiomas->fetch_assoc()): ?>
                    <option value="<?= $idioma['id'] ?>" <?= $idioma['id'] == $livro['id_idioma'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($idioma['nome']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Ano de Publicação:<br>
            <input type="number" name="ano_publicacao" value="<?= $livro['ano_publicacao'] ?>">
        </label><br><br>

        <label>ISBN:<br>
            <input type="text" name="isbn" value="<?= htmlspecialchars($livro['isbn']) ?>">
        </label><br><br>

        <label>Páginas:<br>
            <input type="number" name="paginas" value="<?= $livro['paginas'] ?>">
        </label><br><br>

        <button type="submit">Atualizar Livro</button>
    </form>

    <p><a href="index.php">Voltar à lista</a></p>
</body>
</html>

