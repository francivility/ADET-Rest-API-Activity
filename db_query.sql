CREATE DATABASE IF NOT EXISTS zenfit_db;
USE zenfit_db;

CREATE TABLE IF NOT EXISTS applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    membership_type VARCHAR(20) NOT NULL,
    price INT NOT NULL,
    created_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO applicants (id, fullname, email, membership_type, price, created_date, created_at) VALUES
(1, 'Test Member', 'test@example.com', 'Premium', 500.00, '2026-05-17', '2026-04-17 06:56:51'),
(2, 'John Smith', 'john@test.com', 'Standard', 500.00, '2026-05-02', '2026-04-17 06:56:51'),
(7, 'Ian Raphael Bonaobra', 'ian@gmail.com', 'Premium', 500.00, '2026-05-17', '2026-04-17 07:26:58'),
(10, 'Ane Christel Barrameda', 'ane@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:29:12'),
(12, 'France Mhary Jasareno', 'france@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:29:31'),
(13, 'Nicole Dimple Martinez', 'nics@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:32:55'),
(15, 'Daryl James Borjal', 'daryl@gmail.com', 'Premium', 500.00, '2026-05-17', '2026-04-17 07:33:16'),
(17, 'Juan De Luna', 'deluna@gmail.com', 'Standard', 500.00, '2026-05-17', '2026-04-17 07:40:31');
