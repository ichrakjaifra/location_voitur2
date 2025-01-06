<?php
require_once 'Utilisateur.php';
require_once 'Vehicule.php';  
require_once 'Database.php'; // N'oubliez pas d'inclure la classe Database

class Administrateur extends Utilisateur {

  public function getVehicules() {
    $db = new Database();
    $db->connect();
    $query = "SELECT * FROM vehicules";
    $results = $db->fetchAll($query);

    $vehicules = [];
    foreach ($results as $row) {
        $vehicules[] = new Vehicule(
            $row['id'], $row['modele'], $row['prix'], $row['disponibilite'],
            $row['categorie_id'], $row['image_path'], $row['marque'], 
            $row['fabriquant'], $row['source_energie'], $row['contenance'], 
            $row['nombre_chaises'], $row['vitesses_max'], 
            $row['transmission'], $row['acceleration'], $row['puissance_moteur'], $row['annee']
        );
    }

    return $vehicules;
}

// public function getVehicules() {
//   $db = new Database();
//   $db->connect();
//   $query = "SELECT * FROM ListeVehicules";
//   $results = $db->fetchAll($query);

//   $vehicules = [];
//   foreach ($results as $row) {
//       $vehicules[] = new Vehicule(
//           $row['id'], $row['modele'], $row['prix'], $row['disponibilite'],
//           $row['categorie_id'], $row['image_path'], $row['marque'], 
//           $row['fabriquant'], $row['source_energie'], $row['contenance'], 
//           $row['nombre_chaises'], $row['vitesses_max'], 
//           $row['transmission'], $row['acceleration'], $row['puissance_moteur'], 
//           $row['annee'], $row['categorie_nom'], $row['evaluation_note'] 
//       );
//   }

//   return $vehicules;
// }




    // Méthode pour ajouter plusieurs véhicules à la fois
    public function ajouterVehicules($vehicules) {
      $db = new Database();
      $db->connect();
  
      foreach ($vehicules as $vehicule) {
          $query = "INSERT INTO vehicules 
                    (modele, prix, disponibilite, categorie_id, image_path, marque, 
                     fabriquant, source_energie, contenance, nombre_chaises, vitesses_max, 
                     transmission, acceleration, puissance_moteur, annee) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          
          $db->execute($query, [
              $vehicule->getModele(), $vehicule->getPrix(), $vehicule->getDisponibilite(),
              $vehicule->getCategorieId(), $vehicule->getImagePath(), $vehicule->getMarque(),
              $vehicule->getFabriquant(), $vehicule->getSourceEnergie(), 
              $vehicule->getContenance(), $vehicule->getNombreChaises(), 
              $vehicule->getVitessesMax(), $vehicule->getTransmission(), 
              $vehicule->getAcceleration(), $vehicule->getPuissanceMoteur(),
              $vehicule->getAnnee()
          ]);
      }
  }
  

    // Méthode pour supprimer un véhicule
    public function supprimerVehicule($id) {
        $db = new Database(); 
        $db->connect(); 
        
      
        $query = "DELETE FROM vehicules WHERE id = ?";
        $db->execute($query, [$id]);
    }

    // Méthode pour modifier un véhicule
    public function modifierVehicule($id, $modele, $prix, $disponibilite, $categorie_id, $image_path, 
    $marque, $fabriquant, $source_energie, $contenance, 
    $nombre_chaises, $vitesses_max, $transmission, $acceleration, $puissance_moteur, $annee) {

    $db = new Database();
    $db->connect();

    $query = "UPDATE vehicules 
              SET modele = ?, prix = ?, disponibilite = ?, categorie_id = ?, image_path = ?, 
                  marque = ?, fabriquant = ?, source_energie = ?, contenance = ?, 
                  nombre_chaises = ?, vitesses_max = ?, transmission = ?, 
                  acceleration = ?, puissance_moteur = ?, annee =? 
              WHERE id = ?";

    $db->execute($query, [
        $modele, $prix, $disponibilite, $categorie_id, $image_path, 
        $marque, $fabriquant, $source_energie, $contenance, 
        $nombre_chaises, $vitesses_max, $transmission, $acceleration, $puissance_moteur, $annee, $id
    ]);
}

}

