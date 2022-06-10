<?php

require_once '../inc/functions.php';
require '../inc/header.php';
logged_only();

if(!empty($_POST)){
    if(!empty($_POST['newFamily']) && preg_match('/^[a-zA-Z \']+$/',$_POST['newFamily'])){
        require '../inc/db.php';
        $req = $pdo -> prepare('SELECT family_id FROM tbl_family WHERE family_label = ?');
        $req -> execute([$_POST['newFamily']]);
        $newF = $req -> fetch();
        if($newF){
            $_SESSION['flash']['danger'] = 'Ce type de produits existe déjà';
            header('Location: familyCrudRead.php');
            exit();
        }else{
            $req = $pdo -> prepare('INSERT INTO tbl_family SET family_label = ?');
            $req -> execute([$_POST['newFamily']]);
            $_SESSION['flash']['success'] = 'Un nouveau type de produits a été ajouté';
            header('Location: familyCrudRead.php');
            exit();
        }
    }else{
        $_SESSION['flash']['danger'] = "Veuillez remplir ce champs et n'utiliser que des lettres minuscules et/ou majuscules séparées par des espaces (ex : Téléviseur LED).";
        header('Location: familyCrudRead.php');
        exit();
    }
}

?>

<h1>Nouveau type de produits</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Insérez un nouveau type de produits</label>
        <input type="text" name="newFamily" class="form-control" >
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>

<?php include '../inc/footer.php'?>