<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Adicionar Usuário</title>
</head>
<body>
  <h1>Adicionar Novo Usuário</h1>
  <form action="salvar_usuario.php" method="post">
    <label>Nome:<br>
      <input type="text" name="nome" required>
    </label><br><br>

    <label>Email:<br>
      <input type="email" name="email" required>
    </label><br><br>

    <label>Telefone:<br>
      <input type="text" name="telefone">
    </label><br><br>

    <button type="submit">Salvar</button>
  </form>
  <p><a href="usuarios.php">Voltar à lista</a></p>
</body>
</html>


