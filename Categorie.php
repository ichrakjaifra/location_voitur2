<?php
require_once 'Database.php';

class Categorie {
    private $id;
    private $nom;
    private $description;

    public function __construct($id, $nom, $description) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
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

    public static function getCategories() {
        $database = new Database();
        $db = $database->connect(); 
        
        $query = "SELECT * FROM categories";

        $results = $database->fetchAll($query);

        $categories = [];

        foreach ($results as $row) {
            $categorie = new Categorie($row['id'], $row['nom'], $row['description']);
            $categories[] = $categorie;
        }

        return $categories;
    }

    

  // Delete a category
  public static function deleteCategory($categoryId) {
    $database = new Database();
    $db = $database->connect();

    $query = "DELETE FROM categories WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $categoryId);

    if ($stmt->execute()) {
        return true;
    } else {
        // Debugging: Log the error message
        error_log("Failed to delete category: " . implode(", ", $stmt->errorInfo()));
        return false;
    }
}


  // Add a new category
public static function addCategory($categorie) {
  $database = new Database();
  $db = $database->connect();

  $query = "INSERT INTO categories (nom, description) VALUES (:nom, :description)";
  $stmt = $db->prepare($query);

  $nom = $categorie->getNom(); 
  $description = $categorie->getDescription(); 

  $stmt->bindParam(':nom', $nom); 
  $stmt->bindParam(':description', $description); 

  if ($stmt->execute()) {
      return true;
  }

  return false;
}

// Update a category
public static function updateCategory($categorie) {
  $database = new Database();
  $db = $database->connect();

  $query = "UPDATE categories SET nom = :nom, description = :description WHERE id = :id";
  $stmt = $db->prepare($query);

  $id = $categorie->getId(); // Assign value to a variable
  $nom = $categorie->getNom(); // Assign value to a variable
  $description = $categorie->getDescription(); // Assign value to a variable

  $stmt->bindParam(':id', $id); // Pass variable by reference
  $stmt->bindParam(':nom', $nom); // Pass variable by reference
  $stmt->bindParam(':description', $description); // Pass variable by reference

  if ($stmt->execute()) {
      return true;
  }

  return false;
}


}
?>
