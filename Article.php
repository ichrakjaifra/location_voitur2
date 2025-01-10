<?php

class Article
{
    private $id;
    private $titre;
    private $contenu;
    private $imagePath;
    private $videoPath;
    private $themeId;
    private $utilisateurId;
    private $datePublication;
    private $estApprouve;

    public function __construct($id = null, $titre = "", $contenu = "", $imagePath = null, $videoPath = null, $themeId = null, $utilisateurId = null, $datePublication = null, $estApprouve = false)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->imagePath = $imagePath;
        $this->videoPath = $videoPath;
        $this->themeId = $themeId;
        $this->utilisateurId = $utilisateurId;
        $this->datePublication = $datePublication;
        $this->estApprouve = $estApprouve;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getContenu() { return $this->contenu; }
    public function getImagePath() { return $this->imagePath; }
    public function getVideoPath() { return $this->videoPath; }
    public function getThemeId() { return $this->themeId; }
    public function getUtilisateurId() { return $this->utilisateurId; }
    public function getDatePublication() { return $this->datePublication; }
    public function getEstApprouve() { return $this->estApprouve; }

    // Setters
    public function setTitre($titre) { $this->titre = $titre; }
    public function setContenu($contenu) { $this->contenu = $contenu; }
    public function setImagePath($imagePath) { $this->imagePath = $imagePath; }
    public function setVideoPath($videoPath) { $this->videoPath = $videoPath; }
    public function setThemeId($themeId) { $this->themeId = $themeId; }
    public function setUtilisateurId($utilisateurId) { $this->utilisateurId = $utilisateurId; }
    public function setEstApprouve($estApprouve) { $this->estApprouve = $estApprouve; }

    // Static Methods for Database Operations
    public static function getArticlesByTheme($themeId, $pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE theme_id = :themeId");
        $stmt->bindParam(':themeId', $themeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllArticles($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM articles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addArticle($article, $pdo)
    {
        $stmt = $pdo->prepare("INSERT INTO articles (titre, contenu, image_path, video_path, theme_id, utilisateur_id, est_approuve) VALUES (:titre, :contenu, :imagePath, :videoPath, :themeId, :utilisateurId, :estApprouve)");
        $stmt->bindParam(':titre', $article->titre, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $article->contenu, PDO::PARAM_STR);
        $stmt->bindParam(':imagePath', $article->imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':videoPath', $article->videoPath, PDO::PARAM_STR);
        $stmt->bindParam(':themeId', $article->themeId, PDO::PARAM_INT);
        $stmt->bindParam(':utilisateurId', $article->utilisateurId, PDO::PARAM_INT);
        $stmt->bindParam(':estApprouve', $article->estApprouve, PDO::PARAM_BOOL);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public static function deleteArticle($id, $pdo)
    {
        $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function updateArticle($article, $pdo)
    {
        $stmt = $pdo->prepare("UPDATE articles SET titre = :titre, contenu = :contenu, image_path = :imagePath, video_path = :videoPath, theme_id = :themeId, utilisateur_id = :utilisateurId, est_approuve = :estApprouve WHERE id = :id");
        $stmt->bindParam(':id', $article->id, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $article->titre, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $article->contenu, PDO::PARAM_STR);
        $stmt->bindParam(':imagePath', $article->imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':videoPath', $article->videoPath, PDO::PARAM_STR);
        $stmt->bindParam(':themeId', $article->themeId, PDO::PARAM_INT);
        $stmt->bindParam(':utilisateurId', $article->utilisateurId, PDO::PARAM_INT);
        $stmt->bindParam(':estApprouve', $article->estApprouve, PDO::PARAM_BOOL);
        return $stmt->execute();
    }
}

?>
