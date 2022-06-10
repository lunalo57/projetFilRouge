<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM tbl_family WHERE family_id = ?');
    $stmt->execute([$_GET['id']]);
    $family = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$family) {
        $_SESSION['flash']['danger'] = "Ce type de produits n'existe pas";
        exit();
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM tbl_family WHERE family_id = ?');
            $stmt->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "Cette marque de produit a bien été effacée";
            header('Location: familyCrudRead.php');
            exit();
        } else {
            header('Location: familyCrudRead.php');
            exit;
        }
    }
} else {
    header('Location: familyCrudRead.php');
    exit();
}

?>

<div class="content delete">
	<h2>Delete <?=$family['family_label']?></h2>
	<p>Are you sure you want to delete family <?=$family['family_label']?>?</p>
    <div class="yesno">
        <a href="familyCrudDelete.php?id=<?=$family['family_id']?>&confirm=yes" class="page-link">Yes</a>
        <a href="familyCrudDelete.php?id=<?=$family['family_id']?>&confirm=no" class="page-link">No</a>
    </div>
</div>

<?php require '../inc/footer.php'; ?>