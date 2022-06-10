<?php

require_once '../inc/functions.php';
require '../inc/header.php';
require '../inc/db.php';
logged_only();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM tbl_formation ORDER BY formation_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_formations = $pdo->query('SELECT COUNT(*) FROM tbl_formation')->fetchColumn();

?>

    <h2>Vos formations</h2>
	<a href="formationCrudCreate.php" class="create-contact">Create Formation</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Formation</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($formations as $formation): ?>
            <tr>
                <td><?=$formation['formation_id']?></td>
                <td><?=$formation['formation_name']?></td>
                <td class="actions">
                    <a href="formationCrudUpdate.php?id=<?=$formation['formation_id']?>" class="page-link"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="formationCrudDelete.php?id=<?=$formation['formation_id']?>" class="page-link"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="...">
        <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="formationCrudRead.php?page=<?= $page-1 ?>">Previous</a></li>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_formations): ?>
            <li class="page-item"><a class="page-link" href="formationCrudRead.php?page=<?= $page+1 ?>">Next</a></li>
        <?php endif; ?>
        </ul>
    </nav>

<?php require '../inc/footer.php'; ?>