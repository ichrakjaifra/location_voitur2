<?php
require_once 'Article.php';

$article = new Article();
$theme_id = $_GET['theme_id'] ?? null;
$articles = $article->getArticlesByTheme($theme_id);
?>

<section class="section articles">
    <div class="container">
        <h2 class="section-title">Articles for Theme ID: <?php echo $theme_id; ?></h2>
        <button onclick="document.getElementById('add-article-form').style.display='block'" class="btn btn-primary">Ajouter un Article</button>

        <div id="add-article-form" style="display:none;">
            <form method="POST" action="add_article.php">
                <input type="hidden" name="theme_id" value="<?php echo $theme_id; ?>">
                <input type="text" name="titre" placeholder="Titre" required>
                <textarea name="contenu" placeholder="Contenu" required></textarea>
                <input type="file" name="image">
                <input type="file" name="video">
                <input type="text" name="tags" placeholder="Tags (séparés par des virgules)">
                <button type="submit" class="btn">Ajouter</button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-6">
            <?php foreach ($articles as $article): ?>
            <div class="article-card bg-white shadow-lg rounded-lg overflow-hidden">
                <h3><?php echo htmlspecialchars($article['titre']); ?></h3>
                <p><?php echo htmlspecialchars($article['contenu']); ?></p>
                <img src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="" class="w-full h-48 object-cover">
                <a href="#" class="btn btn-secondary">Lire Plus</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
