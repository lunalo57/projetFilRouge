<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM tbl_status WHERE status_id = ?');
    $stmt->execute([$_GET['id']]);
    $status = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$status) {
        $_SESSION['flash']['danger'] = "Cette marque de produit n'existe pas";
        exit();
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM tbl_status WHERE status_id = ?');
            $stmt->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "Ce statut d'utilisateur a bien été effacée";
            header('Location: statusCrudRead.php');
            exit();
        } else {
            header('Location: statusCrudRead.php');
            exit;
        }
    }
} else {
    header('Location: statusCrudRead.php');
    exit();
}

?>

<div class="content delete">
	<h2>Delete <?=$status['status_name']?></h2>
	<p>Are you sure you want to delete status <?=$status['status_name']?>?</p>
    <div class="yesno">
        <a href="statusCrudDelete.php?id=<?=$status['status_id']?>&confirm=yes" class="page-link">Yes</a>
        <a href="statusCrudDelete.php?id=<?=$status['status_id']?>&confirm=no" class="page-link">No</a>
    </div>
</div>

<?php require '../inc/footer.php'; ?>