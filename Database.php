<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'voiture';
    private $username = 'root';
    private $password = 'ichrak';
    public $conn;

    // Méthode pour se connecter à la base de données
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        return $this->conn;
    }

    // Méthode pour exécuter les requêtes préparées
    public function execute($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
    }

    // Méthode pour récupérer tous les résultats d'une requête
    public function fetchAll($query, $params = []) {
        $stmt = $this->conn->prepare($query); 
        $stmt->execute($params); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
}
?>
