<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM tbl_formationCenter WHERE formationCenter_id = ?');
    $stmt->execute([$_GET['id']]);
    $formationCenter = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$formationCenter) {
        $_SESSION['flash']['danger'] = "Cette marque de produit n'existe pas";
        exit();
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM tbl_formationCenter WHERE formationCenter_id = ?');
            $stmt->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "Ce centre de formation a bien été effacée";
            header('Location: formationCenterCrudRead.php');
            exit();
        } else {
            header('Location: formationCenterCrudRead.php');
            exit;
        }
    }
} else {
    header('Location: formationCenterCrudRead.php');
    exit();
}

?>

<div class="content delete">
	<h2>Delete <?=$formationCenter['formationCenter_name']?></h2>
	<p>Are you sure you want to delete formationCenter <?=$formationCenter['brand_name']?>?</p>
    <div class="yesno">
        <a href="formationCenterCrudDelete.php?id=<?=$formationCenter['formationCenter_id']?>&confirm=yes" class="page-link">Yes</a>
        <a href="formationCenterCrudDelete.php?id=<?=$formationCenter['formationCenter_id']?>&confirm=no" class="page-link">No</a>
    </div>
</div>

<?php require '../inc/footer.php'; ?>