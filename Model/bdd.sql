CREATE DATABASE IF NOT EXISTS race_and_meet;

USE race_and_meet;

CREATE TABLE IF NOT EXISTS usuarios (
    id       INT          AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100),
    email    VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol      VARCHAR(20)  DEFAULT 'usuario',
    path     VARCHAR(255) NOT NULL DEFAULT ''
);


INSERT INTO usuarios (name, email, password, rol) VALUES
('Adm',  'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('User', 'user@test.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario');