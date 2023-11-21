create database aprendendoMaisPhp3;
use aprendendoMaisPhp3;
-- Desativar verificação de chaves estrangeiras temporariamente
SET foreign_key_checks = 0;

-- Tabela para armazenar informações sobre as turmas
CREATE TABLE turma (
    idturma INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    idprofessor INT,
    FOREIGN KEY (idprofessor) REFERENCES professor(idprofessor),
    iddisciplina INT,
    FOREIGN KEY (iddisciplina) REFERENCES disciplina(iddisciplina),
    tipodeturma CHAR(1),
    data_registro DATETIME,
    percentualregresso FLOAT(4)
);

-- Tabela para armazenar informações sobre os alunos
CREATE TABLE aluno (
    matricula VARCHAR(20) PRIMARY KEY,
    nome VARCHAR(45) NOT NULL,
    telefone VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL
);

-- Tabela para armazenar informações sobre os cursos
CREATE TABLE curso (
    idcurso INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45),
    idinstituicao INT,
    FOREIGN KEY (idinstituicao) REFERENCES instituicao(idinstituicao)
);

-- Tabela para armazenar informações sobre as disciplinas
CREATE TABLE disciplina (
    iddisciplina INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45),
    idcurso INT,
    FOREIGN KEY (idcurso) REFERENCES curso(idcurso)
);

-- Tabela para armazenar informações sobre as instituições
CREATE TABLE instituicao (
    idinstituicao INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    cnpj VARCHAR(14),
    telefone VARCHAR(45),
    email VARCHAR(45)
);

-- Tabela para armazenar informações sobre os professores
CREATE TABLE professor (
    idprofessor INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    email VARCHAR(45)
);

-- Tabela para armazenar informações sobre os alunos e turmas
CREATE TABLE desempenho_aluno_turma (
    matricula VARCHAR(20) NOT NULL,
    idturma INT(11) NOT NULL,
    nota DECIMAL(4,2),
    falta INT,
    PRIMARY KEY (matricula, idturma),
    FOREIGN KEY (matricula) REFERENCES aluno(matricula) ON DELETE CASCADE,
    FOREIGN KEY (idturma) REFERENCES turma(idturma) ON DELETE CASCADE
);

-- Ativar verificação de chaves estrangeiras
SET foreign_key_checks = 1;

-- Inserir dados de exemplo nas tabelas
INSERT INTO instituicao (nome, cnpj, telefone, email) VALUES ('SENAI CAMAÇARI', '00045695781377', '71 93648-1900', 'Senaicamacari@ba.intituicao.org');
INSERT INTO curso (nome, idinstituicao) VALUES ('Desenvolvimento de Sistemas', 1);
INSERT INTO disciplina (nome, idcurso) VALUES ('Lógica de Programação', 1);
INSERT INTO professor (nome, email) VALUES ('Izadora B', 'Izadora.b@ba.docente.senai.br');
INSERT INTO turma (nome, idprofessor, iddisciplina, tipodeturma, data_registro, percentualregresso) VALUES ('Turma A', 1, 1, 'A', NOW(), 0.0);
INSERT INTO aluno (matricula, nome, telefone, email) VALUES ('MAT001', 'Nome Aluno 1', '123456789', 'aluno1@example.com');
INSERT INTO desempenho_aluno_turma (matricula, idturma, nota, falta) VALUES ('MAT001', 1, 8.5, 2);

ALTER TABLE desempenho_aluno_turma ADD COLUMN previsoes DECIMAL(4,2)
-- ALTER TABLE desempenho_aluno_turma DROP PRIMARY KEY;

-- ALTER TABLE desempenho_aluno_turma DROP INDEX matricula_UNIQUE;


