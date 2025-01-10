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



CREATE TABLE themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    image_path VARCHAR(100)
);


CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    image_path VARCHAR(255),
    video_path VARCHAR(255),
    theme_id INT,
    utilisateur_id INT,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    est_approuve BOOLEAN DEFAULT 0,
    FOREIGN KEY (theme_id) REFERENCES themes(id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE article_tags (
    article_id INT,
    tag_id INT,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES articles(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);


CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    contenu TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);


CREATE TABLE favoris (
    utilisateur_id INT,
    article_id INT,
    PRIMARY KEY (utilisateur_id, article_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
    FOREIGN KEY (article_id) REFERENCES articles(id)
);


-- Insérer des thèmes
INSERT INTO themes (nom, image_path, description) VALUES ('SUV', 'images_voitures/suv.jpg', 'Véhicules utilitaires sport, adaptés pour la conduite hors route'), ('Berline', 'images_voitures/berline.jpg', 'Véhicules confortables pour la conduite sur route'), ('Coupé', 'images_voitures/coupe.jpg', 'Véhicules compacts avec un design sportif'), ('Camion', 'images_voitures/camion.png', 'Véhicules pour le transport de marchandises'), ('Monospace', 'images_voitures/monospace.png', 'Véhicules spacieux pour les familles et les groupes');

-- Insérer des tags
INSERT INTO tags (nom) VALUES
('SUV'), ('Électrique'), ('Compacte'), ('Essence'), ('Sécurité');

-- Insérer des articles
INSERT INTO articles (titre, contenu, image_path, video_path, theme_id, utilisateur_id, est_approuve) 
VALUES 
('Le SUV idéal pour la famille', 
 'Découvrez les meilleurs SUV offrant confort et sécurité pour vos voyages en famille.', 
 'images_voitures/suv_famille.png', 
 NULL, 
 12,  
 4,  
 1),
 ('SUV hybride : le futur des véhicules tout-terrain', 
 'Les SUV hybrides allient puissance et respect de l’environnement pour une conduite optimale.', 
 'images_voitures/suv_hybride.png', 
 NULL, 
 12,  
 5,  
 1),
 ('Confort et élégance : les meilleures berlines de 2025', 
 'Un guide pour choisir une berline qui allie luxe et performance.', 
 'images_voitures/berline_confort.png', 
 NULL, 
 13,  
 4,  
 1),
 ('Pourquoi choisir une berline électrique ?', 
 'Les avantages des berlines électriques : autonomie, économie et silence.', 
 'images_voitures/berline_electrique.png', 
 NULL, 
 13,  
 5,  
 1),
 ('Les coupés sportifs les plus prisés de cette année', 
 'Un aperçu des modèles coupés qui dominent le marché automobile.', 
 'images_voitures/coupe_sport.png', 
 NULL, 
 14,  
 6,  
 1),
('Design et performance : tout savoir sur les coupés modernes', 
 'Les caractéristiques des coupés modernes qui en font des véhicules d’exception.', 
 'images_voitures/coupe_design.png', 
 NULL, 
 14,  
 4,  
 1),
 ('Les meilleurs camions pour le transport lourd', 
 'Découvrez les camions les plus fiables et performants pour le transport de marchandises.', 
 'images_voitures/camion_transport.png', 
 NULL, 
 15,  
 5,  
 1),
('Innovation dans les camions électriques', 
 'Les camions électriques révolutionnent le secteur du transport.', 
 'images_voitures/camion_electrique.png', 
 NULL, 
 15,  
 6,  
 1),
 ('Monospace : le véhicule parfait pour les grandes familles', 
 'Les monospaces offrent espace et confort pour tous vos trajets en famille.', 
 'images_voitures/monospace_famille.png', 
 NULL, 
 16,  
 4,  
 1),
('Comparatif des meilleurs monospaces 2025', 
 'Un guide complet pour choisir le monospace qui répond à vos besoins.', 
 'images_voitures/monospace_comparatif.png', 
 NULL, 
 16,  
 5,  
 1);


-- Associer des tags aux articles
INSERT INTO article_tags (article_id, tag_id) VALUES
(1, 1), (1, 2), (2, 4), (2, 5);

-- Ajouter des commentaires
INSERT INTO commentaires (article_id, utilisateur_id, contenu) VALUES
(1, 3, 'Article très intéressant, merci pour les infos !'),
(2, 2, 'Merci pour ces conseils utiles.');

