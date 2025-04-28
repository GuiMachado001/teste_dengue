CREATE DATABASE dengue;
USE dengue;
SHOW TABLES;

CREATE TABLE administrador(
    id_administrador INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    email VARCHAR(200),
    senha VARCHAR(250),
    PRIMARY KEY(id_administrador)
);

CREATE TABLE estado(
	id_estado INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
	PRIMARY KEY(id_estado)
);

CREATE TABLE cidade(
    id_cidade INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    id_estado INT,
    PRIMARY KEY(id_cidade),
    FOREIGN KEY(id_estado) REFERENCES estado(id_estado)
);

CREATE TABLE escola(
    id_escola INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    id_cidade INT,
    ativo INT DEFAULT 0,
    PRIMARY KEY(id_escola),
    FOREIGN KEY(id_cidade) REFERENCES cidade(id_cidade)
);

CREATE TABLE serie(
    id_serie INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100),
    id_escola INT,
    PRIMARY KEY(id_serie),
    FOREIGN KEY(id_escola) REFERENCES escola(id_escola)
);

CREATE TABLE aluno(
    id_aluno INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    id_serie INT,
    PRIMARY KEY(id_aluno),
    FOREIGN KEY(id_serie) REFERENCES serie(id_serie)
);

CREATE TABLE pontos_aluno(
	id_pontos_aluno INT NOT NULL AUTO_INCREMENT,
    id_aluno INT NOT NULL,
    pontos INT DEFAULT 0,
    PRIMARY KEY (id_pontos_aluno),
    FOREIGN KEY(id_aluno) REFERENCES aluno(id_aluno)
);

CREATE TABLE pontos_escola (
    id_escola INT PRIMARY KEY,
    total_pontos INT DEFAULT 0,
    FOREIGN KEY (id_escola) REFERENCES escola(id_escola)
);

-- trigger --

DELIMITER $$

CREATE TRIGGER inserir_pontos_escola
AFTER INSERT ON escola
FOR EACH ROW
BEGIN
  -- Inserir um registro correspondente na tabela pontos_escola
  INSERT INTO pontos_escola (id_escola, total_pontos)
  VALUES (NEW.id_escola, 0);
END$$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER atualizar_pontos_escola_insert
AFTER INSERT ON pontos_aluno
FOR EACH ROW
BEGIN
  UPDATE pontos_escola pe
  JOIN (
      SELECT e.id_escola, SUM(pa.pontos) AS total
      FROM pontos_aluno pa
      JOIN aluno a ON pa.id_aluno = a.id_aluno
      JOIN serie s ON a.id_serie = s.id_serie
      JOIN escola e ON s.id_escola = e.id_escola
      GROUP BY e.id_escola
  ) AS sub ON pe.id_escola = sub.id_escola
  SET pe.total_pontos = sub.total
  WHERE pe.id_escola = (
    SELECT s.id_escola
    FROM aluno a
    JOIN serie s ON a.id_serie = s.id_serie
    WHERE a.id_aluno = NEW.id_aluno
  );
END$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER atualizar_pontos_escola_update
AFTER UPDATE ON pontos_aluno
FOR EACH ROW
BEGIN
  -- Verificar se houve mudança nos pontos do aluno
  IF OLD.pontos <> NEW.pontos THEN
    -- Atualizar a soma de pontos para a escola correspondente
    UPDATE pontos_escola pe
    JOIN (
        SELECT e.id_escola, SUM(pa.pontos) AS total
        FROM pontos_aluno pa
        JOIN aluno a ON pa.id_aluno = a.id_aluno
        JOIN serie s ON a.id_serie = s.id_serie
        JOIN escola e ON s.id_escola = e.id_escola
        GROUP BY e.id_escola
    ) AS sub ON pe.id_escola = sub.id_escola
    SET pe.total_pontos = sub.total
    WHERE pe.id_escola = (SELECT id_escola FROM serie s
                           JOIN aluno a ON s.id_serie = a.id_serie
                           WHERE a.id_aluno = NEW.id_aluno);
  END IF;
END$$

DELIMITER ;






-- insert --
INSERT INTO estado (nome) VALUES ('Mato Grosso do Sul');
INSERT INTO cidade (nome, id_estado) VALUES ('Campo Grande', 1);
INSERT INTO escola (nome, id_cidade, ativo) VALUES ('Escola Estadual Adventor Divino de Almeida', 1, 1);
INSERT INTO serie (nome, id_escola) VALUES ('8º Ano B', 1);
INSERT INTO aluno (nome, id_serie) VALUES ('Guilherme Machado', 1);
INSERT INTO pontos_aluno (id_aluno, pontos) VALUES (1, 3000);


-- consultas --

SELECT * FROM aluno;
SELECT * FROM serie;
SELECT * FROM pontos_aluno;
SELECT * FROM pontos_escola;


UPDATE pontos_aluno
SET pontos = pontos + 6000
WHERE id_aluno = 1;






-- Consultar todos os estados e suas respectivas cidades
SELECT estado.nome AS Estado, GROUP_CONCAT(cidade.nome ORDER BY cidade.nome) AS Cidades
FROM estado
JOIN cidade ON estado.id_estado = cidade.id_estado
GROUP BY estado.id_estado;

-- Consultar todas as escolas em uma cidade específica
SELECT escola.nome AS Escola, cidade.nome AS Cidade, estado.nome AS Estado
FROM escola
JOIN cidade ON escola.id_cidade = cidade.id_cidade
JOIN estado ON cidade.id_estado = estado.id_estado
WHERE cidade.nome = 'Campo Grande';

-- Consultar a soma de pontos de todos os alunos de uma escola
SELECT escola.nome AS Escola, SUM(pontos_aluno.pontos) AS Total_Pontos
FROM pontos_aluno
JOIN aluno ON pontos_aluno.id_aluno = aluno.id_aluno
JOIN serie ON aluno.id_serie = serie.id_serie
JOIN escola ON serie.id_escola = escola.id_escola
GROUP BY escola.id_escola;

-- Consultar a soma de pontos de todos os alunos de todas as escolas
SELECT escola.nome AS Escola, SUM(pontos_aluno.pontos) AS Total_Pontos
FROM pontos_aluno
JOIN aluno ON pontos_aluno.id_aluno = aluno.id_aluno
JOIN serie ON aluno.id_serie = serie.id_serie
JOIN escola ON serie.id_escola = escola.id_escola
GROUP BY escola.id_escola;

-- Consultar o total de pontos de uma escola específica (usando a tabela pontos_escola)
SELECT escola.nome AS Escola, pontos_escola.total_pontos AS Total_Pontos
FROM pontos_escola
JOIN escola ON pontos_escola.id_escola = escola.id_escola
WHERE escola.nome = 'Escola Estadual Maria';

-- Consultar os pontos de um aluno específico
SELECT aluno.nome AS Aluno, pontos_aluno.pontos AS Pontos
FROM pontos_aluno
JOIN aluno ON pontos_aluno.id_aluno = aluno.id_aluno
WHERE aluno.nome = 'Guilherme Machado';

-- Consultar o total de pontos das escolas com status ativo (status = 1)
SELECT escola.nome AS Escola, pontos_escola.total_pontos AS Total_Pontos
FROM pontos_escola
JOIN escola ON pontos_escola.id_escola = escola.id_escola
WHERE escola.ativo = 1;

-- Consultar todos os alunos e os pontos de cada um
SELECT aluno.nome AS Aluno, pontos_aluno.pontos AS Pontos
FROM aluno
JOIN pontos_aluno ON aluno.id_aluno = pontos_aluno.id_aluno;


