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

-- Légumes
INSERT INTO Ingredient (nom, unite) VALUES
('Tomate', 'g'),
('Oignon', 'g'),
('Ail', 'g'),
('Poivron rouge', 'g'),
('Poivron vert', 'g'),
('Courgette', 'g'),
('Aubergine', 'g'),
('Pomme de terre', 'g'),
('Patate douce', 'g'),
('Brocoli', 'g'),
('Chou-fleur', 'g'),
('Chou', 'g'),
('Épinard', 'g'),
('Salade verte', 'g'),
('Concombre', 'g'),
('Champignon', 'g'),
('Poireau', 'g'),
('Céleri', 'g'),
('Betterave', 'g'),
('Radis', 'g'),
('Haricot vert', 'g'),
('Petit pois', 'g'),
('Maïs', 'g'),
('Asperge', 'g'),
('Artichaut', 'g'),
('Potiron', 'g'),
('Courge butternut', 'g');

-- Fruits
INSERT INTO Ingredient (nom, unite) VALUES
('Pomme', 'u'),
('Poire', 'u'),
('Banane', 'u'),
('Orange', 'u'),
('Citron', 'u'),
('Citron vert', 'u'),
('Fraise', 'g'),
('Framboise', 'g'),
('Myrtille', 'g'),
('Mûre', 'g'),
('Raisin', 'g'),
('Cerise', 'g'),
('Pêche', 'u'),
('Abricot', 'u'),
('Prune', 'u'),
('Kiwi', 'u'),
('Mangue', 'u'),
('Ananas', 'u'),
('Melon', 'g'),
('Pastèque', 'g'),
('Avocat', 'u');

-- Viandes
INSERT INTO Ingredient (nom, unite) VALUES
('Poulet', 'g'),
('Dinde', 'g'),
('Bœuf', 'g'),
('Veau', 'g'),
('Porc', 'g'),
('Agneau', 'g'),
('Canard', 'g'),
('Lapin', 'g'),
('Jambon', 'g'),
('Lardons', 'g'),
('Saucisse', 'g'),
('Merguez', 'g'),
('Steak haché', 'g');

-- Poissons et fruits de mer
INSERT INTO Ingredient (nom, unite) VALUES
('Saumon', 'g'),
('Thon', 'g'),
('Cabillaud', 'g'),
('Dorade', 'g'),
('Bar', 'g'),
('Truite', 'g'),
('Sole', 'g'),
('Crevette', 'g'),
('Moule', 'g'),
('Huître', 'u'),
('Calamar', 'g'),
('Saint-Jacques', 'u'),
('Crabe', 'g'),
('Homard', 'g');

-- Produits laitiers
INSERT INTO Ingredient (nom, unite) VALUES
('Beurre', 'g'),
('Crème fraîche', 'mL'),
('Yaourt nature', 'g'),
('Fromage blanc', 'g'),
('Gruyère', 'g'),
('Parmesan', 'g'),
('Mozzarella', 'g'),
('Chèvre', 'g'),
('Roquefort', 'g'),
('Camembert', 'g'),
('Brie', 'g'),
('Emmental', 'g'),
('Comté', 'g'),
('Mascarpone', 'g'),
('Ricotta', 'g');

-- Féculents et céréales
INSERT INTO Ingredient (nom, unite) VALUES
('Riz blanc', 'g'),
('Riz complet', 'g'),
('Pâtes', 'g'),
('Spaghetti', 'g'),
('Tagliatelles', 'g'),
('Penne', 'g'),
('Couscous', 'g'),
('Quinoa', 'g'),
('Boulgour', 'g'),
('Pain', 'g'),
('Pain de mie', 'tranche'),
('Baguette', 'g'),
('Semoule', 'g'),
('Polenta', 'g');

-- Légumineuses
INSERT INTO Ingredient (nom, unite) VALUES
('Lentilles vertes', 'g'),
('Lentilles corail', 'g'),
('Pois chiche', 'g'),
('Haricot rouge', 'g'),
('Haricot blanc', 'g'),
('Flageolet', 'g');

-- Huiles et condiments
INSERT INTO Ingredient (nom, unite) VALUES
('Huile d\'olive', 'mL'),
('Huile de tournesol', 'mL'),
('Huile de noix', 'mL'),
('Vinaigre balsamique', 'mL'),
('Vinaigre de vin', 'mL'),
('Moutarde', 'g'),
('Mayonnaise', 'g'),
('Ketchup', 'g'),
('Sauce soja', 'mL'),
('Sauce tomate', 'g'),
('Concentré de tomate', 'g'),
('Fond de veau', 'mL'),
('Bouillon de légumes', 'mL'),
('Bouillon de poulet', 'mL');

-- Épices et herbes
INSERT INTO Ingredient (nom, unite) VALUES
('Sel', 'g'),
('Poivre noir', 'g'),
('Paprika', 'g'),
('Cumin', 'g'),
('Curry', 'g'),
('Curcuma', 'g'),
('Gingembre', 'g'),
('Cannelle', 'g'),
('Muscade', 'g'),
('Thym', 'g'),
('Romarin', 'g'),
('Basilic', 'g'),
('Persil', 'g'),
('Coriandre', 'g'),
('Menthe', 'g'),
('Origan', 'g'),
('Laurier', 'feuille'),
('Herbes de Provence', 'g');

