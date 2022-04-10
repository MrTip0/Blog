<?php 
require './db.php';
$db = getDB();
$sql = 'CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT UNIQUE,
    name VARCHAR(50),
    username VARCHAR(50) UNIQUE,
    password CHAR(40),
    admin TINYINT,
    PRIMARY KEY (id)
);';
$db -> query($sql);

$sql = 'CREATE TABLE IF NOT EXISTS posts (
    id INT NOT NULL AUTO_INCREMENT UNIQUE,
    title VARCHAR(100),
    description TEXT,
    releasedate DATE,
    cover VARCHAR(100),
    body TEXT,
    author INT NOT NULL,
    FOREIGN KEY (author) REFERENCES users(id),
    PRIMARY KEY(title, id)
);';
$db -> query($sql);

$db -> close();
?>