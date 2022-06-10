<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM tbl_formation WHERE formation_id = ?');
    $stmt->execute([$_GET['id']]);
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$brand) {
        $_SESSION['flash']['danger'] = "Cette formation n'existe pas";
        exit();
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM tbl_formation WHERE formation_id = ?');
            $stmt->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "Cette formation a bien été effacée";
            header('Location: formationCrudRead.php');
            exit();
        } else {
            header('Location: formationCrudRead.php');
            exit;
        }
    }
} else {
    header('Location: formationCrudRead.php');
    exit();
}

?>

<div class="content delete">
	<h2>Delete formation<?=$brand['formation_name']?></h2>
	<p>Are you sure you want to delete this formation <?=$brand['formation_name']?>?</p>
    <div class="yesno">
        <a href="formationCrudDelete.php?id=<?=$brand['formation_id']?>&confirm=yes" class="page-link">Yes</a>
        <a href="formationCrudDelete.php?id=<?=$brand['formation_id']?>&confirm=no" class="page-link">No</a>
    </div>
</div>

<?php require '../inc/footer.php'; ?>