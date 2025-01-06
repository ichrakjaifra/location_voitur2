<?php
require_once 'Database.php'; // Inclure la classe Database

$db = new Database();
$conn = $db->connect();

// Récupérer les données du formulaire
$car_model = $_POST['car_model'] ?? '';
$monthly_pay = $_POST['monthly_pay'] ?? '';
$year = $_POST['year'] ?? '';

// Construire la requête SQL
$query = "SELECT * FROM vehicules WHERE 1";
$params = [];

if (!empty($car_model)) {
    $query .= " AND (modele LIKE :car_model OR marque LIKE :car_model)";
    $params[':car_model'] = "%$car_model%";
}

if (!empty($monthly_pay)) {
    $query .= " AND prix <= :monthly_pay";
    $params[':monthly_pay'] = $monthly_pay;
}

if (!empty($year)) {
    $query .= " AND annee >= :year";
    $params[':year'] = $year;
}

// Exécuter la requête
$results = $db->fetchAll($query, $params);
?>

<section class="section featured-car" id="search-results">
    <div class="container">
        <div class="title-wrapper">
            <h2 class="h2 section-title">Search Results</h2>
        </div>

        <?php
        if ($results) {
            echo '<ul class="featured-car-list">';
            foreach ($results as $car) {
                echo '<li>';
                echo '    <div class="featured-car-card">';
                echo '        <figure class="card-banner">';
                $imagePath = $car['image_path'];
                echo '            <img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($car['modele']) . '" loading="lazy" width="440" height="300" class="w-100">';
                echo '        </figure>';
                echo '        <div class="card-content">';
                echo '            <div class="card-title-wrapper">';
                echo '                <h3 class="h3 card-title"><a href="#">' . htmlspecialchars($car['marque']) . ' ' . htmlspecialchars($car['modele']) . '</a></h3>';
                echo '                <data class="year" value="' . htmlspecialchars($car['annee']) . '">' . htmlspecialchars($car['annee']) . '</data>';
                echo '            </div>';
                echo '            <ul class="card-list">';
                echo '                <li class="card-list-item"><ion-icon name="people-outline"></ion-icon><span class="card-item-text">' . htmlspecialchars($car['nombre_chaises']) . ' Chaises</span></li>';
                echo '                <li class="card-list-item"><ion-icon name="flash-outline"></ion-icon><span class="card-item-text">' . htmlspecialchars($car['source_energie']) . '</span></li>';
                echo '                <li class="card-list-item"><ion-icon name="speedometer-outline"></ion-icon><span class="card-item-text">Fuel Efficiency</span></li>';
                echo '            </ul>';

                echo '            <div class="card-price-wrapper text-center">';
                echo '                <p class="card-price"><strong>$' . htmlspecialchars($car['prix']) . '</strong> / month</p>';
                echo '                <div class="flex justify-center gap-4 mt-2">';
                echo '                    <a href="sign_in.php?redirect=' . urlencode("reservations.php?id=" . $car['id']) . '" class="btn inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-blue-600">Rent now</a>';
                echo '                    <a href="detail.php?id=' . htmlspecialchars($car['id']) . '" class="btn inline-block px-4 py-2 bg-gray-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-gray-600">View Details</a>';
                echo '                </div>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo "<p>No cars found matching your criteria.</p>";
        }
        ?>
    </div>
</section>



