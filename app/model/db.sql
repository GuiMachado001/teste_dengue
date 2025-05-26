CREATE DATABASE dengue;
USE dengue;



CREATE TABLE perfil (
	id_perfil INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150),
    PRIMARY KEY(id_perfil)
);

INSERT INTO perfil (nome) VALUES ('Administrador');
INSERT INTO perfil (nome) VALUES ('Supervisor');

CREATE TABLE usuario (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    email VARCHAR(200) NOT NULL UNIQUE,
    senha VARCHAR(255),
    id_perfil INT NOT NULL,
    PRIMARY KEY(id_usuario),
    FOREIGN KEY(id_perfil) REFERENCES perfil(id_perfil)
);

INSERT INTO usuario (nome, email, senha, id_perfil) VALUES ('administrador', 'administrador@outlook.com', '123', '1');
INSERT INTO usuario (nome, email, senha, id_perfil) VALUES ('supervisor', 'supervisor@outlook.com', '123', '2');
SELECT * FROM usuario;

CREATE TABLE estado(
	id_estado INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
	PRIMARY KEY(id_estado)
);

CREATE TABLE cidade(
    id_cidade INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    id_estado INT NOT NULL,
    PRIMARY KEY(id_cidade),
    FOREIGN KEY(id_estado) REFERENCES estado(id_estado)
);

CREATE TABLE escola(
    id_escola INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    id_cidade INT NOT NULL,
    ativo INT DEFAULT 0,
    PRIMARY KEY(id_escola),
    FOREIGN KEY(id_cidade) REFERENCES cidade(id_cidade)
);

CREATE TABLE serie(
    id_serie INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100),
    id_escola INT NOT NULL,
    PRIMARY KEY(id_serie),
    FOREIGN KEY(id_escola) REFERENCES escola(id_escola)
);

CREATE TABLE aluno(
    id_aluno INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    id_serie INT NOT NULL,
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

DELIMITER $$

CREATE TRIGGER inserir_pontos_aluno
AFTER INSERT ON aluno
FOR EACH ROW
BEGIN
  -- Inserir um registro correspondente na tabela pontos_aluno
  INSERT INTO pontos_aluno (id_aluno, pontos)
  VALUES (NEW.id_aluno, 0);
END$$

DELIMITER ;



