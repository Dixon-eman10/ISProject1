-- database.sql for ISProject1

CREATE DATABASE IF NOT EXISTS isproject1_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE isproject1_db;

-- Users table storing role-based accounts and password hashes
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Login logs table tracking successful and failed authentication attempts
CREATE TABLE IF NOT EXISTS login_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    email_attempted VARCHAR(150) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    status ENUM('success', 'failed') NOT NULL,
    logged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;