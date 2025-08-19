<?php
require 'config.php';

$sql = "SELECT * FROM Usuarios ORDER BY nome";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Lista de Usuários</title>
  <style>
    table { border-collapse: collapse; width: 80%; margin: 20px auto; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f0f0f0; }
    a.button {
      background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px;
    }
    a.button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <?php include 'menu.php'; ?>
  <h1 style="text-align:center;">Usuários Cadastrados</h1>
  <p style="text-align:center;"><a href="adicionar_usuario.php" class="button">➕ Novo Usuário</a></p>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['telefone']) ?></td>
            <td>
              <a href="editar_usuario.php?id=<?= $row['id'] ?>" class="button" style="background:#28a745;">Editar</a>
              <a href="excluir_usuario.php?id=<?= $row['id'] ?>" class="button" style="background:#dc3545;" onclick="return confirm('Confirma exclusão do usuário?')">Excluir</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5" style="text-align:center;">Nenhum usuário encontrado.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>

<?php $conn->close(); ?>

