<?php

require_once '../inc/functions.php';
require '../inc/header.php';
require '../inc/db.php';
logged_only();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM tbl_supplier ORDER BY supplier_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_suppliers = $pdo->query('SELECT COUNT(*) FROM tbl_supplier')->fetchColumn();

?>

    <h2>Vos fournisseurs</h2>
	<a href="supplierCrudCreate.php" class="create-contact">Ajouter vos forunisseurs</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Supplier</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($suppliers as $supplier): ?>
            <tr>
                <td><?=$supplier['supplier_id']?></td>
                <td><?=$supplier['supplier_name']?></td>
                <td class="actions">
                    <a href="supplierCrudUpdate.php?id=<?=$supplier['supplier_id']?>" class="page-link"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="supplierCrudDelete.php?id=<?=$supplier['supplier_id']?>" class="page-link"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="...">
        <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="supplierCrudRead.php?page=<?= $page-1 ?>">Previous</a></li>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_suppliers): ?>
            <li class="page-item"><a class="page-link" href="supplierCrudRead.php?page=<?= $page+1 ?>">Next</a></li>
        <?php endif; ?>
        </ul>
    </nav>

<?php require '../inc/footer.php'; ?>