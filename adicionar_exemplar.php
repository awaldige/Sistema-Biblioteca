<?php
require 'config.php';

// Buscar livros e idiomas
$livros = $conn->query("SELECT id, titulo FROM livros ORDER BY titulo");
$idiomas = $conn->query("SELECT id, nome FROM idiomas ORDER BY nome");

// Inserção de exemplar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livro = intval($_POST['id_livro']);
    $codigo_exemplar = trim($_POST['codigo_exemplar']);
    $id_idioma = intval($_POST['id_idioma']);

    if ($id_livro > 0 && !empty($codigo_exemplar) && $id_idioma > 0) {
        $stmt = $conn->prepare("INSERT INTO exemplares (id_livro, codigo_exemplar, id_idioma) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $id_livro, $codigo_exemplar, $id_idioma);
        $stmt->execute();
        $stmt->close();
        header("Location: listar_exemplares.php");
        exit;
    } else {
        $erro = "Todos os campos são obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Exemplar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f7f7f7; }
        form { background: white; padding: 20px; border-radius: 8px; max-width: 500px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; }
        select, input[type=text] { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
        .erro { color: red; margin-top: 10px; }
        .menu {
            background-color: #007bff; padding: 12px; margin-bottom: 20px; border-radius: 8px;
        }
        .menu a {
            color: white; margin-right: 15px; text-decoration: none; font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<h1>Adicionar Novo Exemplar</h1>

<?php if (isset($erro)): ?>
    <p class="erro"><?= $erro ?></p>
<?php endif; ?>

<form method="post">
    <label>Livro:
        <select name="id_livro" required>
            <option value="">-- Selecione --</option>
            <?php while ($l = $livros->fetch_assoc()): ?>
                <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['titulo']) ?></option>
            <?php endwhile; ?>
        </select>
    </label>

    <label>Código do Exemplar:
        <input type="text" name="codigo_exemplar" required>
    </label>

    <label>Idioma:
        <select name="id_idioma" required>
            <option value="">-- Selecione --</option>
            <?php while ($idioma = $idiomas->fetch_assoc()): ?>
                <option value="<?= $idioma['id'] ?>"><?= htmlspecialchars($idioma['nome']) ?></option>
            <?php endwhile; ?>
        </select>
    </label>

    <button type="submit">Salvar Exemplar</button>
</form>

</body>
</html>

<?php $conn->close(); ?>

