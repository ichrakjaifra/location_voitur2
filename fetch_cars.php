<?php
require_once 'Database.php';

$database = new Database();
$conn = $database->connect();

$category = isset($_POST['category']) ? intval($_POST['category']) : 0;

$sql = "SELECT * FROM vehicules";
if ($category > 0) {
    $sql .= " WHERE categorie_id = :category";
}
$stmt = $conn->prepare($sql);

if ($category > 0) {
    $stmt->bindValue(':category', $category, PDO::PARAM_INT);
}

$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// if (!empty($vehicles)) {
//     foreach ($vehicles as $row) {
//         echo '<li>';
//         echo '    <div class="featured-car-card">';
//         echo '        <figure class="card-banner">';
//         echo '            <img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['modele']) . '" loading="lazy" width="440" height="300">';
//         echo '        </figure>';
//         echo '        <div class="card-content">';
//         echo '            <h3>' . htmlspecialchars($row['marque']) . ' ' . htmlspecialchars($row['modele']) . '</h3>';
//         echo '            <p><strong>$' . htmlspecialchars($row['prix']) . '</strong> / month</p>';
//         echo '        </div>';
//         echo '    </div>';
//         echo '</li>';
//     }
// } else {
//     echo '<p>No cars found for this category.</p>';
// }



?>

<section class="section featured-car" id="search-results">
    <div class="container">
        <div class="title-wrapper">
            <h2 class="h2 section-title">Search Results</h2>
        </div>

        <?php
        if (!empty($vehicles)) {
            echo '<ul class="featured-car-list">';
            foreach ($vehicles as $row) {
                echo '<li>';
                echo '    <div class="featured-car-card">';
                echo '        <figure class="card-banner">';
                $imagePath = $row['image_path'];
                echo '            <img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['modele']) . '" loading="lazy" width="440" height="300" class="w-100">';
                echo '        </figure>';
                echo '        <div class="card-content">';
                echo '            <div class="card-title-wrapper">';
                echo '                <h3 class="h3 card-title"><a href="#">' . htmlspecialchars($row['marque']) . ' ' . htmlspecialchars($row['modele']) . '</a></h3>';
                echo '                <data class="year" value="' . htmlspecialchars($row['annee']) . '">' . htmlspecialchars($row['annee']) . '</data>';
                echo '            </div>';
                echo '            <ul class="card-list">';
                echo '                <li class="card-list-item"><ion-icon name="people-outline"></ion-icon><span class="card-item-text">' . htmlspecialchars($row['nombre_chaises']) . ' Chaises</span></li>';
                echo '                <li class="card-list-item"><ion-icon name="flash-outline"></ion-icon><span class="card-item-text">' . htmlspecialchars($row['source_energie']) . '</span></li>';
                echo '                <li class="card-list-item"><ion-icon name="speedometer-outline"></ion-icon><span class="card-item-text">Fuel Efficiency</span></li>';
                echo '            </ul>';

                echo '            <div class="card-price-wrapper text-center">';
                echo '                <p class="card-price"><strong>$' . htmlspecialchars($row['prix']) . '</strong> / month</p>';
                echo '                <div class="flex justify-center gap-4 mt-2">';
                echo '                    <a href="sign_in.php?redirect=' . urlencode("reservations.php?id=" . $row['id']) . '" class="btn inline-block px-4 py-2 bg-blue-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-blue-600">Rent now</a>';
                echo '                    <a href="detail.php?id=' . htmlspecialchars($row['id']) . '" class="btn inline-block px-4 py-2 bg-gray-500 text-white font-semibold text-center rounded-lg shadow-md hover:bg-gray-600">View Details</a>';
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
