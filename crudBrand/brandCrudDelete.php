<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM tbl_brand WHERE brand_id = ?');
    $stmt->execute([$_GET['id']]);
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$brand) {
        $_SESSION['flash']['danger'] = "Cette marque de produit n'existe pas";
        exit();
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM tbl_brand WHERE brand_id = ?');
            $stmt->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "Cette marque de produit a bien été effacée";
            header('Location: brandCrudRead.php');
            exit();
        } else {
            header('Location: brandCrudRead.php');
            exit;
        }
    }
} else {
    header('Location: brandCrudRead.php');
    exit();
}

?>

<div class="content delete">
	<h2>Delete Contact <?=$brand['brand_name']?></h2>
	<p>Are you sure you want to delete brand <?=$brand['brand_name']?>?</p>
    <div class="yesno">
        <a href="brandCrudDelete.php?id=<?=$brand['brand_id']?>&confirm=yes" class="page-link">Yes</a>
        <a href="brandCrudDelete.php?id=<?=$brand['brand_id']?>&confirm=no" class="page-link">No</a>
    </div>
</div>

<?php require '../inc/footer.php'; ?>
