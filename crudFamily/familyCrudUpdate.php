<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $stmt = $pdo->prepare('UPDATE tbl_family SET family_id = ?, family_label = ? WHERE family_id = ?');
        $stmt->execute([$id, $name, $_GET['id']]);
        $_SESSION['flash']['success'] = "Modifications réalisées";
        header('Location: familyCrudRead.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_family WHERE family_id = ?');
    $stmt->execute([$_GET['id']]);
    $family = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$family) {
        header('Location: familyCrudRead.php');
        exit();
    }
} else {
    header('Location: familyCrudRead.php');
    exit();
}

?>

<div class="content update">
	<h2>Update <?=$family['family_id']?></h2>
    <form action="familyCrudUpdate.php?id=<?=$family['family_id']?>" method="post">
        
        <label for="name">Name</label>
        <input type="hidden" name="id" value="<?=$family['family_id']?>">
        <input type="text" name="name" value="<?=$family['family_label']?>">
        <input type="submit" value="Update">
    </form>

</div>

<?php require '../inc/footer.php' ?>