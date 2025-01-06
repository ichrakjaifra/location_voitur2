<?php
session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    die('Vous devez être connecté pour soumettre un avis.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'Database.php'; 
    $db = new Database();
    $conn = $db->connect();

    $utilisateur_id = $_SESSION['utilisateur_id'];
    $vehicule_id = $_POST['vehicule_id'];
    $note = $_POST['rating'];
    $commentaire = $_POST['review'];

    
    $stmt = $conn->prepare("INSERT INTO avis (utilisateur_id, vehicule_id, commentaire, note) VALUES (?, ?, ?, ?)");
    $stmt->execute([$utilisateur_id, $vehicule_id, htmlspecialchars($commentaire), $note]);

    
    header('Location: details_vehicule.php?id=' . $vehicule_id);
    exit();
}
?>

