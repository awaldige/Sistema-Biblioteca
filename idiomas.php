<?php
require 'config.php';

// Inserção ou atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome']);

    if (!empty($nome)) {
        if ($id) {
            $stmt = $conn->prepare("UPDATE idiomas SET nome = ? WHERE id = ?");
            $stmt->bind_param("si", $nome, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO idiomas (nome) VALUES (?)");
            $stmt->bind_param("s", $nome);
        }
        $stmt->execute();
        $stmt->close();
        header("Location: idiomas.php");
        exit;
    }
}

// Exclusão
if (isset($_GET['excluir'])) {
    $idExcluir = intval($_GET['excluir']);
    $conn->query("DELETE FROM idiomas WHERE id = $idExcluir");
    header("Location: idiomas.php");
    exit;
}

// Edição
$idiomaEdit = null;
if (isset($_GET['editar'])) {
    $idEditar = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM idiomas WHERE id = $idEditar");
    if ($res->num_rows > 0) {
        $idiomaEdit = $res->fetch_assoc();
    }
}

// Listar todos os idiomas
$result = $conn->query("SELECT * FROM idiomas ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Idiomas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        h2, h3 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #e9ecef; }
        form { margin-bottom: 20px; padding: 15px; background: #fff; border: 1px solid #ddd; border-radius: 5px; max-width: 400px; }
        input[type="text"] { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { padding: 8px 14px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        button:hover { background-color: #0056b3; }
        a.btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.9em; }
        .editar { background: #ffc107; color: black; }
        .excluir { background: #dc3545; color: white; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<h2><?= $idiomaEdit ? 'Editar Idioma' : 'Cadastro de Idiomas' ?></h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $idiomaEdit['id'] ?? '' ?>">
    <label>Nome do Idioma:
        <input type="text" name="nome" required value="<?= htmlspecialchars($idiomaEdit['nome'] ?? '') ?>">
    </label>
    <button type="submit"><?= $idiomaEdit ? 'Atualizar' : 'Cadastrar' ?></button>
</form>

<h3>Lista de Idiomas</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nome']) ?></td>
        <td>
            <a href="?editar=<?= $row['id'] ?>" class="btn editar">✏️ Editar</a>
            <a href="?excluir=<?= $row['id'] ?>" class="btn excluir" onclick="return confirm('Deseja excluir este idioma?')">🗑️ Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>

