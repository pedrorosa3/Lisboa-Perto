-- Dados iniciais para o ambiente Docker
-- (executado automaticamente a seguir ao BDASW18.sql, só na primeira vez que a BD é criada)

-- Estados (os IDs 1, 2 e 3 são usados diretamente no código)
INSERT INTO estado (id, nome_estado) VALUES
    (1, 'Por Resolver'),
    (2, 'A ser Resolvido'),
    (3, 'Resolvido');

-- Categorias (os nomes têm de coincidir com os filtros de pesquisa)
INSERT INTO categorias (id, nome) VALUES
    (1, 'Acidentes de Transito'),
    (2, 'Defeitos na via publica'),
    (3, 'Riscos de causas naturais');

-- Subcategorias de exemplo
INSERT INTO subcategorias (nome, categoria) VALUES
    ('Colisao', 1),
    ('Atropelamento', 1),
    ('Buraco na estrada', 2),
    ('Iluminacao publica avariada', 2),
    ('Sinalizacao danificada', 2),
    ('Queda de arvore', 3),
    ('Inundacao', 3);

-- Utilizador da CML para aceder ao back-office
-- email: cml@lisboaperto.pt | password: admin123
INSERT INTO utilizador (nome, tipo, email, passwd) VALUES
    ('Funcionario CML', 'cml', 'cml@lisboaperto.pt',
     '$2y$10$fCM6ZOhvlqPRoyfJxV8lOeOzfbxKGU1G7Q4FGI.64U0Jx43FhcS9S');
