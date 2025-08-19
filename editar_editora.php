<?php
require 'config.php';

// Atualizar a editora (quando o formulário é enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome']);
    $site = trim($_POST['site']);

    if ($id) {
        $stmt = $conn->prepare("UPDATE editoras SET nome = ?, site = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $site, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: editoras.php");
        exit;
    } else {
        echo "⚠️ ID da editora não informado.";
        exit;
    }
}

// Buscar os dados da editora para edição (GET)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM editoras WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $editora = $res->fetch_assoc();
    $stmt->close();

    if (!$editora) {
        echo "⚠️ Editora não encontrada.";
        exit;
    }
} else {
    echo "⚠️ ID da editora não informado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Editora</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 400px; }
        label { display: block; margin-top: 10px; }
        input[type="text"] { width: 100%; padding: 6px; box-sizing: border-box; }
        button {
            margin-top: 15px;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background-color: #0056b3; }
        a { display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Editar Editora</h1>

    <form method="post" action="editar_editora.php">
        <input type="hidden" name="id" value="<?= $editora['id'] ?>">
        
        <label>Nome da Editora:
            <input type="text" name="nome" required value="<?= htmlspecialchars($editora['nome']) ?>">
        </label>

        <label>Site:
            <input type="text" name="site" value="<?= htmlspecialchars($editora['site'] ?? '') ?>">
        </label>

        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="editoras.php">⬅️ Voltar para lista de editoras</a>
</body>
</html>



