<?php
session_start();
require_once 'Article.php';

if (!isset($_SESSION['utilisateur_id'])) {
  header('Location: sign_in.php');
  exit();}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $theme_id = $_POST['theme_id'];
    $tags = explode(',', $_POST['tags']);
    $image_path = ''; 
    $video_path = ''; 
    $utilisateur_id = $_SESSION['utilisateur_id']; 

    $article = new Article();
    $article->addArticle($titre, $contenu, $image_path, $video_path, $theme_id, $utilisateur_id, $tags);

    header("Location: articles_par_theme.php?theme_id=$theme_id");
}
?>
