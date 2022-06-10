<?php 


if(!empty($_POST) && !empty($_POST['email'])){
    session_start();
    require_once '../inc/db.php';
    require_once '../inc/functions.php'; 

    $req = $pdo -> prepare('SELECT * FROM tbl_user WHERE user_email = :userEmail AND confirmed_at IS NOT NULL');
    $req -> execute(['userEmail' => $_POST['email']]);
    $user = $req -> fetch();
    
    if($user){
        session_start();

        require 'mailer.php';
        $reset_token = str_random(60);
        // $req = $pdo -> prepare("UPDATE tbl_user SET reset_token = ?, reset_at = NOW() WHERE user_id =?");
        $req = $pdo -> prepare("UPDATE tbl_user SET reset_token = ?, reset_at = NOW() WHERE user_id =?");
        $req -> execute([$reset_token, $user->user_id]);
        $_SESSION['flash']['success'] = "Les instructions du rappel de mot de passe vous ont été envoyées par email";
        
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://5.196.6.108/skeleton/reset.php?id=".$user->user_id."&token=".$reset_token;
        $recipient = $_POST['email'];

        sendEmail($subject,$message,$recipient);
        // mail($_POST['email'],
        //     'Réinitialisation de votre mot de passe',
        //     "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost/RED/reset.php?id={$user->user_id}&token=$rest_token");
        header('Location: login.php');
        exit();

    }else{
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
    } 
}

?>

<?php require '../inc/header.php'; ?>

<!-- <?php debug($_SESSION); ?> -->

<h1>Mot de passe oublié</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" >
    </div>

    <button type="submit" class="btn btn-primary">Se connecter</button>

</form>

<?php require '../inc/footer.php'; ?>