<?php
require 'config.php';

if (!isset($_GET['id'])) {
    echo "ID do exemplar não informado.";
    exit;
}

$id = intval($_GET['id']);

// Buscar exemplar com informações do livro e idioma
$stmt = $conn->prepare("
    SELECT e.id, e.codigo_exemplar, e.id_livro, e.id_idioma, l.titulo 
    FROM exemplares e
    JOIN livros l ON e.id_livro = l.id
    WHERE e.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$exemplar = $res->fetch_assoc();
$stmt->close();

if (!$exemplar) {
    echo "Exemplar não encontrado.";
    exit;
}

// Atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo_exemplar']);
    $id_livro = intval($_POST['id_livro']);
    $id_idioma = intval($_POST['id_idioma']);

    $stmt = $conn->prepare("UPDATE exemplares SET codigo_exemplar = ?, id_livro = ?, id_idioma = ? WHERE id = ?");
    $stmt->bind_param("siii", $codigo, $id_livro, $id_idioma, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: listar_exemplares.php");
    exit;
}

// Carregar livros
$livros = $conn->query("SELECT id, titulo FROM livros ORDER BY titulo");

// Carregar idiomas
$idiomas = $conn->query("SELECT id, nome FROM idiomas ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Exemplar</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 500px; background: #f2f2f2; padding: 20px; border-radius: 8px; box-shadow: 0 0 8px #ccc; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px; background-color: #28a745; border: none; color: white; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>
<h1>Editar Exemplar</h1>

<form method="post">
    <label>Código do Exemplar:
        <input type="text" name="codigo_exemplar" value="<?= htmlspecialchars($exemplar['codigo_exemplar']) ?>" required>
    </label>

    <label>Livro:
        <select name="id_livro" required>
            <option value="">-- Selecione --</option>
            <?php while ($livro = $livros->fetch_assoc()): ?>
                <option value="<?= $livro['id'] ?>" <?= $livro['id'] == $exemplar['id_livro'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($livro['titulo']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </label>

    <label>Idioma:
        <select name="id_idioma" required>
            <option value="">-- Selecione --</option>
            <?php while ($idioma = $idiomas->fetch_assoc()): ?>
                <option value="<?= $idioma['id'] ?>" <?= $idioma['id'] == $exemplar['id_idioma'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($idioma['nome']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </label>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>

<?php $conn->close(); ?>


