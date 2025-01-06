CREATE DATABASE voiture;

USE voiture;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL
);

CREATE TABLE vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(100) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    disponibilite BOOLEAN NOT NULL DEFAULT 1,
    categorie_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    vehicule_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    lieu VARCHAR(255) NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    vehicule_id INT NOT NULL,
    commentaire TEXT NOT NULL,
    note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

INSERT INTO roles (id, nom) VALUES 
('1', 'admin'),
('2', 'client');


ALTER TABLE vehicules 
ADD COLUMN marque VARCHAR(100),
ADD COLUMN fabriquant VARCHAR(100),
ADD COLUMN source_energie VARCHAR(50),
ADD COLUMN contenance INT,
ADD COLUMN nombre_chaises INT,
ADD COLUMN vitesses_max INT,
ADD COLUMN transmission VARCHAR(50),
ADD COLUMN acceleration FLOAT,
ADD COLUMN annee INT(11) NOT NULL,
ADD COLUMN puissance_moteur INT;



INSERT INTO categories (nom, description) VALUES
('SUV', 'Véhicules utilitaires sport, adaptés pour la conduite hors route'),
('Berline', 'Véhicules confortables pour la conduite sur route'),
('Coupé', 'Véhicules compacts avec un design sportif'),
('Camion', 'Véhicules pour le transport de marchandises'),
('Monospace', 'Véhicules spacieux pour les familles et les groupes');



INSERT INTO vehicules (modele, prix, disponibilite, categorie_id, image_path, marque, fabriquant, source_energie, contenance, nombre_chaises, vitesses_max, transmission, acceleration, annee, puissance_moteur) VALUES
('JK2018', 20000.00, 1, 2, 'images_voitures/1.jpg', 'TOYOTA', 'TOYOTA', 'Essence', 190, 2, '180', 'Manuel', 3.4, 2018, 200),
('LAND CRUISER', 35000.00, 1, 2, 'images_voitures/3.jpg', 'TOYOTA', 'TOYOTA', 'Gaz-oil', 220, 7, '230', 'Manuel', 4.2, 2018, 250),
('KJ451', 500000.00, 1, 4, 'images_voitures/4.jpg', 'BUGATTI', 'BUGATTI', 'Essence', 60, 2, '310', 'Automatique', 3.6, 2018, 350),
('KL45', 25000.00, 1, 2, 'images_voitures/6.jpg', 'HONDA', 'HONDA', 'Gaz-oil', 225, 2, '250', 'Manuel', 3.5, 2018, 400),
('KL54', 20000.00, 1, 3, 'images_voitures/8.jpg', 'MITSUBISHI', 'MITSUBISHI', 'Gaz-oil', 75, 5, '198', 'Manuel', 5.2, 2018, 250),
('DS45', 23000.00, 1, 3, 'images_voitures/9.jpg', 'HYUNDAI', 'HYUNDAI', 'Essence', 75, 5, '220', 'Automatique', 5.1, 2018, 500),
('CHEVROLET', 28000.00, 1, 2, 'images_voitures/10.jpg', 'CAMARO', 'CHEVROLET', 'Essence', 65, 2, '305', 'Automatique', 3.1, 2018, 350),
('UYG45', 19000.00, 1, 2, 'images_voitures/11.jpg', 'TOYOTA', 'TOYOTA', 'Essence', 175, 6, '185', 'Manuel', 5.6, 2018, 200),
('TUNDRA', 40000.00, 1, 2, 'images_voitures/12.jpg', 'TUNDRA', 'TUNDRA', 'Gaz-oil', 200, 5, '185', 'Automatique', 5.6, 2018, 200),
('FR2019', 90000.00, 1, 4, 'images_voitures/13.jpg', 'FERRARI', 'FERRARI', 'Essence', 50, 3, '360', 'Automatique', 2.5, 2019, 350),
('KL45', 24000.00, 1, 3, 'images_voitures/14.jpg', 'VOLVO', 'VOLVO', 'Essence', 180, 5, '220', 'Automatique', 3.5, 2018, 400),
('luigefe54', 12000.00, 1, 5, 'images_voitures/15.jpg', 'GENERIC', 'GENERIC', 'Essence', 150, 5, '180', 'Manuel', 3.4, 2018, 45);




CREATE PROCEDURE AjouterReservation(
    IN p_utilisateur_id INT,
    IN p_vehicule_id INT,
    IN p_date_debut DATE,
    IN p_date_fin DATE,
    IN p_lieu VARCHAR(255)
)
BEGIN

    INSERT INTO reservations (utilisateur_id, vehicule_id, date_debut, date_fin, lieu)
    VALUES (p_utilisateur_id, p_vehicule_id, p_date_debut, p_date_fin, p_lieu);
    
    
    UPDATE vehicules
    SET disponibilite = 0  
    WHERE id = p_vehicule_id;

END


CREATE VIEW ListeVehicules AS
SELECT 
    v.id,
    v.modele,
    v.prix,
    v.disponibilite,
    v.categorie_id,
    v.image_path,
    v.marque,
    v.fabriquant,
    v.source_energie,
    v.contenance,
    v.nombre_chaises,
    v.vitesses_max,
    v.transmission,
    v.acceleration,
    v.puissance_moteur,
    v.annee,
    c.nom AS categorie_nom,  -- Nom de la catégorie
    e.note AS evaluation_note  -- Note d'évaluation
FROM 
    vehicules v
LEFT JOIN 
    categories c ON v.categorie_id = c.id
LEFT JOIN 
    evaluations e ON v.id = e.vehicule_id;
