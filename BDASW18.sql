



CREATE TABLE utilizador(
    id int NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255),
    telemovel NUMERIC(9),
    idade NUMERIC(9),
    nif NUMERIC(9),
    morada VARCHAR(255),
    tipo VARCHAR(30),
    email VARCHAR(255),
    passwd VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE categorias(

    nome VARCHAR(255),
    id int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id)
);

CREATE TABLE subcategorias(

    nome VARCHAR(255),
    id int NOT NULL AUTO_INCREMENT,
    categoria int,
    PRIMARY KEY(id),
    FOREIGN KEY (categoria) REFERENCES categorias(id)
);

CREATE TABLE estado(
    id int NOT NULL AUTO_INCREMENT,
    nome_estado VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE ocorrencia(
    id int NOT NULL AUTO_INCREMENT,
    gravidade VARCHAR(255),
    morada VARCHAR(255),
    localizacao VARCHAR(255),
    urgencia VARCHAR(255),
    descricao VARCHAR(255),
    foto VARCHAR(255),
    localidade VARCHAR(255),
    idutilizador int,
    subcategoria int,
    idestado int,
    PRIMARY KEY(id),
    FOREIGN KEY (subcategoria) REFERENCES subcategorias(id),
    FOREIGN KEY (idutilizador) REFERENCES utilizador(id),
    FOREIGN KEY (idestado) REFERENCES estado(id),
    CONSTRAINT chk_urgencia CHECK (urgencia>0 AND urgencia<6)
);





CREATE TABLE chat(
    mensagem VARCHAR(255),
    tempo_mensagem VARCHAR(255),
    utilizador1 int,
    utilizador2 int,
    ocorrencia int,
    FOREIGN KEY (utilizador1) REFERENCES utilizador(id),
    FOREIGN KEY (utilizador2) REFERENCES utilizador(id),
    FOREIGN KEY (ocorrencia) REFERENCES ocorrencia(id)

);



CREATE TABLE mudancaEstado(
    tempo DATETIME,
    ocorrencia int,
    estado int,
    PRIMARY KEY (ocorrencia,estado),
    FOREIGN KEY (ocorrencia) REFERENCES ocorrencia(id),
    FOREIGN KEY (estado) REFERENCES estado(id)
);

CREATE TABLE feedback(
    id int NOT NULL AUTO_INCREMENT,
    tempo DATETIME,
    mensagem VARCHAR(255),
    rating int,
    idutilizador int,
    idocorrencia int,
    PRIMARY KEY(id,idutilizador,idocorrencia),
    FOREIGN KEY (idutilizador) REFERENCES utilizador(id),
    FOREIGN KEY (idocorrencia) REFERENCES ocorrencia(id),
    CONSTRAINT chk_rating CHECK (rating>0 AND rating<6)
);

