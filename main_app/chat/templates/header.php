<?php 

include 'functions/app_start.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE; ?></title>
    <link rel="stylesheet" href="<?php echo URL . "assets/css/bootstrap.css"; ?>">
    <link rel="stylesheet" href="<?php echo URL . "assets/css/custom.css"; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><?php echo SITE; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo URL; ?>">Chat
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>friends.php">Friends</a>
      </li>
      <?php if(isset($_SESSION['user'])): ?>
      <li class="nav-item">
        <a class="btn btn-danger" href="<?php echo URL; ?>logout.php">Logout</a>
      </li>      
      <?php else: ?>
        <li class="nav-item">
        <a class="btn btn-success" href="<?php echo URL; ?>login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-info ml-2" href="<?php echo URL; ?>register.php">Register</a>
      </li>
      <?php endif; ?>
  </div>
</nav>