<?php
// Inclure la classe Article et Database
require_once 'Article.php';
require_once 'Database.php';

// Initialiser la connexion à la base de données
$db = new Database();
$conn = $db->connect();

// Récupérer les thèmes
$sqlThemes = "SELECT id, nom FROM themes";
$themes = $db->fetchAll($sqlThemes);

// Vérifier si un thème est sélectionné
$themeId = isset($_GET['theme_id']) ? intval($_GET['theme_id']) : null;

// $articles = [];
// if ($themeId) {
//     $articles = Article::getArticlesByTheme($themeId, $conn);
// }

// Pagination
$limit = 6; // Nombre d'articles par page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Récupérer les articles par thème et avec pagination
$articles = [];
if ($themeId) {
    $articles = Article::getArticlesByThemeWithPagination($themeId, $conn, $limit, $offset);
}

// Récupérer le nombre total d'articles pour ce thème
$totalArticles = Article::getTotalArticlesByTheme($themeId, $conn);
$totalPages = ceil($totalArticles / $limit);

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ridex - Rent your favourite car</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&family=Open+Sans&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">

<!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="#" class="logo">
        <img src="./assets/images/logo.svg" alt="Ridex logo">
      </a>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">

          <li>
            <a href="index.php" class="navbar-link" data-nav-link>Home</a>
          </li>

          <li>
            <a href="explore_cars.php" class="navbar-link" data-nav-link>Explore cars</a>
          </li>

          <li>
            <a href="#" class="navbar-link" data-nav-link>About us</a>
          </li>

          <li>
            <a href="blog.php" class="navbar-link" data-nav-link>Blog</a>
          </li>

        </ul>
      </nav>

      <div class="header-actions">

        <div class="header-contact">
          <a href="tel:88002345678" class="contact-link">8 800 234 56 78</a>

          <span class="contact-time">Mon - Sat: 9:00 am - 6:00 pm</span>
        </div>

        <a href="#featured-car" class="btn" aria-labelledby="aria-label-txt">
          <ion-icon name="car-outline"></ion-icon>

          <span id="aria-label-txt">Explore cars</span>
        </a>

        <a href="sign_in.php" class="btn user-btn" aria-label="Profile">
          <ion-icon name="person-outline"></ion-icon>
        </a>

        <button class="nav-toggle-btn" data-nav-toggle-btn aria-label="Toggle Menu">
          <span class="one"></span>
          <span class="two"></span>
          <span class="three"></span>
        </button>

      </div>

    </div>
  </header>


  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Affichage des thèmes -->
        <section class="mb-12">
    <h2 class="text-2xl font-bold mb-6">Explorez par thème</h2>
    <div class="flex flex-wrap gap-4">
        <?php foreach ($themes as $theme): ?>
            <a href="?theme_id=<?= $theme['id'] ?>"
               class="px-6 py-3 text-white rounded-full hover:bg-blue-700 transition-colors" style="background-color:hsl(204, 91%, 53%);">
                <?= htmlspecialchars($theme['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Barre recherche -->
<section class="mb-8 flex flex-wrap gap-4 items-center justify-between bg-white p-4 rounded-lg shadow-sm">
            <div class="relative">
                <input type="search" placeholder="Rechercher un article..." 
                    class="pl-10 pr-4 py-2 border rounded-lg w-64">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </section>

        <!-- Grille d'articles -->
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if ($articles): ?>
        <?php foreach ($articles as $article): ?>
            <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <?php if ($article['image_path']): ?>
                    <img src="<?= htmlspecialchars($article['image_path']) ?>" alt="Article thumbnail"
                         class="w-full h-48 object-cover">
                <?php else: ?>
                    <img src="/api/placeholder/800/400" alt="Image placeholder" class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <!-- Affichage des thèmes associés à l'article (par exemple) -->
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full"><?= htmlspecialchars($theme['nom']) ?></span>
                    </div>
                    <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($article['titre']) ?></h3>
                    <p class="text-gray-600 mb-4"><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center gap-4">
                            <!-- Icônes de statistiques (par exemple, vues et commentaires) -->
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                245
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                32
                            </span>
                        </div>
                        <time class="text-sm text-gray-500"><?= date("d M Y", strtotime($article['date_publication'])) ?></time>
                    </div>
                    <a href="detail_article.php?id=<?= htmlspecialchars($article['id']) ?>"
                       class="inline-block px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition">
                        Learn More
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article disponible pour ce thème.</p>
    <?php endif; ?>
</section>

<!-- Pagination -->

        <nav class="mt-8 flex justify-center gap-2">
    <!-- Previous Button -->
    <?php if ($page > 1): ?>
        <a href="?theme_id=<?= $themeId ?>&page=<?= $page - 1 ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Précédent</a>
    <?php else: ?>
        <span class="px-4 py-2 border rounded-lg text-gray-400">Précédent</span>
    <?php endif; ?>

    <!-- Page Buttons -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?theme_id=<?= $themeId ?>&page=<?= $i ?>" 
            class="px-4 py-2 border rounded-lg <?= $i == $page ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <!-- Next Button -->
    <?php if ($page < $totalPages): ?>
        <a href="?theme_id=<?= $themeId ?>&page=<?= $page + 1 ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Suivant</a>
    <?php else: ?>
        <span class="px-4 py-2 border rounded-lg text-gray-400">Suivant</span>
    <?php endif; ?>
</nav>




        <!-- Formulaire d'ajout d'article -->
        <div class="mt-10">
    <h2 class="text-2xl font-semibold mb-4">Ajouter un article</h2>
    <form action="ajouter_article.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        <div class="mb-4">
            <label for="titre" class="block text-gray-700">Titre :</label>
            <input type="text" id="titre" name="titre" required class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="contenu" class="block text-gray-700">Contenu :</label>
            <textarea id="contenu" name="contenu" rows="4" required class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div class="mb-4">
            <label for="theme_id" class="block text-gray-700">Thème :</label>
            <select id="theme_id" name="theme_id" required class="w-full px-3 py-2 border rounded">
                <?php foreach ($themes as $theme): ?>
                    <option value="<?= $theme['id'] ?>"><?= htmlspecialchars($theme['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="tags" class="block text-gray-700">Tags (séparés par des virgules) :</label>
            <input type="text" id="tags" name="tags" class="w-full px-3 py-2 border rounded" placeholder="Tag1, Tag2, Tag3">
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Image :</label>
            <input type="file" id="image" name="image" class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ajouter</button>
    </form>
</div>


        

  </main>

<!-- 
    - #FOOTER
  -->

  <footer class="footer">
    <div class="container">

      <div class="footer-top">

        <div class="footer-brand">
          <a href="#" class="logo">
            <img src="./assets/images/logo.svg" alt="Ridex logo">
          </a>

          <p class="footer-text">
            Search for cheap rental cars in New York. With a diverse fleet of 19,000 vehicles, Waydex offers its
            consumers an
            attractive and fun selection.
          </p>
        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Company</p>
          </li>

          <li>
            <a href="#" class="footer-link">About us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Pricing plans</a>
          </li>

          <li>
            <a href="#" class="footer-link">Our blog</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contacts</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Support</p>
          </li>

          <li>
            <a href="#" class="footer-link">Help center</a>
          </li>

          <li>
            <a href="#" class="footer-link">Ask a question</a>
          </li>

          <li>
            <a href="#" class="footer-link">Privacy policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms & conditions</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Neighborhoods in New York</p>
          </li>

          <li>
            <a href="#" class="footer-link">Manhattan</a>
          </li>

          <li>
            <a href="#" class="footer-link">Central New York City</a>
          </li>

          <li>
            <a href="#" class="footer-link">Upper East Side</a>
          </li>

          <li>
            <a href="#" class="footer-link">Queens</a>
          </li>

          <li>
            <a href="#" class="footer-link">Theater District</a>
          </li>

          <li>
            <a href="#" class="footer-link">Midtown</a>
          </li>

          <li>
            <a href="#" class="footer-link">SoHo</a>
          </li>

          <li>
            <a href="#" class="footer-link">Chelsea</a>
          </li>

        </ul>

      </div>

      <div class="footer-bottom">

        <ul class="social-list">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-skype"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="mail-outline"></ion-icon>
            </a>
          </li>

        </ul>

        <p class="copyright">
          &copy; 2022 <a href="#">codewithsadee</a>. All Rights Reserved
        </p>

      </div>

    </div>
  </footer>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
