<?php
require 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do usuário não informado.");
}

$id = intval($_GET['id']);

// Atualiza os dados se formulário enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'] ?? null;

    $sql = "UPDATE Usuarios SET nome=?, email=?, telefone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $telefone, $id);

    if ($stmt->execute()) {
        echo "Usuário atualizado com sucesso!<br>";
        echo "<a href='usuarios.php'>Voltar à lista</a>";
        exit;
    } else {
        echo "Erro ao atualizar usuário: " . $conn->error;
    }
}

// Busca dados atuais para preencher formulário
$sql = "SELECT * FROM Usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuário não encontrado.");
}

$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Editar Usuário</title>
</head>
<body>
    <?php include 'menu.php'; ?>
  <h1>Editar Usuário</h1>
  <form method="post" action="">
    <label>Nome:<br>
      <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
    </label><br><br>

    <label>Email:<br>
      <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
    </label><br><br>

    <label>Telefone:<br>
      <input type="text" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>">
    </label><br><br>

    <button type="submit">Atualizar</button>
  </form>
  <p><a href="usuarios.php">Voltar à lista</a></p>
</body>
</html>



