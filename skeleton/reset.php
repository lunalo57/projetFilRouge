<?php 

if(isset($_GET['id']) && isset($_GET['token'])){
    require_once '../inc/functions.php';
    require "../inc/db.php";
    $req = $pdo -> prepare('SELECT * FROM tbl_user WHERE user_id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW() , INTERVAL 30 MINUTE)');
    $req -> execute([$_GET['id'], $_GET['token']]);
    $user = $req -> fetch();
    if($user){
        if(!empty($_POST)){
            if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $req = $pdo -> prepare('UPDATE tbl_user SET user_password = ?, reset_token = NULL , reset_at = NULL');
                $req -> execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }else{
                session_start();
                $_SESSION['flash']['danger'] = "Vous devez saisir deux fois le même mot de passe";
            }
        }
    }else{
        session_start();
        $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
        exit();
    } 
}else{
header('Location: login.php');
exit();
}
?>

<?php require '../inc/header.php'; ?>

<h1>Réinitialiser mon mot de passe</h1>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Confirmation du mot de passe</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Réinitialiser votre mot de passe</button>

</form>

<?php require '../inc/footer.php'; ?>


