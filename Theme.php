<?php
require_once 'Database.php';

class Theme {
    private $id;
    private $nom;
    private $description;
    private $imagePath;

    public function __construct($id, $nom, $description, $imagePath) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->imagePath = $imagePath;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public static function getThemes() {
        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM themes";
        $results = $database->fetchAll($query);

        $themes = [];

        foreach ($results as $row) {
            $theme = new Theme($row['id'], $row['nom'], $row['description'], $row['image_path']);
            $themes[] = $theme;
        }

        return $themes;
    }

    public static function deleteTheme($themeId) {
        $database = new Database();
        $db = $database->connect();

        $query = "DELETE FROM themes WHERE id = :id";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':id', $themeId);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to delete theme: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public static function addTheme($theme) {
        $database = new Database();
        $db = $database->connect();

        $query = "INSERT INTO themes (nom, description, image_path) VALUES (:nom, :description, :imagePath)";
        $stmt = $db->prepare($query);

        $nom = $theme->getNom();
        $description = $theme->getDescription();
        $imagePath = $theme->getImagePath();

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':imagePath', $imagePath);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public static function updateTheme($theme) {
        $database = new Database();
        $db = $database->connect();

        $query = "UPDATE themes SET nom = :nom, description = :description, image_path = :imagePath WHERE id = :id";
        $stmt = $db->prepare($query);

        $id = $theme->getId();
        $nom = $theme->getNom();
        $description = $theme->getDescription();
        $imagePath = $theme->getImagePath();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':imagePath', $imagePath);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
