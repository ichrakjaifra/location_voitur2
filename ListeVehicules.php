<?php
class ListeVehicules {

    private $vehicules = []; // Liste des véhicules, initialement vide

    // Constructeur pour initialiser la liste de véhicules
    public function __construct($vehicules = []) {
        $this->vehicules = $vehicules;
    }

    // Méthode pour ajouter un véhicule à la liste
    public function ajouterVehicule($vehicule) {
        $this->vehicules[] = $vehicule;
    }

    // Méthode pour rechercher un véhicule par modèle ou caractéristiques
    public function rechercherVehicule($modele, $caracteristiques) {
        $resultats = [];
        
        foreach ($this->vehicules as $vehicule) {
            if (stripos($vehicule->getModele(), $modele) !== false || 
                stripos($vehicule->getDescription(), $caracteristiques) !== false) {
                $resultats[] = $vehicule;
            }
        }

        return $resultats;
    }

    // Méthode pour filtrer les véhicules par catégorie
    public function filtrerParCategorie($categorie) {
        $resultats = [];

        foreach ($this->vehicules as $vehicule) {
            if ($vehicule->getCategorieId() === $categorie->getId()) {
                $resultats[] = $vehicule;
            }
        }

        return $resultats;
    }

    // Méthode pour paginer les véhicules
    public function paginer($page, $taille) {
        $resultats = [];
        $start = ($page - 1) * $taille; // Calcul de l'index de départ
        $fin = $start + $taille; // Index de fin

        // Retourner les véhicules correspondant à la page demandée
        for ($i = $start; $i < $fin && $i < count($this->vehicules); $i++) {
            $resultats[] = $this->vehicules[$i];
        }

        return $resultats;
    }

    // Méthode pour obtenir le nombre total de pages
    public function getNombreDePages($taille) {
        return ceil(count($this->vehicules) / $taille);
    }
}
?>
