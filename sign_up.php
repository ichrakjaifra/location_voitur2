<?php
require_once 'Database.php';
require_once 'Utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $database = new Database();
    $conn = $database->connect();

    $utilisateur = new Utilisateur($nom, $email, $password);
    $utilisateur->sinscrire($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In Modal</title>
  <link rel="stylesheet" href="sign.css">
  <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="sign_in.php">login now</a></p>
   </form>

</div>
</body>
</html>