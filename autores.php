<?php
require 'config.php';

// Ação para excluir autor
if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    $stmtDel = $conn->prepare("DELETE FROM autores WHERE id = ?");
    $stmtDel->bind_param("i", $idExcluir);
    $stmtDel->execute();
    $stmtDel->close();
    header("Location: autores.php");
    exit;
}

// Inserir ou atualizar autor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome']);
    $nacionalidade = trim($_POST['nacionalidade']);

    if ($id) {
        // Atualizar
        $stmt = $conn->prepare("UPDATE autores SET nome=?, nacionalidade=? WHERE id=?");
        $stmt->bind_param("ssi", $nome, $nacionalidade, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Inserir
        $stmt = $conn->prepare("INSERT INTO autores (nome, nacionalidade) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $nacionalidade);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: autores.php");
    exit;
}

// Buscar autor para editar
$autorEdit = null;
if (isset($_GET['editar'])) {
    $idEditar = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM autores WHERE id = ?");
    $stmt->bind_param("i", $idEditar);
    $stmt->execute();
    $res = $stmt->get_result();
    $autorEdit = $res->fetch_assoc();
    $stmt->close();
}

// Listar todos autores
$result = $conn->query("SELECT * FROM autores ORDER BY nome ASC");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Autores</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px;}
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f0f0f0; }
        form { max-width: 400px; margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input[type=text] { width: 100%; padding: 6px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <h1>Autores</h1>

    <form method="post" action="autores.php">
        <input type="hidden" name="id" value="<?= $autorEdit['id'] ?? '' ?>">
        <label>Nome:
            <input type="text" name="nome" required value="<?= htmlspecialchars($autorEdit['nome'] ?? '') ?>">
        </label>
        <label>Nacionalidade:
            <input type="text" name="nacionalidade" value="<?= htmlspecialchars($autorEdit['nacionalidade'] ?? '') ?>">
        </label>
        
        <button type="submit"><?= $autorEdit ? 'Atualizar' : 'Adicionar' ?> Autor</button>
    </form>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Nacionalidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['nacionalidade']) ?></td>
                    <td>
                        <a href="autores.php?editar=<?= $row['id'] ?>">Editar</a> |
                        <a href="autores.php?excluir=<?= $row['id'] ?>" onclick="return confirm('Confirma exclusão do autor?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum autor cadastrado.</p>
    <?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
