<?php

require '../inc/functions.php';
require '../inc/db.php';
require '../inc/header.php';
logged_only();

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';

        $stmt = $pdo->prepare('UPDATE tbl_status SET status_id = ?, status_name = ? WHERE status_id = ?');
        $stmt->execute([$id, $name, $_GET['id']]);
        $_SESSION['flash']['success'] = "Modifications réalisées";
        header('Location: statusCrudRead.php');
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM tbl_status WHERE status_id = ?');
    $stmt->execute([$_GET['id']]);
    $status = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$status) {
        header('Location: statusCrudRead.php');
        exit();
    }
} else {
    header('Location: statusCrudRead.php');
    exit();
}

?>

<div class="content update">
	<h2>Update <?=$status['status_id']?></h2>
    <form action="statusCrudUpdate.php?id=<?=$status['status_id']?>" method="post">
        
        <label for="name">Name</label>
        <input type="hidden" name="id" value="<?=$status['status_id']?>">
        <input type="text" name="name" value="<?=$status['status_name']?>">
        <input type="submit" value="Update">
    </form>

</div>

<?php require '../inc/footer.php' ?>