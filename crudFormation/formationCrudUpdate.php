<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $stmt = $pdo->prepare('UPDATE tbl_formation SET formation_id = ?, formation_name = ? WHERE formation_id = ?');
        $stmt->execute([$id, $name, $_GET['id']]);
        $_SESSION['flash']['success'] = "Modifications réalisées";
        header('Location: formationCrudRead.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_formation WHERE formation_id = ?');
    $stmt->execute([$_GET['id']]);
    $formation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$formation) {
        header('Location: formationCrudRead.php');
        exit();
    }
} else {
    header('Location: formationCrudRead.php');
    exit();
}

?>

<div class="content update">
	<h2>Update <?=$formation['formation_id']?></h2>
    <form action="formationCrudUpdate.php?id=<?=$formation['formation_id']?>" method="post">
        
        <label for="name">Name</label>
        <input type="hidden" name="id" value="<?=$formation['formation_id']?>">
        <input type="text" name="name" value="<?=$formation['formation_name']?>">
        <input type="submit" value="Update">
    </form>

</div>

<?php require '../inc/footer.php' ?>