<?php

require_once '../inc/functions.php';
require '../inc/header.php';
logged_only();

if(!empty($_POST)){
    if(!empty($_POST['newFormationCenter']) && preg_match('/^[a-zA-Z \']+$/',$_POST['newFormationCenter'])){
        require '../inc/db.php';
        $req = $pdo -> prepare('SELECT formationCenter_id FROM tbl_formationCenter WHERE formationCenter_name = ?');
        $req -> execute([$_POST['newFormationCenter']]);
        $newFC = $req -> fetch();
        if($newFC){
            $_SESSION['flash']['danger'] = 'Ce centre de formations existe déjà';
            header('Location: formationCenterCrudRead.php');
            exit();
        }else{
            $req = $pdo -> prepare('INSERT INTO tbl_formationCenter SET formationCenter_name = ?');
            $req -> execute([$_POST['newFormationCenter']]);
            $_SESSION['flash']['success'] = 'Une nouveau centre de formation a été ajouté';
            header('Location: formationCenterCrudRead.php');
            exit();
        }
    }else{
        $_SESSION['flash']['danger'] = "Veuillez remplir ce champs et n'utiliser que des lettres minuscules et/ou majuscules séparées par des espaces (ex : Metz Numeric School).";
        header('Location: formationCenterCrudRead.php');
        exit();
    }
}

?>

<h1>Nouveau centre de formation</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Insérez un nouveau centre de formation</label>
        <input type="text" name="newFormationCenter" class="form-control" >
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>

<?php include '../inc/footer.php'?>