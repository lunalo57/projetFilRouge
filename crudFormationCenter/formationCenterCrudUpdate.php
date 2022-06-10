<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $stmt = $pdo->prepare('UPDATE tbl_formationCenter SET formationCenter_id = ?, formationCenter_name = ? WHERE formationCenter_id = ?');
        $stmt->execute([$id, $name, $_GET['id']]);
        $_SESSION['flash']['success'] = "Modifications réalisées";
        header('Location: formationCenterCrudRead.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_formationCenter WHERE formationCenter_id = ?');
    $stmt->execute([$_GET['id']]);
    $formationCenter = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$formationCenter) {
        header('Location: formationCenterCrudRead.php');
        exit();
    }
} else {
    header('Location: formationCenterCrudRead.php');
    exit();
}

?>

<div class="content update">
	<h2>Update <?=$formationCenter['formationCenter_id']?></h2>
    <form action="formationCenterCrudUpdate.php?id=<?=$formationCenter['formationCenter_id']?>" method="post">
        
        <label for="name">Name</label>
        <input type="hidden" name="id" value="<?=$formationCenter['formationCenter_id']?>">
        <input type="text" name="name" value="<?=$formationCenter['formationCenter_name']?>">
        <input type="submit" value="Update">
    </form>

</div>

<?php require '../inc/footer.php' ?>