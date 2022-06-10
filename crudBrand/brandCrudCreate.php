<?php

require_once '../inc/functions.php';
require '../inc/header.php';
logged_only();

if(!empty($_POST)){
    if(!empty($_POST['newBrand']) && preg_match('/^[a-zA-Z \']+$/',$_POST['newBrand'])){
        require '../inc/db.php';
        $req = $pdo -> prepare('SELECT brand_id FROM tbl_brand WHERE brand_name = ?');
        $req -> execute([$_POST['newBrand']]);
        $newB = $req -> fetch();
        if($newB){
            $_SESSION['flash']['danger'] = 'Cette marque de produits existe déjà';
            header('Location: brandCrudRead.php');
            exit();
        }else{
            $req = $pdo -> prepare('INSERT INTO tbl_brand SET brand_name = ?');
            $req -> execute([$_POST['newBrand']]);
            $_SESSION['flash']['success'] = 'Une nouvelle marque de produits a été ajoutée';
            header('Location: brandCrudRead.php');
            exit();
        }
    }else{
        $_SESSION['flash']['danger'] = "Veuillez remplir ce champs et n'utiliser que des lettres minuscules et/ou majuscules séparées par des espaces (ex : Silver Crest).";
        header('Location: brandCrudRead.php');
        exit();
    }
}

?>

<h1>Nouvelle marque de produits</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Insérez une nouvelle marque de produits</label>
        <input type="text" name="newBrand"  class="form-control" >
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>

<?php include '../inc/footer.php'?>