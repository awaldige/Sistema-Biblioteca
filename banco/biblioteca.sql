-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Tempo de geração: 19/08/2025 às 17:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `autores`
--

CREATE TABLE `autores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `nacionalidade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `autores`
--

INSERT INTO `autores` (`id`, `nome`, `nacionalidade`) VALUES
(1, 'Machado de Assis', ''),
(2, 'J.K. Rowling', ''),
(3, 'George Orwell', ''),
(4, 'Machado de Assis', 'Brasileira'),
(5, 'Clarice Lispector', 'Brasileira'),
(6, 'José Saramago', 'Portuguesa'),
(7, 'Gabriel García Márquez', 'Colombiana'),
(8, 'Jorge Amado', 'Brasileira'),
(9, 'William Shakespeare', 'Inglesa'),
(10, 'Jane Austen', 'Inglesa'),
(11, 'Paulo Coelho', 'Brasileira'),
(12, 'Charles Dickens', 'Inglesa'),
(13, 'Virginia Woolf', 'Inglesa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `editoras`
--

CREATE TABLE `editoras` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `site` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `editoras`
--

INSERT INTO `editoras` (`id`, `nome`, `site`) VALUES
(1, 'Companhia das Letras', NULL),
(2, 'Rocco', NULL),
(3, 'Intrínseca', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimos`
--

CREATE TABLE `emprestimos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_exemplar` int(11) NOT NULL,
  `data_emprestimo` date NOT NULL DEFAULT curdate(),
  `data_devolucao` date DEFAULT NULL,
  `status` enum('ativo','devolvido') NOT NULL DEFAULT 'ativo',
  `renovacoes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `emprestimos`
--

INSERT INTO `emprestimos` (`id`, `id_usuario`, `id_exemplar`, `data_emprestimo`, `data_devolucao`, `status`, `renovacoes`) VALUES
(1, 1, 1, '2025-06-28', NULL, 'ativo', 0),
(2, 2, 2, '2025-06-28', NULL, 'ativo', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `exemplares`
--

CREATE TABLE `exemplares` (
  `id` int(11) NOT NULL,
  `id_livro` int(11) NOT NULL,
  `codigo_exemplar` varchar(50) NOT NULL,
  `disponibilidade` enum('disponível','emprestado') DEFAULT 'disponível',
  `status` enum('disponivel','emprestado') NOT NULL DEFAULT 'disponivel',
  `id_idioma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `exemplares`
--

INSERT INTO `exemplares` (`id`, `id_livro`, `codigo_exemplar`, `disponibilidade`, `status`, `id_idioma`) VALUES
(1, 1, 'EX001', 'disponível', 'disponivel', NULL),
(2, 2, 'EX002', 'disponível', 'disponivel', NULL),
(3, 3, 'EX003', 'disponível', 'disponivel', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `generos`
--

INSERT INTO `generos` (`id`, `nome`) VALUES
(1, 'Romance'),
(2, 'Fantasia'),
(3, 'Distopia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `idiomas`
--

CREATE TABLE `idiomas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `idiomas`
--

INSERT INTO `idiomas` (`id`, `nome`) VALUES
(1, 'Português'),
(2, 'Inglês');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `id_autor` int(11) DEFAULT NULL,
  `id_editora` int(11) DEFAULT NULL,
  `id_genero` int(11) DEFAULT NULL,
  `ano_publicacao` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `paginas` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `id_autor`, `id_editora`, `id_genero`, `ano_publicacao`, `isbn`, `paginas`, `data_cadastro`) VALUES
(1, 'Dom Casmurro', 1, 1, 1, 1899, '1234567890123', 256, '2025-06-28 19:31:08'),
(2, 'Harry Potter e a Pedra Filosofal', 2, 2, 2, 1997, '9788532530783', 320, '2025-06-28 19:31:08'),
(3, '1984', 3, 3, 3, 1949, '9788535914849', 328, '2025-06-28 19:31:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_exemplar` int(11) NOT NULL,
  `data_reserva` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('ativa','cancelada','concluída') DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `telefone`, `data_cadastro`) VALUES
(1, 'João Silva', 'joao@email.com', '11988887777', '2025-06-28 19:31:08'),
(2, 'Maria Oliveira', 'maria@email.com', '11977776666', '2025-06-28 19:31:08');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `editoras`
--
ALTER TABLE `editoras`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_exemplar` (`id_exemplar`);

--
-- Índices de tabela `exemplares`
--
ALTER TABLE `exemplares`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_exemplar` (`codigo_exemplar`),
  ADD KEY `id_livro` (`id_livro`),
  ADD KEY `id_idioma` (`id_idioma`);

--
-- Índices de tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_editora` (`id_editora`),
  ADD KEY `id_genero` (`id_genero`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_exemplar` (`id_exemplar`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `autores`
--
ALTER TABLE `autores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `editoras`
--
ALTER TABLE `editoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `exemplares`
--
ALTER TABLE `exemplares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD CONSTRAINT `emprestimos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emprestimos_ibfk_2` FOREIGN KEY (`id_exemplar`) REFERENCES `exemplares` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `exemplares`
--
ALTER TABLE `exemplares`
  ADD CONSTRAINT `exemplares_ibfk_1` FOREIGN KEY (`id_livro`) REFERENCES `livros` (`id`),
  ADD CONSTRAINT `exemplares_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idiomas` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `livros`
--
ALTER TABLE `livros`
  ADD CONSTRAINT `livros_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id`),
  ADD CONSTRAINT `livros_ibfk_2` FOREIGN KEY (`id_editora`) REFERENCES `editoras` (`id`),
  ADD CONSTRAINT `livros_ibfk_3` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id`);

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_exemplar`) REFERENCES `exemplares` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
