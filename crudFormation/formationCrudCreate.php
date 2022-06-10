<?php

require_once '../inc/functions.php';
require '../inc/header.php';
require '../inc/db.php';
logged_only();

if(!empty($_POST)){
    if(!empty($_POST['newFormation'])){
        $req = $pdo -> prepare('SELECT formation_id FROM tbl_formation WHERE formation_name = ?, formation_start = ?, formation_end = ?, formationCenter_id = ?');
        $req -> execute([$_POST['newFormation'],$_POST['newFormationStart'],$_POST['newFormationEnd'],$_POST['formationCenterList']]);
        $newB = $req -> fetch();
        if($newB){
            $_SESSION['flash']['danger'] = 'Cette formation existe déjà';
            
            header('Location: formationCrudRead.php');
            exit();
        }else{
            $req = $pdo -> prepare('INSERT INTO tbl_formation SET formation_name = ?, formation_start = ?, formation_end = ?, formationCenter_id = ?');

            $req -> execute([$_POST['newFormation'],$_POST['newFormationStart'],$_POST['newFormationEnd'],$_POST['formationCenterList']]);
            $req -> debugDumpParams();
            exit();
            $_SESSION['flash']['success'] = 'Une nouvelle formation a été ajoutée';
            header('Location: formationCrudRead.php');
            exit();
        }
    }else{
        $_SESSION['flash']['danger'] = "Veuillez remplir ce champs et n'utiliser que des lettres minuscules et/ou majuscules séparées par des espaces (ex : Comptabilité).";
        header('Location: formationCrudRead.php');
        exit();
    }
}

?>

<h1>Nouvelle formation</h1>
<form action="" method="post">

    <div class="form-group">
        <label for="">Insérez une nouvelle formation</label>
        <input type="text" name="newFormation"  class="form-control" >
    </div>
    <div class="form-group">
        <label for="">Date de début</label>
        <input type="date" name="newFormationStart"  class="form-control" >
    </div>
    <div class="form-group">
        <label for="">Date de fin</label>
        <input type="date" name="newFormationEnd"  class="form-control" >
    </div>

    <?php
        $req = $pdo ->prepare("SELECT * FROM tbl_formationCenter");
        $req -> execute();
        $formationCenters = $req -> fetchAll(PDO::FETCH_ASSOC);
    ?>

    <select name="formationCenterList" id="">
        <option value="0">Sélectionner votre centre de formation</option>
        <?php foreach($formationCenters as $formationCenter){ ?>
            <option value="<?= $formationCenter['formationCenter_id'] ?>">
                <?= $formationCenter['formationCenter_name'] ?>
            </option>
        <?php } ?>

    </select><br>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>

<?php include '../inc/footer.php'?>