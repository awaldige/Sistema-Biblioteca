<?php
require 'config.php';

// Excluir editora
if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    $stmtDel = $conn->prepare("DELETE FROM editoras WHERE id = ?");
    $stmtDel->bind_param("i", $idExcluir);
    $stmtDel->execute();
    $stmtDel->close();
    header("Location: editoras.php");
    exit;
}

// Buscar todas as editoras
$result = $conn->query("SELECT * FROM editoras ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editoras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f0f0f0; }
        a.btn {
            text-decoration: none;
            padding: 6px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            margin-right: 5px;
        }
        a.btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <h1>Editoras</h1>

    <p><a href="adicionar_editora.php" class="btn">➕ Nova Editora</a></p>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Site</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td>
                        <?php if (!empty($row['site'])): ?>
                            <a href="<?= htmlspecialchars($row['site']) ?>" target="_blank">
                                <?= htmlspecialchars($row['site']) ?>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar_editora.php?id=<?= $row['id'] ?>" class="btn">✏️ Editar</a>
                        <a href="editoras.php?excluir=<?= $row['id'] ?>" class="btn" onclick="return confirm('Excluir esta editora?')">🗑️ Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma editora cadastrada.</p>
    <?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>




