CREATE DATABASE bd_foro;

USE bd_foro;

-- Crear tabla de usuarios
CREATE TABLE tbl_usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_usuario VARCHAR(50),
    nombreReal_usuario VARCHAR(70),
    telf_usuario CHAR(9),
    psswd_usuario VARCHAR(60)
);

-- Crear tabla de preguntas
CREATE TABLE tbl_preguntas( 
    id_preguntas INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    texto_preguntas VARCHAR(255) NOT NULL,
    titulo_preguntas VARCHAR(150) NOT NULL,
    estado_preguntas ENUM ('no respondida', 'guardada', 'respondida') NOT NULL DEFAULT 'no respondida',
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES tbl_usuarios(id_usuario)
);

-- Crear tabla de respuestas
CREATE TABLE tbl_respuestas(
    id_respuestas INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    texto_respuestas VARCHAR(255) NOT NULL,
    titulo_respuestas VARCHAR(150) NOT NULL,
    estado_respuestas ENUM('no contestada', 'contestada') NOT NULL DEFAULT 'no contestada',
    id_preguntas INT NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_preguntas) REFERENCES tbl_preguntas(id_preguntas),
    FOREIGN KEY (id_usuario) REFERENCES tbl_usuarios(id_usuario)
);

-- Insertar datos en la tabla de usuarios
INSERT INTO tbl_usuarios (nombre_usuario, nombreReal_usuario, telf_usuario, psswd_usuario) 
VALUES 
('Juan123', 'Juan Pérez', '123456789', 'qweQWE123'),
('Adri123', 'Adri Martín', '123456789', 'qweQWE123'),
('Manel123', 'Manel Rodriguez', '123456789', 'qweQWE123'),
('Juanjo123', 'Juanjo Pérez', '123456789', 'qweQWE123'),
('Pol123', 'Pol Martín', '123456789', 'qweQWE123'),
('Julian123', 'Julian Vargas', '123456789', 'qweQWE123');
