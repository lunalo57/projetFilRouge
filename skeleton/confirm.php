<?php 

$idUrl = $_GET['id'];
$token = $_GET['token'];

require '../inc/db.php';

$req = $pdo -> prepare('SELECT * FROM tbl_user WHERE user_id = ?');
$req -> execute([$idUrl]);
$user = $req -> fetch();

session_start();

if($user && $user -> confirmation_token == $token){
    $req = $pdo -> prepare('UPDATE tbl_user SET 
                        confirmation_token = NULL ,
                        confirmed_at = NOW()
                        WHERE user_id = ?');
    $req -> execute([$idUrl]);
    $_SESSION['flash']['success'] = "Votre compte a bien été validé";
    $_SESSION['auth'] = $user;
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: login.php');
}

?>