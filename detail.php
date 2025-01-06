<?php

session_start();

require_once 'Database.php';

if (isset($_GET['id'])) {
    $vehiculeId = intval($_GET['id']);

    $db = new Database();
    $conn = $db->connect();

    $query = "SELECT v.*, c.nom AS categorie_nom, c.description AS categorie_description 
              FROM vehicules v
              JOIN categories c ON v.categorie_id = c.id
              WHERE v.id = :id";

    $stmt = $conn->prepare($query);
    $stmt->execute(['id' => $vehiculeId]);

    $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicule) {
        echo "<p>Le véhicule demandé n'existe pas.</p>";
        exit;
    }
} else {
    echo "<p>Aucun identifiant de véhicule fourni.</p>";
    exit;
}
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



  <div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-8"><?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']); ?></h1>
    <div class="bg-white rounded-lg shadow-md p-6">
        <img src="<?php echo htmlspecialchars($vehicule['image_path']); ?>" alt="<?php echo htmlspecialchars($vehicule['modele']); ?>" class="w-full h-auto mb-4 rounded-lg">
        <table class="table-auto w-full text-left border-collapse">
            <tbody>
                <tr>
                    <th class="border px-4 py-2 font-medium">Marque</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['marque']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Modèle</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['modele']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Disponibilité</th>
                    <td class="border px-4 py-2"><?php echo $vehicule['disponibilite'] ? 'Disponible' : 'Indisponible'; ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Fabriquant</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['fabriquant']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Source d'énergie</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['source_energie']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Contenance</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['contenance']); ?> L</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Nombre de chaises</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['nombre_chaises']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Vitesse Max</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['vitesses_max']); ?> km/h</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Transmission</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['transmission']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Accélération</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['acceleration']); ?> s (0-100 km/h)</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Puissance Moteur</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['puissance_moteur']); ?> CV</td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Année</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['annee']); ?></td>
                </tr>
                <tr>
                    <th class="border px-4 py-2 font-medium">Catégorie</th>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($vehicule['categorie_nom']); ?> - <?php echo htmlspecialchars($vehicule['categorie_description']); ?></td>
                </tr>
            </tbody>
        </table>
        <a href="explore_cars.php" class="btn mt-4 inline-block px-6 py-2 bg-blue-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-blue-600">Retour</a>
    </div>
</div>


<div class="mt-6">
    <?php 
    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['utilisateur_id'])): 
        // Vérifiez si l'utilisateur a réservé ce véhicule
        $utilisateur_id = $_SESSION['utilisateur_id'];
        $vehicule_id = $vehicule['id']; // Supposons que $vehicule contient les détails du véhicule

        // Requête pour vérifier la réservation
        $stmt = $conn->prepare("SELECT COUNT(*) FROM reservations WHERE utilisateur_id = ? AND vehicule_id = ?");
        $stmt->execute([$utilisateur_id, $vehicule_id]);
        $aReserve = $stmt->fetchColumn() > 0;

        if ($aReserve): ?>
            <!-- Formulaire d'ajout d'avis -->
            <div class=" rounded-lg p-6 shadow-md" style="background-color: hhsl(216, 38%, 95%);">
                <h2 class="text-xl font-semibold mb-4">Add a review</h2>
                <form action="submit_review.php" method="POST">
                    <input type="hidden" name="vehicule_id" value="<?php echo htmlspecialchars($vehicule['id']); ?>">
                    <div class="mb-4">
                        <label for="rating" class="block font-medium">Rating (1 to 5 stars)</label>
                        <select id="rating" name="rating" required class="w-full mt-2 p-2 border rounded">
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="review" class="block font-medium">Review</label>
                        <textarea id="review" name="review" rows="4" required class="w-full mt-2 p-2 border rounded" placeholder="Write your review..."></textarea>
                    </div>
                    <button type="submit" class="px-6 py-2 text-white font-semibold rounded shadow hover:bg-green-600" style="background-color: hsl(211, 100%, 35%);">
                    Submit
                    </button>
                </form>
            </div>
        <?php else: ?>
            <!-- Message si l'utilisateur n'a pas réservé ce véhicule -->
            <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 shadow-md">
                <p>You must reserve this vehicle before you can leave a review.</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Message si l'utilisateur n'est pas connecté -->
        <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 shadow-md">
            <p>Veuillez <a href="sign_in.php" class="text-blue-500 underline">vous connecter</a> pour ajouter un avis.</p>
        </div>
    <?php endif; ?>
</div>



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