<?php
require_once('Database.php');
require_once('Article.php');
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


  <!-- Article Content -->
  <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Image de l'article -->
            <?php if (!empty($article['image_url']) && file_exists($article['image_url'])): ?>
            <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['titre']) ?>"
                class="w-full h-96 object-cover">
            <?php else: ?>
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <?php endif; ?>

            <div class="p-8">
                <!-- Thème et Date -->
                <div class="flex items-center justify-between mb-6">
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">
                        <?= htmlspecialchars($article['theme_nom']) ?>
                    </span>
                    <time class="text-gray-500 text-sm">
                        <?= date('d/m/Y', strtotime($article['date_publication'])) ?>
                    </time>
                </div>

                <!-- Titre -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    <?= htmlspecialchars($article['titre']) ?>
                </h1>

                <!-- Auteur -->
                <!-- <div class="flex items-center mb-8">
                    <div class="bg-gray-200 rounded-full w-12 h-12 flex items-center justify-center">
                        <span class="text-xl"><?= strtoupper(substr($article['prenom'], 0, 1)) ?></span>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-900 font-medium">
                            <?= htmlspecialchars($article['prenom'] . ' ' . $article['nom']) ?>
                        </p>
                        <p class="text-gray-500 text-sm">Auteur</p>
                    </div>
                </div> -->
                <!-- Section des tags -->
                <?php if (!empty($article['article_tags'])): ?>
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (explode(',', $article['article_tags']) as $tag): ?>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                            #<?= htmlspecialchars(trim($tag)) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Contenu de l'article -->
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    <?= nl2br(htmlspecialchars($article['contenu'])) ?>
                </div>

                <!-- Bouton retour -->
                <div class="mt-12">
                    <a href="blog2.php" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux articles
                    </a>
                </div>
            </div>
        </div>

        <!-- Section des commentaires -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md mt-8 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Commentaires</h2>

            <!-- Affichage des commentaires existants -->
            <?php
    try {
        $query = "SELECT c.*, u.nom, u.prenom 
                  FROM Commentaires c 
                  INNER JOIN Utilisateurs u ON c.id_utilisateur = u.id_utilisateur 
                  WHERE c.id_article = :id_article 
                  ORDER BY c.created_at DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id_article' => $_GET['id']]);
        $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($commentaires): ?>
            <div class="space-y-6 mb-8">
                <?php foreach ($commentaires as $commentaire): ?>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-100 rounded-full w-8 h-8 flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-800">
                                <?= strtoupper(substr($commentaire['prenom'], 0, 1)) ?>
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($commentaire['prenom'] . ' ' . $commentaire['nom']) ?>
                            </p>
                            <p class="text-xs text-gray-500">
                                <?= date('d/m/Y H:i', strtotime($commentaire['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                    <p class="text-gray-700">
                        <?= nl2br(htmlspecialchars($commentaire['contenu'])) ?>
                    </p>
                    <?php if (isset($_SESSION['user_id']) && $commentaire['id_utilisateur'] == $_SESSION['user_id']): ?>
                <div class="flex space-x-4 mt-2">
                    <!-- Bouton Modifier -->
                    <button onclick="toggleEditForm(<?= $commentaire['id_commentaire'] ?>)"
                        class="text-sm text-blue-600 hover:text-blue-800">
                        Modifier
                    </button>

                    <!-- Formulaire de modification (caché par défaut) -->
                    <form id="editForm<?= $commentaire['id_commentaire']; ?>" action="manage_commentaire.php"
                        method="POST" class="hidden mt-2 w-full">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id_commentaire" value="<?= $commentaire['id_commentaire'] ?>">
                        <input type="hidden" name="id_article" value="<?= $_GET['id'] ?>">
                        <textarea name="contenu"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required><?= htmlspecialchars($commentaire['contenu']) ?></textarea>
                        <div class="flex space-x-2 mt-2">
                            <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Enregistrer
                            </button>
                            <button type="button" onclick="toggleEditForm(<?= $commentaire['id_commentaire'] ?>)"
                                class="px-3 py-1 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                                Annuler
                            </button>
                        </div>
                    </form>

                    <!-- Formulaire de suppression -->
                    <form action="manage_commentaire.php" method="POST" class="inline"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_commentaire" value="<?= $commentaire['id_commentaire'] ?>">
                        <input type="hidden" name="id_article" value="<?= $_GET['id'] ?>">
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                            Supprimer
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                </div>
                
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-gray-500 mb-8">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
            <?php endif; ?>

            <?php } catch (Exception $e) {
        echo "<p class='text-red-500'>Erreur lors de la récupération des commentaires : " . htmlspecialchars($e->getMessage()) . "</p>";
    } ?>

            <!-- Formulaire pour ajouter un commentaire -->
            <form action="manage_commentaire.php" method="POST" class="space-y-4">
                <input type="hidden" name="id_article" value="<?= htmlspecialchars($_GET['id']) ?>">
                <input type="hidden" name="action" value="create">

                <div>
                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Votre commentaire
                    </label>
                    <textarea id="commentaire" name="contenu" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required></textarea>
                </div>

                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Publier le commentaire
                </button>
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
