use ecommerce

CREATE TABLE EstudianteCienciasComputacionales (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    edad INT,
    especialidad VARCHAR(50)
);

INSERT INTO
    EstudianteCienciasComputacionales (
        nombre,
        apellido,
        edad,
        especialidad
    )
VALUES (
        'Juan',
        'Doe',
        22,
        'Ciencias de la Computación'
    );

INSERT INTO
    EstudianteCienciasComputacionales (
        nombre,
        apellido,
        edad,
        especialidad
    )
VALUES (
        'Ana',
        'Martinez',
        21,
        'Inteligencia Artificial'
    );

INSERT INTO
    EstudianteCienciasComputacionales (
        nombre,
        apellido,
        edad,
        especialidad
    )
VALUES (
        'Luis',
        'Gomez',
        23,
        'Desarrollo Web'
    );

INSERT INTO
    EstudianteCienciasComputacionales (
        nombre,
        apellido,
        edad,
        especialidad
    )
VALUES (
        'María',
        'Fernandez',
        20,
        'Seguridad Informatica'
    );

INSERT INTO
    EstudianteCienciasComputacionales (
        nombre,
        apellido,
        edad,
        especialidad
    )
VALUES (
        'Carlos',
        'Rodriguez',
        24,
        'Bases de Datos'
    );