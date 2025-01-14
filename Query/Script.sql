CREATE DATABASE youdemy;
USE youdemy;
CREATE TABLE users(
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    f_name VARCHAR(15),
    l_name VARCHAR(15),
    email VARCHAR(50) UNIQUE,
    pwd_hashed VARCHAR(100),
    roles VARCHAR(10) DEFAULT 'Etudiant',
    birth_day DATE,
    created_at DATETIME,
    avatar VARCHAR(100),
    is_suspended int,
    is_deleted int
);

CREATE TABLE category(
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(20),
    creatd_at DATETIME
);

CREATE TABLE cours(
    cours_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50),
    descriptions VARCHAR(150),
    contenu BLOB,
    created_at DATETIME,
    users_id int,
    category_id int,
    Foreign Key (users_id) REFERENCES users_id(users_id),
    Foreign Key (category_id) REFERENCES category(category_id)
);

CREATE TABLE tags(
    tag_id INT PRIMARY KEY AUTO_INCREMENT,
    tag_name VARCHAR(10),
    created_at DATETIME
);

CREATE TABLE cours_tags(
    ids INT PRIMARY KEY AUTO_INCREMENT,
    cours_id INT,
    tags_id INT,
    Foreign Key (cours_id) REFERENCES cours(cours_id),
    Foreign Key (tags_id) REFERENCES tags(tags_id)
);