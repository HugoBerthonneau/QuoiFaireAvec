DROP DATABASE dbQFA;
CREATE DATABASE IF NOT EXISTS dbQFA;
USE dbQFA;

CREATE TABLE IF NOT EXISTS Utilisateur
(
    login VARCHAR(30) PRIMARY KEY,
    mdp VARCHAR(150),
    token VARCHAR(300)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS Ingredient
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(30),
    unite VARCHAR(10)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS Reserve
(
    numero INT,
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
    PRIMARY KEY (login,numero,idIngredient),
    FOREIGN KEY (login,numero) REFERENCES Reserve(login,numero),
    FOREIGN KEY (idIngredient) REFERENCES Ingredient(id)
)Engine=InnoDB;


-- INSERTION POUR LE TEST

INSERT INTO Utilisateur (login, mdp,token) VALUES
('jean.dupont', '$2y$12$YkWcnX7Q17T2cNCMLx9jKOtUF/1AvDwycX7XYJzppdB7QCCg3G8QS',''), -- P@ssword1
('marie.curie', '$2y$12$NsyXUv9pL05Q2cvb7/jX2.dyli7CL8dNdDtcEWz4qJj6aUegE8BXq',''), -- Radium2024
('albert.ein', '$2y$12$8kA/EPzC3SPzr0yuK0lfSOk8RI0mG2eXEYIvDMQtY9HdgfX6ZmlMy','') -- Relativite
;

INSERT INTO Ingredient (nom, unite) VALUES
('Carotte', 'g'),
('Oeuf', 'unité'),
('Farine', 'kg'),
('Lait', 'L'),
('Sucre', 'g');

-- Pour jean.dupont
INSERT INTO Reserve (numero, nom, login) VALUES
(1, 'Réfrigérateur', 'jean.dupont'),
(2, 'Garde-manger', 'jean.dupont'),
(3, 'Congélateur', 'jean.dupont');

-- Pour marie.curie
INSERT INTO Reserve (numero, nom, login) VALUES
(1, 'Cave', 'marie.curie');

INSERT INTO Conserver (numero, login, idIngredient, quantite) VALUES
-- Jean Dupont a 500g de Carotte dans son Réfrigérateur (1)
(1, 'jean.dupont', 1, 500.00),
-- Jean Dupont a 1.50kg de Farine dans son Garde-manger (2)
(2, 'jean.dupont', 3, 1.50),
-- Jean Dupont a 1.00L de Lait dans son Réfrigérateur (1)
(1, 'jean.dupont', 4, 1.00),
-- Marie Curie a 12 unités d'Oeuf dans sa Cave (1)
(1, 'marie.curie', 2, 12.00);

-- utilisateurs et droits

DROP USER 'accesUtilisateur'@'localhost';
CREATE USER 'accesUtilisateur'@'localhost';
GRANT ALL PRIVILEGES ON dbQFA.* TO 'accesUtilisateur'@'localhost';

-- TRIGGERS

DELIMITER $

CREATE TRIGGER suppressionIngredientConserver BEFORE DELETE ON Ingredient
FOR EACH ROW
BEGIN
    DELETE FROM Conserver WHERE idIngredient = OLD.id;
END$

CREATE TRIGGER suppressionReserveConserver BEFORE DELETE ON Reserve
FOR EACH ROW
BEGIN
    DELETE FROM Conserver WHERE numero = OLD.numero AND login = OLD.login;
END$