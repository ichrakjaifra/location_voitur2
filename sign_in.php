<?php
require_once 'Database.php';
require_once 'Utilisateur.php';

session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $database = new Database();
    $conn = $database->connect();

    $utilisateur = new Utilisateur(null, $email, $password);
    if (!$utilisateur->seConnecter($conn)) {
      if (isset($_GET['redirect'])) {
        header("Location: " . $_GET['redirect']);
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    $message = "Email ou mot de passe incorrect.";
}
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
      <h3>login now</h3>
      <?php if (!empty($message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
      <?php endif; ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="sign_up.php">register now</a></p>
   </form>

</div>


</body>
</html>