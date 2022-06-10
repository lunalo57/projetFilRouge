<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM tbl_supplier WHERE supplier_id = ?');
    $stmt->execute([$_GET['id']]);
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$supplier) {
        $_SESSION['flash']['danger'] = "Ce fournisseur n'existe pas";
        exit();
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM tbl_supplier WHERE supplier_id = ?');
            $stmt->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "Ce fournisseur a bien été effacée";
            header('Location: supplierCrudRead.php');
            exit();
        } else {
            header('Location: supplierCrudRead.php');
            exit;
        }
    }
} else {
    header('Location: supplierCrudRead.php');
    exit();
}

?>

<div class="content delete">
	<h2>Delete <?=$supplier['supplier_name']?></h2>
	<p>Are you sure you want to delete supplier <?=$supplier['supplier_name']?>?</p>
    <div class="yesno">
        <a href="supplierCrudDelete.php?id=<?=$supplier['supplier_id']?>&confirm=yes" class="page-link">Yes</a>
        <a href="supplierCrudDelete.php?id=<?=$supplier['supplier_id']?>&confirm=no" class="page-link">No</a>
    </div>
</div>

<?php require '../inc/footer.php'; ?>