<?php
require_once 'Utilisateur.php'; 

class Client extends Utilisateur {
    
    public function ajouterAvis($conn, $avis) {
        try {
            $sql = "INSERT INTO avis (utilisateur_id, vehicule_id, commentaire, note) 
                    VALUES (:utilisateur_id, :vehicule_id, :commentaire, :note)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':utilisateur_id' => $this->id,        
                ':vehicule_id' => $avis['vehicule_id'], 
                ':commentaire' => $avis['commentaire'], 
                ':note' => $avis['note']                
            ]);
            echo "Avis ajouté avec succès!";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'avis : " . $e->getMessage();
        }
    }

  
    public function modifierAvis($conn, $avisId, $contenu) {
        try {
            $sql = "UPDATE avis SET commentaire = :commentaire WHERE id = :avisId AND utilisateur_id = :utilisateur_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':commentaire' => $contenu,            
                ':avisId' => $avisId,                  
                ':utilisateur_id' => $this->id         
            ]);
            echo "Avis modifié avec succès!";
        } catch (PDOException $e) {
            echo "Erreur lors de la modification de l'avis : " . $e->getMessage();
        }
    }

  
    public function supprimerAvis($conn, $avisId) {
        try {
            $sql = "DELETE FROM avis WHERE id = :avisId AND utilisateur_id = :utilisateur_id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':avisId' => $avisId,                  
                ':utilisateur_id' => $this->id         
            ]);
            echo "Avis supprimé avec succès!";
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de l'avis : " . $e->getMessage();
        }
    }
}
?>
