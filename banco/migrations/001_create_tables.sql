-- 001_create_tables.sql
-- Migration inicial: criação das tabelas do sistema Biblioteca

CREATE TABLE IF NOT EXISTS autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS editoras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS idiomas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    id_autor INT NOT NULL,
    id_editora INT NOT NULL,
    id_genero INT NOT NULL,
    id_idioma INT NOT NULL,
    ano_publicacao YEAR,
    FOREIGN KEY (id_autor) REFERENCES autores(id),
    FOREIGN KEY (id_editora) REFERENCES editoras(id),
    FOREIGN KEY (id_genero) REFERENCES generos(id),
    FOREIGN KEY (id_idioma) REFERENCES idiomas(id)
);

CREATE TABLE IF NOT EXISTS exemplares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_livro INT NOT NULL,
    status ENUM('Disponível','Emprestado') DEFAULT 'Disponível',
    FOREIGN KEY (id_livro) REFERENCES livros(id)
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);
