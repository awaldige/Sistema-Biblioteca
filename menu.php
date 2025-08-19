<!-- menu.php -->
<style>
    .menu {
        background-color: #007bff;
        padding: 12px 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .menu a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        padding: 8px 14px;
        border-radius: 6px;
        transition: background 0.3s ease;
        background-color: rgba(255,255,255,0.1);
    }

    .menu a:hover {
        background-color: rgba(255,255,255,0.25);
    }

    @media (max-width: 600px) {
        .menu {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="menu">
    <a href="index.php">🏠 Início</a>
    <a href="usuarios.php">👤 Usuários</a>
   
    <a href="autores.php">✍️ Autores</a>
    <a href="editoras.php">🏢 Editoras</a>
    <a href="generos.php">🏷️ Gêneros</a>
    <a href="idiomas.php">🌐 Idiomas</a>
    <a href="adicionar_exemplar.php">📦 Adicionar Exemplar</a>
    <a href="listar_exemplares.php">📦 Exemplares</a>
    <a href="emprestar.php">📤 Emprestar</a>
    <a href="emprestimos.php">📋 Empréstimos</a>
    <a href="reservas.php">📌 Reservas</a>
</div>

