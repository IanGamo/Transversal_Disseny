CREATE DATABASE IF NOT EXISTS race_and_meet;

USE race_and_meet;

CREATE TABLE
    IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(250),
        rol VARCHAR(20) DEFAULT 'user',
        path VARCHAR(255) NOT NULL DEFAULT ''
    );

INSERT INTO
    usuarios (name, email, password, rol)
VALUES
    ('Adm', 'admin@test.com', 'admin123', 'admin');

INSERT INTO
    usuarios (name, email, password, rol)
VALUES
    ('User', 'user@test.com', 'user123', 'user');