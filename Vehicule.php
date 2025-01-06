<?php
class Vehicule {
  private $id;
  private $modele;
  private $prix;
  private $disponibilite;
  private $categorieId;
  private $imagePath;
  private $marque;
  private $fabriquant;
  private $sourceEnergie;
  private $contenance;
  private $nombreChaises;
  private $vitessesMax;
  private $transmission;
  private $acceleration;
  private $puissanceMoteur;
  private $annee;

  public function __construct(
      $id, $modele, $prix, $disponibilite, $categorieId, $imagePath,
      $marque, $fabriquant, $sourceEnergie, $contenance, 
      $nombreChaises, $vitessesMax, $transmission, $acceleration, $puissanceMoteur, $annee
  ) {
      $this->id = $id;
      $this->modele = $modele;
      $this->prix = $prix;
      $this->disponibilite = $disponibilite;
      $this->categorieId = $categorieId;
      $this->imagePath = $imagePath;
      $this->marque = $marque;
      $this->fabriquant = $fabriquant;
      $this->sourceEnergie = $sourceEnergie;
      $this->contenance = $contenance;
      $this->nombreChaises = $nombreChaises;
      $this->vitessesMax = $vitessesMax;
      $this->transmission = $transmission;
      $this->acceleration = $acceleration;
      $this->puissanceMoteur = $puissanceMoteur;
      $this->annee = $annee;
  }

  // Getters pour tous les attributs
  public function getId() { return $this->id; }
  public function getModele() { return $this->modele; }
  public function getPrix() { return $this->prix; }
  public function getDisponibilite() { return $this->disponibilite; }
  public function getCategorieId() { return $this->categorieId; }
  public function getImagePath() { return $this->imagePath; }
  public function getMarque() { return $this->marque; }
  public function getFabriquant() { return $this->fabriquant; }
  public function getSourceEnergie() { return $this->sourceEnergie; }
  public function getContenance() { return $this->contenance; }
  public function getNombreChaises() { return $this->nombreChaises; }
  public function getVitessesMax() { return $this->vitessesMax; }
  public function getTransmission() { return $this->transmission; }
  public function getAcceleration() { return $this->acceleration; }
  public function getPuissanceMoteur() { return $this->puissanceMoteur; }
  public function getAnnee() { return $this->annee; }
}

?>
















<!-- private $categorieNom;
    private $evaluationNote;

    public function __construct($id, $modele, $prix, $disponibilite, $categorieId, $imagePath, 
                                $marque, $fabriquant, $sourceEnergie, $contenance, $nombreChaises, 
                                $vitessesMax, $transmission, $acceleration, $puissanceMoteur, $annee,
                                $categorieNom = null, $evaluationNote = null) {
        $this->id = $id;
        $this->modele = $modele;
        $this->prix = $prix;
        $this->disponibilite = $disponibilite;
        $this->categorieId = $categorieId;
        $this->imagePath = $imagePath;
        $this->marque = $marque;
        $this->fabriquant = $fabriquant;
        $this->sourceEnergie = $sourceEnergie;
        $this->contenance = $contenance;
        $this->nombreChaises = $nombreChaises;
        $this->vitessesMax = $vitessesMax;
        $this->transmission = $transmission;
        $this->acceleration = $acceleration;
        $this->puissanceMoteur = $puissanceMoteur;
        $this->annee = $annee;

        $this->categorieNom = $categorieNom;
        $this->evaluationNote = $evaluationNote;
    }

  
    public function getCategorieNom() {
        return $this->categorieNom;
    }

    public function getEvaluationNote() {
        return $this->evaluationNote;
    } -->
