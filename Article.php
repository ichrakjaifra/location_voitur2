<?php
require_once 'Database.php';

class Article {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();  
    }

    public function getArticlesByTheme($theme_id) {
        // Requête pour récupérer les articles par thème
        $query = "SELECT * FROM articles WHERE theme_id = :theme_id";
        return $this->db->fetchAll($query, ['theme_id' => $theme_id]);
    }

    public function addArticle($titre, $contenu, $image_path, $video_path, $theme_id, $utilisateur_id, $tags) {
        // Insertion d'un nouvel article
        $this->db->execute(
            "INSERT INTO articles (titre, contenu, image_path, video_path, theme_id, utilisateur_id) 
             VALUES (:titre, :contenu, :image_path, :video_path, :theme_id, :utilisateur_id)",
            compact('titre', 'contenu', 'image_path', 'video_path', 'theme_id', 'utilisateur_id')
        );

        // Récupération de l'ID du nouvel article
        $article_id = $this->db->conn->lastInsertId();

        // Ajout des tags pour l'article
        foreach ($tags as $tag) {
            $tag_id = $this->addTag($tag); // Ajout d'un tag ou récupération de l'ID du tag existant
            $this->db->execute(
                "INSERT INTO article_tags (article_id, tag_id) VALUES (:article_id, :tag_id)",
                ['article_id' => $article_id, 'tag_id' => $tag_id]
            );
        }
    }

    private function addTag($tag) {
        try {
            // Si le tag n'existe pas, on l'ajoute
            $this->db->execute("INSERT INTO tags (nom) VALUES (:nom)", ['nom' => $tag]);
            return $this->db->conn->lastInsertId();
        } catch (PDOException $e) {
            // Si une exception se produit, on vérifie si le tag existe déjà
            $query = "SELECT id FROM tags WHERE nom = :nom";
            $result = $this->db->fetchAll($query, ['nom' => $tag]);
            // Si le tag existe déjà, on retourne son ID
            return isset($result[0]['id']) ? $result[0]['id'] : null;
        }
    }
}
?>