-- Produits sucrés
INSERT INTO Ingredient (nom, unite) VALUES
('Sucre en poudre', 'g'),
('Sucre glace', 'g'),
('Cassonade', 'g'),
('Miel', 'g'),
('Sirop d\'érable', 'mL'),
('Confiture', 'g'),
('Chocolat noir', 'g'),
('Chocolat au lait', 'g'),
('Chocolat blanc', 'g'),
('Cacao en poudre', 'g'),
('Pépites de chocolat', 'g'),
('Vanille', 'gousse'),
('Extrait de vanille', 'mL');

-- Produits de boulangerie
INSERT INTO Ingredient (nom, unite) VALUES
('Farine complète', 'g'),
('Fécule de maïs', 'g'),
('Levure chimique', 'g'),
('Levure de boulanger', 'g'),
('Bicarbonate', 'g');

-- Fruits secs et oléagineux
INSERT INTO Ingredient (nom, unite) VALUES
('Amande', 'g'),
('Noisette', 'g'),
('Noix', 'g'),
('Noix de cajou', 'g'),
('Pistache', 'g'),
('Pignon de pin', 'g'),
('Raisin sec', 'g'),
('Abricot sec', 'g'),
('Datte', 'g'),
('Figue sèche', 'g'),
('Pruneau', 'g'),
('Noix de coco râpée', 'g');

-- Boissons et liquides
INSERT INTO Ingredient (nom, unite) VALUES
('Eau', 'mL'),
('Vin blanc', 'mL'),
('Vin rouge', 'mL'),
('Bière', 'mL'),
('Cognac', 'mL'),
('Rhum', 'mL'),
('Café', 'mL'),
('Thé', 'mL'),
('Lait de coco', 'mL'),
('Crème de coco', 'mL');

-- Autres
INSERT INTO Ingredient (nom, unite) VALUES
('Tofu', 'g'),
('Tempeh', 'g'),
('Seitan', 'g'),
('Algue nori', 'feuille'),
('Wasabi', 'g'),
('Gingembre mariné', 'g'),
('Câpre', 'g'),
('Olive verte', 'g'),
('Olive noire', 'g'),
('Cornichon', 'g'),
('Anchois', 'g'),
('Parmesan râpé', 'g');

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
-- Marie Curie a 12 us d'Oeuf dans sa Cave (1)
(1, 'marie.curie', 2, 12.00);



-- Insertions dans Conserver pour marie.curie
-- Rappel : marie.curie a une seule réserve : Cave (numero = 1)

INSERT INTO Conserver (numero, login, idIngredient, quantite) VALUES
-- Légumes (Cave)
(1, 'marie.curie', 1, 800.00),  -- Carotte 800g
(1, 'marie.curie', 6, 450.00),  -- Tomate 450g
(1, 'marie.curie', 7, 300.00),  -- Oignon 300g
(1, 'marie.curie', 8, 50.00),   -- Ail 50g
(1, 'marie.curie', 9, 200.00),  -- Poivron rouge 200g
(1, 'marie.curie', 11, 350.00), -- Courgette 350g
(1, 'marie.curie', 13, 600.00), -- Pomme de terre 600g
(1, 'marie.curie', 16, 250.00), -- Brocoli 250g
(1, 'marie.curie', 20, 180.00), -- Concombre 180g
(1, 'marie.curie', 21, 200.00), -- Champignon 200g

-- Fruits (Cave)
(1, 'marie.curie', 34, 4.00),   -- Pomme 4 us
(1, 'marie.curie', 35, 3.00),   -- Poire 3 us
(1, 'marie.curie', 36, 6.00),   -- Banane 6 us
(1, 'marie.curie', 37, 5.00),   -- Orange 5 us
(1, 'marie.curie', 38, 2.00),   -- Citron 2 us
(1, 'marie.curie', 40, 300.00), -- Fraise 300g
(1, 'marie.curie', 55, 1.00),   -- Avocat 1 u

-- Viandes (Cave - conservées)
(1, 'marie.curie', 56, 500.00), -- Poulet 500g
(1, 'marie.curie', 58, 400.00), -- Bœuf 400g
(1, 'marie.curie', 65, 250.00), -- Jambon 250g
(1, 'marie.curie', 66, 150.00), -- Lardons 150g

-- Poissons (Cave)
(1, 'marie.curie', 70, 300.00), -- Saumon 300g
(1, 'marie.curie', 71, 250.00), -- Thon 250g
(1, 'marie.curie', 75, 200.00), -- Truite 200g

-- Produits laitiers (Cave)
(1, 'marie.curie', 4, 2.00),    -- Lait 2L
(1, 'marie.curie', 84, 250.00), -- Beurre 250g
(1, 'marie.curie', 85, 500.00), -- Crème fraîche 500mL
(1, 'marie.curie', 86, 400.00), -- Yaourt nature 400g
(1, 'marie.curie', 87, 300.00), -- Fromage blanc 300g
(1, 'marie.curie', 88, 200.00), -- Gruyère 200g
(1, 'marie.curie', 89, 150.00), -- Parmesan 150g
(1, 'marie.curie', 90, 250.00), -- Mozzarella 250g

