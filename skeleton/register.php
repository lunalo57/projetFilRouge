
<?php
require '../inc/header.php'; 
require_once '../inc/functions.php';
if(!empty($_POST)){
    $errors = array();
    require_once '../inc/db.php';
    //! FIRSTNAME
    if(empty($_POST['firstname']) || !preg_match('/^[a-zA-Z]+$/',$_POST['firstname'])){
        $errors['firstname'] = "Votre prénom n'est pas valide";
    }
    
    //! NAME
    if(empty($_POST['name']) || !preg_match('/^[a-zA-Z]+$/',$_POST['name'])){
        $errors['name'] = "Votre nom n'est pas valide";
    }
    else{

        $req = $pdo -> prepare("SELECT user_id FROM tbl_user WHERE user_name = ?");
        $req -> execute([$_POST['name']]);
        $userName = $req -> fetch();
        if($userName){
            $errors['name'] = "Ce nom existe déjà";
        }
    }
    
    //! EMAIL
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide";
    }
    else{
        $req = $pdo -> prepare("SELECT user_id FROM tbl_user WHERE user_email = ?");
        $req -> execute([$_POST['email']]);
        $userEmail = $req -> fetch();
        if($userEmail){
            $errors['email'] = "Cet email existe déjà";
        }
    }

    //! PHONE
    if(empty($_POST['phone']) || !preg_match('/^[0-9]{10}$/',$_POST['phone'])){
        $errors['phone'] = "Votre numéro de téléphone doit contenir 10 chiffres de la forme 0610101010";
    }
    //! PASSWORD
    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password']= "Vous devez saisir deux fois le même mot de passe pour le confirmer";
    }

    //! REQUETE POUR L'INSCRIPTION DE L'UTILISATEUR
    if(empty($errors)){
        require 'mailer.php';

        $req = $pdo -> prepare("INSERT INTO tbl_user SET 
            user_firstname = ?,
            user_name = ?,
            user_email = ?,
            user_phone = ?,
            user_password = ?,
            status_id = 3,
            user_createdat = NOW(),
            confirmation_token = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req -> execute([$_POST['firstname'], 
                        $_POST['name'], 
                        $_POST['email'], 
                        $_POST['phone'], 
                        $password,
                        $token]);

        $idUrl = $pdo -> lastInsertId();

        $subject = "Confirmation de votre compte";
        $message = "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://5.196.6.108/skeleton/confirm.php?id=$idUrl&token=$token";
        $recipient = htmlspecialchars( $_POST['email'], ENT_QUOTES,'charset=ut8');

        sendEmail($subject,$message,$recipient);
        // exit();

        // mail($_POST['email'],
        //     'Confirmation de votre compte',
        //     "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost/RED/confirm.php?id=$idUrl&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location: login.php');
        exit();
    }
}

?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>Vous n'avez pas rempli le formulaire correctement</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="" method="post">

    <div class="form-group">
        <label for="">Prénom</label>
        <input type="text" name="firstname" class="form-control" >
    </div>

    <div class="form-group">
        <label for="">Nom</label>
        <input type="text" name="name" class="form-control" >
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" >
    </div>

    <div class="form-group">
        <label for="">Téléphone</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">M'inscrire</button>

</form>

<?php require '../inc/footer.php'; ?>