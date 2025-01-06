<?php
class Reservation {
    private $id;
    private $utilisateur_id;
    private $vehicule_id;
    private $date_debut;
    private $date_fin;
    private $lieu;
    private $db;

    // Constructor to initialize all properties
    public function __construct($db, $id = null, $utilisateur_id = null, $vehicule_id = null, $date_debut = null, $date_fin = null, $lieu = null) {
        $this->db = $db;
        $this->id = $id;
        $this->utilisateur_id = $utilisateur_id;
        $this->vehicule_id = $vehicule_id;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->lieu = $lieu;
    }

    // Add a reservation
    public function addReservation() {
        $query = "INSERT INTO reservations (utilisateur_id, vehicule_id, date_debut, date_fin, lieu) 
                  VALUES (:utilisateur_id, :vehicule_id, :date_debut, :date_fin, :lieu)";
        
        $params = [
            ':utilisateur_id' => $this->utilisateur_id,
            ':vehicule_id' => $this->vehicule_id,
            ':date_debut' => $this->date_debut,
            ':date_fin' => $this->date_fin,
            ':lieu' => $this->lieu
        ];

        $this->db->execute($query, $params);
    }

  //   public function addReservation() {
      
  //     $query = "CALL AjouterReservation(:utilisateur_id, :vehicule_id, :date_debut, :date_fin, :lieu)";
      
  //     $params = [
  //         ':utilisateur_id' => $this->utilisateur_id,
  //         ':vehicule_id' => $this->vehicule_id,
  //         ':date_debut' => $this->date_debut,
  //         ':date_fin' => $this->date_fin,
  //         ':lieu' => $this->lieu
  //     ];
  
  //     $this->db->execute($query, $params);
  // }
  

    // Fetch reservation details by vehicle ID
    public function getReservationDetails($vehicule_id) {
        $query = "SELECT * FROM reservations WHERE vehicule_id = :vehicule_id";
        $params = [':vehicule_id' => $vehicule_id];
        return $this->db->fetchAll($query, $params);
    }

    // Get all reservations for a specific user
    public function getUserReservations($utilisateur_id) {
        $query = "SELECT * FROM reservations WHERE utilisateur_id = :utilisateur_id";
        $params = [':utilisateur_id' => $utilisateur_id];
        return $this->db->fetchAll($query, $params);
    }

    // Getter methods to retrieve the properties
    public function getId() {
        return $this->id;
    }

    public function getUtilisateurId() {
        return $this->utilisateur_id;
    }

    public function getVehiculeId() {
        return $this->vehicule_id;
    }

    public function getDateDebut() {
        return $this->date_debut;
    }

    public function getDateFin() {
        return $this->date_fin;
    }

    public function getLieu() {
        return $this->lieu;
    }

    // Setter methods to set the properties
    public function setId($id) {
        $this->id = $id;
    }

    public function setUtilisateurId($utilisateur_id) {
        $this->utilisateur_id = $utilisateur_id;
    }

    public function setVehiculeId($vehicule_id) {
        $this->vehicule_id = $vehicule_id;
    }

    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function setLieu($lieu) {
        $this->lieu = $lieu;
    }
}
