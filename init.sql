CREATE DATABASE prescription_app;
USE prescription_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    address TEXT,
    contact VARCHAR(20),
    dob DATE
);

CREATE TABLE prescriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    note TEXT,
    delivery_address TEXT,
    delivery_time_slot VARCHAR(50),
    images TEXT, -- at least 5 images
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE quotations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prescription_id INT,
    items TEXT, -- ex: [{"drug": "Paracetamol", "qty": 5, "price": 10}]
    total DECIMAL(10,2),
    status ENUM('sent', 'accepted', 'rejected') DEFAULT 'sent' -- staus
);

-- text should be json type data