<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $site = trim($_POST['site']);

    if (!empty($nome)) {
        $stmt = $conn->prepare("INSERT INTO editoras (nome, site) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $site);
        if ($stmt->execute()) {
            header("Location: editoras.php");
            exit;
        } else {
            echo "Erro ao adicionar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "O nome da editora é obrigatório.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Editora</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { max-width: 400px; }
        label { display: block; margin-top: 10px; }
        input[type=text] { width: 100%; padding: 6px; }
        button { margin-top: 15px; padding: 8px 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <h1>Adicionar Editora</h1>

    <form method="post" action="adicionar_editora.php">
        <label>Nome:
            <input type="text" name="nome" required>
        </label>

        <label>Site:
            <input type="text" name="site" placeholder="https://www.exemplo.com">
        </label>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="editoras.php">← Voltar para lista</a></p>
</body>
</html>

<?php $conn->close(); ?>
