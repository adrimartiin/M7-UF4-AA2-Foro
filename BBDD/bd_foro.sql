CREATE DATABASE bd_foro;

USE bd_foro;

CREATE TABLE tbl_usuarios(
    id_usuario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_usuario VARCHAR(50) ,
    nombreReal_usuario VARCHAR(70) ,
    telf_usuario CHAR(9),
    psswd_usuario VARCHAR(60)
);

create TABLE tbl_preguntas(
    id_preguntas INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    texto_preguntas VARCHAR(255) NOT NULL,
    titulo_preguntas VARCHAR(150) NOT NULL,
    FOREIGN KEY (id_usuarios) REFERENCES tbl_usuarios(tbl_usuarios)
);

create TABLE tbl_respuestas(
    id_respuestas INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    texto_respuestas VARCHAR(255) NOT NULL,
    titulo_respuestas VARCHAR(150) NOT NULL,
    estado_respuestas ENUM('no conestada', 'contestada') NOT NULL DEFAULT 'no contestada';
    FOREIGN KEY (id_preguntas) REFERENCES tbl_preguntas(id_preguntas),
    FOREIGN KEY (id_usuarios) REFERENCES tbl_usuarios(id_usuarios)
);