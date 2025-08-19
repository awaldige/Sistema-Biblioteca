<?php
require 'config.php';

$id_reserva = isset($_GET['reserva']) ? intval($_GET['reserva']) : null;

// Caso o empréstimo esteja vindo de uma reserva
if ($id_reserva) {
    $stmt = $conn->prepare("
        SELECT r.id_usuario, r.id_exemplar, u.nome, l.titulo, e.codigo_exemplar
        FROM reservas r
        JOIN usuarios u ON r.id_usuario = u.id
        JOIN exemplares e ON r.id_exemplar = e.id
        JOIN livros l ON e.id_livro = l.id
        WHERE r.id = ? AND r.status = 'ativa'
    ");
    $stmt->bind_param("i", $id_reserva);
    $stmt->execute();
    $res = $stmt->get_result();
    $reserva = $res->fetch_assoc();
    $stmt->close();

    if (!$reserva) {
        echo "<p>Reserva inválida ou já concluída.</p>";
        echo "<p><a href='reservas.php'>⬅ Voltar</a></p>";
        exit;
    }

    // Inserir empréstimo direto
    $stmt = $conn->prepare("INSERT INTO emprestimos (id_usuario, id_exemplar) VALUES (?, ?)");
    $stmt->bind_param("ii", $reserva['id_usuario'], $reserva['id_exemplar']);
    $stmt->execute();
    $stmt->close();

    // Marcar reserva como concluída
    $stmt = $conn->prepare("UPDATE reservas SET status = 'concluída' WHERE id = ?");
    $stmt->bind_param("i", $id_reserva);
    $stmt->execute();
    $stmt->close();

    header("Location: emprestimos.php");
    exit;
}

// Modo normal: empréstimo sem reserva
$usuarios = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome");

$exemplares = $conn->query("
    SELECT e.id, l.titulo, e.codigo_exemplar
    FROM exemplares e
    JOIN livros l ON e.id_livro = l.id
    WHERE e.id NOT IN (
        SELECT id_exemplar FROM emprestimos WHERE status = 'ativo'
    )
    AND e.id NOT IN (
        SELECT id_exemplar FROM reservas WHERE status = 'ativa'
    )
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario']);
    $id_exemplar = intval($_POST['id_exemplar']);

    if ($id_usuario > 0 && $id_exemplar > 0) {
        $stmt = $conn->prepare("INSERT INTO emprestimos (id_usuario, id_exemplar) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_usuario, $id_exemplar);
        $stmt->execute();
        $stmt->close();

        header("Location: emprestimos.php");
        exit;
    } else {
        echo "<p style='color:red;'>Selecione um usuário e um exemplar válidos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar Empréstimo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { max-width: 400px; background: #f9f9f9; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 15px; }
        select, button { width: 100%; padding: 8px; margin-top: 8px; }
        button { background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<h1>Registrar Novo Empréstimo</h1>

<form method="post">
    <label>Usuário:</label>
    <select name="id_usuario" required>
        <option value="">-- Selecione o usuário --</option>
        <?php while ($u = $usuarios->fetch_assoc()): ?>
            <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
        <?php endwhile; ?>
    </select>

    <label>Livro / Exemplar:</label>
    <select name="id_exemplar" required>
        <option value="">-- Selecione o exemplar --</option>
        <?php if ($exemplares && $exemplares->num_rows > 0): ?>
            <?php while ($e = $exemplares->fetch_assoc()): ?>
                <option value="<?= $e['id'] ?>">
                    <?= htmlspecialchars($e['titulo']) ?> (<?= htmlspecialchars($e['codigo_exemplar']) ?>)
                </option>
            <?php endwhile; ?>
        <?php else: ?>
            <option disabled>Nenhum exemplar disponível para empréstimo.</option>
        <?php endif; ?>
    </select>

    <button type="submit">Registrar Empréstimo</button>
</form>

</body>
</html>

<?php $conn->close(); ?>


