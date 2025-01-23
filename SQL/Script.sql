DROP DATABASE IF EXISTS youdemy;
CREATE DATABASE youdemy;
USE youdemy;
CREATE TABLE users(
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    f_name VARCHAR(15),
    l_name VARCHAR(15),
    email VARCHAR(50) UNIQUE,
    pwd_hashed VARCHAR(100),
    roles VARCHAR(12),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_suspended int DEFAULT 0,
    is_deleted int DEFAULT 0
);

CREATE TABLE category(
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_deleted INT DEFAULT 0
);

CREATE TABLE cours(
    cours_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50),
    descriptions VARCHAR(150),
    contenu VARCHAR(200),
    created_at DATETIME,
    is_deleted int DEFAULT 0,
    enseignant int,
    category int,
    Foreign Key (enseignant) REFERENCES users(users_id),
    Foreign Key (category) REFERENCES category(category_id)
);

CREATE TABLE tags(
    tag_id INT PRIMARY KEY AUTO_INCREMENT,
    tag_name VARCHAR(10),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_deleted INT DEFAULT 0
);

CREATE TABLE cours_tags(
    ids INT PRIMARY KEY AUTO_INCREMENT,
    cours_id INT,
    tags_id INT,
    Foreign Key (cours_id) REFERENCES cours(cours_id),
    Foreign Key (tags_id) REFERENCES tags(tag_id)
);

CREATE TABLE cours_etudiant(
    ids INT PRIMARY KEY AUTO_INCREMENT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    cours INT,
    etudiant INT,
    enseignant INT,
    is_terminer INT DEFAULT 0,
    Foreign Key (cours) REFERENCES cours(cours_id),
    Foreign Key (etudiant) REFERENCES users(users_id),
    Foreign Key (enseignant) REFERENCES users(users_id)
);

INSERT INTO users (f_name, l_name, email, pwd_hashed, roles)
VALUES('Ahlallay', 'Abderrahmane', 'admin@admin.com', '$2y$10$soOyVvC/b2OzxTU45mlYp.mpZnU51pm1sLxqc91JqJyVabrF3lP4e', 'admin'),
('user-02', 'user-02', 'user-02@etudiant.com', '$2y$10$soOyVvC/b2OzxTU45mlYp.mpZnU51pm1sLxqc91JqJyVabrF3lP4e', 'etudiant'),
('user-03', 'user-03', 'user-03@enseignant.com', '$2y$10$soOyVvC/b2OzxTU45mlYp.mpZnU51pm1sLxqc91JqJyVabrF3lP4e', 'enseignant'),
('user-04', 'user-04', 'user-04@etudiant.com', '$2y$10$soOyVvC/b2OzxTU45mlYp.mpZnU51pm1sLxqc91JqJyVabrF3lP4e', 'etudiant'),
('user-05', 'user-05', 'user-05@enseignant.com', '$2y$10$soOyVvC/b2OzxTU45mlYp.mpZnU51pm1sLxqc91JqJyVabrF3lP4e', 'enseignant'),
('user-06', 'user-06', 'user-06@etudiant.com', '$2y$10$soOyVvC/b2OzxTU45mlYp.mpZnU51pm1sLxqc91JqJyVabrF3lP4e', 'etudiant');

INSERT INTO category (category_name) VALUES('Frontend'),('Backend'),('Developpement web'),('Cyber Security'), ('Diagrammes');
INSERT INTO tags (tag_name) VALUES('Java Script'),('HTML'),('CSS'),('Use Case'),('POO');