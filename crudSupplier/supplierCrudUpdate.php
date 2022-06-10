<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $stmt = $pdo->prepare('UPDATE tbl_supplier SET supplier_id = ?, supplier_name = ? WHERE supplier_id = ?');
        $stmt->execute([$id, $name, $_GET['id']]);
        $_SESSION['flash']['success'] = "Modifications réalisées";
        header('Location: supplierCrudRead.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_supplier WHERE supplier_id = ?');
    $stmt->execute([$_GET['id']]);
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$supplier) {
        header('Location: supplierCrudRead.php');
        exit();
    }
} else {
    header('Location: supplierCrudRead.php');
    exit();
}

?>

<div class="content update">
	<h2>Update <?=$supplier['supplier_id']?></h2>
    <form action="supplierCrudUpdate.php?id=<?=$supplier['supplier_id']?>" method="post">
        
        <label for="name">Name</label>
        <input type="hidden" name="id" value="<?=$supplier['supplier_id']?>">
        <input type="text" name="name" value="<?=$supplier['supplier_name']?>">
        <input type="submit" value="Update">
    </form>

</div>

<?php require '../inc/footer.php' ?>