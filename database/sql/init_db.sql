DROP DATABASE IF EXISTS kenshu_php_sql;
CREATE DATABASE kenshu_php_sql;
USE kenshu_php_sql;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
   	user_password VARCHAR(255) NOT NULL,
    UNIQUE (email)
);

CREATE TABLE tags (
	id INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(255) NOT NULL,
    UNIQUE (tag_name)
);

CREATE TABLE articles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE article_tag (
	article_id INT NOT NULL,
    tag_id INT NOT NULL,
    CONSTRAINT PK_article_tag PRIMARY KEY (article_id,tag_id),
    FOREIGN KEY (article_id) REFERENCES articles(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);

CREATE TABLE images (
	id INT AUTO_INCREMENT PRIMARY KEY,
    image TEXT NOT NULL,
    is_thumbnail BOOLEAN,
    article_id INT,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);
