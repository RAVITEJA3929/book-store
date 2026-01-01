USE bookstore;

CREATE TABLE IF NOT EXISTS books (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(25) NOT NULL,
    book_publisher VARCHAR(20),
    book_price FLOAT
);

INSERT INTO books (book_name, book_publisher, book_price) VALUES
('Docker Deep Dive', 'Packt Publishing', 49.99),
('Kubernetes in Action', 'Manning', 59.99),
('PHP Cookbook', 'O\'Reilly', 44.99),
('Learning MySQL', 'O\'Reilly', 39.99),
('Apache Cookbook', 'O\'Reilly', 54.99);
