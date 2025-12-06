DROP DATABASE dbQFA;
CREATE DATABASE IF NOT EXISTS dbQFA;
USE dbQFA;

CREATE TABLE IF NOT EXISTS Utilisateur
(
    login VARCHAR(30) PRIMARY KEY,
    mdp VARCHAR(30)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS Ingredient
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(30)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS Reserve
(
    numero INT AUTO_INCREMENT,
    nom VARCHAR(30),
    login VARCHAR(30),
    PRIMARY KEY (numero,login),
    FOREIGN KEY (login) REFERENCES Utilisateur(login)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS Conserver
(
    numero INT,
    login VARCHAR(30),
    idIngredient INT,
    quantite NUMERIC(7,2),
    unite VARCHAR(10),
    PRIMARY KEY (login,numero,idIngredient),
    FOREIGN KEY (login,numero) REFERENCES Reserve(login,numero),
    FOREIGN KEY (idIngredient) REFERENCES Ingredient(id)
)Engine=InnoDB;


-- INSERTION POUR LE TEST --

INSERT INTO Utilisateur (login, mdp) VALUES
('alice', 'pass123'),
('bob', 'securepass'),
('charlie', 'mdp456');

INSERT INTO Ingredient (nom) VALUES
('Carotte'),
('Pomme de terre'),
('Farine'),
('Oeuf'),
('Lait'),
('Sucre');

-- Réserves pour 'alice'
INSERT INTO Reserve (nom, login) VALUES
('Frigo principal', 'alice'),
('Congélateur cuisine', 'alice');

-- Réserves pour 'bob'
INSERT INTO Reserve (nom, login) VALUES
('Garde-manger', 'bob'),
('Cave à vin', 'bob');

INSERT INTO Conserver (login, numero, idIngredient, quantite, unite) VALUES
-- Alice - Frigo principal (numero=1)
('alice', 1, 1, 0.50, 'kg'),  -- 0.50 kg de Carotte
('alice', 1, 4, 12.00, 'pièce'), -- 12 Oeufs
('alice', 1, 5, 1.50, 'L'),   -- 1.50 L de Lait

-- Alice - Congélateur cuisine (numero=2)
('alice', 2, 2, 2.00, 'kg'),  -- 2.00 kg de Pomme de terre (dans ce cas, congelées)

-- Bob - Garde-manger (numero=3)
('bob', 3, 3, 500.00, 'g'),   -- 500 g de Farine
('bob', 3, 6, 1.00, 'kg');    -- 1.00 kg de Sucre

DROP USER 'accesUtilisateur'@'localhost';
CREATE USER 'accesUtilisateur'@'localhost';
GRANT ALL PRIVILEGES ON dbQFA.* TO 'accesUtilisateur'@'localhost';