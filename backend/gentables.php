<?php 
require './lib/db.php';
$db = getDB();
$sql = 'CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT UNIQUE,
    name VARCHAR(50),
    username VARCHAR(50),
    password CHAR(40),
    admin TINYINT,
    PRIMARY KEY (id)
);';
$db -> query($sql);

$sql = 'CREATE TABLE IF NOT EXISTS posts (
    link varchar(100) UNIQUE,
    title VARCHAR(100),
    description TEXT,
    releasedate DATE,
    cover VARCHAR(100),
    body TEXT,
    PRIMARY KEY(link)
);';
$db -> query($sql);
?>