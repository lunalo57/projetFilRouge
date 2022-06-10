<?php 

require_once '../inc/functions.php';
reconnect_from_cookie();

if(isset($_SESSION['auth'])){
    header('Location: account.php');
    exit();
}

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){

    require_once '../inc/db.php';
    require_once '../inc/functions.php';

    $req = $pdo -> prepare('SELECT * FROM tbl_user WHERE user_email = :username OR user_name = :username AND confirmed_at IS NOT NULL');
    $req -> execute(['username' => $_POST['username']]);
    $user = $req -> fetch();
    // var_dump($user);
    
    // exit();

    if(password_verify($_POST['password'],$user->user_password)){
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connecté"; 

        if($_POST['remember']){
            $remember_token = str_random(250);
            $req = $pdo -> prepare('UPDATE tbl_user SET remember_token = ? WHERE user_id = ?');
            $req -> execute([$remember_token, $user -> user_id]); 
            setcookie('remember', $user -> user_id . '==' . $remember_token . sha1($user -> user_id . 'respireMec'), time() + 60 * 60 * 24 *7);
        }
        
        header('Location: account.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
    } 
}

?>

<?php require '../inc/header.php'; ?>

<h1>Se connecter</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Nom ou email</label>
        <input type="text" name="username" class="form-control" >
    </div>

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">(J'ai oublié mon mot de passe)</a></label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="remember" id="" value="1"/>Se souvenir de moi
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Se connecter</button>

</form>

<?php require '../inc/footer.php'; ?>