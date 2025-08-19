<?php
require 'config.php';

$id_exemplar = intval($_GET['id_exemplar']);

// Se for POST, processa reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario']);

    // Verifica se já existe reserva ativa
    $stmt = $conn->prepare("SELECT id FROM reservas WHERE id_exemplar = ? AND id_usuario = ? AND status = 'ativa'");
    $stmt->bind_param("ii", $id_exemplar, $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO reservas (id_usuario, id_exemplar) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_usuario, $id_exemplar);
        $stmt->execute();
        echo "<p>✅ Reserva realizada com sucesso.</p>";
    } else {
        echo "<p>⚠️ Usuário já possui uma reserva ativa para este exemplar.</p>";
    }

    $stmt->close();
    $conn->close();
    echo '<p><a href="emprestimos.php">⬅ Voltar</a></p>';
    exit;
}

// Seleciona usuários para o formulário
$usuarios = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome");
?>

<h1>Reservar Exemplar</h1>
<form method="post">
    <label>Usuário:
        <select name="id_usuario" required>
            <option value="">-- Selecione --</option>
            <?php while ($u = $usuarios->fetch_assoc()): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
            <?php endwhile; ?>
        </select>
    </label><br><br>

    <button type="submit">Confirmar Reserva</button>
</form>

