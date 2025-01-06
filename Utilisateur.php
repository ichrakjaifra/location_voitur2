<?php
class Utilisateur {
    protected $id;
    protected $nom;
    protected $email;
    protected $motDePasse;
    protected $roleId;

    public function __construct($nom = null, $email = null, $motDePasse = null, $roleId = 2) {
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->roleId = $roleId; 
    }

    // Méthode pour s'inscrire
    public function sinscrire($conn) {
        try {
            $hashedPassword = password_hash($this->motDePasse, PASSWORD_BCRYPT);
            $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role_id) VALUES (:nom, :email, :motDePasse, :roleId)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nom' => $this->nom,
                ':email' => $this->email,
                ':motDePasse' => $hashedPassword,
                ':roleId' => $this->roleId
            ]);
            echo "Inscription réussie!";
        } catch (PDOException $e) {
            echo "Erreur lors de l'inscription.";
        }
    }

    // Méthode pour se connecter
    // public function seConnecter($conn) {
    //     try {
    //         session_start();
    //         $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->execute([':email' => $this->email]);
    //         $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    //         if ($utilisateur && password_verify($this->motDePasse, $utilisateur['mot_de_passe'])) {
    //             $_SESSION['user_id'] = $utilisateur['id'];
    //             $_SESSION['user_role'] = $utilisateur['role_id'];

    //             if ($utilisateur['role_id'] == 1) {
    //                 header("Location: dashboord.php"); 
    //                 exit();
    //             } else {
    //                 header("Location: index.php");
    //                 exit();
    //             }
    //         } else {
    //             echo "Email ou mot de passe incorrect.";
    //         }
    //     } catch (PDOException $e) {
    //         echo "Erreur lors de la connexion.";
    //     }
    // }
    public function seConnecter($conn) {
      try {
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }
          $sql = "SELECT * FROM utilisateurs WHERE email = :email";
          $stmt = $conn->prepare($sql);
          $stmt->execute([':email' => $this->email]);
          $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
  
          if ($utilisateur && password_verify($this->motDePasse, $utilisateur['mot_de_passe'])) {
            $_SESSION['user_id'] = $utilisateur['id'];
              $_SESSION['utilisateur_id'] = $utilisateur['id']; 
              $_SESSION['role_id'] = $utilisateur['role_id'];
  
              if ($utilisateur['role_id'] == 1) {
                  header("Location: dashboord.php"); 
                  exit();
              } else {
                  return true;  
              }
          } else {
              return false; 
          }
      } catch (PDOException $e) {
          echo "Erreur lors de la connexion.";
      }
  }
}
