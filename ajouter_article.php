<?php
require_once 'Database.php';

// Connexion à la base de données
$db = new Database();
$conn = $db->connect();

// Récupération des données du formulaire
$titre = $_POST['titre'];
$contenu = $_POST['contenu'];
$theme_id = $_POST['theme_id'];
$tags = $_POST['tags']; // Tags en format "Tag1, Tag2, Tag3"
$image = $_FILES['image'];

// Insertion de l'article dans la table `articles`
$query = "INSERT INTO articles (titre, contenu, theme_id, image_path) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$imagePath = null;

if ($image['tmp_name']) {
    // Traitement de l'image (si elle est téléchargée)
    $imagePath = 'path_to_images/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $imagePath);
}

$stmt->execute([$titre, $contenu, $theme_id, $imagePath]);

// Récupération de l'ID de l'article inséré
$articleId = $conn->lastInsertId();

// Traitement des tags
if (!empty($tags)) {
    $tagList = explode(',', $tags); // Conversion des tags en tableau
    foreach ($tagList as $tag) {
        $tag = trim($tag); // Suppression des espaces superflus

        // Vérifier si le tag existe déjà
        $query = "SELECT id FROM tags WHERE nom = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$tag]);
        $tagId = $stmt->fetchColumn();

        if (!$tagId) {
            // Si le tag n'existe pas, l'ajouter à la table `tags`
            $query = "INSERT INTO tags (nom) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$tag]);

            // Récupérer l'ID du tag ajouté
            $tagId = $conn->lastInsertId();
        }

        // Vérifier si la relation article_tag existe déjà
        $query = "SELECT COUNT(*) FROM article_tags WHERE article_id = ? AND tag_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$articleId, $tagId]);
        $existingRelation = $stmt->fetchColumn();

        if (!$existingRelation) {
            // Lier le tag à l'article dans la table `article_tags` si la relation n'existe pas
            $query = "INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$articleId, $tagId]);
        }
    }
}

// Rediriger vers une page de confirmation ou la page d'index
header('Location: blog.php');
exit;
?>
