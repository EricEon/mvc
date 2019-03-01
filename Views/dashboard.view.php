<?php include 'header.php';
use Flux\Core\Helpers\Session;
?>

<div class="container">
<?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['status'] ?>">
        <p><?php Session::display()?></p>
    </div>
<?php endif; ?>
    <h3>WELCOME TO THE DASHBOARD</h3>
</div>

<?php include 'footer.php';?>

