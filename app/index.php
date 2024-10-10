<?php
  require_once('../config.php');
  require_once('../auth.php');

  // Check if the user is logged in
  if (!isLoggedIn()) {
      // If the user is not logged in, redirect to the login page or display an error message
      header("Location: /login/login.php");
      exit;
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/app/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DND Character Sheet</title>
    <script type="module" crossorigin src="/app/assets/index-Be2--WoA.js"></script>
    <link rel="stylesheet" crossorigin href="/app/assets/index-CytbuWE4.css">
  </head>
  <body>
    <div id="app"></div>
  </body>
</html>