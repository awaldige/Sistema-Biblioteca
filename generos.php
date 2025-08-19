<?php
require 'config.php';

// Inserção ou Atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $id = $_POST['id'] ?? null;

    if (!empty($nome)) {
        if ($id) {
            $sql = "UPDATE Generos SET nome = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $nome, $id);
        } else {
            $sql = "INSERT INTO Generos (nome) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nome);
        }
        $stmt->execute();
        $stmt->close();
        header("Location: generos.php");
        exit;
    }
}

// Exclusão
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM Generos WHERE id = $id");
    header("Location: generos.php");
    exit;
}

// Edição
$generoEdit = null;
if (isset($_GET['editar'])) {
    $idEditar = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM Generos WHERE id = $idEditar");
    if ($res->num_rows > 0) {
        $generoEdit = $res->fetch_assoc();
    }
}

// Listagem
$generos = $conn->query("SELECT * FROM Generos ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gêneros</title>
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

<h2><?= $generoEdit ? 'Editar Gênero' : 'Cadastro de Gêneros' ?></h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $generoEdit['id'] ?? '' ?>">
    <label>Nome do Gênero:
        <input type="text" name="nome" required value="<?= htmlspecialchars($generoEdit['nome'] ?? '') ?>">
    </label>
    <button type="submit"><?= $generoEdit ? 'Atualizar' : 'Cadastrar' ?></button>
</form>

<h3>Lista de Gêneros</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>
    <?php while ($genero = $generos->fetch_assoc()): ?>
        <tr>
            <td><?= $genero['id'] ?></td>
            <td><?= htmlspecialchars($genero['nome']) ?></td>
            <td>
                <a href="?editar=<?= $genero['id'] ?>" class="btn editar">✏️ Editar</a>
                <a href="?excluir=<?= $genero['id'] ?>" class="btn excluir" onclick="return confirm('Deseja excluir este gênero?')">🗑️ Excluir</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>

