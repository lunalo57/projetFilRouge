<?php

require_once '../inc/functions.php';
require '../inc/header.php';
logged_only();


if(!empty($_POST)){
    if(!empty($_POST['newSupplier']) && preg_match('/^[a-zA-Z \']+$/',$_POST['newSupplier'])){
        require '../inc/db.php';
        $req = $pdo -> prepare('SELECT supplier_id FROM tbl_supplier WHERE supplier_name = ?');
        $req -> execute([$_POST['newSupplier']]);
        $newFC = $req -> fetch();
        if($newFC){
            $_SESSION['flash']['danger'] = 'Ce fournisseur existe déjà';
            header('Location: supplierCrudRead.php');
            exit();
        }else{
            $req = $pdo -> prepare('INSERT INTO tbl_supplier SET supplier_name = ?');
            $req -> execute([$_POST['newSupplier']]);
            $_SESSION['flash']['success'] = 'Une nouveau fournisseur a été ajouté';
            header('Location: supplierCrudRead.php');
            exit();
        }
    }else{
        $_SESSION['flash']['danger'] = "Veuillez remplir ce champs et n'utiliser que des lettres minuscules et/ou majuscules séparées par des espaces (ex : Saturn).";
        header('Location: supplierCrudRead.php');
        exit();
    }
}

?>

<h1>Nouvelle catégorie de produits</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Insérez votre nouvelle catégorie de produits</label>
        <input type="text" name="newSupplier" class="form-control" >
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>

<?php include '../inc/footer.php'?>