<?php 

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

?>


<?php require_once 'functions.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>MNSLOC</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>

<nav class="navbar navbar-expand-lg bg-light">
    <h2>MNSLOC</h2>
    <div class="container-fluid">   
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
            <!-- <?php // if(isset($_SESSION['auth'])): ?> -->
                <a class="nav-link" href="logout.php">Se déconnecter</a>
            <!-- <?php // else: ?> -->
                <a class="nav-link active" aria-current="page" href="../index.php">HOME</a>
                <a class="nav-link" href="../skeleton/register.php">S'inscrire</a>
                <a class="nav-link" href="../skeleton/login.php">Se connecter</a>
                <a class="nav-link" href="../crudBrand/brandCrudRead.php">READ Marque de produits</a>
                <a class="nav-link" href="../crudFamily/familyCrudRead.php">READ Type de produits</a>
                <a class="nav-link" href="../crudFormationCenter/formationCenterCrudRead.php">READ Centre de formations</a>
                <a class="nav-link" href="../crudSupplier/supplierCrudRead.php">READ Fournisseurs</a>
                <a class="nav-link" href="../crudStatus/statusCrudRead.php">READ Statut de l'utilisateur</a>
                <a class="nav-link" href="../crudFormation/formationCrudRead.php">READ Formation</a>
            <!-- <?php // endif; ?> -->
      </div>
    </div>
  </div>
</nav>

   
<div class="container">
    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <?= $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
 