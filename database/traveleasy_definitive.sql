-- =========================================================
-- TravelEasy Definitive SQL Script (met rollen)
-- =========================================================

-- DROP EN CREATE DATABASE
DROP DATABASE IF EXISTS traveleasy;
CREATE DATABASE IF NOT EXISTS traveleasy;
USE traveleasy;

-- Users (voor Laravel auth + rollen)
CREATE TABLE IF NOT EXISTS users (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('Administrator', 'Reisadviseur', 'Financieel Medewerker', 'Manager')
        NOT NULL DEFAULT 'Reisadviseur',
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_users_name (name),
    UNIQUE KEY uq_users_email (email)
);

-- Voor Laravel password reset
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(100) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- Voor Laravel sessies
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_sessions_user_id (user_id),
    INDEX idx_sessions_last_activity (last_activity),
    CONSTRAINT fk_sessions_user
        FOREIGN KEY (user_id) REFERENCES users(Id) ON DELETE CASCADE
);

-- Klanten
CREATE TABLE IF NOT EXISTS klanten (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    naam VARCHAR(100) NOT NULL,
    adres VARCHAR(255),
    telefoon VARCHAR(20),
    geboortedatum DATE,
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_klanten_user
        FOREIGN KEY (userId) REFERENCES users(Id) ON DELETE CASCADE
);

-- Medewerkers
CREATE TABLE IF NOT EXISTS medewerkers (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    naam VARCHAR(100) NOT NULL,
    functie VARCHAR(50),
    telefoon VARCHAR(20),
    email VARCHAR(255),
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_medewerkers_user
        FOREIGN KEY (userId) REFERENCES users(Id) ON DELETE CASCADE
);

-- Reizen
CREATE TABLE IF NOT EXISTS reizen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100) NOT NULL,
    bestemming VARCHAR(100),
    startdatum DATE NOT NULL,
    einddatum DATE NOT NULL,
    prijs DECIMAL(10,2) NOT NULL,
    beschrijving TEXT,
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Accommodaties
CREATE TABLE IF NOT EXISTS accommodaties (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100) NOT NULL,
    locatie VARCHAR(100),
    type VARCHAR(50),
    prijs_per_nacht DECIMAL(10,2),
    valuta CHAR(3) DEFAULT 'EUR',
    check_in DATE,
    check_out DATE,
    kamertype VARCHAR(50),
    verzorgingstype VARCHAR(50),
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pivot tabel: Reizen ↔ Accommodaties (veel-op-veel)
CREATE TABLE IF NOT EXISTS reis_accommodatie (
    reisId INT NOT NULL,
    accommodatieId INT NOT NULL,
    PRIMARY KEY (reisId, accommodatieId),
    CONSTRAINT fk_reis_accommodatie_reis
        FOREIGN KEY (reisId) REFERENCES reizen(Id),
    CONSTRAINT fk_reis_accommodatie_accommodatie
        FOREIGN KEY (accommodatieId) REFERENCES accommodaties(Id)
);

-- Transport
CREATE TABLE IF NOT EXISTS transport (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('vliegtuig','bus','trein','boot','auto') NOT NULL,
    maatschappij VARCHAR(100),
    vertrekplaats VARCHAR(100),
    aankomstplaats VARCHAR(100),
    prijs DECIMAL(10,2),
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Verzekeringen
CREATE TABLE IF NOT EXISTS verzekeringen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100) NOT NULL,
    omschrijving TEXT,
    prijs DECIMAL(10,2),
    valuta CHAR(3) DEFAULT 'EUR',
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Boekingen
CREATE TABLE IF NOT EXISTS boekingen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    klantId INT NOT NULL,
    reisId INT NOT NULL,
    accommodatieId INT,
    transportId INT,
    verzekeringId INT,
    aantal_personen INT DEFAULT 1,
    datum_boeking DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('optie','geboekt','bevestigd','geannuleerd') DEFAULT 'optie',
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_boekingen_klant
        FOREIGN KEY (klantId) REFERENCES klanten(Id) ON DELETE CASCADE,
    CONSTRAINT fk_boekingen_reis
        FOREIGN KEY (reisId) REFERENCES reizen(Id),
    CONSTRAINT fk_boekingen_accommodatie
        FOREIGN KEY (accommodatieId) REFERENCES accommodaties(Id),
    CONSTRAINT fk_boekingen_transport
        FOREIGN KEY (transportId) REFERENCES transport(Id),
    CONSTRAINT fk_boekingen_verzekering
        FOREIGN KEY (verzekeringId) REFERENCES verzekeringen(Id)
);

-- Facturen
CREATE TABLE IF NOT EXISTS facturen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    boekingId INT NOT NULL,
    datum_factuur DATETIME DEFAULT CURRENT_TIMESTAMP,
    totaal_bedrag DECIMAL(10,2) NOT NULL,
    betaald BOOLEAN DEFAULT FALSE,
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_facturen_boeking
        FOREIGN KEY (boekingId) REFERENCES boekingen(Id) ON DELETE CASCADE
);

-- Management logs
CREATE TABLE IF NOT EXISTS management_logs (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    medewerkerId INT,
    actie VARCHAR(255) NOT NULL,
    datum_actie DATETIME DEFAULT CURRENT_TIMESTAMP,
    IsActief BOOLEAN DEFAULT TRUE,
    Opmerking VARCHAR(255),
    DatumAangemaakt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DatumGewijzigd TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_management_logs_medewerker
        FOREIGN KEY (medewerkerId) REFERENCES medewerkers(Id)
);

-- =========================================================
-- Seed users met rollen (wachtwoord voor allemaal: password)
-- Hash is bcrypt voor "password"
-- =========================================================
INSERT INTO users (name, email, role, password)
VALUES
    ('admin', 'admin@traveleasy.nl', 'Administrator', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
    ('manager', 'manager@traveleasy.nl', 'Manager', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
    ('reisadviseur', 'reisadviseur@traveleasy.nl', 'Reisadviseur', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
    ('financieel', 'financieel@traveleasy.nl', 'Financieel Medewerker', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
