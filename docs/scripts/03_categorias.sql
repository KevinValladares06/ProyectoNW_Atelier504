CREATE TABLE categorias (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    categoria VARCHAR(255),
    estado CHAR(3)
) COMMENT 'Categorias de Productos';