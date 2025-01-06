<?php
require_once 'Database.php';

$database = new Database();
$conn = $database->connect();

// $sql = "SELECT * FROM vehicules";
// $result = $database->fetchAll($sql);

// Nombre d'éléments par page
$items_per_page = 6;

// Page actuelle
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // S'assurer que la page est au moins 1

// Calcul de l'offset
$offset = ($page - 1) * $items_per_page;

// Récupérer le total des voitures
$total_items_query = "SELECT COUNT(*) AS total FROM vehicules";
$total_items_result = $database->fetchAll($total_items_query);
$total_items = $total_items_result[0]['total'];

// Calcul du nombre total de pages
$total_pages = ceil($total_items / $items_per_page);

// Requête avec limite et offset
$sql = "SELECT * FROM vehicules LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<body>

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
            <a href="#blog" class="navbar-link" data-nav-link>Blog</a>
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

  <!-- 
        - #HERO
      -->

      <section class="section hero" id="home">
        <div class="container">

          <div class="hero-content">
            <h2 class="h1 hero-title">The easy way to takeover a lease</h2>

            <p class="hero-text">
              Live in New York, New Jerset and Connecticut!
            </p>
          </div>

          <div class="hero-banner"></div>
<!-- Formulaire HTML -->
<form id="car-search-form" class="hero-form">
  <div class="input-wrapper">
    <label for="input-1" class="input-label">Car, model, or brand</label>
    <input type="text" name="car_model" id="input-1" class="input-field" placeholder="What car are you looking?">
  </div>

  <div class="input-wrapper">
    <label for="input-2" class="input-label">Max. monthly payment</label>
    <input type="text" name="monthly_pay" id="input-2" class="input-field" placeholder="Add an amount in $">
  </div>

  <div class="input-wrapper">
    <label for="input-3" class="input-label">Make Year</label>
    <input type="text" name="year" id="input-3" class="input-field" placeholder="Add a minimal make year">
  </div>

  <button type="button" id="search-button" class="btn">Search</button>
</form>

<!-- Conteneur pour les résultats -->
<!-- <div id="search-results"></div> -->

<script>
  // Gestionnaire d'événement pour le bouton de recherche
  document.getElementById('search-button').addEventListener('click', function () {
    const form = document.getElementById('car-search-form');
    const formData = new FormData(form); // Récupère les données du formulaire

    // Crée une requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_cars.php', true); // Envoie les données à search_cars.php

    // Gestion de la réponse
    xhr.onload = function () {
      if (xhr.status === 200) {
        document.getElementById('search-results').innerHTML = xhr.responseText; // Affiche les résultats
      } else {
        document.getElementById('search-results').innerHTML = '<p>An error occurred while searching for cars.</p>';
      }
    };

    // Gestion des erreurs réseau
    xhr.onerror = function () {
      document.getElementById('search-results').innerHTML = '<p>Network error occurred.</p>';
    };

    // Envoie les données du formulaire
    xhr.send(formData);
  });
</script>



        </div>
      </section>



      
      <div class="input-wrapper">
  <label for="category-select" class="input-label">Filter by Category</label>
  <select id="category-select" class="input-field">
    <option value="">All Categories</option>
    <?php
    // Fetch all categories from the 'categories' table
    $categories = $database->fetchAll("SELECT id, nom FROM categories");
    foreach ($categories as $category) {
        echo '<option value="' . htmlspecialchars($category['id']) . '">' . htmlspecialchars($category['nom']) . '</option>';
    }
    ?>
  </select>
</div>
<script>
  document.getElementById('category-select').addEventListener('change', function () {
  const category = this.value;
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'fetch_cars.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById('search-results').innerHTML = xhr.responseText;
    } else {
      document.getElementById('search-results').innerHTML = '<p>Error loading cars.</p>';
    }
  };

  xhr.send('category=' + encodeURIComponent(category));
});

</script>

      

<section class="section featured-car" id="search-results">
    <div class="container">
        <div class="title-wrapper">
            <h2 class="h2 section-title">Featured cars</h2>
            <a href="#" class="featured-car-link">
                <span>View more</span>
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </a>
        </div>

        <ul class="featured-car-list">
            <?php
            // Si des données sont disponibles, affichez-les
            if (!empty($result)) {
                // Parcourez chaque voiture
                foreach ($result as $row) {
                    echo '<li>';
                    echo '    <div class="featured-car-card">';
                    echo '        <figure class="card-banner">';
                    $imagePath = $row['image_path'];  
                    echo '            <img src="' . $imagePath . '" alt="' . $row['modele'] . '" loading="lazy" width="440" height="300" class="w-100">';
                    echo '        </figure>';
                    echo '        <div class="card-content">';
                    echo '            <div class="card-title-wrapper">';
                    echo '                <h3 class="h3 card-title"><a href="#">' . $row['marque'] . ' ' . $row['modele'] . '</a></h3>';
                    echo '                <data class="year" value="' . $row['annee'] . '">' . $row['annee'] . '</data>';
                    echo '            </div>';
                    echo '            <ul class="card-list">';
                    echo '                <li class="card-list-item"><ion-icon name="people-outline"></ion-icon><span class="card-item-text">' . $row['nombre_chaises'] . ' Chaises</span></li>';
                    echo '                <li class="card-list-item"><ion-icon name="flash-outline"></ion-icon><span class="card-item-text">' . $row['source_energie'] . '</span></li>';
                    echo '                <li class="card-list-item"><ion-icon name="speedometer-outline"></ion-icon><span class="card-item-text">Fuel Efficiency</span></li>';
                    echo '            </ul>';
                    


                    echo'<div class="card-price-wrapper text-center">';
                    echo'<p class="card-price"><strong>$' .  htmlspecialchars($row['prix']) .'</strong> / month</p>';
                    echo'<div class="flex justify-center gap-4 mt-2">';
                    // echo'  <a href="reservations.php?id=' . $row['id'] .'" class="btn inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-blue-600">Rent now</a>';
                    echo '<a href="sign_in.php?redirect=' . urlencode("reservations.php?id=" . $row['id']) . '" class="btn inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-blue-600">Rent now</a>';
                    echo'<a href="detail.php?id=' . $row['id'] . '" class="btn inline-block px-4 py-2 bg-gray-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-gray-600">View Details</a>';
                    echo'</div>';
                    echo'</div>';




                    echo '        </div>';
                    echo '    </div>';
                    echo '</li>';
                }
            } else {
                echo "<p>No featured cars available.</p>";
            }
            ?>
        </ul>

        <?php
echo '<div style="text-align: center; margin: 20px 0;">';
if ($page > 1) {
    echo '<a href="?page=' . ($page - 1) . '" style="margin: 0 5px; text-decoration: none; color: black;">Previous</a>';
}
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        // Page actuelle mise en surbrillance
        echo '<span style="margin: 0 5px; font-weight: bold; color: black;">' . $i . '</span>';
    } else {
        echo '<a href="?page=' . $i . '" style="margin: 0 5px; text-decoration: none; color: black;">' . $i . '</a>';
    }
}
if ($page < $total_pages) {
    echo '<a href="?page=' . ($page + 1) . '" style="margin: 0 5px; text-decoration: none; color: black;">Next</a>';
}
echo '</div>';
?>

    </div>
</section>


      


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