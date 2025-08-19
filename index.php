<?php
require 'config.php';

$sql = "SELECT * FROM livros";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Lista de Livros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f8f9fa;
        }
        h1 {
            color: #333;
        }
        a.adicionar {
            display: inline-block;
            margin-bottom: 15px;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
        }
        a.adicionar:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 8px rgb(0 0 0 / 0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
        }

        .actions a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 5px;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
            user-select: none;
            cursor: pointer;
            margin-right: 5px;
        }
        .actions a.edit {
            background-color: #28a745;
        }
        .actions a.edit:hover {
            background-color: #218838;
        }
        .actions a.delete {
            background-color: #dc3545;
        }
        .actions a.delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <h1>Lista de Livros</h1>

    <a href="adicionar.php" class="adicionar">➕ Adicionar Novo Livro</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>ID Autor</th>
                <th>ID Editora</th>
                <th>ID Gênero</th>
                <th>Ano</th>
                <th>ISBN</th>
                <th>Páginas</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while($livro = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($livro['id']) ?></td>
                    <td><?= htmlspecialchars($livro['titulo']) ?></td>
                    <td><?= $livro['id_autor'] ?></td>
                    <td><?= $livro['id_editora'] ?></td>
                    <td><?= $livro['id_genero'] ?></td>
                    <td><?= $livro['ano_publicacao'] ?></td>
                    <td><?= htmlspecialchars($livro['isbn']) ?></td>
                    <td><?= $livro['paginas'] ?></td>
                    <td><?= $livro['data_cadastro'] ?></td>
                    <td class="actions">
                        <a href="editar.php?id=<?= $livro['id'] ?>" class="edit" title="Editar">&#9998; Editar</a>
                        <a href="excluir.php?tipo=livros&id=<?= $livro['id'] ?>" class="delete" title="Excluir" onclick="return confirm('Confirma exclusão do livro?')">&#10060; Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" style="text-align:center;">Nenhum livro cadastrado.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
