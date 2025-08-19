<?php
require 'config.php';

// Excluir exemplar, se solicitado
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM exemplares WHERE id = $id");
    header("Location: listar_exemplares.php");
    exit;
}

// Buscar todos os exemplares com título do livro e idioma (idioma está em exemplares)
$sql = "
    SELECT 
        e.id, 
        e.codigo_exemplar, 
        l.titulo, 
        i.nome AS idioma
    FROM exemplares e
    JOIN livros l ON e.id_livro = l.id
    LEFT JOIN idiomas i ON e.id_idioma = i.id
    ORDER BY l.titulo
";
$exemplares = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Exemplares</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f0f0f0; }
        a.button {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
        }
        a.editar { background-color: #ffc107; color: black; }
        a.excluir { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<h1>Exemplares Cadastrados</h1>

<p><a href="adicionar_exemplar.php" class="button">➕ Adicionar Novo Exemplar</a></p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Livro</th>
            <th>Idioma</th>
            <th>Código do Exemplar</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($exemplares && $exemplares->num_rows > 0): ?>
            <?php while ($row = $exemplares->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['idioma'] ?? 'Não informado') ?></td>
                    <td><?= htmlspecialchars($row['codigo_exemplar']) ?></td>
                    <td>
                        <a href="editar_exemplar.php?id=<?= $row['id'] ?>" class="button editar">✏️ Editar</a>
                        <a href="listar_exemplares.php?excluir=<?= $row['id'] ?>" class="button excluir" onclick="return confirm('Deseja excluir este exemplar?')">🗑️ Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">Nenhum exemplar cadastrado.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>



