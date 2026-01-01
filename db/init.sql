USE bookstore;

CREATE TABLE IF NOT EXISTS books (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(100) NOT NULL,
    book_publisher VARCHAR(50),
    book_price DECIMAL(10,2),
    book_author VARCHAR(100) DEFAULT 'Unknown',
    book_rating TINYINT(1) DEFAULT 5 CHECK (book_rating BETWEEN 1 AND 5),
    book_genre VARCHAR(50) DEFAULT '',
    book_year VARCHAR(10) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (book_name),
    INDEX idx_author (book_author),
    INDEX idx_genre (book_genre)
);

-- Sample data with ALL fields
INSERT IGNORE INTO books (book_name, book_publisher, book_price, book_author, book_rating, book_genre, book_year) VALUES
('Docker Mastery', 'Bret Fisher', 39.99, 'Bret Fisher', 5, 'DevOps', '2024'),
('Kubernetes Up & Running', 'OReilly', 49.99, 'Kelsey Hightower', 5, 'Cloud', '2023'),
('PHP The Right Way', 'PHP Community', 0.00, 'PHP Team', 4, 'PHP', '2024'),
('MySQL High Performance', 'OReilly', 44.99, 'Baron Schwartz', 4, 'Database', '2022'),
('Apache HTTP Server Cookbook', 'OReilly', 49.99, 'Rich Bowen', 4, 'Web Server', '2023');
