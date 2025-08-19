<?php
require 'config.php';

$sql = "
SELECT e.id, e.id_exemplar, u.nome AS usuario, l.titulo, ex.codigo_exemplar, 
       e.data_emprestimo, e.data_devolucao, e.status, e.renovacoes
FROM emprestimos e
JOIN usuarios u ON e.id_usuario = u.id
JOIN exemplares ex ON e.id_exemplar = ex.id
JOIN livros l ON ex.id_livro = l.id
ORDER BY e.data_emprestimo DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Empréstimos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f7fa;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .button {
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 0.85em;
            color: white;
            text-decoration: none;
            margin: 2px;
            display: inline-block;
        }
        .devolver { background-color: #28a745; }
        .renovar { background-color: #ffc107; color: black; }
        .reservar { background-color: #6c757d; }
        .novo-emprestimo {
            display: inline-block;
            background-color: #17a2b8;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 15px;
        }
        .novo-emprestimo:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <h1>📋 Empréstimos</h1>

    <a href="emprestar.php" class="novo-emprestimo">➕ Registrar novo empréstimo</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Cód. Exemplar</th>
                <th>Data Empréstimo</th>
                <th>Data Devolução</th>
                <th>Status</th>
                <th>Renovações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['usuario']) ?></td>
                        <td><?= htmlspecialchars($row['titulo']) ?></td>
                        <td><?= htmlspecialchars($row['codigo_exemplar']) ?></td>
                        <td><?= $row['data_emprestimo'] ?></td>
                        <td><?= $row['data_devolucao'] ?: '-' ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= $row['renovacoes'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'ativo'): ?>
                                <a href="devolver.php?id=<?= $row['id'] ?>" class="button devolver" onclick="return confirm('Confirmar devolução?')">🔁 Devolver</a>
                                <a href="renovar.php?id=<?= $row['id'] ?>" class="button renovar" onclick="return confirm('Confirmar renovação?')">🔄 Renovar</a>
                            <?php else: ?>
                                <span style="color: #888;">✔️ Finalizado</span>
                                <a href="reservar.php?id_exemplar=<?= $row['id_exemplar'] ?>" class="button reservar">📌 Reservar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" style="text-align:center;">Nenhum empréstimo registrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>