// Insert Vehicle Logic
if (isset($_POST['submit'])) {
  $modele = $_POST['modele'];
  $prix = $_POST['prix'];
  $disponibilite = $_POST['disponibilite'];
  $categorie_id = $_POST['categorie_id'];

  $marque = $_POST['marque'];
  $fabriquant = $_POST['fabriquant'];
  $source_energie = $_POST['source_energie'];
  $contenance = $_POST['contenance'];
  $nombre_chaises = $_POST['nombre_chaises'];
  $vitesses_max = $_POST['vitesses_max'];
  $transmission = $_POST['transmission'];
  $acceleration = $_POST['acceleration'];
  $puissance_moteur = $_POST['puissance_moteur'];
  $annee = $_POST['annee'];

  // File upload handling remains the same
  $image_path = "";
  if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
      $target_dir = "uploads/";
      $file_type = pathinfo($_FILES["image_path"]["name"], PATHINFO_EXTENSION);
      $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

      if (in_array($file_type, $allowed_types)) {
          $target_file = $target_dir . uniqid() . "." . $file_type;
          move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file);
          $image_path = $target_file;
      } else {
          echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
          exit;
      }
  }

  // Validation
  if (empty($modele) || empty($prix) || empty($categorie_id)) {
      echo "<script>alert('Model, price, and category are required!');</script>";
  } else {
      // Create a new vehicle object with all attributes
      $vehicule = new Vehicule(
          null, $modele, $prix, $disponibilite, $categorie_id, $image_path,
          $marque, $fabriquant, $source_energie, $contenance,
          $nombre_chaises, $vitesses_max, $transmission,
          $acceleration, $puissance_moteur, $annee
      );

      // Add the vehicle to the database
      $administrateur = new Administrateur();
      $administrateur->ajouterVehicules([$vehicule]);

      echo "<script>alert('Vehicle added successfully!');</script>";
  }
}


// Handle edit form submission
if (isset($_POST['update'])) {
  $id = $_POST['edit_id'];
  $modele = $_POST['edit_modele'];
  $prix = $_POST['edit_prix'];
  $disponibilite = $_POST['edit_disponibilite'];
  $categorie_id = $_POST['edit_categorie_id'];

  $marque = $_POST['edit_marque'];
  $fabriquant = $_POST['edit_fabriquant'];
  $source_energie = $_POST['edit_source_energie'];
  $contenance = $_POST['edit_contenance'];
  $nombre_chaises = $_POST['edit_nombre_chaises'];
  $vitesses_max = $_POST['edit_vitesses_max'];
  $transmission = $_POST['edit_transmission'];
  $acceleration = $_POST['edit_acceleration'];
  $puissance_moteur = $_POST['edit_puissance_moteur'];
  $annee = $_POST['edit_annee'];

  $image_path = $_POST['edit_image_path'];

  if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
      $target_dir = "uploads/";
      $file_type = pathinfo($_FILES["image_path"]["name"], PATHINFO_EXTENSION);
      $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

      if (in_array($file_type, $allowed_types)) {
          $target_file = $target_dir . uniqid() . "." . $file_type;
          move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file);
          $image_path = $target_file;
      } else {
          echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
          exit;
      }
  }

  // Update vehicle details in the database
  $administrateur = new Administrateur();
  $administrateur->modifierVehicule(
      $id, $modele, $prix, $disponibilite, $categorie_id, $image_path,
      $marque, $fabriquant, $source_energie, $contenance,
      $nombre_chaises, $vitesses_max, $transmission,
      $acceleration, $puissance_moteur, $annee
  );

  echo "<script>alert('Vehicle updated successfully!'); window.location.href='vehicles.php';</script>";
}



// Handle delete
if (isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];

  // Create an instance of the Administrateur class to delete the vehicle
  $administrateur = new Administrateur();
  $administrateur->supprimerVehicule($id);

  echo "<script>alert('Vehicle deleted successfully!');</script>";
}


?>