-- Féculents et céréales (Cave)
(1, 'marie.curie', 3, 2.00),    -- Farine 2kg
(1, 'marie.curie', 99, 1.00),   -- Riz blanc 1kg
(1, 'marie.curie', 100, 500.00),-- Riz complet 500g
(1, 'marie.curie', 101, 800.00),-- Pâtes 800g
(1, 'marie.curie', 102, 500.00),-- Spaghetti 500g
(1, 'marie.curie', 105, 400.00),-- Couscous 400g
(1, 'marie.curie', 106, 300.00),-- Quinoa 300g
(1, 'marie.curie', 109, 500.00),-- Pain 500g

-- Légumineuses (Cave)
(1, 'marie.curie', 113, 600.00),-- Lentilles vertes 600g
(1, 'marie.curie', 114, 400.00),-- Lentilles corail 400g
(1, 'marie.curie', 115, 500.00),-- Pois chiche 500g
(1, 'marie.curie', 116, 300.00),-- Haricot rouge 300g

-- Huiles et condiments (Cave)
(1, 'marie.curie', 119, 750.00), -- Huile d'olive 750mL
(1, 'marie.curie', 120, 500.00), -- Huile de tournesol 500mL
(1, 'marie.curie', 122, 250.00), -- Vinaigre balsamique 250mL
(1, 'marie.curie', 123, 300.00), -- Vinaigre de vin 300mL
(1, 'marie.curie', 124, 200.00), -- Moutarde 200g
(1, 'marie.curie', 126, 300.00), -- Ketchup 300g
(1, 'marie.curie', 127, 200.00), -- Sauce soja 200mL
(1, 'marie.curie', 128, 400.00), -- Sauce tomate 400g
(1, 'marie.curie', 129, 150.00), -- Concentré de tomate 150g

-- Épices et herbes (Cave)
(1, 'marie.curie', 133, 1000.00), -- Sel 1kg
(1, 'marie.curie', 134, 100.00),  -- Poivre noir 100g
(1, 'marie.curie', 135, 50.00),   -- Paprika 50g
(1, 'marie.curie', 136, 40.00),   -- Cumin 40g
(1, 'marie.curie', 137, 60.00),   -- Curry 60g
(1, 'marie.curie', 138, 30.00),   -- Curcuma 30g
(1, 'marie.curie', 139, 50.00),   -- Gingembre 50g
(1, 'marie.curie', 140, 40.00),   -- Cannelle 40g
(1, 'marie.curie', 142, 30.00),   -- Thym 30g
(1, 'marie.curie', 143, 25.00),   -- Romarin 25g
(1, 'marie.curie', 144, 20.00),   -- Basilic 20g
(1, 'marie.curie', 145, 30.00),   -- Persil 30g
(1, 'marie.curie', 149, 15.00),   -- Origan 15g
(1, 'marie.curie', 150, 10.00),   -- Herbes de Provence 10g

-- Produits sucrés (Cave)
(1, 'marie.curie', 5, 1000.00),   -- Sucre 1kg
(1, 'marie.curie', 151, 500.00),  -- Sucre en poudre 500g
(1, 'marie.curie', 152, 250.00),  -- Sucre glace 250g
(1, 'marie.curie', 154, 300.00),  -- Miel 300g
(1, 'marie.curie', 156, 400.00),  -- Confiture 400g
(1, 'marie.curie', 157, 200.00),  -- Chocolat noir 200g
(1, 'marie.curie', 159, 150.00),  -- Chocolat blanc 150g
(1, 'marie.curie', 160, 100.00),  -- Cacao en poudre 100g

-- Produits de boulangerie (Cave)
(1, 'marie.curie', 165, 500.00),  -- Farine complète 500g
(1, 'marie.curie', 166, 200.00),  -- Fécule de maïs 200g
(1, 'marie.curie', 167, 50.00),   -- Levure chimique 50g
(1, 'marie.curie', 168, 30.00),   -- Levure de boulanger 30g

-- Fruits secs et oléagineux (Cave)
(1, 'marie.curie', 170, 250.00),  -- Amande 250g
(1, 'marie.curie', 171, 200.00),  -- Noisette 200g
(1, 'marie.curie', 172, 180.00),  -- Noix 180g
(1, 'marie.curie', 174, 150.00),  -- Pistache 150g
(1, 'marie.curie', 176, 200.00),  -- Raisin sec 200g
(1, 'marie.curie', 178, 150.00),  -- Datte 150g

-- Boissons et liquides (Cave)
(1, 'marie.curie', 182, 2000.00), -- Eau 2L
(1, 'marie.curie', 183, 750.00),  -- Vin blanc 750mL
(1, 'marie.curie', 184, 750.00),  -- Vin rouge 750mL
(1, 'marie.curie', 188, 100.00),  -- Café 100mL
(1, 'marie.curie', 190, 400.00);  -- Lait de coco 400mL
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