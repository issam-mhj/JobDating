CREATE TYPE role AS ENUM ('user', 'admin');

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role role NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE companies (
    id SERIAL PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE announcements (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date TIMESTAMP NOT NULL,
    location VARCHAR(255) NOT NULL,
    company_id INT REFERENCES companies(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_announcements_company_id ON announcements(company_id);

ALTER TABLE announcements ADD COLUMN deleted_at TIMESTAMP NULL;

CREATE INDEX idx_announcements_deleted_at ON announcements(deleted_at);


INSERT INTO companies (company_name, details) VALUES
('OCP Group', 'A leading Moroccan phosphate mining and fertilizer production company.'),
('Attijariwafa Bank', 'One of the largest banking groups in Morocco and Africa.'),
('Maroc Telecom', 'The largest telecommunications company in Morocco.'),
('ONEE', 'National Office for Electricity and Drinking Water, managing utilities in Morocco.'),
('Royal Air Maroc', 'The national airline of Morocco, offering domestic and international flights.'),
('Yazaki Morocco', 'A major automotive components manufacturer operating in Morocco.'),
('Cosumar', 'A leading Moroccan company specializing in sugar production and refining.'),
('Managem', 'A Moroccan mining group focused on extracting and processing precious metals.'),
('Saham Assurance', 'A prominent insurance company offering a wide range of services in Morocco.'),
('Marjane Holding', 'A large retail and distribution group operating supermarkets and hypermarkets in Morocco.');