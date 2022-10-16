CREATE TABLE `db_blog`
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE `user`
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL,
    created_at TIMESTAMP,
    username VARCHAR(255) NOT NULL
);

CREATE TABLE `post`
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    content varchar(255),
    created_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES `user`(id)
);

