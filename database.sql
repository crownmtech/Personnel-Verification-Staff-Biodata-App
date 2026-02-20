CREATE DATABASE IF NOT EXISTS staff_biodata CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE staff_biodata;

CREATE TABLE IF NOT EXISTS staff (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    other_name VARCHAR(100) DEFAULT NULL,
    date_of_birth DATE NOT NULL,
    sex ENUM('M','F') NOT NULL,
    marital_status VARCHAR(50) NOT NULL,

    state_of_origin VARCHAR(100) NOT NULL,
    lga_origin VARCHAR(100) NOT NULL,
    state_of_origin_address VARCHAR(255) NOT NULL,

    state_of_residence VARCHAR(100) NOT NULL,
    lga_residence VARCHAR(100) NOT NULL,
    residential_address VARCHAR(255) NOT NULL,

    phone VARCHAR(30) NOT NULL,
    email VARCHAR(150) NOT NULL,

    psn_no VARCHAR(100) NOT NULL,
    file_no VARCHAR(100) NOT NULL,
    rank_position VARCHAR(150) NOT NULL,
    date_of_first_appointment DATE NOT NULL,
    gl_level VARCHAR(50) NOT NULL,
    step_level VARCHAR(50) NOT NULL,
    salary_structure VARCHAR(150) NOT NULL,
    cadre VARCHAR(150) NOT NULL,

    bank_name VARCHAR(150) NOT NULL,
    account_number VARCHAR(20) NOT NULL,
    bvn VARCHAR(20) NOT NULL,
    nin VARCHAR(20) NOT NULL,

    passport_path VARCHAR(255) NOT NULL,
    fingerprint_path VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
