<?php
require 'config.php';

$sql = "
    SELECT r.*, u.nome AS usuario, e.codigo_exemplar, l.titulo,
        (SELECT COUNT(*) FROM reservas r2 WHERE r2.id_exemplar = r.id_exemplar AND r2.id <= r.id AND r2.status = 'ativa') AS posicao_fila
    FROM reservas r
    JOIN usuarios u ON r.id_usuario = u.id
    JOIN exemplares e ON r.id_exemplar = e.id
    JOIN livros l ON e.id_livro = l.id
    WHERE r.status = 'ativa'
    ORDER BY r.data_reserva ASC
";
$reservas = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reservas</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #007bff; color: white; }
        h1 { color: #333; }
        .btn {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9em;
            margin-right: 5px;
        }
        .btn-emprestar { background-color: #28a745; color: white; }
        .btn-cancelar { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<h1>📌 Reservas Ativas</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Cód. Exemplar</th>
            <th>Data</th>
            <th>Fila</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($reservas && $reservas->num_rows > 0): ?>
            <?php while ($row = $reservas->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['usuario']) ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['codigo_exemplar']) ?></td>
                    <td><?= $row['data_reserva'] ?></td>
                    <td><?= $row['posicao_fila'] ?></td>
                    <td>
                        <?php if ($row['posicao_fila'] == 1): ?>
                            <a href="emprestar.php?reserva=<?= $row['id'] ?>" class="btn btn-emprestar">📤 Emprestar</a>
                        <?php endif; ?>
                        <a href="cancelar_reserva.php?id=<?= $row['id'] ?>" class="btn btn-cancelar" onclick="return confirm('Cancelar esta reserva?')">❌ Cancelar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" style="text-align:center;">Nenhuma reserva ativa.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>


