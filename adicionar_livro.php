<?php
require 'config.php';

// Buscar dados para selects
$autores = $conn->query("SELECT id, nome FROM autores ORDER BY nome");
$editoras = $conn->query("SELECT id, nome FROM editoras ORDER BY nome");
$generos = $conn->query("SELECT id, nome FROM generos ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Adicionar Livro</title>
</head>
<body>
    <h1>Adicionar Livro</h1>

    <form method="post" action="salvar.php">
        <label>Título:
            <input type="text" name="titulo" required>
        </label><br><br>

        <label>Autor:
            <select name="id_autor" required>
                <option value="">-- Selecione --</option>
                <?php while($a = $autores->fetch_assoc()): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Editora:
            <select name="id_editora" required>
                <option value="">-- Selecione --</option>
                <?php while($e = $editoras->fetch_assoc()): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Gênero:
            <select name="id_genero" required>
                <option value="">-- Selecione --</option>
                <?php while($g = $generos->fetch_assoc()): ?>
                    <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </label><br><br>

        <label>Ano de Publicação:
            <input type="number" name="ano_publicacao" min="1000" max="2099" required>
        </label><br><br>

        <label>ISBN:
            <input type="text" name="isbn">
        </label><br><br>

        <label>Páginas:
            <input type="number" name="paginas" min="1">
        </label><br><br>

        <button type="submit">Cadastrar Livro</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>

