<?php

require_once '../inc/functions.php';
require '../inc/header.php';
require '../inc/db.php';
logged_only();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM tbl_brand ORDER BY brand_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_brands = $pdo->query('SELECT COUNT(*) FROM tbl_brand')->fetchColumn();

?>

    <h2>Vos marques de produits</h2>
	<a href="brandCrudCreate.php" class="create-contact">Create Marque de produits</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Brand</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($brands as $brand): ?>
            <tr>
                <td><?=$brand['brand_id']?></td>
                <td><?=$brand['brand_name']?></td>
                <td class="actions">
                    <a href="brandCrudUpdate.php?id=<?=$brand['brand_id']?>" class="page-link"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="brandCrudDelete.php?id=<?=$brand['brand_id']?>" class="page-link"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="...">
        <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="brandCrudRead.php?page=<?= $page-1 ?>">Previous</a></li>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_brands): ?>
            <li class="page-item"><a class="page-link" href="brandCrudRead.php?page=<?= $page+1 ?>">Next</a></li>
        <?php endif; ?>
        </ul>
    </nav>

<?php require '../inc/footer.php'; ?>