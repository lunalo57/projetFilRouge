<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $stmt = $pdo->prepare('UPDATE tbl_brand SET brand_id = ?, brand_name = ? WHERE brand_id = ?');
        $stmt->execute([$id, $name, $_GET['id']]);
        $_SESSION['flash']['success'] = "Modifications réalisées";
        header('Location: brandCrudRead.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_brand WHERE brand_id = ?');
    $stmt->execute([$_GET['id']]);
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$brand) {
        header('Location: brandCrudRead.php');
        exit();
    }
} else {
    header('Location: brandCrudRead.php');
    exit();
}

?>

<div class="content update">
	<h2>Update <?=$brand['brand_id']?></h2>
    <form action="brandCrudUpdate.php?id=<?=$brand['brand_id']?>" method="post">
        <label for="name">Name</label>
        <input type="hidden" name="id" value="<?=$brand['brand_id']?>">
        <input type="text" name="name" value="<?=$brand['brand_name']?>">
        <input type="submit" value="Update">
    </form>

</div>

<?php require '../inc/footer.php' ?>

