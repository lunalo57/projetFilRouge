<?php

require_once '../inc/functions.php';
require '../inc/header.php';
logged_only();


if(!empty($_POST)){
    if(!empty($_POST['newStatus']) && preg_match('/^[a-zA-Z \']+$/',$_POST['newStatus'])){
        require '../inc/db.php';
        $req = $pdo -> prepare('SELECT status_id FROM tbl_status WHERE status_name = ?');
        $req -> execute([$_POST['newStatus']]);
        $newFC = $req -> fetch();
        if($newFC){
            $_SESSION['flash']['danger'] = 'Ce statut existe déjà';
            header('Location: statusCrudRead.php');
            exit();
        }else{
            $req = $pdo -> prepare('INSERT INTO tbl_status SET status_name = ?');
            $req -> execute([$_POST['newStatus']]);
            $_SESSION['flash']['success'] = 'Une nouveau statut a été ajouté';
            header('Location: statusCrudRead.php');
            exit();
        }
    }else{
        $_SESSION['flash']['danger'] = "Veuillez remplir ce champs et n'utiliser que des lettres minuscules et/ou majuscules séparées par des espaces (ex : Administrateur).";
        header('Location: statusCrudRead.php');
        exit();
    }
}

?>

<h1>Nouveau statut de l'utilisateur</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Insérez un nouveau statut</label>
        <input type="text" name="newStatus" class="form-control" >
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>

<?php include '../inc/footer.php'?>