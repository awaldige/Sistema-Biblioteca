<?php
require 'config.php';

// Busca opções
$autores = $conn->query("SELECT id, nome FROM Autores");
$editoras = $conn->query("SELECT id, nome FROM Editoras");
$generos = $conn->query("SELECT id, nome FROM Generos");
$idiomas = $conn->query("SELECT id, nome FROM Idiomas");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Livro</title>
</head>
<body> 
    <?php include 'menu.php'; ?>
    <h2>Adicionar Livro</h2>

    <form method="post" action="salvar.php">
        <label>Título:<br>
            <input type="text" name="titulo" required>
        </label><br><br>

        <label>Autor:<br>
            <select name="id_autor" required>
                <option value="">Selecione</option>
                <?php while($autor = $autores->fetch_assoc()): ?>
                    <option value="<?= $autor['id'] ?>"><?= htmlspecialchars($autor['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Editora:<br>
            <select name="id_editora" required>
                <option value="">Selecione</option>
                <?php while($editora = $editoras->fetch_assoc()): ?>
                    <option value="<?= $editora['id'] ?>"><?= htmlspecialchars($editora['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Gênero:<br>
            <select name="id_genero" required>
                <option value="">Selecione</option>
                <?php while($genero = $generos->fetch_assoc()): ?>
                    <option value="<?= $genero['id'] ?>"><?= htmlspecialchars($genero['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        

        <label>Ano de Publicação:<br>
            <input type="number" name="ano_publicacao">
        </label><br><br>

        <label>ISBN:<br>
            <input type="text" name="isbn">
        </label><br><br>

        <label>Páginas:<br>
            <input type="number" name="paginas">
        </label><br><br>

        <button type="submit">Salvar Livro</button>
    </form>
</body>
</html>

