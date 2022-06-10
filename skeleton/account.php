<?php 

require_once '../inc/functions.php';

logged_only();

if(!empty($_POST)){
    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
    }else{
        $userId = $_SESSION['auth'] -> user_id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once '../inc/db.php';
        $req = $pdo -> prepare('UPDATE tbl_user SET user_password = ? WHERE user_id = ?');
        $req -> execute([$password,$userId]);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
}
?>

<?php require '../inc/header.php'; ?>

<h1>Bonjour <?= $_SESSION['auth'] -> user_firstname ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <input class="form-control" type="password" name="password" id="" placeholder="Changer de mot de passe">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="password_confirm" id="" placeholder="Confirmation du mot de passe">
    </div>
    <button class="btn btn-primary">Changer de mot de passe</button>
</form>

<?php require '../inc/footer.php'; ?>